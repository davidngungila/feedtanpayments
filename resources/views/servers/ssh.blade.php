@extends('layouts.app')

@section('title', 'SSH Access Management')
@section('description', 'Manage SSH access and security settings')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">SSH Access Management</h5>
                    <p class="card-subtitle">Manage SSH access, keys, and security settings</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-success" onclick="restartSSH()">
                        <i class="bx bx-refresh me-1"></i> Restart SSH
                    </button>
                    <button class="btn btn-outline-primary" onclick="addSSHKey()">
                        <i class="bx bx-key me-1"></i> Add Key
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- SSH Overview -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-success bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-lock text-success"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Status</h6>
                                <h4 class="mb-0 text-success">{{ $ssh_config['status'] }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-primary bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-info-circle text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Protocol</h6>
                                <h4 class="mb-0">{{ $ssh_config['protocol'] }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-info bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-link text-info"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Connections</h6>
                                <h4 class="mb-0 text-info">{{ $ssh_config['active_connections'] }}/{{ $ssh_config['max_connections'] }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-warning bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-port text-warning"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Port</h6>
                                <h4 class="mb-0 text-warning">{{ $ssh_config['port'] }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SSH Configuration -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">SSH Configuration</h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="text-muted" style="width: 150px;">Port:</td>
                                        <td><strong>{{ $ssh_config['port'] }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Protocol:</td>
                                        <td><strong>{{ $ssh_config['protocol'] }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Max Connections:</td>
                                        <td><strong>{{ $ssh_config['max_connections'] }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Active Connections:</td>
                                        <td><strong>{{ $ssh_config['active_connections'] }}</strong></td>
                                    </tr>
                                </table>
                                <div class="progress mt-3" style="height: 8px;">
                                    <div class="progress-bar bg-info" style="width: {{ ($ssh_config['active_connections'] / $ssh_config['max_connections']) * 100 }}%"></div>
                                </div>
                                <small class="text-muted">Connection Usage: {{ round(($ssh_config['active_connections'] / $ssh_config['max_connections']) * 100, 1) }}%</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Authentication Methods</h6>
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($ssh_config['auth_methods'] as $method)
                                    <span class="badge bg-success">{{ $method }}</span>
                                    @endforeach
                                </div>
                                <div class="mt-3">
                                    <small class="text-muted">Allowed Users:</small><br>
                                    <div class="d-flex flex-wrap gap-2 mt-1">
                                        @foreach($ssh_config['allowed_users'] as $user)
                                        <code>{{ $user }}</code>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SSH Keys -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">SSH Keys</h6>
                                <button class="btn btn-sm btn-outline-primary" onclick="addSSHKey()">
                                    <i class="bx bx-plus me-1"></i> Add Key
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>User</th>
                                                <th>Key Type</th>
                                                <th>Fingerprint</th>
                                                <th>Added</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($ssh_config['keys'] as $key)
                                            <tr>
                                                <td><strong>{{ $key['user'] }}</strong></td>
                                                <td>
                                                    @if(str_contains($key['key'], 'ssh-rsa'))
                                                        <span class="badge bg-primary">RSA</span>
                                                    @elseif(str_contains($key['key'], 'ssh-ed25519'))
                                                        <span class="badge bg-success">ED25519</span>
                                                    @else
                                                        <span class="badge bg-info">Other</span>
                                                    @endif
                                                </td>
                                                <td><code>{{ substr($key['key'], 0, 20) }}...</code></td>
                                                <td>{{ $key['added'] }}</td>
                                                <td><span class="badge bg-success">Active</span></td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a href="#" class="dropdown-item" onclick="viewKeyDetails('{{ $key['user'] }}')">
                                                                <i class="bx bx-eye me-2"></i> View Details
                                                            </a>
                                                            <a href="#" class="dropdown-item text-warning" onclick="disableKey('{{ $key['user'] }}')">
                                                                <i class="bx bx-pause me-2"></i> Disable
                                                            </a>
                                                            <div class="dropdown-divider"></div>
                                                            <a href="#" class="dropdown-item text-danger" onclick="removeKey('{{ $key['user'] }}')">
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
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Login Activity -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Recent Login Activity</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>User</th>
                                                <th>IP Address</th>
                                                <th>Time</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($ssh_config['recent_logins'] as $login)
                                            <tr>
                                                <td><strong>{{ $login['user'] }}</strong></td>
                                                <td><code>{{ $login['ip'] }}</code></td>
                                                <td>{{ $login['time'] }}</td>
                                                <td>
                                                    @if($login['status'] == 'success')
                                                        <span class="badge bg-success">Success</span>
                                                    @else
                                                        <span class="badge bg-danger">Failed</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a href="#" class="dropdown-item" onclick="viewLoginDetails('{{ $login['ip'] }}', '{{ $login['time'] }}')">
                                                                <i class="bx bx-eye me-2"></i> View Details
                                                            </a>
                                                            @if($login['status'] == 'failed')
                                                            <a href="#" class="dropdown-item text-warning" onclick="blockIP('{{ $login['ip'] }}')">
                                                                <i class="bx bx-block me-2"></i> Block IP
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
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Security Settings -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Security Settings</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="rootLogin" checked>
                                            <label class="form-check-label" for="rootLogin">
                                                Allow root login
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="passwordAuth" checked>
                                            <label class="form-check-label" for="passwordAuth">
                                                Allow password authentication
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="keyAuth" checked>
                                            <label class="form-check-label" for="keyAuth">
                                                Allow key authentication
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="portKnocking">
                                            <label class="form-check-label" for="portKnocking">
                                                Enable port knocking
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="fail2ban" checked>
                                            <label class="form-check-label" for="fail2ban">
                                                Enable Fail2Ban protection
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="twoFactor">
                                            <label class="form-check-label" for="twoFactor">
                                                Enable two-factor authentication
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="geoBlocking">
                                            <label class="form-check-label" for="geoBlocking">
                                                Enable geographic blocking
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="logging" checked>
                                            <label class="form-check-label" for="logging">
                                                Enable detailed logging
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-primary" onclick="saveSecuritySettings()">
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
function restartSSH() {
    if (confirm('Are you sure you want to restart SSH service? This will disconnect all active sessions.')) {
        showNotification('SSH service restart initiated', 'warning');
    }
}

function addSSHKey() {
    showNotification('Opening SSH key addition wizard...', 'info');
}

function viewKeyDetails(user) {
    showNotification(`Viewing SSH key details for user: ${user}`, 'info');
}

function disableKey(user) {
    if (confirm(`Are you sure you want to disable SSH key for user: ${user}?`)) {
        showNotification(`SSH key disabled for user: ${user}`, 'warning');
    }
}

function removeKey(user) {
    if (confirm(`Are you sure you want to remove SSH key for user: ${user}? This action cannot be undone.`)) {
        showNotification(`SSH key removed for user: ${user}`, 'danger');
    }
}

function viewLoginDetails(ip, time) {
    showNotification(`Viewing login details for IP: ${ip} at ${time}`, 'info');
}

function blockIP(ip) {
    if (confirm(`Are you sure you want to block IP address: ${ip}?`)) {
        showNotification(`IP address ${ip} has been blocked`, 'warning');
    }
}

function saveSecuritySettings() {
    showNotification('SSH security settings saved successfully', 'success');
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
