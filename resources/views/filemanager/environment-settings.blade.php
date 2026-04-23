@extends('layouts.app')

@section('title', 'Environment Settings')
@section('description', 'Manage environment configurations and settings')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">Environment Settings</h5>
                    <p class="card-subtitle">Manage environment configurations and settings</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-success" onclick="addEnvironment()">
                        <i class="bx bx-plus me-1"></i> Add Environment
                    </button>
                    <button class="btn btn-outline-primary" onclick="syncAllEnvironments()">
                        <i class="bx bx-sync me-1"></i> Sync All
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- Environment List -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Environment</th>
                                <th>Domain</th>
                                <th>PHP Version</th>
                                <th>Memory Limit</th>
                                <th>Max Execution</th>
                                <th>Upload Size</th>
                                <th>OPcache</th>
                                <th>Debug</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($environments as $env)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-globe text-primary me-2"></i>
                                        <strong>{{ $env['name'] }}</strong>
                                    </div>
                                </td>
                                <td><code>{{ $env['domain'] }}</code></td>
                                <td><span class="badge bg-info">{{ $env['php_version'] }}</span></td>
                                <td><code>{{ $env['memory_limit'] }}</code></td>
                                <td><code>{{ $env['max_execution_time'] == '0' ? 'Unlimited' : $env['max_execution_time'] . 's' }}</code></td>
                                <td><code>{{ $env['upload_max_filesize'] }}</code></td>
                                <td>
                                    <span class="badge bg-{{ $env['opcache'] ? 'success' : 'secondary' }}">
                                        {{ $env['opcache'] ? 'Enabled' : 'Disabled' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $env['debug'] ? 'warning' : 'success' }}">
                                        {{ $env['debug'] ? 'Enabled' : 'Disabled' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $env['status'] == 'active' ? 'success' : 'danger' }}">
                                        {{ $env['status'] }}
                                    </span>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a href="#" class="dropdown-item" onclick="editEnvironment('{{ $env['name'] }}')">
                                                <i class="bx bx-edit me-2"></i> Edit Settings
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="viewPhpInfo('{{ $env['name'] }}')">
                                                <i class="bx bx-info-circle me-2"></i> PHP Info
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="viewErrorLog('{{ $env['name'] }}')">
                                                <i class="bx bx-file me-2"></i> Error Log
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="viewAccessLog('{{ $env['name'] }}')">
                                                <i class="bx bx-history me-2"></i> Access Log
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item" onclick="restartEnvironment('{{ $env['name'] }}')">
                                                <i class="bx bx-refresh me-2"></i> Restart
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="clearCache('{{ $env['name'] }}')">
                                                <i class="bx bx-trash me-2"></i> Clear Cache
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            @if($env['status'] == 'active')
                                            <a href="#" class="dropdown-item text-warning" onclick="disableEnvironment('{{ $env['name'] }}')">
                                                <i class="bx bx-pause me-2"></i> Disable
                                            </a>
                                            @else
                                            <a href="#" class="dropdown-item text-success" onclick="enableEnvironment('{{ $env['name'] }}')">
                                                <i class="bx bx-play me-2"></i> Enable
                                            </a>
                                            @endif
                                            <a href="#" class="dropdown-item text-danger" onclick="deleteEnvironment('{{ $env['name'] }}')">
                                                <i class="bx bx-trash me-2"></i> Delete
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Environment Comparison -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Environment Comparison</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Setting</th>
                                                <th>Production</th>
                                                <th>Staging</th>
                                                <th>Development</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><strong>Memory Limit</strong></td>
                                                <td><code>256M</code></td>
                                                <td><code>512M</code></td>
                                                <td><code>1G</code></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Max Execution</strong></td>
                                                <td><code>300s</code></td>
                                                <td><code>600s</code></td>
                                                <td><code>Unlimited</code></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Upload Size</strong></td>
                                                <td><code>64M</code></td>
                                                <td><code>128M</code></td>
                                                <td><code>256M</code></td>
                                            </tr>
                                            <tr>
                                                <td><strong>OPcache</strong></td>
                                                <td><span class="badge bg-success">Enabled</span></td>
                                                <td><span class="badge bg-success">Enabled</span></td>
                                                <td><span class="badge bg-secondary">Disabled</span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Debug</strong></td>
                                                <td><span class="badge bg-secondary">Disabled</span></td>
                                                <td><span class="badge bg-warning">Enabled</span></td>
                                                <td><span class="badge bg-warning">Enabled</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Environment Variables</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Variable</th>
                                                <th>Production</th>
                                                <th>Staging</th>
                                                <th>Development</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><code>APP_ENV</code></td>
                                                <td><code>production</code></td>
                                                <td><code>staging</code></td>
                                                <td><code>development</code></td>
                                            </tr>
                                            <tr>
                                                <td><code>APP_DEBUG</code></td>
                                                <td><code>false</code></td>
                                                <td><code>true</code></td>
                                                <td><code>true</code></td>
                                            </tr>
                                            <tr>
                                                <td><code>DB_HOST</code></td>
                                                <td><code>prod-db.example.com</code></td>
                                                <td><code>staging-db.example.com</code></td>
                                                <td><code>localhost</code></td>
                                            </tr>
                                            <tr>
                                                <td><code>CACHE_DRIVER</code></td>
                                                <td><code>redis</code></td>
                                                <td><code>redis</code></td>
                                                <td><code>file</code></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Environment Templates -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Environment Templates</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body text-center">
                                                <h6 class="card-title">Production</h6>
                                                <p class="card-text small">Optimized for production with security and performance</p>
                                                <button class="btn btn-outline-danger btn-sm" onclick="applyTemplate('production')">
                                                    Apply Template
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body text-center">
                                                <h6 class="card-title">Staging</h6>
                                                <p class="card-text small">Mirror production with debug enabled for testing</p>
                                                <button class="btn btn-outline-warning btn-sm" onclick="applyTemplate('staging')">
                                                    Apply Template
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body text-center">
                                                <h6 class="card-title">Development</h6>
                                                <p class="card-text small">Development-friendly with debugging and logging</p>
                                                <button class="btn btn-outline-info btn-sm" onclick="applyTemplate('development')">
                                                    Apply Template
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body text-center">
                                                <h6 class="card-title">Testing</h6>
                                                <p class="card-text small">Optimized for automated testing and CI/CD</p>
                                                <button class="btn btn-outline-success btn-sm" onclick="applyTemplate('testing')">
                                                    Apply Template
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Environment Health -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Environment Health</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="text-center">
                                            <h4 class="text-success mb-0">Production</h4>
                                            <div class="progress mb-2" style="height: 8px;">
                                                <div class="progress-bar bg-success" style="width: 95%"></div>
                                            </div>
                                            <small class="text-muted">95% Healthy</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-center">
                                            <h4 class="text-warning mb-0">Staging</h4>
                                            <div class="progress mb-2" style="height: 8px;">
                                                <div class="progress-bar bg-warning" style="width: 85%"></div>
                                            </div>
                                            <small class="text-muted">85% Healthy</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-center">
                                            <h4 class="text-info mb-0">Development</h4>
                                            <div class="progress mb-2" style="height: 8px;">
                                                <div class="progress-bar bg-info" style="width: 90%"></div>
                                            </div>
                                            <small class="text-muted">90% Healthy</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-outline-primary" onclick="runHealthCheck()">
                                        <i class="bx bx-heart me-1"></i> Run Health Check
                                    </button>
                                    <button class="btn btn-outline-info ms-2" onclick="viewHealthDetails()">
                                        <i class="bx bx-info-circle me-1"></i> View Details
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
function addEnvironment() {
    showNotification('Add environment dialog opened', 'info');
}

