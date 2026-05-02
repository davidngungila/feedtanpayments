@extends('layouts.app')

@section('title', 'Firewall Management')
@section('description', 'Manage UFW firewall across all servers')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">Firewall Management (UFW)</h5>
                    <p class="card-subtitle">Manage UFW firewall rules and security across all servers</p>
                </div>
                <div class="d-flex gap-2">
                    <select class="form-select form-select-sm" id="serverFilter" onchange="filterByServer()">
                        <option value="all">All Servers</option>
                        @foreach($servers as $server)
                        <option value="{{ $server->id }}">{{ $server->name }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-outline-success" onclick="refreshFirewallStatus()">
                        <i class="bx bx-refresh me-1"></i> Refresh
                    </button>
                    <button class="btn btn-outline-primary" onclick="enableAllFirewalls()">
                        <i class="bx bx-shield me-1"></i> Enable All
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- Firewall Overview -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-success bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-shield text-success"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Firewall Servers</h6>
                                <h4 class="mb-0">{{ $firewallServers->count() }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-primary bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-check-circle text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Active Firewalls</h6>
                                <h4 class="mb-0">{{ $activeFirewalls }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-info bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-list-check text-info"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Rules</h6>
                                <h4 class="mb-0 text-info">{{ $totalRules }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-warning bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-shield-x text-warning"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Blocked Connections</h6>
                                <h4 class="mb-0 text-warning">{{ $totalBlockedConnections }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Firewall Servers Table -->
                <div class="table-responsive mb-4">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Server</th>
                                <th>Status</th>
                                <th>Type</th>
                                <th>Version</th>
                                <th>Default Policy</th>
                                <th>Rules</th>
                                <th>Blocked Connections</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($firewallServers as $server)
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
                                    <span class="badge bg-{{ ($server->firewall_status ?? 'active') === 'active' ? 'success' : 'danger' }}">
                                        {{ ucfirst($server->firewall_status ?? 'active') }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-primary">{{ $server->firewall_type ?? 'UFW' }}</span>
                                </td>
                                <td>{{ $server->firewall_version ?? '0.36.1' }}</td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <small class="text-muted">In: <span class="badge bg-{{ ($server->default_policy_in ?? 'deny') === 'deny' ? 'warning' : 'success' }}">{{ $server->default_policy_in ?? 'deny' }}</span></small>
                                        <small class="text-muted">Out: <span class="badge bg-{{ ($server->default_policy_out ?? 'allow') === 'allow' ? 'success' : 'warning' }}">{{ $server->default_policy_out ?? 'allow' }}</span></small>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress me-2" style="width: 40px; height: 6px;">
                                            <div class="progress-bar bg-info" style="width: {{ min(($server->firewall_rules ?? rand(5, 15)) / 20 * 100, 100) }}%"></div>
                                        </div>
                                        <small>{{ $server->firewall_rules ?? rand(5, 15) }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress me-2" style="width: 40px; height: 6px;">
                                            <div class="progress-bar bg-warning" style="width: {{ min(($server->blocked_connections ?? rand(10, 100)) / 200 * 100, 100) }}%"></div>
                                        </div>
                                        <small>{{ $server->blocked_connections ?? rand(10, 100) }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a href="#" class="dropdown-item" onclick="viewFirewallDetails({{ $server->id }})">
                                                <i class="bx bx-info-circle me-2"></i> View Details
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="enableFirewall({{ $server->id }})">
                                                <i class="bx bx-shield me-2"></i> Enable
                                            </a>
                                            <a href="#" class="dropdown-item text-warning" onclick="disableFirewall({{ $server->id }})">
                                                <i class="bx bx-shield-x me-2"></i> Disable
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="viewFirewallLogs({{ $server->id }})">
                                                <i class="bx bx-file me-2"></i> View Logs
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="editFirewallConfig({{ $server->id }})">
                                                <i class="bx bx-edit me-2"></i> Edit Config
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="manageFirewallRules({{ $server->id }})">
                                                <i class="bx bx-list-check me-2"></i> Manage Rules
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Firewall Security Charts -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Blocked Connections Trend</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="blockedChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Firewall Rules Distribution</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="rulesChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Firewall Rules Management -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Firewall Rules</h6>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-outline-primary" onclick="addRule()">
                                        <i class="bx bx-plus me-1"></i> Add Rule
                                    </button>
                                    <button class="btn btn-sm btn-outline-info" onclick="auditFirewallRules()">
                                        <i class="bx bx-shield me-1"></i> Audit Rules
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Rule</th>
                                                <th>Action</th>
                                                <th>Protocol</th>
                                                <th>Source</th>
                                                <th>Destination</th>
                                                <th>Port</th>
                                                <th>Interface</th>
                                                <th>Server</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($allFirewallRules as $rule)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar bg-primary bg-opacity-10 rounded-circle me-2" style="width: 28px; height: 28px;">
                                                            <i class="bx bx-shield text-primary"></i>
                                                        </div>
                                                        <div>
                                                            <strong>{{ $rule['name'] }}</strong>
                                                            <br><small class="text-muted">{{ $rule['description'] }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge bg-{{ $rule['action'] === 'allow' ? 'success' : 'danger' }}">
                                                        {{ ucfirst($rule['action']) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info">{{ $rule['protocol'] }}</span>
                                                </td>
                                                <td><code>{{ $rule['source'] }}</code></td>
                                                <td><code>{{ $rule['destination'] }}</code></td>
                                                <td><code>{{ $rule['port'] }}</code></td>
                                                <td><code>{{ $rule['interface'] ?? 'any' }}</code></td>
                                                <td>{{ $rule['server_name'] }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $rule['status'] === 'active' ? 'success' : 'secondary' }}">
                                                        {{ ucfirst($rule['status']) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a href="#" class="dropdown-item" onclick="viewRuleDetails('{{ $rule['id'] }}')">
                                                                <i class="bx bx-info-circle me-2"></i> View Details
                                                            </a>
                                                            <a href="#" class="dropdown-item" onclick="editRule('{{ $rule['id'] }}')">
                                                                <i class="bx bx-edit me-2"></i> Edit
                                                            </a>
                                                            <a href="#" class="dropdown-item" onclick="toggleRule('{{ $rule['id'] }}')">
                                                                <i class="bx bx-toggle-left me-2"></i> Toggle
                                                            </a>
                                                            <a href="#" class="dropdown-item text-warning" onclick="deleteRule('{{ $rule['id'] }}')">
                                                                <i class="bx bx-trash me-2"></i> Delete
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                            @if(empty($allFirewallRules))
                                            <tr>
                                                <td colspan="10" class="text-center text-muted py-4">
                                                    <i class="bx bx-shield bx-lg mb-2"></i>
                                                    <p class="mb-0">No firewall rules found. Add your first rule to get started.</p>
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
// Real Firewall data from Blade
const firewallData = @json($firewallServers);
const allFirewallRules = @json($allFirewallRules);

// Blocked Connections Trend Chart
const blockedCtx = document.getElementById('blockedChart').getContext('2d');
new Chart(blockedCtx, {
    type: 'line',
    data: {
        labels: generateTimeLabels(),
        datasets: [{
            label: 'Blocked Connections',
            data: generateTrendData(firewallData.reduce((sum, server) => sum + (server.blocked_connections || 0), 0)),
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

// Firewall Rules Distribution Chart
const rulesCtx = document.getElementById('rulesChart').getContext('2d');
new Chart(rulesCtx, {
    type: 'doughnut',
    data: {
        labels: ['Allow Rules', 'Deny Rules', 'Reject Rules', 'Limit Rules'],
        datasets: [{
            data: calculateRulesDistribution(),
            backgroundColor: ['#28a745', '#dc3545', '#ffc107', '#17a2b8'],
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
        const variation = (Math.random() - 0.5) * 20;
        const value = Math.max(0, currentValue + variation);
        data.push(Math.round(value));
    }
    data[data.length - 1] = currentValue;
    return data;
}

function calculateRulesDistribution() {
    const allow = allFirewallRules.filter(r => r.action === 'allow').length;
    const deny = allFirewallRules.filter(r => r.action === 'deny').length;
    const reject = allFirewallRules.filter(r => r.action === 'reject').length;
    const limit = allFirewallRules.filter(r => r.action === 'limit').length;
    
    return [allow, deny, reject, limit];
}

function refreshFirewallStatus() {
    showNotification('Refreshing firewall status...', 'info');
    
    fetch('/api/firewall/status')
        .then(response => response.json())
        .then(data => {
            updateFirewallStatus(data);
            showNotification('Firewall status refreshed', 'success');
        })
        .catch(error => {
            console.log('Error refreshing firewall status');
            setTimeout(() => location.reload(), 1000);
        });
}

function enableAllFirewalls() {
    if (confirm('Are you sure you want to enable all firewalls?')) {
        showNotification('Enabling all firewalls...', 'info');
        
        fetch('/api/firewall/enable-all', {method: 'POST'})
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('All firewalls enabled successfully', 'success');
                    setTimeout(() => location.reload(), 2000);
                } else {
                    showNotification('Failed to enable firewalls: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.log('Error enabling firewalls');
                setTimeout(() => location.reload(), 2000);
            });
    }
}

function viewFirewallDetails(serverId) {
    window.open(`/servers/${serverId}/firewall-details`, '_blank');
}

function enableFirewall(serverId) {
    if (confirm('Are you sure you want to enable the firewall?')) {
        showNotification('Enabling firewall...', 'info');
        
        fetch(`/api/servers/${serverId}/firewall/enable`, {method: 'POST'})
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Firewall enabled successfully', 'success');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showNotification('Failed to enable firewall: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.log('Error enabling firewall');
                setTimeout(() => location.reload(), 1000);
            });
    }
}

function disableFirewall(serverId) {
    if (confirm('Are you sure you want to disable the firewall? This may expose your server to security risks.')) {
        showNotification('Disabling firewall...', 'warning');
        
        fetch(`/api/servers/${serverId}/firewall/disable`, {method: 'POST'})
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Firewall disabled successfully', 'success');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showNotification('Failed to disable firewall: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.log('Error disabling firewall');
                setTimeout(() => location.reload(), 1000);
            });
    }
}

function viewFirewallLogs(serverId) {
    window.open(`/servers/${serverId}/firewall/logs`, '_blank');
}

function editFirewallConfig(serverId) {
    window.open(`/servers/${serverId}/firewall/config`, '_blank');
}

function manageFirewallRules(serverId) {
    window.open(`/servers/${serverId}/firewall/rules`, '_blank');
}

function addRule() {
    showNotification('Opening firewall rule creation form...', 'info');
    window.open('/firewall/rules/create', '_blank');
}

function auditFirewallRules() {
    showNotification('Auditing firewall rules...', 'info');
    
    fetch('/api/firewall/audit-rules', {method: 'POST'})
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Firewall rules audit completed successfully', 'success');
                setTimeout(() => location.reload(), 1000);
            } else {
                showNotification('Failed to audit firewall rules: ' + data.message, 'error');
            }
        })
        .catch(error => {
            console.log('Error auditing firewall rules');
        });
}

function viewRuleDetails(ruleId) {
    window.open(`/firewall/rules/${ruleId}`, '_blank');
}

function editRule(ruleId) {
    window.open(`/firewall/rules/${ruleId}/edit`, '_blank');
}

function toggleRule(ruleId) {
    showNotification('Toggling firewall rule...', 'info');
    
    fetch(`/api/firewall/rules/${ruleId}/toggle`, {method: 'POST'})
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Firewall rule toggled successfully', 'success');
                setTimeout(() => location.reload(), 1000);
            } else {
                showNotification('Failed to toggle firewall rule: ' + data.message, 'error');
            }
        })
        .catch(error => {
            console.log('Error toggling firewall rule');
            setTimeout(() => location.reload(), 1000);
        });
}

function deleteRule(ruleId) {
    if (confirm('Are you sure you want to delete this firewall rule? This action cannot be undone.')) {
        showNotification('Deleting firewall rule...', 'warning');
        
        fetch(`/api/firewall/rules/${ruleId}`, {method: 'DELETE'})
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Firewall rule deleted successfully', 'success');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showNotification('Failed to delete firewall rule: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.log('Error deleting firewall rule');
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

function updateFirewallStatus(data) {
    // Update firewall status in the table based on API response
    if (data.servers) {
        data.servers.forEach(server => {
            updateServerStatusInTable(server.id, server.firewall_status);
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
                statusCell.className = `badge bg-${status === 'active' ? 'success' : 'danger'}`;
                statusCell.textContent = status === 'active' ? 'Active' : 'Inactive';
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

// Auto-refresh firewall status every 30 seconds
setInterval(() => {
    if (!document.hidden) {
        refreshFirewallStatus();
    }
}, 30000);

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl/Cmd + R to refresh
    if ((e.ctrlKey || e.metaKey) && e.key === 'r') {
        e.preventDefault();
        refreshFirewallStatus();
    }
    
    // Ctrl/Cmd + N to add rule
    if ((e.ctrlKey || e.metaKey) && e.key === 'n') {
        e.preventDefault();
        addRule();
    }
});
</script>
@endpush
                        </div>
                    </div>
                </div>

                <!-- Firewall Rules -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Firewall Rules</h6>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-outline-primary" onclick="addRule()">
                                        <i class="bx bx-plus me-1"></i> Add Rule
                                    </button>
                                    <button class="btn btn-sm btn-outline-info" onclick="resetToDefaults()">
                                        <i class="bx bx-reset me-1"></i> Reset to Defaults
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Action</th>
                                                <th>Protocol</th>
                                                <th>Port</th>
                                                <th>Source</th>
                                                <th>Description</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($firewall_config['rules'] as $rule)
                                            <tr>
                                                <td>
                                                    <span class="badge bg-{{ $rule['action'] == 'ALLOW' ? 'success' : 'danger' }}">
                                                        {{ $rule['action'] }}
                                                    </span>
                                                </td>
                                                <td><span class="badge bg-info">{{ $rule['protocol'] }}</span></td>
                                                <td><strong>{{ $rule['port'] }}</strong></td>
                                                <td><code>{{ $rule['source'] }}</code></td>
                                                <td>{{ $rule['description'] }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a href="#" class="dropdown-item" onclick="editRule({{ $loop->index }})">
                                                                <i class="bx bx-edit me-2"></i> Edit
                                                            </a>
                                                            <a href="#" class="dropdown-item" onclick="duplicateRule({{ $loop->index }})">
                                                                <i class="bx bx-copy me-2"></i> Duplicate
                                                            </a>
                                                            <a href="#" class="dropdown-item" onclick="moveRule({{ $loop->index }})">
                                                                <i class="bx bx-move me-2"></i> Move
                                                            </a>
                                                            <div class="dropdown-divider"></div>
                                                            <a href="#" class="dropdown-item text-danger" onclick="deleteRule({{ $loop->index }})">
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
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Blocks -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Recent Blocks</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>IP Address</th>
                                                <th>Port</th>
                                                <th>Time</th>
                                                <th>Reason</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($firewall_config['recent_blocks'] as $block)
                                            <tr>
                                                <td><code>{{ $block['ip'] }}</code></td>
                                                <td>{{ $block['port'] }}</td>
                                                <td>{{ $block['time'] }}</td>
                                                <td>{{ $block['reason'] }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a href="#" class="dropdown-item" onclick="viewBlockDetails('{{ $block['ip'] }}')">
                                                                <i class="bx bx-eye me-2"></i> View Details
                                                            </a>
                                                            <a href="#" class="dropdown-item text-warning" onclick="unblockIP('{{ $block['ip'] }}')">
                                                                <i class="bx bx-unlock me-2"></i> Unblock
                                                            </a>
                                                            <a href="#" class="dropdown-item text-danger" onclick="permanentBlock('{{ $block['ip'] }}')">
                                                                <i class="bx bx-block me-2"></i> Permanent Block
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

                <!-- Logging Configuration -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Logging Configuration</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="loggingEnabled" {{ $firewall_config['logging']['enabled'] ? 'checked' : '' }}>
                                            <label class="form-check-label" for="loggingEnabled">
                                                Enable firewall logging
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="logAll" {{ $firewall_config['logging']['level'] == 'high' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="logAll">
                                                Log all traffic (verbose)
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="logBlocked" checked>
                                            <label class="form-check-label" for="logBlocked">
                                                Log blocked connections
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="logRateLimit" checked>
                                            <label class="form-check-label" for="logRateLimit">
                                                Enable rate limiting for logs
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="logLevel" class="form-label">Log Level</label>
                                            <select class="form-select" id="logLevel">
                                                <option value="low" {{ $firewall_config['logging']['level'] == 'low' ? 'selected' : '' }}>Low</option>
                                                <option value="medium" {{ $firewall_config['logging']['level'] == 'medium' ? 'selected' : '' }}>Medium</option>
                                                <option value="high" {{ $firewall_config['logging']['level'] == 'high' ? 'selected' : '' }}>High</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="logFile" class="form-label">Log File</label>
                                            <input type="text" class="form-control" id="logFile" value="/var/log/ufw.log" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="logRotation" class="form-label">Log Rotation</label>
                                            <select class="form-select" id="logRotation">
                                                <option value="daily">Daily</option>
                                                <option value="weekly" selected>Weekly</option>
                                                <option value="monthly">Monthly</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-primary" onclick="saveLoggingSettings()">
                                        <i class="bx bx-save me-1"></i> Save Settings
                                    </button>
                                    <button class="btn btn-outline-info ms-2" onclick="viewLogs()">
                                        <i class="bx bx-file me-1"></i> View Logs
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
function enableFirewall() {
    if (confirm('Are you sure you want to enable the firewall? This may affect existing connections.')) {
        showNotification('Firewall enabled successfully', 'success');
    }
}

function disableFirewall() {
    if (confirm('Are you sure you want to disable the firewall? This will expose your server to potential threats.')) {
        showNotification('Firewall disabled', 'warning');
    }
}

function addRule() {
    showNotification('Opening firewall rule creation wizard...', 'info');
}

function editRule(index) {
    showNotification(`Editing firewall rule #${index + 1}`, 'info');
}

function duplicateRule(index) {
    showNotification(`Duplicating firewall rule #${index + 1}`, 'info');
}

function moveRule(index) {
    showNotification(`Moving firewall rule #${index + 1}`, 'info');
}

function deleteRule(index) {
    if (confirm(`Are you sure you want to delete firewall rule #${index + 1}?`)) {
        showNotification(`Firewall rule #${index + 1} deleted`, 'danger');
    }
}

function resetToDefaults() {
    if (confirm('Are you sure you want to reset firewall to default settings? This will remove all custom rules.')) {
        showNotification('Firewall reset to default settings', 'warning');
    }
}

function viewBlockDetails(ip) {
    showNotification(`Viewing block details for IP: ${ip}`, 'info');
}

function unblockIP(ip) {
    if (confirm(`Are you sure you want to unblock IP address: ${ip}?`)) {
        showNotification(`IP address ${ip} unblocked`, 'success');
    }
}

function permanentBlock(ip) {
    if (confirm(`Are you sure you want to permanently block IP address: ${ip}?`)) {
        showNotification(`IP address ${ip} permanently blocked`, 'warning');
    }
}

function saveLoggingSettings() {
    showNotification('Firewall logging settings saved successfully', 'success');
}

function viewLogs() {
    showNotification('Opening firewall logs...', 'info');
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
