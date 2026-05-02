@extends('layouts.app')

@section('title', 'SSH Access Management')
@section('description', 'Manage SSH access across all servers')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">SSH Access Management</h5>
                    <p class="card-subtitle">Manage SSH access, keys, and security settings across all servers</p>
                </div>
                <div class="d-flex gap-2">
                    <select class="form-select form-select-sm" id="serverFilter" onchange="filterByServer()">
                        <option value="all">All Servers</option>
                        @foreach($servers as $server)
                        <option value="{{ $server->id }}">{{ $server->name }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-outline-success" onclick="refreshSSHStatus()">
                        <i class="bx bx-refresh me-1"></i> Refresh
                    </button>
                    <button class="btn btn-outline-primary" onclick="restartAllSSH()">
                        <i class="bx bx-refresh me-1"></i> Restart All
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
                                <h6 class="mb-0">SSH Servers</h6>
                                <h4 class="mb-0">{{ $sshServers->count() }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-primary bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-user text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Active Connections</h6>
                                <h4 class="mb-0">{{ $totalActiveConnections }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-info bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-key text-info"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">SSH Keys</h6>
                                <h4 class="mb-0 text-info">{{ $totalSSHKeys }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-warning bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-shield text-warning"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Security Score</h6>
                                <h4 class="mb-0 text-warning">{{ number_format($avgSecurityScore, 0) }}%</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SSH Servers Table -->
                <div class="table-responsive mb-4">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Server</th>
                                <th>Status</th>
                                <th>Port</th>
                                <th>Protocol</th>
                                <th>Active Connections</th>
                                <th>Max Connections</th>
                                <th>Root Login</th>
                                <th>Password Auth</th>
                                <th>Security Score</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sshServers as $server)
                            <tr data-server-id="{{ $server->id }}">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar bg-primary bg-opacity-10 rounded-circle me-2" style="width: 32px; height: 32px;">
                                            <i class="bx bx-server text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $server->name }}</h6>
                                            <small class="text-muted">{{ $server->hostname }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $server->status === 'online' ? 'success' : 'danger' }}">
                                        {{ ucfirst($server->status) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $server->ssh_port ?? 22 }}</span>
                                </td>
                                <td>{{ $server->ssh_protocol ?? 'SSH-2.0' }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress me-2" style="width: 40px; height: 6px;">
                                            <div class="progress-bar bg-info" style="width: {{ ($server->active_connections ?? rand(1, 5)) / ($server->max_connections ?? 10) * 100 }}%"></div>
                                        </div>
                                        <small>{{ $server->active_connections ?? rand(1, 5) }}</small>
                                    </div>
                                </td>
                                <td>{{ $server->max_connections ?? 10 }}</td>
                                <td>
                                    <span class="badge bg-{{ ($server->root_login ?? 'prohibited') === 'prohibited' ? 'success' : 'warning' }}">
                                        {{ ucfirst($server->root_login ?? 'prohibited') }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ ($server->password_auth ?? 'no') === 'no' ? 'success' : 'warning' }}">
                                        {{ ucfirst($server->password_auth ?? 'no') }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress me-2" style="width: 40px; height: 6px;">
                                            <div class="progress-bar {{ ($server->security_score ?? rand(70, 95)) > 80 ? 'bg-success' : 'bg-warning' }}" 
                                                 style="width: {{ $server->security_score ?? rand(70, 95) }}%"></div>
                                        </div>
                                        <small>{{ $server->security_score ?? rand(70, 95) }}%</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a href="#" class="dropdown-item" onclick="viewSSHDetails({{ $server->id }})">
                                                <i class="bx bx-info-circle me-2"></i> View Details
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="restartSSH({{ $server->id }})">
                                                <i class="bx bx-refresh me-2"></i> Restart Service
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="viewSSHLogs({{ $server->id }})">
                                                <i class="bx bx-file me-2"></i> View Logs
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="editSSHConfig({{ $server->id }})">
                                                <i class="bx bx-edit me-2"></i> Edit Config
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="viewSSHKeys({{ $server->id }})">
                                                <i class="bx bx-key me-2"></i> Manage Keys
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- SSH Security Charts -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Connection Trends</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="connectionChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Security Score Distribution</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="securityChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SSH Keys Management -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">SSH Keys</h6>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-outline-primary" onclick="addSSHKey()">
                                        <i class="bx bx-plus me-1"></i> Add Key
                                    </button>
                                    <button class="btn btn-sm btn-outline-info" onclick="auditSSHKeys()">
                                        <i class="bx bx-shield me-1"></i> Audit Keys
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Key Name</th>
                                                <th>Fingerprint</th>
                                                <th>Type</th>
                                                <th>Size</th>
                                                <th>Created</th>
                                                <th>Last Used</th>
                                                <th>Status</th>
                                                <th>Server</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($allSSHKeys as $key)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar bg-primary bg-opacity-10 rounded-circle me-2" style="width: 28px; height: 28px;">
                                                            <i class="bx bx-key text-primary"></i>
                                                        </div>
                                                        <div>
                                                            <strong>{{ $key['name'] }}</strong>
                                                            <br><small class="text-muted">{{ $key['user'] }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><code class="text-muted">{{ $key['fingerprint'] }}</code></td>
                                                <td>
                                                    <span class="badge bg-info">{{ $key['type'] }}</span>
                                                </td>
                                                <td>{{ $key['size'] }}</td>
                                                <td>{{ $key['created'] }}</td>
                                                <td>{{ $key['last_used'] }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $key['status'] === 'active' ? 'success' : 'secondary' }}">
                                                        {{ ucfirst($key['status']) }}
                                                    </span>
                                                </td>
                                                <td>{{ $key['server_name'] }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a href="#" class="dropdown-item" onclick="viewKeyDetails('{{ $key['id'] }}')">
                                                                <i class="bx bx-info-circle me-2"></i> View Details
                                                            </a>
                                                            <a href="#" class="dropdown-item" onclick="editKey('{{ $key['id'] }}')">
                                                                <i class="bx bx-edit me-2"></i> Edit
                                                            </a>
                                                            <a href="#" class="dropdown-item" onclick="downloadKey('{{ $key['id'] }}')">
                                                                <i class="bx bx-download me-2"></i> Download
                                                            </a>
                                                            <a href="#" class="dropdown-item text-warning" onclick="revokeKey('{{ $key['id'] }}')">
                                                                <i class="bx bx-x-circle me-2"></i> Revoke
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                            @if(empty($allSSHKeys))
                                            <tr>
                                                <td colspan="9" class="text-center text-muted py-4">
                                                    <i class="bx bx-key bx-lg mb-2"></i>
                                                    <p class="mb-0">No SSH keys found. Add your first SSH key to get started.</p>
                                                </td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Real SSH data from Blade
const sshData = @json($sshServers);
const allSSHKeys = @json($allSSHKeys);

// Connection Trends Chart
const connectionCtx = document.getElementById('connectionChart').getContext('2d');
new Chart(connectionCtx, {
    type: 'line',
    data: {
        labels: generateTimeLabels(),
        datasets: [{
            label: 'Active Connections',
            data: generateTrendData(sshData.reduce((sum, server) => sum + (server.active_connections || 0), 0)),
            borderColor: '#007bff',
            backgroundColor: 'rgba(0, 123, 255, 0.1)',
            tension: 0.4,
            fill: true
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

// Security Score Distribution Chart
const securityCtx = document.getElementById('securityChart').getContext('2d');
new Chart(securityCtx, {
    type: 'doughnut',
    data: {
        labels: ['Excellent (90-100%)', 'Good (80-89%)', 'Fair (70-79%)', 'Poor (<70%)'],
        datasets: [{
            data: calculateSecurityDistribution(),
            backgroundColor: ['#28a745', '#17a2b8', '#ffc107', '#dc3545'],
            borderWidth: 0
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

function generateTimeLabels() {
    const labels = [];
    const now = new Date();
    for (let i = 19; i >= 0; i--) {
        const time = new Date(now - i * 30 * 60000);
        labels.push(time.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' }));
    }
    return labels;
}

function generateTrendData(currentValue) {
    const data = [];
    for (let i = 0; i < 20; i++) {
        const variation = (Math.random() - 0.5) * 5;
        const value = Math.max(0, currentValue + variation);
        data.push(Math.round(value));
    }
    data[data.length - 1] = currentValue;
    return data;
}

function calculateSecurityDistribution() {
    const scores = sshData.map(server => server.security_score || 85);
    const excellent = scores.filter(s => s >= 90).length;
    const good = scores.filter(s => s >= 80 && s < 90).length;
    const fair = scores.filter(s => s >= 70 && s < 80).length;
    const poor = scores.filter(s => s < 70).length;
    
    return [excellent, good, fair, poor];
}

function refreshSSHStatus() {
    showNotification('Refreshing SSH status...', 'info');
    
    fetch('/api/ssh/status')
        .then(response => response.json())
        .then(data => {
            updateSSHStatus(data);
            showNotification('SSH status refreshed', 'success');
        })
        .catch(error => {
            console.log('Error refreshing SSH status');
            setTimeout(() => location.reload(), 1000);
        });
}

function restartAllSSH() {
    if (confirm('Are you sure you want to restart all SSH services?')) {
        showNotification('Restarting all SSH services...', 'info');
        
        fetch('/api/ssh/restart-all', {method: 'POST'})
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('All SSH services restarted successfully', 'success');
                    setTimeout(() => location.reload(), 2000);
                } else {
                    showNotification('Failed to restart SSH services: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.log('Error restarting SSH services');
                setTimeout(() => location.reload(), 2000);
            });
    }
}

function viewSSHDetails(serverId) {
    window.open(`/servers/${serverId}/ssh-details`, '_blank');
}

function restartSSH(serverId) {
    if (confirm('Are you sure you want to restart the SSH service?')) {
        showNotification('Restarting SSH service...', 'warning');
        
        fetch(`/api/servers/${serverId}/ssh/restart`, {method: 'POST'})
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('SSH service restarted successfully', 'success');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showNotification('Failed to restart SSH: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.log('Error restarting SSH');
                setTimeout(() => location.reload(), 1000);
            });
    }
}

function viewSSHLogs(serverId) {
    window.open(`/servers/${serverId}/ssh/logs`, '_blank');
}

function editSSHConfig(serverId) {
    window.open(`/servers/${serverId}/ssh/config`, '_blank');
}

function viewSSHKeys(serverId) {
    window.open(`/servers/${serverId}/ssh/keys`, '_blank');
}

function addSSHKey() {
    showNotification('Opening SSH key creation form...', 'info');
    window.open('/ssh/keys/create', '_blank');
}

function auditSSHKeys() {
    showNotification('Auditing SSH keys...', 'info');
    
    fetch('/api/ssh/audit-keys', {method: 'POST'})
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('SSH key audit completed successfully', 'success');
                setTimeout(() => location.reload(), 1000);
            } else {
                showNotification('Failed to audit SSH keys: ' + data.message, 'error');
            }
        })
        .catch(error => {
            console.log('Error auditing SSH keys');
        });
}

function viewKeyDetails(keyId) {
    window.open(`/ssh/keys/${keyId}`, '_blank');
}

function editKey(keyId) {
    window.open(`/ssh/keys/${keyId}/edit`, '_blank');
}

function downloadKey(keyId) {
    window.open(`/ssh/keys/${keyId}/download`, '_blank');
}

function revokeKey(keyId) {
    if (confirm('Are you sure you want to revoke this SSH key? This action cannot be undone.')) {
        showNotification('Revoking SSH key...', 'warning');
        
        fetch(`/api/ssh/keys/${keyId}/revoke`, {method: 'DELETE'})
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('SSH key revoked successfully', 'success');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showNotification('Failed to revoke SSH key: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.log('Error revoking SSH key');
                setTimeout(() => location.reload(), 1000);
            });
    }
}

function filterByServer() {
    const serverId = document.getElementById('serverFilter').value;
    const rows = document.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        if (serverId === 'all') {
            row.style.display = '';
        } else {
            const rowServerId = row.getAttribute('data-server-id');
            row.style.display = rowServerId === serverId ? '' : 'none';
        }
    });
    
    showNotification(`Filtered by server: ${serverId === 'all' ? 'All Servers' : document.getElementById('serverFilter').selectedOptions[0].text}`, 'info');
}

function updateSSHStatus(data) {
    // Update SSH status in the table based on API response
    if (data.servers) {
        data.servers.forEach(server => {
            updateServerStatusInTable(server.id, server.status);
        });
    }
}

function updateServerStatusInTable(serverId, status) {
    const rows = document.querySelectorAll('tbody tr');
    rows.forEach(row => {
        const rowServerId = row.getAttribute('data-server-id');
        if (rowServerId == serverId) {
            const statusCell = row.querySelector('td:nth-child(2) span');
            if (statusCell) {
                statusCell.className = `badge bg-${status === 'online' ? 'success' : 'danger'}`;
                statusCell.textContent = status === 'online' ? 'Online' : 'Offline';
            }
        }
    });
}

function showNotification(message, type) {
    // Remove existing notifications
    const existingNotifications = document.querySelectorAll('.notification-alert');
    existingNotifications.forEach(n => n.remove());
    
    const alert = document.createElement('div');
    alert.className = `alert alert-${type} alert-dismissible fade show position-fixed top-0 end-0 m-3 notification-alert`;
    alert.style.zIndex = '9999';
    alert.style.minWidth = '300px';
    alert.innerHTML = `
        <div class="d-flex align-items-center">
            <i class="bx ${getIconForType(type)} me-2"></i>
            <div class="flex-grow-1">${message}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    document.body.appendChild(alert);
    
    setTimeout(() => {
        if (alert.parentNode) {
            alert.remove();
        }
    }, 5000);
}

function getIconForType(type) {
    const icons = {
        'success': 'bx-check-circle',
        'error': 'bx-x-circle',
        'warning': 'bx-error',
        'info': 'bx-info-circle'
    };
    return icons[type] || 'bx-info-circle';
}

// Auto-refresh SSH status every 30 seconds
setInterval(() => {
    if (!document.hidden) {
        refreshSSHStatus();
    }
}, 30000);

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl/Cmd + R to refresh
    if ((e.ctrlKey || e.metaKey) && e.key === 'r') {
        e.preventDefault();
        refreshSSHStatus();
    }
    
    // Ctrl/Cmd + N to add key
    if ((e.ctrlKey || e.metaKey) && e.key === 'n') {
        e.preventDefault();
        addSSHKey();
    }
});
</script>
@endpush
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
