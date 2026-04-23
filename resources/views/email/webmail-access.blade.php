@extends('layouts.app')

@section('title', 'Webmail Access')
@section('description', 'Manage webmail clients and access')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">Webmail Access</h5>
                    <p class="card-subtitle">Manage webmail clients and access</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-success" onclick="installWebmail()">
                        <i class="bx bx-plus me-1"></i> Install Client
                    </button>
                    <button class="btn btn-outline-primary" onclick="openWebmail()">
                        <i class="bx bx-envelope-open me-1"></i> Open Webmail
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- Webmail Statistics -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-primary bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-envelope text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Clients</h6>
                                <h4 class="mb-0">{{ $stats['total_clients'] }}</h4>
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
                                <h4 class="mb-0 text-success">{{ $stats['active_clients'] }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-info bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-user text-info"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Users</h6>
                                <h4 class="mb-0 text-info">{{ $stats['total_users'] }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-warning bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-time text-warning"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Active Sessions</h6>
                                <h4 class="mb-0 text-warning">{{ $stats['active_sessions'] }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Webmail Clients -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Client</th>
                                <th>URL</th>
                                <th>Version</th>
                                <th>Status</th>
                                <th>Users</th>
                                <th>Last Login</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($webmailClients as $client)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-envelope text-primary me-2"></i>
                                        <strong>{{ $client['name'] }}</strong>
                                    </div>
                                </td>
                                <td><code>{{ $client['url'] }}</code></td>
                                <td><span class="badge bg-info">{{ $client['version'] }}</span></td>
                                <td>
                                    <span class="badge bg-{{ $client['status'] == 'active' ? 'success' : 'secondary' }}">
                                        {{ $client['status'] }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <strong>{{ $client['users'] }}</strong>
                                        <small class="text-muted ms-1">users</small>
                                    </div>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($client['last_login'])->format('M d, H:i') }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a href="#" class="dropdown-item" onclick="openClient('{{ $client['name'] }}')">
                                                <i class="bx bx-envelope-open me-2"></i> Open Client
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="configureClient('{{ $client['name'] }}')">
                                                <i class="bx bx-cog me-2"></i> Configure
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="updateClient('{{ $client['name'] }}')">
                                                <i class="bx bx-refresh me-2"></i> Update
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="viewUsers('{{ $client['name'] }}')">
                                                <i class="bx bx-user me-2"></i> View Users
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            @if($client['status'] == 'active')
                                            <a href="#" class="dropdown-item text-warning" onclick="disableClient('{{ $client['name'] }}')">
                                                <i class="bx bx-pause me-2"></i> Disable
                                            </a>
                                            @else
                                            <a href="#" class="dropdown-item text-success" onclick="enableClient('{{ $client['name'] }}')">
                                                <i class="bx bx-play me-2"></i> Enable
                                            </a>
                                            @endif
                                            <a href="#" class="dropdown-item text-danger" onclick="uninstallClient('{{ $client['name'] }}')">
                                                <i class="bx bx-trash me-2"></i> Uninstall
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Recent Logins -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Recent Logins</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Email</th>
                                                <th>Client</th>
                                                <th>IP Address</th>
                                                <th>Time</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($recentLogins as $login)
                                            <tr>
                                                <td><strong>{{ $login['email'] }}</strong></td>
                                                <td><span class="badge bg-info">{{ $login['client'] }}</span></td>
                                                <td><code>{{ $login['ip'] }}</code></td>
                                                <td>{{ \Carbon\Carbon::parse($login['time'])->format('H:i') }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $login['status'] == 'success' ? 'success' : 'danger' }}">
                                                        {{ $login['status'] }}
                                                    </span>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <button class="btn btn-outline-info btn-sm w-100 mt-2" onclick="viewAllLogins()">
                                    <i class="bx bx-history me-1"></i> View All Logins
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Webmail Usage</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="usageChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Webmail Settings -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Webmail Settings</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="mb-3">Global Settings</h6>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="enableWebmail" checked>
                                            <label class="form-check-label" for="enableWebmail">
                                                Enable webmail access
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="forceHTTPS" checked>
                                            <label class="form-check-label" for="forceHTTPS">
                                                Force HTTPS for webmail
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="enableTwoFactor" checked>
                                            <label class="form-check-label" for="enableTwoFactor">
                                                Enable two-factor authentication
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="logAccess" checked>
                                            <label class="form-check-label" for="logAccess">
                                                Log webmail access
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="enableAutoLogout">
                                            <label class="form-check-label" for="enableAutoLogout">
                                                Enable automatic logout
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="mb-3">Security Settings</h6>
                                        <div class="mb-3">
                                            <label for="sessionTimeout" class="form-label">Session Timeout (minutes)</label>
                                            <input type="number" class="form-control" id="sessionTimeout" value="30" min="5" max="480">
                                        </div>
                                        <div class="mb-3">
                                            <label for="maxLoginAttempts" class="form-label">Max Login Attempts</label>
                                            <input type="number" class="form-control" id="maxLoginAttempts" value="5" min="1" max="20">
                                        </div>
                                        <div class="mb-3">
                                            <label for="lockoutDuration" class="form-label">Lockout Duration (minutes)</label>
                                            <input type="number" class="form-control" id="lockoutDuration" value="15" min="1" max="1440">
                                        </div>
                                        <div class="mb-3">
                                            <label for="defaultClient" class="form-label">Default Webmail Client</label>
                                            <select class="form-select" id="defaultClient">
                                                <option value="roundcube" selected>Roundcube</option>
                                                <option value="horde">Horde</option>
                                                <option value="squirrelmail">SquirrelMail</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-primary" onclick="saveWebmailSettings()">
                                        <i class="bx bx-save me-1"></i> Save Settings
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Client Configuration -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Available Webmail Clients</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body text-center">
                                                <h6 class="card-title">Roundcube</h6>
                                                <p class="card-text small">Modern webmail client with intuitive interface</p>
                                                <span class="badge bg-success">Installed</span>
                                                <div class="mt-2">
                                                    <button class="btn btn-outline-primary btn-sm" onclick="configureClient('Roundcube')">
                                                        Configure
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body text-center">
                                                <h6 class="card-title">Horde</h6>
                                                <p class="card-text small">Feature-rich webmail with calendar and contacts</p>
                                                <span class="badge bg-success">Installed</span>
                                                <div class="mt-2">
                                                    <button class="btn btn-outline-primary btn-sm" onclick="configureClient('Horde')">
                                                        Configure
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body text-center">
                                                <h6 class="card-title">SquirrelMail</h6>
                                                <p class="card-text small">Classic webmail client with simple interface</p>
                                                <span class="badge bg-secondary">Installed</span>
                                                <div class="mt-2">
                                                    <button class="btn btn-outline-warning btn-sm" onclick="installClient('SquirrelMail')">
                                                        Reinstall
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body text-center">
                                                <h6 class="card-title">RainLoop</h6>
                                                <p class="card-text small">Modern and fast webmail client</p>
                                                <span class="badge bg-warning">Not Installed</span>
                                                <div class="mt-2">
                                                    <button class="btn btn-outline-success btn-sm" onclick="installClient('RainLoop')">
                                                        Install
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
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Webmail Usage Chart
const usageCtx = document.getElementById('usageChart').getContext('2d');
new Chart(usageCtx, {
    type: 'bar',
    data: {
        labels: ['Roundcube', 'Horde', 'SquirrelMail'],
        datasets: [{
            label: 'Active Users',
            data: [15, 8, 2],
            backgroundColor: ['#007bff', '#28a745', '#ffc107']
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

function installWebmail() {
    showNotification('Install webmail client dialog opened', 'info');
}

function openWebmail() {
    showNotification('Opening webmail...', 'info');
}

function openClient(clientName) {
    showNotification(`Opening ${clientName}...`, 'info');
}

function configureClient(clientName) {
    showNotification(`Configuring ${clientName}...`, 'info');
}

function updateClient(clientName) {
    showNotification(`Updating ${clientName}...`, 'info');
}

function viewUsers(clientName) {
    showNotification(`Viewing users for ${clientName}...`, 'info');
}

function disableClient(clientName) {
    if (confirm(`Are you sure you want to disable ${clientName}?`)) {
        showNotification(`${clientName} disabled`, 'warning');
    }
}

function enableClient(clientName) {
    if (confirm(`Are you sure you want to enable ${clientName}?`)) {
        showNotification(`${clientName} enabled`, 'success');
    }
}

function uninstallClient(clientName) {
    if (confirm(`Are you sure you want to uninstall ${clientName}? This action cannot be undone.`)) {
        showNotification(`${clientName} uninstalled`, 'danger');
    }
}

function viewAllLogins() {
    showNotification('Opening all login history...', 'info');
}

function saveWebmailSettings() {
    showNotification('Webmail settings saved successfully', 'success');
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
