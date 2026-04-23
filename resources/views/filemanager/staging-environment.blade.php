@extends('layouts.app')

@section('title', 'Staging Environment')
@section('description', 'Manage staging environments and synchronization')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">Staging Environment</h5>
                    <p class="card-subtitle">Manage staging environments and synchronization</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-success" onclick="createStaging()">
                        <i class="bx bx-plus me-1"></i> Create Staging
                    </button>
                    <button class="btn btn-outline-primary" onclick="syncAllStaging()">
                        <i class="bx bx-sync me-1"></i> Sync All
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- Staging Statistics -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-primary bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-git-branch text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Staging Sites</h6>
                                <h4 class="mb-0">{{ $stats['total_staging_sites'] }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-success bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-check-circle text-success"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Synced</h6>
                                <h4 class="mb-0 text-success">{{ $stats['synced_sites'] }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-warning bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-time text-warning"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Pending</h6>
                                <h4 class="mb-0 text-warning">{{ $stats['pending_sites'] }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-danger bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-x-circle text-danger"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Errors</h6>
                                <h4 class="mb-0 text-danger">{{ $stats['error_sites'] }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Staging Sites List -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Site Name</th>
                                <th>Staging URL</th>
                                <th>Production URL</th>
                                <th>Status</th>
                                <th>Last Sync</th>
                                <th>DB Sync</th>
                                <th>Files Sync</th>
                                <th>Auto Sync</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stagingSites as $site)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-globe text-primary me-2"></i>
                                        <strong>{{ $site['name'] }}</strong>
                                    </div>
                                </td>
                                <td><code>{{ $site['staging_url'] }}</code></td>
                                <td><code>{{ $site['production_url'] }}</code></td>
                                <td>
                                    <span class="badge bg-{{ $site['status'] == 'synced' ? 'success' : ($site['status'] == 'pending' ? 'warning' : 'danger') }}">
                                        {{ $site['status'] }}
                                    </span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($site['last_sync'])->format('M d, H:i') }}</td>
                                <td>
                                    <span class="badge bg-{{ $site['db_sync'] ? 'success' : 'danger' }}">
                                        {{ $site['db_sync'] ? 'Enabled' : 'Disabled' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $site['files_sync'] ? 'success' : 'danger' }}">
                                        {{ $site['files_sync'] ? 'Enabled' : 'Disabled' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $site['auto_sync'] ? 'success' : 'secondary' }}">
                                        {{ $site['auto_sync'] ? 'Enabled' : 'Disabled' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a href="#" class="dropdown-item" onclick="syncSite('{{ $site['name'] }}')">
                                                <i class="bx bx-sync me-2"></i> Sync Now
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="syncDB('{{ $site['name'] }}')">
                                                <i class="bx bx-data me-2"></i> Sync Database
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="syncFiles('{{ $site['name'] }}')">
                                                <i class="bx bx-folder me-2"></i> Sync Files
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="viewSyncLog('{{ $site['name'] }}')">
                                                <i class="bx bx-history me-2"></i> View Sync Log
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="deployToProduction('{{ $site['name'] }}')">
                                                <i class="bx bx-git-branch me-2"></i> Deploy to Production
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item" onclick="toggleAutoSync('{{ $site['name'] }}', '{{ $site['auto_sync'] }}')">
                                                <i class="bx bx-sync me-2"></i> {{ $site['auto_sync'] ? 'Disable' : 'Enable' }} Auto Sync
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="toggleDBSync('{{ $site['name'] }}', '{{ $site['db_sync'] }}')">
                                                <i class="bx bx-data me-2"></i> {{ $site['db_sync'] ? 'Disable' : 'Enable' }} DB Sync
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="toggleFilesSync('{{ $site['name'] }}', '{{ $site['files_sync'] }}')">
                                                <i class="bx bx-folder me-2"></i> {{ $site['files_sync'] ? 'Disable' : 'Enable' }} Files Sync
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item" onclick="configureStaging('{{ $site['name'] }}')">
                                                <i class="bx bx-cog me-2"></i> Configure
                                            </a>
                                            <a href="#" class="dropdown-item text-danger" onclick="removeStaging('{{ $site['name'] }}')">
                                                <i class="bx bx-trash me-2"></i> Remove
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Sync Queue -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Sync Queue</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Site</th>
                                                <th>Type</th>
                                                <th>Status</th>
                                                <th>Started</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><strong>mydomain.net</strong></td>
                                                <td><span class="badge bg-info">Full Sync</span></td>
                                                <td><span class="badge bg-warning">In Progress</span></td>
                                                <td>2 min ago</td>
                                            </tr>
                                            <tr>
                                                <td><strong>example.com</strong></td>
                                                <td><span class="badge bg-success">DB Sync</span></td>
                                                <td><span class="badge bg-success">Completed</span></td>
                                                <td>5 min ago</td>
                                            </tr>
                                            <tr>
                                                <td><strong>test.org</strong></td>
                                                <td><span class="badge bg-warning">Files Sync</span></td>
                                                <td><span class="badge bg-secondary">Queued</span></td>
                                                <td>8 min ago</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <button class="btn btn-outline-primary btn-sm w-100 mt-2" onclick="clearSyncQueue()">
                                    <i class="bx bx-trash me-1"></i> Clear Queue
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Recent Sync Activity</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Site</th>
                                                <th>Type</th>
                                                <th>Status</th>
                                                <th>Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><strong>site.co</strong></td>
                                                <td><span class="badge bg-info">Full Sync</span></td>
                                                <td><span class="badge bg-success">Success</span></td>
                                                <td>11:30</td>
                                            </tr>
                                            <tr>
                                                <td><strong>example.com</strong></td>
                                                <td><span class="badge bg-success">DB Sync</span></td>
                                                <td><span class="badge bg-success">Success</span></td>
                                                <td>11:15</td>
                                            </tr>
                                            <tr>
                                                <td><strong>test.org</strong></td>
                                                <td><span class="badge bg-warning">Files Sync</span></td>
                                                <td><span class="badge bg-danger">Failed</span></td>
                                                <td>11:00</td>
                                            </tr>
                                            <tr>
                                                <td><strong>mydomain.net</strong></td>
                                                <td><span class="badge bg-info">Full Sync</span></td>
                                                <td><span class="badge bg-success">Success</span></td>
                                                <td>10:45</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <button class="btn btn-outline-info btn-sm w-100 mt-2" onclick="viewSyncHistory()">
                                    <i class="bx bx-history me-1"></i> View Full History
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Staging Settings -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Staging Settings</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="mb-3">Sync Configuration</h6>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="autoSync" checked>
                                            <label class="form-check-label" for="autoSync">
                                                Enable automatic synchronization
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="realTimeSync">
                                            <label class="form-check-label" for="realTimeSync">
                                                Enable real-time synchronization
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="backupBeforeSync" checked>
                                            <label class="form-check-label" for="backupBeforeSync">
                                                Create backup before sync
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="notifySyncErrors" checked>
                                            <label class="form-check-label" for="notifySyncErrors">
                                                Notify on sync errors
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="mb-3">Sync Preferences</h6>
                                        <div class="mb-3">
                                            <label for="syncInterval" class="form-label">Sync Interval (minutes)</label>
                                            <select class="form-select" id="syncInterval">
                                                <option value="5">5 minutes</option>
                                                <option value="15" selected>15 minutes</option>
                                                <option value="30">30 minutes</option>
                                                <option value="60">1 hour</option>
                                                <option value="1440">Daily</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="maxConcurrentSync" class="form-label">Max Concurrent Syncs</label>
                                            <input type="number" class="form-control" id="maxConcurrentSync" value="3" min="1" max="10">
                                        </div>
                                        <div class="mb-3">
                                            <label for="syncTimeout" class="form-label">Sync Timeout (minutes)</label>
                                            <input type="number" class="form-control" id="syncTimeout" value="30" min="5" max="120">
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-primary" onclick="saveStagingSettings()">
                                        <i class="bx bx-save me-1"></i> Save Settings
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Deployment Pipeline -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Deployment Pipeline</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="text-center">
                                            <div class="avatar bg-primary bg-opacity-10 rounded-circle mx-auto mb-2" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                                                <i class="bx bx-code text-primary" style="font-size: 24px;"></i>
                                            </div>
                                            <h6>Development</h6>
                                            <p class="text-muted small">Code development and testing</p>
                                            <button class="btn btn-outline-primary btn-sm" onclick="viewEnvironment('development')">
                                                View
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-center">
                                            <div class="avatar bg-warning bg-opacity-10 rounded-circle mx-auto mb-2" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                                                <i class="bx bx-git-branch text-warning" style="font-size: 24px;"></i>
                                            </div>
                                            <h6>Staging</h6>
                                            <p class="text-muted small">Testing and validation</p>
                                            <button class="btn btn-outline-warning btn-sm" onclick="viewEnvironment('staging')">
                                                View
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-center">
                                            <div class="avatar bg-info bg-opacity-10 rounded-circle mx-auto mb-2" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                                                <i class="bx bx-test-tube text-info" style="font-size: 24px;"></i>
                                            </div>
                                            <h6>QA Testing</h6>
                                            <p class="text-muted small">Quality assurance</p>
                                            <button class="btn btn-outline-info btn-sm" onclick="viewEnvironment('qa')">
                                                View
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-center">
                                            <div class="avatar bg-success bg-opacity-10 rounded-circle mx-auto mb-2" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                                                <i class="bx bx-globe text-success" style="font-size: 24px;"></i>
                                            </div>
                                            <h6>Production</h6>
                                            <p class="text-muted small">Live environment</p>
                                            <button class="btn btn-outline-success btn-sm" onclick="viewEnvironment('production')">
                                                View
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-outline-primary" onclick="runPipeline()">
                                        <i class="bx bx-play me-1"></i> Run Pipeline
                                    </button>
                                    <button class="btn btn-outline-info ms-2" onclick="viewPipelineConfig()">
                                        <i class="bx bx-cog me-1"></i> Configure Pipeline
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function createStaging() {
    showNotification('Create staging environment dialog opened', 'info');
}

function syncAllStaging() {
    if (confirm('Are you sure you want to sync all staging environments?')) {
        showNotification('Syncing all staging environments...', 'info');
    }
}

function syncSite(name) {
    showNotification(`Syncing staging site: ${name}`, 'info');
}

function syncDB(name) {
    showNotification(`Syncing database for: ${name}`, 'info');
}

function syncFiles(name) {
    showNotification(`Syncing files for: ${name}`, 'info');
}

function viewSyncLog(name) {
    showNotification(`Viewing sync log for: ${name}`, 'info');
}

function deployToProduction(name) {
    if (confirm(`Are you sure you want to deploy ${name} to production?`)) {
        showNotification(`Deploying ${name} to production...`, 'warning');
    }
}

function toggleAutoSync(name, currentStatus) {
    const newStatus = currentStatus ? 'disable' : 'enable';
    if (confirm(`Are you sure you want to ${newStatus} auto-sync for ${name}?`)) {
        showNotification(`Auto-sync ${newStatus}d for ${name}`, 'success');
    }
}

function toggleDBSync(name, currentStatus) {
    const newStatus = currentStatus ? 'disable' : 'enable';
    if (confirm(`Are you sure you want to ${newStatus} database sync for ${name}?`)) {
        showNotification(`Database sync ${newStatus}d for ${name}`, 'success');
    }
}

function toggleFilesSync(name, currentStatus) {
    const newStatus = currentStatus ? 'disable' : 'enable';
    if (confirm(`Are you sure you want to ${newStatus} files sync for ${name}?`)) {
        showNotification(`Files sync ${newStatus}d for ${name}`, 'success');
    }
}

function configureStaging(name) {
    showNotification(`Configuring staging for: ${name}`, 'info');
}

function removeStaging(name) {
    if (confirm(`Are you sure you want to remove staging environment for ${name}?`)) {
        showNotification(`Staging environment removed for ${name}`, 'danger');
    }
}

function clearSyncQueue() {
    if (confirm('Are you sure you want to clear the sync queue?')) {
        showNotification('Sync queue cleared', 'warning');
    }
}

function viewSyncHistory() {
    showNotification('Opening sync history...', 'info');
}

function saveStagingSettings() {
    showNotification('Staging settings saved successfully', 'success');
}

function viewEnvironment(env) {
    showNotification(`Viewing ${env} environment...`, 'info');
}

function runPipeline() {
    if (confirm('Are you sure you want to run the deployment pipeline?')) {
        showNotification('Running deployment pipeline...', 'info');
    }
}

function viewPipelineConfig() {
    showNotification('Opening pipeline configuration...', 'info');
}

function showNotification(message, type) {
    const alert = document.createElement('div');
    alert.className = `alert alert-${type} alert-dismissible fade show position-fixed top-0 end-0 m-3`;
    alert.style.zIndex = '9999';
    alert.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    document.body.appendChild(alert);
    
    setTimeout(() => {
        alert.remove();
    }, 3000);
}
</script>
@endpush
