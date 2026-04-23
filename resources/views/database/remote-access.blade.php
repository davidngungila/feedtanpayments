@extends('layouts.app')

@section('title', 'Remote Access')
@section('description', 'Manage remote database access')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">Remote Access</h5>
                    <p class="card-subtitle">Manage remote database access and connections</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-success" onclick="addRemoteHost()">
                        <i class="bx bx-plus me-1"></i> Add Host
                    </button>
                    <button class="btn btn-outline-primary" onclick="testAllConnections()">
                        <i class="bx bx-test-tube me-1"></i> Test All
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- Remote Access Statistics -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-primary bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-globe text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Hosts</h6>
                                <h4 class="mb-0">{{ $stats['total_remote_hosts'] }}</h4>
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
                                <h4 class="mb-0 text-success">{{ $stats['active_hosts'] }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-warning bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-pause text-warning"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Disabled</h6>
                                <h4 class="mb-0 text-warning">{{ $stats['disabled_hosts'] }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-info bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-link text-info"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Connections Today</h6>
                                <h4 class="mb-0 text-info">{{ $stats['total_connections_today'] }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Remote Hosts List -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Host</th>
                                <th>User</th>
                                <th>Databases</th>
                                <th>Privileges</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Last Access</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($remoteHosts as $host)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-globe text-primary me-2"></i>
                                        <strong>{{ $host['host'] }}</strong>
                                    </div>
                                </td>
                                <td><code>{{ $host['user'] }}</code></td>
                                <td>
                                    <div class="d-flex flex-wrap gap-1">
                                        @foreach(array_slice($host['databases'], 0, 2) as $db)
                                        <span class="badge bg-info">{{ $db }}</span>
                                        @endforeach
                                        @if(count($host['databases']) > 2)
                                        <span class="badge bg-secondary">+{{ count($host['databases']) - 2 }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-wrap gap-1">
                                        @foreach(array_slice($host['privileges'], 0, 2) as $priv)
                                        <span class="badge bg-primary">{{ $priv }}</span>
                                        @endforeach
                                        @if(count($host['privileges']) > 2)
                                        <span class="badge bg-secondary">+{{ count($host['privileges']) - 2 }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $host['status'] == 'active' ? 'success' : 'secondary' }}">
                                        {{ $host['status'] }}
                                    </span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($host['created'])->format('M d, Y') }}</td>
                                <td>
                                    @if($host['last_access'])
                                        {{ \Carbon\Carbon::parse($host['last_access'])->format('M d, H:i') }}
                                    @else
                                        <span class="text-muted">Never</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a href="#" class="dropdown-item" onclick="testConnection('{{ $host['host'] }}')">
                                                <i class="bx bx-test-tube me-2"></i> Test Connection
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="viewLogs('{{ $host['host'] }}')">
                                                <i class="bx bx-history me-2"></i> View Logs
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="editHost('{{ $host['host'] }}')">
                                                <i class="bx bx-edit me-2"></i> Edit Host
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="revokeAccess('{{ $host['host'] }}')">
                                                <i class="bx bx-x-circle me-2"></i> Revoke Access
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            @if($host['status'] == 'active')
                                            <a href="#" class="dropdown-item text-warning" onclick="disableHost('{{ $host['host'] }}')">
                                                <i class="bx bx-pause me-2"></i> Disable
                                            </a>
                                            @else
                                            <a href="#" class="dropdown-item text-success" onclick="enableHost('{{ $host['host'] }}')">
                                                <i class="bx bx-play me-2"></i> Enable
                                            </a>
                                            @endif
                                            <a href="#" class="dropdown-item text-danger" onclick="deleteHost('{{ $host['host'] }}')">
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

                <!-- Remote Access Settings -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Remote Access Settings</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="remoteAccessEnabled" {{ $settings['remote_access_enabled'] ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remoteAccessEnabled">
                                        Enable remote database access
                                    </label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="requireSSL" {{ $settings['require_ssl'] ? 'checked' : '' }}>
                                    <label class="form-check-label" for="requireSSL">
                                        Require SSL connections
                                    </label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="logConnections" checked>
                                    <label class="form-check-label" for="logConnections">
                                        Log connection attempts
                                    </label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="enableFirewall" checked>
                                    <label class="form-check-label" for="enableFirewall">
                                        Enable firewall rules
                                    </label>
                                </div>
                                <button class="btn btn-primary" onclick="saveRemoteSettings()">
                                    <i class="bx bx-save me-1"></i> Save Settings
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Connection Limits</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="maxConnections" class="form-label">Max Connections</label>
                                    <input type="number" class="form-control" id="maxConnections" value="{{ $settings['max_connections'] }}" min="1" max="1000">
                                </div>
                                <div class="mb-3">
                                    <label for="connectionTimeout" class="form-label">Connection Timeout (seconds)</label>
                                    <input type="number" class="form-control" id="connectionTimeout" value="{{ $settings['connection_timeout'] }}" min="5" max="300">
                                </div>
                                <div class="mb-3">
                                    <label for="allowedHosts" class="form-label">Allowed Hosts/CIDR</label>
                                    <textarea class="form-control" id="allowedHosts" rows="3">{{ implode("\n", $settings['allowed_hosts']) }}</textarea>
                                    <small class="text-muted">Enter one host or CIDR per line (e.g., 192.168.1.100 or 192.168.1.0/24)</small>
                                </div>
                                <button class="btn btn-primary" onclick="saveConnectionLimits()">
                                    <i class="bx bx-save me-1"></i> Save Limits
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Connection Activity -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Recent Connections</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Host</th>
                                                <th>User</th>
                                                <th>Database</th>
                                                <th>Status</th>
                                                <th>Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><code>192.168.1.100</code></td>
                                                <td><strong>admin</strong></td>
                                                <td><code>example_com</code></td>
                                                <td><span class="badge bg-success">Success</span></td>
                                                <td>14:30</td>
                                            </tr>
                                            <tr>
                                                <td><code>192.168.1.101</code></td>
                                                <td><strong>webuser</strong></td>
                                                <td><code>example_com</code></td>
                                                <td><span class="badge bg-success">Success</span></td>
                                                <td>14:25</td>
                                            </tr>
                                            <tr>
                                                <td><code>10.0.0.50</code></td>
                                                <td><strong>backup_user</strong></td>
                                                <td><code>example_com</code></td>
                                                <td><span class="badge bg-danger">Failed</span></td>
                                                <td>14:20</td>
                                            </tr>
                                            <tr>
                                                <td><code>192.168.1.103</code></td>
                                                <td><strong>admin</strong></td>
                                                <td><code>mydomain_net</code></td>
                                                <td><span class="badge bg-success">Success</span></td>
                                                <td>14:15</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <button class="btn btn-outline-info btn-sm w-100 mt-2" onclick="viewAllConnections()">
                                    <i class="bx bx-history me-1"></i> View All Connections
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Connection Statistics</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="connectionChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Security Rules -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Security Rules</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Rule</th>
                                                <th>Type</th>
                                                <th>Action</th>
                                                <th>Status</th>
                                                <th>Created</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><strong>Block Suspicious IPs</strong></td>
                                                <td><span class="badge bg-danger">Block</span></td>
                                                <td><span class="badge bg-secondary">Automatic</span></td>
                                                <td><span class="badge bg-success">Active</span></td>
                                                <td>2024-11-15</td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-warning" onclick="editRule('1')">
                                                        <i class="bx bx-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-danger" onclick="deleteRule('1')">
                                                        <i class="bx bx-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Allow Internal Network</strong></td>
                                                <td><span class="badge bg-success">Allow</span></td>
                                                <td><span class="badge bg-secondary">Manual</span></td>
                                                <td><span class="badge bg-success">Active</span></td>
                                                <td>2024-11-20</td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-warning" onclick="editRule('2')">
                                                        <i class="bx bx-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-danger" onclick="deleteRule('2')">
                                                        <i class="bx bx-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Rate Limit Connections</strong></td>
                                                <td><span class="badge bg-warning">Limit</span></td>
                                                <td><span class="badge bg-secondary">Automatic</span></td>
                                                <td><span class="badge bg-success">Active</span></td>
                                                <td>2024-11-25</td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-warning" onclick="editRule('3')">
                                                        <i class="bx bx-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-danger" onclick="deleteRule('3')">
                                                        <i class="bx bx-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-2">
                                    <button class="btn btn-outline-primary" onclick="addRule()">
                                        <i class="bx bx-plus me-1"></i> Add Rule
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
// Connection Statistics Chart
const connectionCtx = document.getElementById('connectionChart').getContext('2d');
new Chart(connectionCtx, {
    type: 'line',
    data: {
        labels: ['00:00', '04:00', '08:00', '12:00', '16:00', '20:00', '23:59'],
        datasets: [{
            label: 'Active Connections',
            data: [12, 8, 15, 25, 32, 28, 18],
            borderColor: '#007bff',
            backgroundColor: 'rgba(0, 123, 255, 0.1)',
            tension: 0.4
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

function addRemoteHost() {
    showNotification('Add remote host dialog opened', 'info');
}

function testAllConnections() {
    if (confirm('Are you sure you want to test all remote connections?')) {
        showNotification('Testing all remote connections...', 'info');
    }
}

function testConnection(host) {
    showNotification(`Testing connection to ${host}...`, 'info');
}

function viewLogs(host) {
    showNotification(`Viewing connection logs for ${host}...`, 'info');
}

function editHost(host) {
    showNotification(`Editing remote host ${host}...`, 'info');
}

function revokeAccess(host) {
    if (confirm(`Are you sure you want to revoke access for ${host}?`)) {
        showNotification(`Access revoked for ${host}`, 'warning');
    }
}

function disableHost(host) {
    if (confirm(`Are you sure you want to disable host ${host}?`)) {
        showNotification(`Host ${host} disabled`, 'warning');
    }
}

function enableHost(host) {
    if (confirm(`Are you sure you want to enable host ${host}?`)) {
        showNotification(`Host ${host} enabled`, 'success');
    }
}

function deleteHost(host) {
    if (confirm(`Are you sure you want to delete host ${host}?`)) {
        showNotification(`Host ${host} deleted`, 'danger');
    }
}

function saveRemoteSettings() {
    showNotification('Remote access settings saved successfully', 'success');
}

function saveConnectionLimits() {
    showNotification('Connection limits saved successfully', 'success');
}

function viewAllConnections() {
    showNotification('Opening all connection history...', 'info');
}

function addRule() {
    showNotification('Add security rule dialog opened', 'info');
}

function editRule(id) {
    showNotification(`Editing security rule ${id}...`, 'info');
}

function deleteRule(id) {
    if (confirm('Are you sure you want to delete this security rule?')) {
        showNotification('Security rule deleted', 'danger');
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
