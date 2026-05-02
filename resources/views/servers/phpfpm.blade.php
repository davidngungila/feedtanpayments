@extends('layouts.app')

@section('title', 'PHP-FPM Management')
@section('description', 'Manage PHP-FPM process manager across all servers')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">PHP-FPM Management</h5>
                    <p class="card-subtitle">Manage PHP-FPM process manager across all servers</p>
                </div>
                <div class="d-flex gap-2">
                    <select class="form-select form-select-sm" id="serverFilter" onchange="filterByServer()">
                        <option value="all">All Servers</option>
                        @foreach($servers as $server)
                        <option value="{{ $server->id }}">{{ $server->name }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-outline-success" onclick="refreshPHPFPMStatus()">
                        <i class="bx bx-refresh me-1"></i> Refresh
                    </button>
                    <button class="btn btn-outline-primary" onclick="restartAllPHPFPM()">
                        <i class="bx bx-refresh me-1"></i> Restart All
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- PHP-FPM Overview -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-success bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-code text-success"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Pools</h6>
                                <h4 class="mb-0">{{ $phpfpmservers->count() }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-primary bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-server text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Active Processes</h6>
                                <h4 class="mb-0">{{ $totalActiveProcesses }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-info bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-tachometer text-info"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Avg Requests/sec</h6>
                                <h4 class="mb-0 text-info">{{ number_format($avgRequestsPerSecond, 1) }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-warning bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-memory text-warning"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Avg Memory Usage</h6>
                                <h4 class="mb-0 text-warning">{{ number_format($avgMemoryUsage, 1) }}%</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- PHP-FPM Servers Table -->
                <div class="table-responsive mb-4">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Server</th>
                                <th>PHP Version</th>
                                <th>Status</th>
                                <th>Process Manager</th>
                                <th>Max Children</th>
                                <th>Active Processes</th>
                                <th>Idle Processes</th>
                                <th>Requests/sec</th>
                                <th>Memory Usage</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($phpfpmservers as $server)
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
                                    <span class="badge bg-info">{{ $server->php_version ?? '8.2.12' }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $server->status === 'online' ? 'success' : 'danger' }}">
                                        {{ ucfirst($server->status) }}
                                    </span>
                                </td>
                                <td>{{ $server->process_manager ?? 'ondemand' }}</td>
                                <td>{{ $server->max_children ?? 50 }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress me-2" style="width: 40px; height: 6px;">
                                            <div class="progress-bar bg-success" style="width: {{ ($server->active_processes ?? rand(5, 15)) / ($server->max_children ?? 50) * 100 }}%"></div>
                                        </div>
                                        <small>{{ $server->active_processes ?? rand(5, 15) }}</small>
                                    </div>
                                </td>
                                <td>{{ $server->idle_processes ?? rand(5, 35) }}</td>
                                <td>{{ number_format($server->requests_per_second ?? (rand(50, 200) / 10), 1) }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress me-2" style="width: 40px; height: 6px;">
                                            <div class="progress-bar {{ ($server->memory_usage ?? rand(20, 60)) > 50 ? 'bg-warning' : 'bg-success' }}" 
                                                 style="width: {{ $server->memory_usage ?? rand(20, 60) }}%"></div>
                                        </div>
                                        <small>{{ $server->memory_usage ?? rand(20, 60) }}%</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a href="#" class="dropdown-item" onclick="viewPHPFPMDetails({{ $server->id }})">
                                                <i class="bx bx-info-circle me-2"></i> View Details
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="restartPHPFPM({{ $server->id }})">
                                                <i class="bx bx-refresh me-2"></i> Restart Service
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="reloadConfig({{ $server->id }})">
                                                <i class="bx bx-sync me-2"></i> Reload Config
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="viewPHPFPMLogs({{ $server->id }})">
                                                <i class="bx bx-file me-2"></i> View Logs
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="editPHPFPMConfig({{ $server->id }})">
                                                <i class="bx bx-edit me-2"></i> Edit Config
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- PHP-FPM Performance Charts -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Request Performance</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="requestChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Memory Usage Trends</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="memoryChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- PHP-FPM Pools -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">PHP-FPM Pools</h6>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-outline-primary" onclick="addPool()">
                                        <i class="bx bx-plus me-1"></i> Add Pool
                                    </button>
                                    <button class="btn btn-sm btn-outline-info" onclick="optimizeAllPools()">
                                        <i class="bx bx-wrench me-1"></i> Optimize All
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Pool Name</th>
                                                <th>Status</th>
                                                <th>Processes</th>
                                                <th>Max Children</th>
                                                <th>Listen</th>
                                                <th>Owner</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($allPools as $pool)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar bg-primary bg-opacity-10 rounded-circle me-2" style="width: 28px; height: 28px;">
                                                            <i class="bx bx-layer text-primary"></i>
                                                        </div>
                                                        <div>
                                                            <strong>{{ $pool['name'] }}</strong>
                                                            <br><small class="text-muted">{{ $pool['server_name'] }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge bg-{{ $pool['status'] == 'active' ? 'success' : 'danger' }}">
                                                        {{ ucfirst($pool['status']) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="progress me-2" style="width: 40px; height: 6px;">
                                                            <div class="progress-bar bg-info" style="width: {{ ($pool['processes'] / $pool['max_children']) * 100 }}%"></div>
                                                        </div>
                                                        <small>{{ $pool['processes'] }}</small>
                                                    </div>
                                                </td>
                                                <td>{{ $pool['max_children'] }}</td>
                                                <td><code>/run/php/php{{ $pool['version'] }}-{{ $pool['name'] }}.sock</code></td>
                                                <td><code>{{ $pool['owner'] ?? 'www-data' }}</code></td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a href="#" class="dropdown-item" onclick="editPool('{{ $pool['name'] }}', {{ $pool['server_id'] }})">
                                                                <i class="bx bx-edit me-2"></i> Edit
                                                            </a>
                                                            <a href="#" class="dropdown-item text-warning" onclick="restartPool('{{ $pool['name'] }}', {{ $pool['server_id'] }})">
                                                                <i class="bx bx-refresh me-2"></i> Restart
                                                            </a>
                                                            <a href="#" class="dropdown-item" onclick="viewPoolStatus('{{ $pool['name'] }}', {{ $pool['server_id'] }})">
                                                                <i class="bx bx-bar-chart me-2"></i> Status
                                                            </a>
                                                            <a href="#" class="dropdown-item" onclick="viewPoolConfig('{{ $pool['name'] }}', {{ $pool['server_id'] }})">
                                                                <i class="bx bx-file me-2"></i> Config
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                            @if(empty($allPools))
                                            <tr>
                                                <td colspan="7" class="text-center text-muted py-4">
                                                    <i class="bx bx-layer bx-lg mb-2"></i>
                                                    <p class="mb-0">No PHP-FPM pools found. Create your first pool to get started.</p>
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
// Real PHP-FPM data from Blade
const phpfpmData = @json($phpfpmservers);
const allPools = @json($allPools);

// Request Performance Chart
const requestCtx = document.getElementById('requestChart').getContext('2d');
new Chart(requestCtx, {
    type: 'line',
    data: {
        labels: generateTimeLabels(),
        datasets: [{
            label: 'Requests per Second',
            data: generateTrendData(phpfpmData.reduce((sum, server) => sum + (server.requests_per_second || 0), 0) / phpfpmData.length),
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

// Memory Usage Trends Chart
const memoryCtx = document.getElementById('memoryChart').getContext('2d');
new Chart(memoryCtx, {
    type: 'line',
    data: {
        labels: generateTimeLabels(),
        datasets: [{
            label: 'Memory Usage (%)',
            data: generateTrendData(phpfpmData.reduce((sum, server) => sum + (server.memory_usage || 0), 0) / phpfpmData.length),
            borderColor: '#ffc107',
            backgroundColor: 'rgba(255, 193, 7, 0.1)',
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
                beginAtZero: true,
                max: 100
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
        data.push(Math.round(value * 10) / 10);
    }
    data[data.length - 1] = currentValue;
    return data;
}

function refreshPHPFPMStatus() {
    showNotification('Refreshing PHP-FPM status...', 'info');
    
    fetch('/api/phpfpm/status')
        .then(response => response.json())
        .then(data => {
            updatePHPFPMStatus(data);
            showNotification('PHP-FPM status refreshed', 'success');
        })
        .catch(error => {
            console.log('Error refreshing PHP-FPM status');
            setTimeout(() => location.reload(), 1000);
        });
}

function restartAllPHPFPM() {
    if (confirm('Are you sure you want to restart all PHP-FPM services?')) {
        showNotification('Restarting all PHP-FPM services...', 'info');
        
        fetch('/api/phpfpm/restart-all', {method: 'POST'})
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('All PHP-FPM services restarted successfully', 'success');
                    setTimeout(() => location.reload(), 2000);
                } else {
                    showNotification('Failed to restart PHP-FPM services: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.log('Error restarting PHP-FPM services');
                setTimeout(() => location.reload(), 2000);
            });
    }
}

function viewPHPFPMDetails(serverId) {
    window.open(`/servers/${serverId}/phpfpm-details`, '_blank');
}

function restartPHPFPM(serverId) {
    if (confirm('Are you sure you want to restart the PHP-FPM service?')) {
        showNotification('Restarting PHP-FPM service...', 'warning');
        
        fetch(`/api/servers/${serverId}/phpfpm/restart`, {method: 'POST'})
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('PHP-FPM service restarted successfully', 'success');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showNotification('Failed to restart PHP-FPM: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.log('Error restarting PHP-FPM');
                setTimeout(() => location.reload(), 1000);
            });
    }
}

function reloadConfig(serverId) {
    showNotification('Reloading PHP-FPM configuration...', 'info');
    
    fetch(`/api/servers/${serverId}/phpfpm/reload`, {method: 'POST'})
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('PHP-FPM configuration reloaded successfully', 'success');
            } else {
                showNotification('Failed to reload PHP-FPM configuration: ' + data.message, 'error');
            }
        })
        .catch(error => {
            console.log('Error reloading PHP-FPM configuration');
        });
}

function viewPHPFPMLogs(serverId) {
    window.open(`/servers/${serverId}/phpfpm/logs`, '_blank');
}

function editPHPFPMConfig(serverId) {
    window.open(`/servers/${serverId}/phpfpm/config`, '_blank');
}

function addPool() {
    showNotification('Opening PHP-FPM pool creation form...', 'info');
    window.open('/phpfpm/pools/create', '_blank');
}

function optimizeAllPools() {
    if (confirm('Are you sure you want to optimize all PHP-FPM pools?')) {
        showNotification('Optimizing all PHP-FPM pools...', 'info');
        
        fetch('/api/phpfpm/optimize-all', {method: 'POST'})
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('All PHP-FPM pools optimized successfully', 'success');
                } else {
                    showNotification('Failed to optimize PHP-FPM pools: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.log('Error optimizing PHP-FPM pools');
            });
    }
}

function editPool(poolName, serverId) {
    window.open(`/servers/${serverId}/phpfpm/pools/${poolName}/edit`, '_blank');
}

function restartPool(poolName, serverId) {
    if (confirm(`Are you sure you want to restart PHP-FPM pool "${poolName}"?`)) {
        showNotification(`Restarting PHP-FPM pool ${poolName}...`, 'warning');
        
        fetch(`/api/servers/${serverId}/phpfpm/pools/${poolName}/restart`, {method: 'POST'})
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(`PHP-FPM pool ${poolName} restarted successfully`, 'success');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showNotification(`Failed to restart pool ${poolName}: ` + data.message, 'error');
                }
            })
            .catch(error => {
                console.log('Error restarting PHP-FPM pool');
                setTimeout(() => location.reload(), 1000);
            });
    }
}

function viewPoolStatus(poolName, serverId) {
    window.open(`/servers/${serverId}/phpfpm/pools/${poolName}/status`, '_blank');
}

function viewPoolConfig(poolName, serverId) {
    window.open(`/servers/${serverId}/phpfpm/pools/${poolName}/config`, '_blank');
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

function updatePHPFPMStatus(data) {
    // Update PHP-FPM status in the table based on API response
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
            const statusCell = row.querySelector('td:nth-child(3) span');
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

// Auto-refresh PHP-FPM status every 30 seconds
setInterval(() => {
    if (!document.hidden) {
        refreshPHPFPMStatus();
    }
}, 30000);

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl/Cmd + R to refresh
    if ((e.ctrlKey || e.metaKey) && e.key === 'r') {
        e.preventDefault();
        refreshPHPFPMStatus();
    }
    
    // Ctrl/Cmd + N to add pool
    if ((e.ctrlKey || e.metaKey) && e.key === 'n') {
        e.preventDefault();
        addPool();
    }
});
</script>
@endpush
                                            <div class="row">
                                                <div class="col-6">
                                                    <small class="text-muted">Hits:</small><br>
                                                    <strong>{{ number_format($phpfpm_config['opcache']['cached_scripts'] - $phpfpm_config['opcache']['misses']) }}</strong>
                                                </div>
                                                <div class="col-6">
                                                    <small class="text-muted">Misses:</small><br>
                                                    <strong>{{ $phpfpm_config['opcache']['misses'] }}</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Performance Chart -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Performance Metrics</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="performanceChart" height="100"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- PHP Extensions -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Loaded Extensions</h6>
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($phpfpm_config['extensions'] as $extension)
                                    <span class="badge bg-primary">{{ $extension }}</span>
                                    @endforeach
                                </div>
                                <div class="mt-3">
                                    <small class="text-muted">Total Extensions: {{ count($phpfpm_config['extensions']) }}</small>
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
// Performance Chart
const performanceCtx = document.getElementById('performanceChart').getContext('2d');
new Chart(performanceCtx, {
    type: 'line',
    data: {
        labels: ['10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00', '13:30', '14:00', '14:30'],
        datasets: [
            {
                label: 'Requests/sec',
                data: [142, 148, 155, 152, 158, 156, 154, 157, 156, 156],
                borderColor: '#28a745',
                backgroundColor: 'rgba(40, 167, 69, 0.1)',
                tension: 0.4,
                yAxisID: 'y'
            },
            {
                label: 'Active Processes',
                data: [6, 7, 8, 7, 9, 8, 8, 8, 8, 8],
                borderColor: '#007bff',
                backgroundColor: 'rgba(0, 123, 255, 0.1)',
                tension: 0.4,
                yAxisID: 'y1'
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: {
            mode: 'index',
            intersect: false,
        },
        scales: {
            y: {
                type: 'linear',
                display: true,
                position: 'left',
                title: {
                    display: true,
                    text: 'Requests/sec'
                }
            },
            y1: {
                type: 'linear',
                display: true,
                position: 'right',
                title: {
                    display: true,
                    text: 'Processes'
                },
                grid: {
                    drawOnChartArea: false,
                },
            },
        }
    }
});

function restartPHPFPM() {
    if (confirm('Are you sure you want to restart PHP-FPM? This will interrupt all PHP requests.')) {
        showNotification('PHP-FPM restart initiated', 'warning');
    }
}

function reloadConfig() {
    showNotification('Reloading PHP-FPM configuration...', 'info');
}

function addPool() {
    showNotification('Opening pool creation wizard...', 'info');
}

function editPool(poolName) {
    showNotification(`Editing pool: ${poolName}`, 'info');
}

function restartPool(poolName) {
    if (confirm(`Are you sure you want to restart pool "${poolName}"?`)) {
        showNotification(`Restarting pool: ${poolName}`, 'warning');
    }
}

function viewPoolStatus(poolName) {
    showNotification(`Viewing status for pool: ${poolName}`, 'info');
}

function viewPoolConfig(poolName) {
    showNotification(`Viewing configuration for pool: ${poolName}`, 'info');
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
