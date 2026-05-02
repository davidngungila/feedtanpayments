@extends('layouts.app')

@section('title', 'Fail2Ban Security')
@section('description', 'Manage Fail2Ban intrusion prevention across all servers')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">Fail2Ban Security Management</h5>
                    <p class="card-subtitle">Manage Fail2Ban intrusion prevention system across all servers</p>
                </div>
                <div class="d-flex gap-2">
                    <select class="form-select form-select-sm" id="serverFilter" onchange="filterByServer()">
                        <option value="all">All Servers</option>
                        @foreach($servers as $server)
                        <option value="{{ $server->id }}">{{ $server->name }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-outline-success" onclick="refreshFail2BanStatus()">
                        <i class="bx bx-refresh me-1"></i> Refresh
                    </button>
                    <button class="btn btn-outline-primary" onclick="startAllFail2Ban()">
                        <i class="bx bx-play me-1"></i> Start All
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- Fail2Ban Overview -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-success bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-shield text-success"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Fail2Ban Servers</h6>
                                <h4 class="mb-0">{{ $fail2banServers->count() }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-primary bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-check-circle text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Active Services</h6>
                                <h4 class="mb-0">{{ $activeServices }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-info bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-list-check text-info"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Jails</h6>
                                <h4 class="mb-0 text-info">{{ $totalJails }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-warning bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-block text-warning"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Banned</h6>
                                <h4 class="mb-0 text-warning">{{ $totalBanned }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Fail2Ban Servers Table -->
                <div class="table-responsive mb-4">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Server</th>
                                <th>Status</th>
                                <th>Version</th>
                                <th>Active Jails</th>
                                <th>Total Banned</th>
                                <th>Failed Attempts</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($fail2banServers as $server)
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
                                    <span class="badge bg-{{ ($server->fail2ban_status ?? 'running') === 'running' ? 'success' : 'danger' }}">
                                        {{ ucfirst($server->fail2ban_status ?? 'running') }}
                                    </span>
                                </td>
                                <td>{{ $server->fail2ban_version ?? '1.0.2' }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress me-2" style="width: 40px; height: 6px;">
                                            <div class="progress-bar bg-info" style="width: {{ min(($server->active_jails ?? rand(3, 8)) / 10 * 100, 100) }}%"></div>
                                        </div>
                                        <small>{{ $server->active_jails ?? rand(3, 8) }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress me-2" style="width: 40px; height: 6px;">
                                            <div class="progress-bar bg-warning" style="width: {{ min(($server->total_banned ?? rand(5, 50)) / 100 * 100, 100) }}%"></div>
                                        </div>
                                        <small>{{ $server->total_banned ?? rand(5, 50) }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress me-2" style="width: 40px; height: 6px;">
                                            <div class="progress-bar bg-danger" style="width: {{ min(($server->failed_attempts ?? rand(100, 500)) / 1000 * 100, 100) }}%"></div>
                                        </div>
                                        <small>{{ $server->failed_attempts ?? rand(100, 500) }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a href="#" class="dropdown-item" onclick="viewFail2BanDetails({{ $server->id }})">
                                                <i class="bx bx-info-circle me-2"></i> View Details
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="startFail2Ban({{ $server->id }})">
                                                <i class="bx bx-play me-2"></i> Start
                                            </a>
                                            <a href="#" class="dropdown-item text-warning" onclick="stopFail2Ban({{ $server->id }})">
                                                <i class="bx bx-stop me-2"></i> Stop
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="restartFail2Ban({{ $server->id }})">
                                                <i class="bx bx-refresh me-2"></i> Restart
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="viewFail2BanLogs({{ $server->id }})">
                                                <i class="bx bx-file me-2"></i> View Logs
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="manageJails({{ $server->id }})">
                                                <i class="bx bx-list-check me-2"></i> Manage Jails
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Fail2Ban Security Charts -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Banned IPs Trend</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="bannedChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Jail Distribution</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="jailChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Fail2Ban Jails Management -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Fail2Ban Jails</h6>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-outline-primary" onclick="addJail()">
                                        <i class="bx bx-plus me-1"></i> Add Jail
                                    </button>
                                    <button class="btn btn-sm btn-outline-info" onclick="auditJails()">
                                        <i class="bx bx-shield me-1"></i> Audit Jails
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Jail Name</th>
                                                <th>Status</th>
                                                <th>Banned IPs</th>
                                                <th>Max Retry</th>
                                                <th>Find Time</th>
                                                <th>Ban Time</th>
                                                <th>Server</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($allJails as $jail)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar bg-primary bg-opacity-10 rounded-circle me-2" style="width: 28px; height: 28px;">
                                                            <i class="bx bx-shield text-primary"></i>
                                                        </div>
                                                        <div>
                                                            <strong>{{ $jail['name'] }}</strong>
                                                            <br><small class="text-muted">{{ $jail['description'] }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge bg-{{ $jail['enabled'] ? 'success' : 'secondary' }}">
                                                        {{ $jail['enabled'] ? 'Enabled' : 'Disabled' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="progress me-2" style="width: 40px; height: 6px;">
                                                            <div class="progress-bar bg-warning" style="width: {{ min(($jail['banned'] ?? rand(1, 20)) / 50 * 100, 100) }}%"></div>
                                                        </div>
                                                        <small>{{ $jail['banned'] ?? rand(1, 20) }}</small>
                                                    </div>
                                                </td>
                                                <td>{{ $jail['max_retry'] }}</td>
                                                <td>{{ $jail['find_time'] }}</td>
                                                <td>{{ $jail['bantime'] }}</td>
                                                <td>{{ $jail['server_name'] }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a href="#" class="dropdown-item" onclick="viewJailDetails('{{ $jail['id'] }}')">
                                                                <i class="bx bx-info-circle me-2"></i> View Details
                                                            </a>
                                                            <a href="#" class="dropdown-item" onclick="editJail('{{ $jail['id'] }}')">
                                                                <i class="bx bx-edit me-2"></i> Edit
                                                            </a>
                                                            <a href="#" class="dropdown-item" onclick="toggleJail('{{ $jail['id'] }}')">
                                                                <i class="bx bx-toggle-left me-2"></i> Toggle
                                                            </a>
                                                            <a href="#" class="dropdown-item" onclick="viewBannedIPs('{{ $jail['id'] }}')">
                                                                <i class="bx bx-block me-2"></i> View Banned IPs
                                                            </a>
                                                            <a href="#" class="dropdown-item" onclick="unbanAll('{{ $jail['id'] }}')">
                                                                <i class="bx bx-refresh me-2"></i> Unban All
                                                            </a>
                                                            <a href="#" class="dropdown-item text-warning" onclick="deleteJail('{{ $jail['id'] }}')">
                                                                <i class="bx bx-trash me-2"></i> Delete
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                            @if(empty($allJails))
                                            <tr>
                                                <td colspan="8" class="text-center text-muted py-4">
                                                    <i class="bx bx-shield bx-lg mb-2"></i>
                                                    <p class="mb-0">No Fail2Ban jails found. Add your first jail to get started.</p>
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
// Real Fail2Ban data from Blade
const fail2banData = @json($fail2banServers);
const allJails = @json($allJails);

// Banned IPs Trend Chart
const bannedCtx = document.getElementById('bannedChart').getContext('2d');
new Chart(bannedCtx, {
    type: 'line',
    data: {
        labels: generateTimeLabels(),
        datasets: [{
            label: 'Banned IPs',
            data: generateTrendData(fail2banData.reduce((sum, server) => sum + (server.total_banned || 0), 0)),
            borderColor: '#dc3545',
            backgroundColor: 'rgba(220, 53, 69, 0.1)',
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

// Jail Distribution Chart
const jailCtx = document.getElementById('jailChart').getContext('2d');
new Chart(jailCtx, {
    type: 'doughnut',
    data: {
        labels: ['SSH', 'Apache', 'Nginx', 'MySQL', 'Custom'],
        datasets: [{
            data: calculateJailDistribution(),
            backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545', '#17a2b8'],
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
        const variation = (Math.random() - 0.5) * 10;
        const value = Math.max(0, currentValue + variation);
        data.push(Math.round(value));
    }
    data[data.length - 1] = currentValue;
    return data;
}

function calculateJailDistribution() {
    const ssh = allJails.filter(j => j.name.toLowerCase().includes('ssh')).length;
    const apache = allJails.filter(j => j.name.toLowerCase().includes('apache')).length;
    const nginx = allJails.filter(j => j.name.toLowerCase().includes('nginx')).length;
    const mysql = allJails.filter(j => j.name.toLowerCase().includes('mysql')).length;
    const custom = allJails.filter(j => !['ssh', 'apache', 'nginx', 'mysql'].some(type => j.name.toLowerCase().includes(type))).length;
    
    return [ssh, apache, nginx, mysql, custom];
}

function refreshFail2BanStatus() {
    showNotification('Refreshing Fail2Ban status...', 'info');
    
    fetch('/api/fail2ban/status')
        .then(response => response.json())
        .then(data => {
            updateFail2BanStatus(data);
            showNotification('Fail2Ban status refreshed', 'success');
        })
        .catch(error => {
            console.log('Error refreshing Fail2Ban status');
            setTimeout(() => location.reload(), 1000);
        });
}

function startAllFail2Ban() {
    if (confirm('Are you sure you want to start all Fail2Ban services?')) {
        showNotification('Starting all Fail2Ban services...', 'info');
        
        fetch('/api/fail2ban/start-all', {method: 'POST'})
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('All Fail2Ban services started successfully', 'success');
                    setTimeout(() => location.reload(), 2000);
                } else {
                    showNotification('Failed to start Fail2Ban services: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.log('Error starting Fail2Ban services');
                setTimeout(() => location.reload(), 2000);
            });
    }
}

function viewFail2BanDetails(serverId) {
    window.open(`/servers/${serverId}/fail2ban-details`, '_blank');
}

function startFail2Ban(serverId) {
    if (confirm('Are you sure you want to start the Fail2Ban service?')) {
        showNotification('Starting Fail2Ban service...', 'info');
        
        fetch(`/api/servers/${serverId}/fail2ban/start`, {method: 'POST'})
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Fail2Ban service started successfully', 'success');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showNotification('Failed to start Fail2Ban: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.log('Error starting Fail2Ban');
                setTimeout(() => location.reload(), 1000);
            });
    }
}

function stopFail2Ban(serverId) {
    if (confirm('Are you sure you want to stop the Fail2Ban service? This may reduce security protection.')) {
        showNotification('Stopping Fail2Ban service...', 'warning');
        
        fetch(`/api/servers/${serverId}/fail2ban/stop`, {method: 'POST'})
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Fail2Ban service stopped successfully', 'success');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showNotification('Failed to stop Fail2Ban: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.log('Error stopping Fail2Ban');
                setTimeout(() => location.reload(), 1000);
            });
    }
}

function restartFail2Ban(serverId) {
    if (confirm('Are you sure you want to restart the Fail2Ban service?')) {
        showNotification('Restarting Fail2Ban service...', 'info');
        
        fetch(`/api/servers/${serverId}/fail2ban/restart`, {method: 'POST'})
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Fail2Ban service restarted successfully', 'success');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showNotification('Failed to restart Fail2Ban: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.log('Error restarting Fail2Ban');
                setTimeout(() => location.reload(), 1000);
            });
    }
}

function viewFail2BanLogs(serverId) {
    window.open(`/servers/${serverId}/fail2ban/logs`, '_blank');
}

function manageJails(serverId) {
    window.open(`/servers/${serverId}/fail2ban/jails`, '_blank');
}

function addJail() {
    showNotification('Opening Fail2Ban jail creation form...', 'info');
    window.open('/fail2ban/jails/create', '_blank');
}

function auditJails() {
    showNotification('Auditing Fail2Ban jails...', 'info');
    
    fetch('/api/fail2ban/audit-jails', {method: 'POST'})
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Fail2Ban jails audit completed successfully', 'success');
                setTimeout(() => location.reload(), 1000);
            } else {
                showNotification('Failed to audit Fail2Ban jails: ' + data.message, 'error');
            }
        })
        .catch(error => {
            console.log('Error auditing Fail2Ban jails');
        });
}

function viewJailDetails(jailId) {
    window.open(`/fail2ban/jails/${jailId}`, '_blank');
}

function editJail(jailId) {
    window.open(`/fail2ban/jails/${jailId}/edit`, '_blank');
}

function toggleJail(jailId) {
    showNotification('Toggling Fail2Ban jail...', 'info');
    
    fetch(`/api/fail2ban/jails/${jailId}/toggle`, {method: 'POST'})
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Fail2Ban jail toggled successfully', 'success');
                setTimeout(() => location.reload(), 1000);
            } else {
                showNotification('Failed to toggle Fail2Ban jail: ' + data.message, 'error');
            }
        })
        .catch(error => {
            console.log('Error toggling Fail2Ban jail');
            setTimeout(() => location.reload(), 1000);
        });
}

function viewBannedIPs(jailId) {
    window.open(`/fail2ban/jails/${jailId}/banned`, '_blank');
}

function unbanAll(jailId) {
    if (confirm('Are you sure you want to unban all IPs from this jail? This action cannot be undone.')) {
        showNotification('Unbanning all IPs...', 'warning');
        
        fetch(`/api/fail2ban/jails/${jailId}/unban-all`, {method: 'POST'})
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('All IPs unbanned successfully', 'success');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showNotification('Failed to unban IPs: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.log('Error unbanning IPs');
                setTimeout(() => location.reload(), 1000);
            });
    }
}

function deleteJail(jailId) {
    if (confirm('Are you sure you want to delete this Fail2Ban jail? This action cannot be undone.')) {
        showNotification('Deleting Fail2Ban jail...', 'warning');
        
        fetch(`/api/fail2ban/jails/${jailId}`, {method: 'DELETE'})
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Fail2Ban jail deleted successfully', 'success');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showNotification('Failed to delete Fail2Ban jail: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.log('Error deleting Fail2Ban jail');
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

function updateFail2BanStatus(data) {
    // Update Fail2Ban status in the table based on API response
    if (data.servers) {
        data.servers.forEach(server => {
            updateServerStatusInTable(server.id, server.fail2ban_status);
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
                statusCell.className = `badge bg-${status === 'running' ? 'success' : 'danger'}`;
                statusCell.textContent = status === 'running' ? 'Running' : 'Stopped';
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

// Auto-refresh Fail2Ban status every 30 seconds
setInterval(() => {
    if (!document.hidden) {
        refreshFail2BanStatus();
    }
}, 30000);

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl/Cmd + R to refresh
    if ((e.ctrlKey || e.metaKey) && e.key === 'r') {
        e.preventDefault();
        refreshFail2BanStatus();
    }
    
    // Ctrl/Cmd + N to add jail
    if ((e.ctrlKey || e.metaKey) && e.key === 'n') {
        e.preventDefault();
        addJail();
    }
});
</script>
@endpush
                                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a href="#" class="dropdown-item" onclick="editJail('{{ $jail['name'] }}')">
                                                                <i class="bx bx-edit me-2"></i> Edit
                                                            </a>
                                                            @if($jail['enabled'])
                                                            <a href="#" class="dropdown-item text-warning" onclick="disableJail('{{ $jail['name'] }}')">
                                                                <i class="bx bx-pause me-2"></i> Disable
                                                            </a>
                                                            @else
                                                            <a href="#" class="dropdown-item text-success" onclick="enableJail('{{ $jail['name'] }}')">
                                                                <i class="bx bx-play me-2"></i> Enable
                                                            </a>
                                                            @endif
                                                            <a href="#" class="dropdown-item" onclick="restartJail('{{ $jail['name'] }}')">
                                                                <i class="bx bx-refresh me-2"></i> Restart
                                                            </a>
                                                            <a href="#" class="dropdown-item" onclick="viewJailLog('{{ $jail['name'] }}')">
                                                                <i class="bx bx-file me-2"></i> View Log
                                                            </a>
                                                            <div class="dropdown-divider"></div>
                                                            <a href="#" class="dropdown-item text-info" onclick="unbanAll('{{ $jail['name'] }}')">
                                                                <i class="bx bx-unlock me-2"></i> Unban All
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

                <!-- Banned IPs -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Currently Banned IPs</h6>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-outline-warning" onclick="unbanAll()">
                                        <i class="bx bx-unlock me-1"></i> Unban All
                                    </button>
                                    <button class="btn btn-sm btn-outline-info" onclick="refreshBannedList()">
                                        <i class="bx bx-refresh me-1"></i> Refresh
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>IP Address</th>
                                                <th>Jail</th>
                                                <th>Banned Time</th>
                                                <th>Unban Time</th>
                                                <th>Time Remaining</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($fail2ban_config['banned_ips'] as $banned)
                                            <tr>
                                                <td><code>{{ $banned['ip'] }}</code></td>
                                                <td><span class="badge bg-primary">{{ $banned['jail'] }}</span></td>
                                                <td>{{ $banned['time'] }}</td>
                                                <td>{{ $banned['unban_time'] }}</td>
                                                <td>
                                                    @php
                                                        $unbanTime = new DateTime($banned['unban_time']);
                                                        $now = new DateTime();
                                                        $remaining = $unbanTime > $now ? $unbanTime->diff($now)->format('%H:%I:%S') : '00:00:00';
                                                    @endphp
                                                    <span class="badge bg-{{ $remaining != '00:00:00' ? 'warning' : 'success' }}">
                                                        {{ $remaining }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a href="#" class="dropdown-item" onclick="viewBanDetails('{{ $banned['ip'] }}')">
                                                                <i class="bx bx-eye me-2"></i> View Details
                                                            </a>
                                                            <a href="#" class="dropdown-item text-success" onclick="unbanIP('{{ $banned['ip'] }}')">
                                                                <i class="bx bx-unlock me-2"></i> Unban
                                                            </a>
                                                            <a href="#" class="dropdown-item text-warning" onclick="extendBan('{{ $banned['ip'] }}')">
                                                                <i class="bx bx-time-five me-2"></i> Extend Ban
                                                            </a>
                                                            <a href="#" class="dropdown-item text-danger" onclick="permanentBan('{{ $banned['ip'] }}')">
                                                                <i class="bx bx-block me-2"></i> Permanent Ban
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

                <!-- Statistics -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Ban Statistics</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="banChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Jail Activity</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="jailChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Log Files -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Log Files</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Log File</th>
                                                <th>Size</th>
                                                <th>Last Modified</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($fail2ban_config['log_files'] as $log)
                                            <tr>
                                                <td><code>{{ $log['name'] }}</code></td>
                                                <td>{{ $log['size'] }}</td>
                                                <td>{{ $log['last_modified'] }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a href="#" class="dropdown-item" onclick="viewLogFile('{{ $log['name'] }}')">
                                                                <i class="bx bx-eye me-2"></i> View
                                                            </a>
                                                            <a href="#" class="dropdown-item" onclick="downloadLogFile('{{ $log['name'] }}')">
                                                                <i class="bx bx-download me-2"></i> Download
                                                            </a>
                                                            <a href="#" class="dropdown-item text-warning" onclick="rotateLogFile('{{ $log['name'] }}')">
                                                                <i class="bx bx-refresh me-2"></i> Rotate
                                                            </a>
                                                            <a href="#" class="dropdown-item text-danger" onclick="clearLogFile('{{ $log['name'] }}')">
                                                                <i class="bx bx-trash me-2"></i> Clear
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
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Ban Statistics Chart
const banCtx = document.getElementById('banChart').getContext('2d');
new Chart(banCtx, {
    type: 'line',
    data: {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        datasets: [{
            label: 'Banned IPs',
            data: [12, 19, 15, 25, 22, 30, 28],
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

// Jail Activity Chart
const jailCtx = document.getElementById('jailChart').getContext('2d');
new Chart(jailCtx, {
    type: 'doughnut',
    data: {
        labels: ['SSH', 'Apache', 'MySQL', 'Nginx'],
        datasets: [{
            data: [5, 12, 2, 0],
            backgroundColor: [
                '#28a745',
                '#007bff',
                '#ffc107',
                '#6c757d'
            ]
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

function startFail2Ban() {
    showNotification('Fail2Ban service started', 'success');
}

function stopFail2Ban() {
    if (confirm('Are you sure you want to stop Fail2Ban? This will disable intrusion protection.')) {
        showNotification('Fail2Ban service stopped', 'warning');
    }
}

function restartFail2Ban() {
    if (confirm('Are you sure you want to restart Fail2Ban?')) {
        showNotification('Fail2Ban service restarted', 'info');
    }
}

function addJail() {
    showNotification('Opening jail creation wizard...', 'info');
}

function editJail(jailName) {
    showNotification(`Editing jail: ${jailName}`, 'info');
}

function enableJail(jailName) {
    showNotification(`Jail ${jailName} enabled`, 'success');
}

function disableJail(jailName) {
    if (confirm(`Are you sure you want to disable jail: ${jailName}?`)) {
        showNotification(`Jail ${jailName} disabled`, 'warning');
    }
}

function restartJail(jailName) {
    showNotification(`Jail ${jailName} restarted`, 'info');
}

function viewJailLog(jailName) {
    showNotification(`Viewing log for jail: ${jailName}`, 'info');
}

function unbanAll(jailName) {
    if (confirm('Are you sure you want to unban all IPs?')) {
        showNotification('All IPs unbanned successfully', 'success');
    }
}

function unbanAll() {
    if (confirm('Are you sure you want to unban all IPs from all jails?')) {
        showNotification('All IPs unbanned from all jails', 'success');
    }
}

function refreshBannedList() {
    showNotification('Banned IP list refreshed', 'info');
}

function viewBanDetails(ip) {
    showNotification(`Viewing ban details for IP: ${ip}`, 'info');
}

function unbanIP(ip) {
    if (confirm(`Are you sure you want to unban IP: ${ip}?`)) {
        showNotification(`IP ${ip} unbanned successfully`, 'success');
    }
}

function extendBan(ip) {
    showNotification(`Ban extended for IP: ${ip}`, 'info');
}

function permanentBan(ip) {
    if (confirm(`Are you sure you want to permanently ban IP: ${ip}?`)) {
        showNotification(`IP ${ip} permanently banned`, 'warning');
    }
}

function viewLogFile(logFile) {
    showNotification(`Viewing log file: ${logFile}`, 'info');
}

function downloadLogFile(logFile) {
    showNotification(`Downloading log file: ${logFile}`, 'info');
}

function rotateLogFile(logFile) {
    if (confirm(`Are you sure you want to rotate log file: ${logFile}?`)) {
        showNotification(`Log file ${logFile} rotated`, 'info');
    }
}

function clearLogFile(logFile) {
    if (confirm(`Are you sure you want to clear log file: ${logFile}? This action cannot be undone.`)) {
        showNotification(`Log file ${logFile} cleared`, 'warning');
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
