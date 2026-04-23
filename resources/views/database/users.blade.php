@extends('layouts.app')

@section('title', 'Database Users')
@section('description', 'Manage database users and permissions')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">Database Users</h5>
                    <p class="card-subtitle">Manage database users and permissions</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-success" onclick="addUser()">
                        <i class="bx bx-plus me-1"></i> Add User
                    </button>
                    <button class="btn btn-outline-primary" onclick="testAllUsers()">
                        <i class="bx bx-test-tube me-1"></i> Test All
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- Users Statistics -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-primary bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-user text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Users</h6>
                                <h4 class="mb-0">{{ $stats['total_users'] }}</h4>
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
                                <h4 class="mb-0 text-success">{{ $stats['active_users'] }}</h4>
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
                                <h4 class="mb-0 text-warning">{{ $stats['suspended_users'] }}</h4>
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
                                <h4 class="mb-0 text-info">{{ $stats['total_connections'] }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Users List -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Host</th>
                                <th>Databases</th>
                                <th>Privileges</th>
                                <th>Created</th>
                                <th>Last Login</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-user text-primary me-2"></i>
                                        <strong>{{ $user['username'] }}</strong>
                                    </div>
                                </td>
                                <td><code>{{ $user['host'] }}</code></td>
                                <td>
                                    <div class="d-flex flex-wrap gap-1">
                                        @foreach(array_slice($user['databases'], 0, 2) as $db)
                                        <span class="badge bg-info">{{ $db }}</span>
                                        @endforeach
                                        @if(count($user['databases']) > 2)
                                        <span class="badge bg-secondary">+{{ count($user['databases']) - 2 }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-wrap gap-1">
                                        @foreach(array_slice($user['privileges'], 0, 2) as $priv)
                                        <span class="badge bg-primary">{{ $priv }}</span>
                                        @endforeach
                                        @if(count($user['privileges']) > 2)
                                        <span class="badge bg-secondary">+{{ count($user['privileges']) - 2 }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($user['created'])->format('M d, Y') }}</td>
                                <td>
                                    @if($user['last_login'])
                                        {{ \Carbon\Carbon::parse($user['last_login'])->format('M d, H:i') }}
                                    @else
                                        <span class="text-muted">Never</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-{{ $user['status'] == 'active' ? 'success' : ($user['status'] == 'suspended' ? 'warning' : 'secondary') }}">
                                        {{ $user['status'] }}
                                    </span>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a href="#" class="dropdown-item" onclick="testUser('{{ $user['username'] }}')">
                                                <i class="bx bx-test-tube me-2"></i> Test Connection
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="viewPrivileges('{{ $user['username'] }}')">
                                                <i class="bx bx-key me-2"></i> View Privileges
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="editUser('{{ $user['username'] }}')">
                                                <i class="bx bx-edit me-2"></i> Edit User
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="resetPassword('{{ $user['username'] }}')">
                                                <i class="bx bx-refresh me-2"></i> Reset Password
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            @if($user['status'] == 'active')
                                            <a href="#" class="dropdown-item text-warning" onclick="suspendUser('{{ $user['username'] }}')">
                                                <i class="bx bx-pause me-2"></i> Suspend
                                            </a>
                                            @else
                                            <a href="#" class="dropdown-item text-success" onclick="activateUser('{{ $user['username'] }}')">
                                                <i class="bx bx-play me-2"></i> Activate
                                            </a>
                                            @endif
                                            <a href="#" class="dropdown-item text-danger" onclick="deleteUser('{{ $user['username'] }}')">
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

                <!-- User Privileges Overview -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Privilege Distribution</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="privilegeChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">User Activity</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="activityChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Templates -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">User Templates</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body text-center">
                                                <h6 class="card-title">Administrator</h6>
                                                <p class="card-text small">Full access to all databases</p>
                                                <button class="btn btn-outline-danger btn-sm" onclick="createUserFromTemplate('administrator')">
                                                    Create User
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body text-center">
                                                <h6 class="card-title">Web User</h6>
                                                <p class="card-text small">Read/write access to web databases</p>
                                                <button class="btn btn-outline-primary btn-sm" onclick="createUserFromTemplate('webuser')">
                                                    Create User
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body text-center">
                                                <h6 class="card-title">Backup User</h6>
                                                <p class="card-text small">Read-only access for backups</p>
                                                <button class="btn btn-outline-info btn-sm" onclick="createUserFromTemplate('backup')">
                                                    Create User
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body text-center">
                                                <h6 class="card-title">Read Only</h6>
                                                <p class="card-text small">Read-only access to specific databases</p>
                                                <button class="btn btn-outline-warning btn-sm" onclick="createUserFromTemplate('readonly')">
                                                    Create User
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Settings -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">User Management Settings</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="mb-3">Security Settings</h6>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="enforceStrongPassword" checked>
                                            <label class="form-check-label" for="enforceStrongPassword">
                                                Enforce strong passwords
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="passwordExpiration">
                                            <label class="form-check-label" for="passwordExpiration">
                                                Password expiration (90 days)
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="loginAttempts" checked>
                                            <label class="form-check-label" for="loginAttempts">
                                                Limit login attempts
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="logUserActivity" checked>
                                            <label class="form-check-label" for="logUserActivity">
                                                Log user activity
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="mb-3">Connection Settings</h6>
                                        <div class="mb-3">
                                            <label for="maxConnections" class="form-label">Max Connections per User</label>
                                            <input type="number" class="form-control" id="maxConnections" value="10" min="1" max="100">
                                        </div>
                                        <div class="mb-3">
                                            <label for="connectionTimeout" class="form-label">Connection Timeout (minutes)</label>
                                            <input type="number" class="form-control" id="connectionTimeout" value="30" min="1" max="480">
                                        </div>
                                        <div class="mb-3">
                                            <label for="idleTimeout" class="form-label">Idle Timeout (minutes)</label>
                                            <input type="number" class="form-control" id="idleTimeout" value="60" min="1" max="1440">
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-primary" onclick="saveUserSettings()">
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
// Privilege Distribution Chart
const privilegeCtx = document.getElementById('privilegeChart').getContext('2d');
new Chart(privilegeCtx, {
    type: 'doughnut',
    data: {
        labels: ['ALL PRIVILEGES', 'SELECT', 'INSERT', 'UPDATE', 'DELETE', 'LOCK TABLES'],
        datasets: [{
            data: [1, 1, 1, 1, 1, 1],
            backgroundColor: ['#dc3545', '#007bff', '#28a745', '#ffc107', '#fd7e14', '#6f42c1']
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

// User Activity Chart
const activityCtx = document.getElementById('activityChart').getContext('2d');
new Chart(activityCtx, {
    type: 'bar',
    data: {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        datasets: [{
            label: 'User Connections',
            data: [25, 32, 28, 35, 30, 18, 15],
            backgroundColor: '#007bff'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

function addUser() {
    showNotification('Add user dialog opened', 'info');
}

function testAllUsers() {
    if (confirm('Are you sure you want to test all users?')) {
        showNotification('Testing all user connections...', 'info');
    }
}

function testUser(username) {
    showNotification(`Testing connection for user: ${username}`, 'info');
}

function viewPrivileges(username) {
    showNotification(`Viewing privileges for user: ${username}`, 'info');
}

function editUser(username) {
    showNotification(`Editing user: ${username}`, 'info');
}

function resetPassword(username) {
    if (confirm(`Are you sure you want to reset password for ${username}?`)) {
        showNotification(`Password reset for ${username}`, 'warning');
    }
}

function suspendUser(username) {
    if (confirm(`Are you sure you want to suspend user ${username}?`)) {
        showNotification(`User ${username} suspended`, 'warning');
    }
}

function activateUser(username) {
    if (confirm(`Are you sure you want to activate user ${username}?`)) {
        showNotification(`User ${username} activated`, 'success');
    }
}

function deleteUser(username) {
    if (confirm(`Are you sure you want to delete user ${username}?`)) {
        showNotification(`User ${username} deleted`, 'danger');
    }
}

function createUserFromTemplate(template) {
    showNotification(`Creating user from ${template} template...`, 'info');
}

function saveUserSettings() {
    showNotification('User management settings saved successfully', 'success');
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
