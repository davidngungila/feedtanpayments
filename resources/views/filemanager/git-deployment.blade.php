@extends('layouts.app')

@section('title', 'Git Deployment')
@section('description', 'Manage Git repositories and deployment')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">Git Deployment</h5>
                    <p class="card-subtitle">Manage Git repositories and deployment</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-success" onclick="addRepository()">
                        <i class="bx bx-plus me-1"></i> Add Repository
                    </button>
                    <button class="btn btn-outline-primary" onclick="deployAll()">
                        <i class="bx bx-git-branch me-1"></i> Deploy All
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- Git Statistics -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-primary bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-git-branch text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Repositories</h6>
                                <h4 class="mb-0">{{ $stats['total_repos'] }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-success bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-check-circle text-success"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Active</h6>
                                <h4 class="mb-0 text-success">{{ $stats['active_repos'] }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-warning bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-time text-warning"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Pending Deploys</h6>
                                <h4 class="mb-0 text-warning">{{ $stats['pending_deploys'] }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-info bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-history text-info"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Last Deploy All</h6>
                                <h4 class="mb-0 text-info">{{ \Carbon\Carbon::parse($stats['last_deploy_all'])->format('H:i') }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Repository List -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Repository</th>
                                <th>URL</th>
                                <th>Branch</th>
                                <th>Last Commit</th>
                                <th>Last Deploy</th>
                                <th>Auto Deploy</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($repositories as $repo)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-git-branch text-primary me-2"></i>
                                        <strong>{{ $repo['name'] }}</strong>
                                    </div>
                                </td>
                                <td><code>{{ $repo['url'] }}</code></td>
                                <td><span class="badge bg-info">{{ $repo['branch'] }}</span></td>
                                <td><code>{{ $repo['last_commit'] }}</code></td>
                                <td>{{ \Carbon\Carbon::parse($repo['last_deploy'])->format('M d, H:i') }}</td>
                                <td>
                                    <span class="badge bg-{{ $repo['auto_deploy'] ? 'success' : 'secondary' }}">
                                        {{ $repo['auto_deploy'] ? 'Enabled' : 'Disabled' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $repo['status'] == 'active' ? 'success' : ($repo['status'] == 'pending' ? 'warning' : 'danger') }}">
                                        {{ $repo['status'] }}
                                    </span>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a href="#" class="dropdown-item" onclick="deployRepository('{{ $repo['name'] }}')">
                                                <i class="bx bx-git-branch me-2"></i> Deploy Now
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="pullChanges('{{ $repo['name'] }}')">
                                                <i class="bx bx-download me-2"></i> Pull Changes
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="viewCommits('{{ $repo['name'] }}')">
                                                <i class="bx bx-history me-2"></i> View Commits
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="viewBranches('{{ $repo['name'] }}')">
                                                <i class="bx bx-git-branch me-2"></i> View Branches
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="viewLog('{{ $repo['name'] }}')">
                                                <i class="bx bx-file me-2"></i> View Log
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item" onclick="editRepository('{{ $repo['name'] }}')">
                                                <i class="bx bx-edit me-2"></i> Edit
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="toggleAutoDeploy('{{ $repo['name'] }}', '{{ $repo['auto_deploy'] }}')">
                                                <i class="bx bx-sync me-2"></i> {{ $repo['auto_deploy'] ? 'Disable' : 'Enable' }} Auto Deploy
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item text-danger" onclick="removeRepository('{{ $repo['name'] }}')">
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

                <!-- Deployment Queue -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Deployment Queue</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Repository</th>
                                                <th>Action</th>
                                                <th>Status</th>
                                                <th>Started</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><strong>test.org</strong></td>
                                                <td><span class="badge bg-info">Deploy</span></td>
                                                <td><span class="badge bg-warning">In Progress</span></td>
                                                <td>2 min ago</td>
                                            </tr>
                                            <tr>
                                                <td><strong>mydomain.net</strong></td>
                                                <td><span class="badge bg-success">Pull</span></td>
                                                <td><span class="badge bg-success">Completed</span></td>
                                                <td>5 min ago</td>
                                            </tr>
                                            <tr>
                                                <td><strong>example.com</strong></td>
                                                <td><span class="badge bg-warning">Merge</span></td>
                                                <td><span class="badge bg-secondary">Queued</span></td>
                                                <td>8 min ago</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <button class="btn btn-outline-primary btn-sm w-100 mt-2" onclick="clearQueue()">
                                    <i class="bx bx-trash me-1"></i> Clear Queue
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Recent Deployments</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Repository</th>
                                                <th>Commit</th>
                                                <th>Status</th>
                                                <th>Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><strong>example.com</strong></td>
                                                <td><code>a1b2c3d</code></td>
                                                <td><span class="badge bg-success">Success</span></td>
                                                <td>14:30</td>
                                            </tr>
                                            <tr>
                                                <td><strong>mydomain.net</strong></td>
                                                <td><code>e4f5g6h</code></td>
                                                <td><span class="badge bg-success">Success</span></td>
                                                <td>13:45</td>
                                            </tr>
                                            <tr>
                                                <td><strong>test.org</strong></td>
                                                <td><code>i7j8k9l</code></td>
                                                <td><span class="badge bg-danger">Failed</span></td>
                                                <td>12:15</td>
                                            </tr>
                                            <tr>
                                                <td><strong>site.co</strong></td>
                                                <td><code>m0n1o2p</code></td>
                                                <td><span class="badge bg-success">Success</span></td>
                                                <td>11:30</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <button class="btn btn-outline-info btn-sm w-100 mt-2" onclick="viewDeploymentHistory()">
                                    <i class="bx bx-history me-1"></i> View Full History
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Git Settings -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Git Settings</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="mb-3">Global Git Configuration</h6>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="autoPull" checked>
                                            <label class="form-check-label" for="autoPull">
                                                Enable automatic pull on webhook
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="autoDeploy" checked>
                                            <label class="form-check-label" for="autoDeploy">
                                                Enable automatic deployment
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="backupBeforeDeploy" checked>
                                            <label class="form-check-label" for="backupBeforeDeploy">
                                                Create backup before deployment
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="runTests">
                                            <label class="form-check-label" for="runTests">
                                                Run tests before deployment
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="mb-3">Deployment Preferences</h6>
                                        <div class="mb-3">
                                            <label for="defaultBranch" class="form-label">Default Branch</label>
                                            <select class="form-select" id="defaultBranch">
                                                <option value="main" selected>main</option>
                                                <option value="master">master</option>
                                                <option value="develop">develop</option>
                                                <option value="production">production</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="deployTimeout" class="form-label">Deployment Timeout (seconds)</label>
                                            <input type="number" class="form-control" id="deployTimeout" value="300" min="60" max="3600">
                                        </div>
                                        <div class="mb-3">
                                            <label for="maxConcurrentDeploys" class="form-label">Max Concurrent Deployments</label>
                                            <input type="number" class="form-control" id="maxConcurrentDeploys" value="3" min="1" max="10">
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-primary" onclick="saveGitSettings()">
                                        <i class="bx bx-save me-1"></i> Save Settings
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
function addRepository() {
    showNotification('Add repository dialog opened', 'info');
}

function deployAll() {
    if (confirm('Are you sure you want to deploy all repositories?')) {
        showNotification('Deploying all repositories...', 'info');
    }
}

function deployRepository(name) {
    showNotification(`Deploying repository: ${name}`, 'info');
}

function pullChanges(name) {
    showNotification(`Pulling changes for: ${name}`, 'info');
}

function viewCommits(name) {
    showNotification(`Viewing commits for: ${name}`, 'info');
}

function viewBranches(name) {
    showNotification(`Viewing branches for: ${name}`, 'info');
}

function viewLog(name) {
    showNotification(`Viewing deployment log for: ${name}`, 'info');
}

function editRepository(name) {
    showNotification(`Editing repository: ${name}`, 'info');
}

function toggleAutoDeploy(name, currentStatus) {
    const newStatus = currentStatus ? 'disable' : 'enable';
    if (confirm(`Are you sure you want to ${newStatus} auto-deploy for ${name}?`)) {
        showNotification(`Auto-deploy ${newStatus}d for ${name}`, 'success');
    }
}

function removeRepository(name) {
    if (confirm(`Are you sure you want to remove repository ${name}?`)) {
        showNotification(`Repository ${name} removed`, 'danger');
    }
}

function clearQueue() {
    if (confirm('Are you sure you want to clear the deployment queue?')) {
        showNotification('Deployment queue cleared', 'warning');
    }
}

function viewDeploymentHistory() {
    showNotification('Opening deployment history...', 'info');
}

function saveGitSettings() {
    showNotification('Git settings saved successfully', 'success');
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
