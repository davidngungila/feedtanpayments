@extends('layouts.app')

@section('title', 'phpMyAdmin Access')
@section('description', 'Manage phpMyAdmin database administration')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">phpMyAdmin Access</h5>
                    <p class="card-subtitle">Manage phpMyAdmin database administration</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-success" onclick="openPhpMyAdmin()">
                        <i class="bx bx-external-link me-1"></i> Open phpMyAdmin
                    </button>
                    <button class="btn btn-outline-primary" onclick="updatePhpMyAdmin()">
                        <i class="bx bx-refresh me-1"></i> Update
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- phpMyAdmin Statistics -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-primary bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-data text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Version</h6>
                                <h4 class="mb-0">{{ $phpMyAdminConfig['version'] }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-success bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-check-circle text-success"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Status</h6>
                                <h4 class="mb-0 text-success">{{ $phpMyAdminConfig['status'] }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-info bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-user text-info"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Active Sessions</h6>
                                <h4 class="mb-0 text-info">{{ $stats['active_sessions'] }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-warning bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-history text-warning"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Logins Today</h6>
                                <h4 class="mb-0 text-warning">{{ $stats['total_logins_today'] }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- phpMyAdmin Configuration -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Configuration</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <tbody>
                                            <tr>
                                                <td><strong>URL</strong></td>
                                                <td><a href="#" onclick="openPhpMyAdmin()">{{ $phpMyAdminConfig['url'] }}</a></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Authentication Type</strong></td>
                                                <td><span class="badge bg-info">{{ $phpMyAdminConfig['auth_type'] }}</span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Max Upload Size</strong></td>
                                                <td><code>{{ $phpMyAdminConfig['max_upload_size'] }}</code></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Session Timeout</strong></td>
                                                <td><code>{{ $phpMyAdminConfig['session_timeout'] }} min</code></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Compression</strong></td>
                                                <td>
                                                    @if($phpMyAdminConfig['compress'])
                                                        <span class="badge bg-success">Enabled</span>
                                                    @else
                                                        <span class="badge bg-secondary">Disabled</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Bzip2</strong></td>
                                                <td>
                                                    @if($phpMyAdminConfig['bzip'])
                                                        <span class="badge bg-success">Enabled</span>
                                                    @else
                                                        <span class="badge bg-secondary">Disabled</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Zip</strong></td>
                                                <td>
                                                    @if($phpMyAdminConfig['zip'])
                                                        <span class="badge bg-success">Enabled</span>
                                                    @else
                                                        <span class="badge bg-secondary">Disabled</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <button class="btn btn-outline-primary btn-sm w-100" onclick="editConfiguration()">
                                    <i class="bx bx-cog me-1"></i> Edit Configuration
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Login Statistics</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="loginChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Login Activity -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Recent Login Activity</h6>
                                <button class="btn btn-outline-info btn-sm" onclick="viewAllLogins()">
                                    <i class="bx bx-history me-1"></i> View All
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Username</th>
                                                <th>IP Address</th>
                                                <th>Time</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                                <th>Details</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($recentLogins as $login)
                                            <tr>
                                                <td><strong>{{ $login['username'] }}</strong></td>
                                                <td><code>{{ $login['ip'] }}</code></td>
                                                <td>{{ \Carbon\Carbon::parse($login['time'])->format('M d, H:i') }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $login['status'] == 'success' ? 'success' : 'danger' }}">
                                                        {{ $login['status'] }}
                                                    </span>
                                                </td>
                                                <td><span class="badge bg-info">{{ $login['action'] }}</span></td>
                                                <td>
                                                    @if($login['status'] == 'failed')
                                                        <button class="btn btn-outline-warning btn-sm" onclick="viewFailedLoginDetails('{{ $login['ip'] }}')">
                                                            <i class="bx bx-info-circle"></i> Details
                                                        </button>
                                                    @else
                                                        <button class="btn btn-outline-info btn-sm" onclick="viewSessionDetails('{{ $login['username'] }}')">
                                                            <i class="bx bx-info-circle"></i> Session
                                                        </button>
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

                <!-- Security Settings -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Security Settings</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="mb-3">Authentication Settings</h6>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="twoFactorAuth" checked>
                                            <label class="form-check-label" for="twoFactorAuth">
                                                Enable two-factor authentication
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="ipWhitelist">
                                            <label class="form-check-label" for="ipWhitelist">
                                                Enable IP whitelist
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="loginAttempts" checked>
                                            <label class="form-check-label" for="loginAttempts">
                                                Limit login attempts
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="captchaLogin">
                                            <label class="form-check-label" for="captchaLogin">
                                                Require CAPTCHA for login
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="forceHTTPS" checked>
                                            <label class="form-check-label" for="forceHTTPS">
                                                Force HTTPS access
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="mb-3">Session Management</h6>
                                        <div class="mb-3">
                                            <label for="maxSessions" class="form-label">Max Sessions per User</label>
                                            <input type="number" class="form-control" id="maxSessions" value="3" min="1" max="10">
                                        </div>
                                        <div class="mb-3">
                                            <label for="sessionLifetime" class="form-label">Session Lifetime (minutes)</label>
                                            <input type="number" class="form-control" id="sessionLifetime" value="1440" min="30" max="10080">
                                        </div>
                                        <div class="mb-3">
                                            <label for="idleTimeout" class="form-label">Idle Timeout (minutes)</label>
                                            <input type="number" class="form-control" id="idleTimeout" value="30" min="5" max="480">
                                        </div>
                                        <div class="mb-3">
                                            <label for="concurrentLogins" class="form-label">Max Concurrent Logins</label>
                                            <input type="number" class="form-control" id="concurrentLogins" value="1" min="1" max="5">
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-primary" onclick="saveSecuritySettings()">
                                        <i class="bx bx-save me-1"></i> Save Security Settings
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- phpMyAdmin Features -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Available Features</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body text-center">
                                                <h6 class="card-title">Database Browser</h6>
                                                <p class="card-text small">Browse and manage database structures</p>
                                                <span class="badge bg-success">Enabled</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body text-center">
                                                <h6 class="card-title">SQL Editor</h6>
                                                <p class="card-text small">Execute SQL queries and scripts</p>
                                                <span class="badge bg-success">Enabled</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body text-center">
                                                <h6 class="card-title">Import/Export</h6>
                                                <p class="card-text small">Import and export database data</p>
                                                <span class="badge bg-success">Enabled</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body text-center">
                                                <h6 class="card-title">User Management</h6>
                                                <p class="card-text small">Manage database users and privileges</p>
                                                <span class="badge bg-success">Enabled</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Quick Actions</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="d-grid">
                                            <button class="btn btn-outline-primary btn-sm" onclick="openPhpMyAdmin()">
                                                <i class="bx bx-external-link me-1"></i> Open phpMyAdmin
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="d-grid">
                                            <button class="btn btn-outline-info btn-sm" onclick="clearSessions()">
                                                <i class="bx bx-trash me-1"></i> Clear Sessions
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="d-grid">
                                            <button class="btn btn-outline-warning btn-sm" onclick="viewLogs()">
                                                <i class="bx bx-history me-1"></i> View Logs
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="d-grid">
                                            <button class="btn btn-outline-success btn-sm" onclick="backupConfig()">
                                                <i class="bx bx-download me-1"></i> Backup Config
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="d-grid">
                                            <button class="btn btn-outline-secondary btn-sm" onclick="checkUpdates()">
                                                <i class="bx bx-refresh me-1"></i> Check Updates
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="d-grid">
                                            <button class="btn btn-outline-danger btn-sm" onclick="restartService()">
                                                <i class="bx bx-reset me-1"></i> Restart Service
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
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Login Statistics Chart
const loginCtx = document.getElementById('loginChart').getContext('2d');
new Chart(loginCtx, {
    type: 'bar',
    data: {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        datasets: [{
            label: 'Successful Logins',
            data: [25, 32, 28, 35, 30, 18, 15],
            backgroundColor: '#28a745'
        }, {
            label: 'Failed Logins',
            data: [3, 5, 2, 4, 3, 1, 2],
            backgroundColor: '#dc3545'
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

function openPhpMyAdmin() {
    showNotification('Opening phpMyAdmin...', 'info');
}

function updatePhpMyAdmin() {
    showNotification('Checking for phpMyAdmin updates...', 'info');
}

function editConfiguration() {
    showNotification('Opening phpMyAdmin configuration...', 'info');
}

function viewAllLogins() {
    showNotification('Opening all login history...', 'info');
}

function viewFailedLoginDetails(ip) {
    showNotification(`Viewing failed login details for ${ip}...`, 'info');
}

function viewSessionDetails(username) {
    showNotification(`Viewing session details for ${username}...`, 'info');
}

function saveSecuritySettings() {
    showNotification('Security settings saved successfully', 'success');
}

function clearSessions() {
    if (confirm('Are you sure you want to clear all active sessions?')) {
        showNotification('All sessions cleared', 'warning');
    }
}

function viewLogs() {
    showNotification('Opening phpMyAdmin logs...', 'info');
}

function backupConfig() {
    showNotification('Creating configuration backup...', 'info');
}

function checkUpdates() {
    showNotification('Checking for phpMyAdmin updates...', 'info');
}

function restartService() {
    if (confirm('Are you sure you want to restart phpMyAdmin service?')) {
        showNotification('Restarting phpMyAdmin service...', 'warning');
    }
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
