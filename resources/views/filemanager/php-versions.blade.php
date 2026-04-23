@extends('layouts.app')

@section('title', 'PHP Versions Management')
@section('description', 'Manage PHP versions and configurations')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">PHP Versions Management</h5>
                    <p class="card-subtitle">Manage PHP versions and configurations</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-success" onclick="installPHPVersion()">
                        <i class="bx bx-plus me-1"></i> Install Version
                    </button>
                    <button class="btn btn-outline-primary" onclick="updateAllVersions()">
                        <i class="bx bx-refresh me-1"></i> Update All
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- PHP Versions Statistics -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-primary bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-code text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Versions</h6>
                                <h4 class="mb-0">{{ $stats['total_versions'] }}</h4>
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
                                <h4 class="mb-0 text-success">{{ $stats['active_versions'] }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-warning bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-alert text-warning"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Deprecated</h6>
                                <h4 class="mb-0 text-warning">{{ $stats['deprecated_versions'] }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-info bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-globe text-info"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Sites</h6>
                                <h4 class="mb-0 text-info">{{ $stats['total_sites'] }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- PHP Versions List -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Version</th>
                                <th>Status</th>
                                <th>Sites</th>
                                <th>Extensions</th>
                                <th>Memory Limit</th>
                                <th>Max Execution</th>
                                <th>OPcache</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($phpVersions as $php)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-code text-primary me-2"></i>
                                        <strong>PHP {{ $php['version'] }}</strong>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $php['status'] == 'active' ? 'success' : ($php['status'] == 'deprecated' ? 'warning' : 'secondary') }}">
                                        {{ $php['status'] }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $php['sites'] }} sites</span>
                                </td>
                                <td>
                                    <div class="d-flex flex-wrap gap-1">
                                        @foreach(array_slice($php['extensions'], 0, 3) as $ext)
                                        <span class="badge bg-primary">{{ $ext }}</span>
                                        @endforeach
                                        @if(count($php['extensions']) > 3)
                                        <span class="badge bg-secondary">+{{ count($php['extensions']) - 3 }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td><code>{{ $php['memory_limit'] }}</code></td>
                                <td><code>{{ $php['max_execution_time'] == '0' ? 'Unlimited' : $php['max_execution_time'] . 's' }}</code></td>
                                <td>
                                    <span class="badge bg-{{ $php['opcache'] ? 'success' : 'secondary' }}">
                                        {{ $php['opcache'] ? 'Enabled' : 'Disabled' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a href="#" class="dropdown-item" onclick="configurePHP('{{ $php['version'] }}')">
                                                <i class="bx bx-cog me-2"></i> Configure
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="manageExtensions('{{ $php['version'] }}')">
                                                <i class="bx bx-puzzle me-2"></i> Extensions
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="viewPhpInfo('{{ $php['version'] }}')">
                                                <i class="bx bx-info-circle me-2"></i> PHP Info
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="viewSites('{{ $php['version'] }}')">
                                                <i class="bx bx-globe me-2"></i> View Sites
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            @if($php['status'] == 'active')
                                            <a href="#" class="dropdown-item text-warning" onclick="deprecatePHP('{{ $php['version'] }}')">
                                                <i class="bx bx-alert me-2"></i> Deprecate
                                            </a>
                                            @elseif($php['status'] == 'deprecated')
                                            <a href="#" class="dropdown-item text-success" onclick="activatePHP('{{ $php['version'] }}')">
                                                <i class="bx bx-play me-2"></i> Activate
                                            </a>
                                            @endif
                                            <a href="#" class="dropdown-item text-info" onclick="updatePHP('{{ $php['version'] }}')">
                                                <i class="bx bx-refresh me-2"></i> Update
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            @if($php['sites'] == 0)
                                            <a href="#" class="dropdown-item text-danger" onclick="uninstallPHP('{{ $php['version'] }}')">
                                                <i class="bx bx-trash me-2"></i> Uninstall
                                            </a>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Extension Management -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Available Extensions</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Extension</th>
                                                <th>PHP 8.3</th>
                                                <th>PHP 8.2</th>
                                                <th>PHP 8.1</th>
                                                <th>PHP 8.0</th>
                                                <th>PHP 7.4</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><strong>curl</strong></td>
                                                <td><span class="badge bg-success">✓</span></td>
                                                <td><span class="badge bg-success">✓</span></td>
                                                <td><span class="badge bg-success">✓</span></td>
                                                <td><span class="badge bg-success">✓</span></td>
                                                <td><span class="badge bg-success">✓</span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>gd</strong></td>
                                                <td><span class="badge bg-success">✓</span></td>
                                                <td><span class="badge bg-success">✓</span></td>
                                                <td><span class="badge bg-success">✓</span></td>
                                                <td><span class="badge bg-success">✓</span></td>
                                                <td><span class="badge bg-success">✓</span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>imagick</strong></td>
                                                <td><span class="badge bg-success">✓</span></td>
                                                <td><span class="badge bg-success">✓</span></td>
                                                <td><span class="badge bg-success">✓</span></td>
                                                <td><span class="badge bg-warning">✗</span></td>
                                                <td><span class="badge bg-danger">✗</span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>redis</strong></td>
                                                <td><span class="badge bg-success">✓</span></td>
                                                <td><span class="badge bg-success">✓</span></td>
                                                <td><span class="badge bg-success">✓</span></td>
                                                <td><span class="badge bg-success">✓</span></td>
                                                <td><span class="badge bg-secondary">✗</span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>xdebug</strong></td>
                                                <td><span class="badge bg-success">✓</span></td>
                                                <td><span class="badge bg-success">✓</span></td>
                                                <td><span class="badge bg-success">✓</span></td>
                                                <td><span class="badge bg-success">✓</span></td>
                                                <td><span class="badge bg-success">✓</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <button class="btn btn-outline-primary btn-sm w-100 mt-2" onclick="manageAllExtensions()">
                                    <i class="bx bx-puzzle me-1"></i> Manage All Extensions
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Version Usage</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="versionUsageChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- PHP Configuration -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Global PHP Configuration</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="mb-3">Default Settings</h6>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="autoUpdate" checked>
                                            <label class="form-check-label" for="autoUpdate">
                                                Enable automatic PHP updates
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="securityUpdates" checked>
                                            <label class="form-check-label" for="securityUpdates">
                                                Enable security updates only
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="backupBeforeUpdate" checked>
                                            <label class="form-check-label" for="backupBeforeUpdate">
                                                Create backup before updates
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="notifyUpdates" checked>
                                            <label class="form-check-label" for="notifyUpdates">
                                                Notify about available updates
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="mb-3">Version Preferences</h6>
                                        <div class="mb-3">
                                            <label for="defaultVersion" class="form-label">Default PHP Version</label>
                                            <select class="form-select" id="defaultVersion">
                                                <option value="8.3" selected>PHP 8.3</option>
                                                <option value="8.2">PHP 8.2</option>
                                                <option value="8.1">PHP 8.1</option>
                                                <option value="8.0">PHP 8.0</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="updateChannel" class="form-label">Update Channel</label>
                                            <select class="form-select" id="updateChannel">
                                                <option value="stable" selected>Stable</option>
                                                <option value="beta">Beta</option>
                                                <option value="nightly">Nightly</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="maxVersions" class="form-label">Maximum Versions Installed</label>
                                            <input type="number" class="form-control" id="maxVersions" value="5" min="1" max="10">
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-primary" onclick="savePHPSettings()">
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Version Usage Chart
const versionCtx = document.getElementById('versionUsageChart').getContext('2d');
new Chart(versionCtx, {
    type: 'doughnut',
    data: {
        labels: ['PHP 8.3', 'PHP 8.2', 'PHP 8.1', 'PHP 8.0', 'PHP 7.4'],
        datasets: [{
            data: [2, 8, 3, 1, 0],
            backgroundColor: ['#28a745', '#007bff', '#ffc107', '#fd7e14', '#dc3545']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

function installPHPVersion() {
    showNotification('Install PHP version dialog opened', 'info');
}

function updateAllVersions() {
    if (confirm('Are you sure you want to update all PHP versions?')) {
        showNotification('Updating all PHP versions...', 'info');
    }
}

function configurePHP(version) {
    showNotification(`Configuring PHP ${version}`, 'info');
}

function manageExtensions(version) {
    showNotification(`Managing extensions for PHP ${version}`, 'info');
}

function viewPhpInfo(version) {
    showNotification(`Viewing PHP info for ${version}`, 'info');
}

function viewSites(version) {
    showNotification(`Viewing sites using PHP ${version}`, 'info');
}

function deprecatePHP(version) {
    if (confirm(`Are you sure you want to deprecate PHP ${version}?`)) {
        showNotification(`PHP ${version} deprecated`, 'warning');
    }
}

function activatePHP(version) {
    if (confirm(`Are you sure you want to activate PHP ${version}?`)) {
        showNotification(`PHP ${version} activated`, 'success');
    }
}

function updatePHP(version) {
    showNotification(`Updating PHP ${version}...`, 'info');
}

function uninstallPHP(version) {
    if (confirm(`Are you sure you want to uninstall PHP ${version}? This action cannot be undone.`)) {
        showNotification(`PHP ${version} uninstalled`, 'danger');
    }
}

function manageAllExtensions() {
    showNotification('Opening extension management...', 'info');
}

function savePHPSettings() {
    showNotification('PHP settings saved successfully', 'success');
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
