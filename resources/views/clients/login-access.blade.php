@extends('layouts.app')

@section('title', 'Client Login Access')
@section('description', 'Manage client login access and permissions')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">Client Login Access</h5>
                    <p class="card-subtitle">Manage client login access and permissions</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-success" onclick="createLogin()">
                        <i class="bx bx-plus me-1"></i> Create Login
                    </button>
                    <button class="btn btn-outline-primary" onclick="exportLogins()">
                        <i class="bx bx-download me-1"></i> Export
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- Login Statistics -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-primary bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-user text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Clients</h6>
                                <h4 class="mb-0">{{ count($clients) }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-success bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-check-circle text-success"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Active Logins</h6>
                                <h4 class="mb-0 text-success">{{ collect($clients)->where('status', 'active')->count() }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-warning bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-pause text-warning"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Suspended</h6>
                                <h4 class="mb-0 text-warning">{{ collect($clients)->where('status', 'suspended')->count() }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-info bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-history text-info"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Failed Attempts</h6>
                                <h4 class="mb-0 text-info">{{ collect($clients)->sum('failed_attempts') }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Client Login Table -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Client</th>
                                <th>Username</th>
                                <th>Status</th>
                                <th>Last Login</th>
                                <th>Session Timeout</th>
                                <th>IP Whitelist</th>
                                <th>Permissions</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clients as $client)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar bg-primary bg-opacity-10 rounded-circle me-2" style="width: 32px; height: 32px;">
                                            <i class="bx bx-user text-primary"></i>
                                        </div>
                                        <div>
                                            <strong>{{ $client['name'] }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $client['email'] }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td><code>{{ $client['username'] }}</code></td>
                                <td>
                                    <span class="badge bg-{{ $client['status'] == 'active' ? 'success' : 'warning' }}">
                                        {{ $client['status'] }}
                                    </span>
                                </td>
                                <td>
                                    @if($client['last_login'])
                                        <small>{{ \Carbon\Carbon::parse($client['last_login'])->format('M d, H:i') }}</small>
                                    @else
                                        <span class="text-muted">Never</span>
                                    @endif
                                </td>
                                <td><small>{{ $client['session_timeout'] }} min</small></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-shield"></i> {{ count($client['ip_whitelist']) }}
                                        </button>
                                        <div class="dropdown-menu">
                                            @foreach($client['ip_whitelist'] as $ip)
                                            <div class="dropdown-item">
                                                <small><code>{{ $ip }}</code></small>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-key"></i> {{ count($client['permissions']) }}
                                        </button>
                                        <div class="dropdown-menu">
                                            @foreach($client['permissions'] as $permission)
                                            <div class="dropdown-item">
                                                <small>{{ ucfirst($permission) }}</small>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a href="#" class="dropdown-item" onclick="viewLogin({{ $client['id'] }})">
                                                <i class="bx bx-eye me-2"></i> View Details
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="editLogin({{ $client['id'] }})">
                                                <i class="bx bx-edit me-2"></i> Edit Login
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="resetPassword({{ $client['id'] }})">
                                                <i class="bx bx-refresh me-2"></i> Reset Password
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="managePermissions({{ $client['id'] }})">
                                                <i class="bx bx-key me-2"></i> Manage Permissions
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="manageIPs({{ $client['id'] }})">
                                                <i class="bx bx-shield me-2"></i> Manage IPs
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            @if($client['status'] == 'active')
                                            <a href="#" class="dropdown-item text-warning" onclick="suspendLogin({{ $client['id'] }})">
                                                <i class="bx bx-pause me-2"></i> Suspend
                                            </a>
                                            @else
                                            <a href="#" class="dropdown-item text-success" onclick="activateLogin({{ $client['id'] }})">
                                                <i class="bx bx-play me-2"></i> Activate
                                            </a>
                                            @endif
                                            <a href="#" class="dropdown-item text-danger" onclick="deleteLogin({{ $client['id'] }})">
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

                <!-- Login Activity Chart -->
                <div class="row mt-4">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Login Activity (Last 7 Days)</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="loginChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Login Status</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="statusChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Login Logs -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Recent Login Activity</h6>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-outline-warning btn-sm" onclick="clearFailedAttempts()">
                                        <i class="bx bx-refresh me-1"></i> Clear Failed Attempts
                                    </button>
                                    <button class="btn btn-outline-info btn-sm" onclick="viewAllLogs()">
                                        <i class="bx bx-history me-1"></i> View All Logs
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Client</th>
                                                <th>Username</th>
                                                <th>IP Address</th>
                                                <th>Time</th>
                                                <th>Status</th>
                                                <th>Details</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($loginLogs as $log)
                                            <tr>
                                                <td><strong>{{ $log['client_name'] }}</strong></td>
                                                <td><code>{{ $log['username'] }}</code></td>
                                                <td><code>{{ $log['ip'] }}</code></td>
                                                <td>{{ \Carbon\Carbon::parse($log['time'])->format('M d, H:i:s') }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $log['status'] == 'success' ? 'success' : 'danger' }}">
                                                        {{ $log['status'] }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if($log['status'] == 'failed')
                                                        <small class="text-danger">Invalid credentials</small>
                                                    @else
                                                        <small class="text-success">Successful login</small>
                                                    @endif
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

                <!-- Login Security Settings -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Login Security Settings</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="mb-3">Security Policies</h6>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="strongPassword" checked>
                                            <label class="form-check-label" for="strongPassword">
                                                Require strong passwords
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="twoFactorAuth">
                                            <label class="form-check-label" for="twoFactorAuth">
                                                Enable two-factor authentication
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="ipWhitelist" checked>
                                            <label class="form-check-label" for="ipWhitelist">
                                                Require IP whitelist
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="loginAttempts" checked>
                                            <label class="form-check-label" for="loginAttempts">
                                                Limit login attempts
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="sessionTimeout" checked>
                                            <label class="form-check-label" for="sessionTimeout">
                                                Enforce session timeout
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="logLoginAttempts" checked>
                                            <label class="form-check-label" for="logLoginAttempts">
                                                Log all login attempts
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="mb-3">Security Configuration</h6>
                                        <div class="mb-3">
                                            <label for="maxAttempts" class="form-label">Max Login Attempts</label>
                                            <input type="number" class="form-control" id="maxAttempts" value="5" min="1" max="20">
                                        </div>
                                        <div class="mb-3">
                                            <label for="lockoutDuration" class="form-label">Lockout Duration (minutes)</label>
                                            <input type="number" class="form-control" id="lockoutDuration" value="30" min="1" max="1440">
                                        </div>
                                        <div class="mb-3">
                                            <label for="defaultTimeout" class="form-label">Default Session Timeout (minutes)</label>
                                            <input type="number" class="form-control" id="defaultTimeout" value="30" min="5" max="1440">
                                        </div>
                                        <div class="mb-3">
                                            <label for="passwordExpiry" class="form-label">Password Expiry (days)</label>
                                            <input type="number" class="form-control" id="passwordExpiry" value="90" min="1" max="365">
                                        </div>
                                        <div class="mb-3">
                                            <label for="allowedIPs" class="form-label">Default Allowed IPs</label>
                                            <textarea class="form-control" id="allowedIPs" rows="3" placeholder="Enter one IP per line">0.0.0.0/0</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-primary" onclick="saveSecuritySettings()">
                                        <i class="bx bx-save me-1"></i> Save Settings
                                    </button>
                                    <button class="btn btn-outline-warning" onclick="testSecurity()">
                                        <i class="bx bx-test-tube me-1"></i> Test Security
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
// Login Activity Chart
const loginCtx = document.getElementById('loginChart').getContext('2d');
new Chart(loginCtx, {
    type: 'line',
    data: {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        datasets: [{
            label: 'Successful Logins',
            data: [45, 52, 48, 58, 62, 35, 28],
            borderColor: '#28a745',
            backgroundColor: 'rgba(40, 167, 69, 0.1)',
            tension: 0.4
        }, {
            label: 'Failed Logins',
            data: [3, 5, 2, 4, 3, 1, 2],
            borderColor: '#dc3545',
            backgroundColor: 'rgba(220, 53, 69, 0.1)',
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Status Chart
const statusCtx = document.getElementById('statusChart').getContext('2d');
new Chart(statusCtx, {
    type: 'doughnut',
    data: {
        labels: ['Active', 'Suspended'],
        datasets: [{
            data: [2, 1],
            backgroundColor: ['#28a745', '#ffc107']
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

function createLogin() {
    showNotification('Create login dialog opened', 'info');
}

function exportLogins() {
    showNotification('Exporting login data...', 'info');
}

function viewLogin(id) {
    showNotification(`Viewing login details for client ${id}...`, 'info');
}

function editLogin(id) {
    showNotification(`Editing login for client ${id}...`, 'info');
}

function resetPassword(id) {
    if (confirm('Are you sure you want to reset the password for this client?')) {
        showNotification(`Password reset for client ${id}`, 'success');
    }
}

function managePermissions(id) {
    showNotification(`Managing permissions for client ${id}...`, 'info');
}

function manageIPs(id) {
    showNotification(`Managing IP whitelist for client ${id}...`, 'info');
}

function suspendLogin(id) {
    if (confirm('Are you sure you want to suspend this client login?')) {
        showNotification(`Login suspended for client ${id}`, 'warning');
    }
}

function activateLogin(id) {
    if (confirm('Are you sure you want to activate this client login?')) {
        showNotification(`Login activated for client ${id}`, 'success');
    }
}

function deleteLogin(id) {
    if (confirm('Are you sure you want to delete this client login?')) {
        if (confirm('This action cannot be undone. Are you absolutely sure?')) {
            showNotification(`Login deleted for client ${id}`, 'danger');
        }
    }
}

function clearFailedAttempts() {
    if (confirm('Are you sure you want to clear all failed login attempts?')) {
        showNotification('Failed login attempts cleared', 'success');
    }
}

function viewAllLogs() {
    showNotification('Opening all login logs...', 'info');
}

function saveSecuritySettings() {
    showNotification('Security settings saved successfully', 'success');
}

function testSecurity() {
    showNotification('Testing security configuration...', 'info');
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