function syncAllEnvironments() {
    if (confirm('Are you sure you want to sync all environments?')) {
        showNotification('Syncing all environments...', 'info');
    }
}

function editEnvironment(name) {
    showNotification(`Editing environment: ${name}`, 'info');
}

function viewPhpInfo(name) {
    showNotification(`Viewing PHP info for: ${name}`, 'info');
}

function viewErrorLog(name) {
    showNotification(`Viewing error log for: ${name}`, 'info');
}

function viewAccessLog(name) {
    showNotification(`Viewing access log for: ${name}`, 'info');
}

function restartEnvironment(name) {
    if (confirm(`Are you sure you want to restart ${name} environment?`)) {
        showNotification(`Restarting ${name} environment...`, 'warning');
    }
}

function clearCache(name) {
    if (confirm(`Are you sure you want to clear cache for ${name} environment?`)) {
        showNotification(`Cache cleared for ${name} environment`, 'success');
    }
}

function disableEnvironment(name) {
    if (confirm(`Are you sure you want to disable ${name} environment?`)) {
        showNotification(`${name} environment disabled`, 'warning');
    }
}

function enableEnvironment(name) {
    if (confirm(`Are you sure you want to enable ${name} environment?`)) {
        showNotification(`${name} environment enabled`, 'success');
    }
}

function deleteEnvironment(name) {
    if (confirm(`Are you sure you want to delete ${name} environment? This action cannot be undone.`)) {
        showNotification(`${name} environment deleted`, 'danger');
    }
}

function applyTemplate(template) {
    if (confirm(`Are you sure you want to apply the ${template} template?`)) {
        showNotification(`Applying ${template} template...`, 'info');
    }
}

function runHealthCheck() {
    showNotification('Running environment health check...', 'info');
}

function viewHealthDetails() {
    showNotification('Opening environment health details...', 'info');
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
