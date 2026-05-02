@extends('layouts.app')

@section('title', 'Services Management')
@section('description', 'Manage system services and processes')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">Services Management</h5>
                    <p class="card-subtitle">Manage system services and processes across all servers</p>
                </div>
                <div class="d-flex gap-2">
                    <select class="form-select form-select-sm" id="serverFilter" onchange="filterByServer()">
                        <option value="all">All Servers</option>
                        @foreach($servers as $server)
                        <option value="{{ $server->id }}">{{ $server->name }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-outline-success" onclick="refreshServices()">
                        <i class="bx bx-refresh me-1"></i> Refresh
                    </button>
                    <button class="btn btn-outline-primary" onclick="startAllServices()">
                        <i class="bx bx-play me-1"></i> Start All
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- Services Statistics -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-primary bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-cog text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Services</h6>
                                <h4 class="mb-0">{{ $allServices->count() }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-success bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-play-circle text-success"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Running</h6>
                                <h4 class="mb-0 text-success">{{ $allServices->where('status', 'active')->count() }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-danger bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-stop-circle text-danger"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Stopped</h6>
                                <h4 class="mb-0 text-danger">{{ $allServices->where('status', '!=', 'active')->count() }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-warning bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-alert text-warning"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Issues</h6>
                                <h4 class="mb-0 text-warning">{{ $allServices->filter(function($service) { return $service['status'] == 'inactive' || $service['status'] == 'failed'; })->count() }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Services Table -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Service</th>
                                <th>Server</th>
                                <th>Status</th>
                                <th>Port</th>
                                <th>CPU Usage</th>
                                <th>Memory Usage</th>
                                <th>Uptime</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($allServices as $service)
                            <tr data-server-id="{{ $service['server_id'] }}">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar bg-primary bg-opacity-10 rounded-circle me-2" style="width: 32px; height: 32px;">
                                            <i class="bx bx-cog text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $service['name'] }}</h6>
                                            <small class="text-muted">{{ ucfirst($service['type']) }} Service</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $service['server_name'] }}</span>
                                </td>
                                <td>
                                    @if($service['status'] == 'active')
                                        <span class="badge bg-success">Running</span>
                                    @else
                                        <span class="badge bg-danger">Stopped</span>
                                    @endif
                                </td>
                                <td>
                                    @if($service['port'])
                                        <span class="badge bg-info">{{ $service['port'] }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress me-2" style="width: 60px; height: 6px;">
                                            <div class="progress-bar {{ ($service['cpu_usage'] ?? 0) > 50 ? 'bg-warning' : 'bg-success' }}" 
                                                 style="width: {{ ($service['cpu_usage'] ?? 0) }}%"></div>
                                        </div>
                                        <small>{{ number_format($service['cpu_usage'] ?? 0, 1) }}%</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress me-2" style="width: 60px; height: 6px;">
                                            <div class="progress-bar {{ ($service['memory_usage'] ?? 0) > 50 ? 'bg-warning' : 'bg-success' }}" 
                                                 style="width: {{ ($service['memory_usage'] ?? 0) }}%"></div>
                                        </div>
                                        <small>{{ number_format($service['memory_usage'] ?? 0, 1) }}%</small>
                                    </div>
                                </td>
                                <td>
                                    <small class="text-muted">{{ $service['uptime'] ?? 'Unknown' }}</small>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            @if($service['status'] == 'active')
                                                <a href="#" class="dropdown-item text-warning" onclick="stopService('{{ $service['name'] }}', {{ $service['server_id'] }})">
                                                    <i class="bx bx-stop me-2"></i> Stop
                                                </a>
                                                <a href="#" class="dropdown-item text-info" onclick="restartService('{{ $service['name'] }}', {{ $service['server_id'] }})">
                                                    <i class="bx bx-refresh me-2"></i> Restart
                                                </a>
                                                <a href="#" class="dropdown-item" onclick="reloadService('{{ $service['name'] }}', {{ $service['server_id'] }})">
                                                    <i class="bx bx-sync me-2"></i> Reload Config
                                                </a>
                                            @else
                                                <a href="#" class="dropdown-item text-success" onclick="startService('{{ $service['name'] }}', {{ $service['server_id'] }})">
                                                    <i class="bx bx-play me-2"></i> Start
                                                </a>
                                            @endif
                                            <a href="#" class="dropdown-item" onclick="viewServiceLogs('{{ $service['name'] }}')">
                                                <i class="bx bx-file me-2"></i> View Logs
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="editServiceConfig('{{ $service['name'] }}')">
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

                <!-- Service Details -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Resource Usage</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="resourceChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Service Health</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span>Apache</span>
                                        <span class="badge bg-success">Healthy</span>
                                    </div>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-success" style="width: 95%"></div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span>MySQL</span>
                                        <span class="badge bg-success">Healthy</span>
                                    </div>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-success" style="width: 88%"></div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span>PHP-FPM</span>
                                        <span class="badge bg-warning">Warning</span>
                                    </div>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-warning" style="width: 72%"></div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span>SSH</span>
                                        <span class="badge bg-success">Healthy</span>
                                    </div>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-success" style="width: 98%"></div>
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
// Real service data from Blade
const serviceData = @json($allServices);

// Resource Usage Chart
const resourceCtx = document.getElementById('resourceChart').getContext('2d');
const serviceNames = [...new Set(serviceData.map(s => s.name))].slice(0, 6);

new Chart(resourceCtx, {
    type: 'bar',
    data: {
        labels: serviceNames,
        datasets: [
            {
                label: 'CPU Usage (%)',
                data: serviceNames.map(name => {
                    const service = serviceData.find(s => s.name === name);
                    return service ? (service.cpu_usage || 0) : 0;
                }),
                backgroundColor: 'rgba(40, 167, 69, 0.6)',
                borderColor: 'rgba(40, 167, 69, 1)',
                borderWidth: 1
            },
            {
                label: 'Memory Usage (%)',
                data: serviceNames.map(name => {
                    const service = serviceData.find(s => s.name === name);
                    return service ? (service.memory_usage || 0) : 0;
                }),
                backgroundColor: 'rgba(0, 123, 255, 0.6)',
                borderColor: 'rgba(0, 123, 255, 1)',
                borderWidth: 1
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                max: 100
            }
        }
    }
});

function refreshServices() {
    showNotification('Refreshing services status...', 'info');
    
    fetch('/api/services/status')
        .then(response => response.json())
        .then(data => {
            updateServiceStatus(data);
            showNotification('Services status refreshed', 'success');
        })
        .catch(error => {
            console.log('Error refreshing services');
            setTimeout(() => location.reload(), 1000);
        });
}

function startAllServices() {
    if (confirm('Are you sure you want to start all stopped services?')) {
        showNotification('Starting all services...', 'info');
        
        fetch('/api/services/start-all', {method: 'POST'})
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('All services started successfully', 'success');
                    setTimeout(() => location.reload(), 2000);
                } else {
                    showNotification('Failed to start services: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.log('Error starting services');
                setTimeout(() => location.reload(), 2000);
            });
    }
}

function startService(serviceName, serverId) {
    showNotification(`Starting ${serviceName}...`, 'info');
    
    fetch(`/api/servers/${serverId}/services/${serviceName}/start`, {method: 'POST'})
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(`${serviceName} started successfully`, 'success');
                updateServiceStatusInTable(serviceName, 'active');
            } else {
                showNotification(`Failed to start ${serviceName}: ` + data.message, 'error');
            }
        })
        .catch(error => {
            console.log('Error starting service');
            setTimeout(() => location.reload(), 1000);
        });
}

function stopService(serviceName, serverId) {
    if (confirm(`Are you sure you want to stop ${serviceName}?`)) {
        showNotification(`Stopping ${serviceName}...`, 'warning');
        
        fetch(`/api/servers/${serverId}/services/${serviceName}/stop`, {method: 'POST'})
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(`${serviceName} stopped successfully`, 'success');
                    updateServiceStatusInTable(serviceName, 'inactive');
                } else {
                    showNotification(`Failed to stop ${serviceName}: ` + data.message, 'error');
                }
            })
            .catch(error => {
                console.log('Error stopping service');
                setTimeout(() => location.reload(), 1000);
            });
    }
}

function restartService(serviceName, serverId) {
    if (confirm(`Are you sure you want to restart ${serviceName}?`)) {
        showNotification(`Restarting ${serviceName}...`, 'info');
        
        fetch(`/api/servers/${serverId}/services/${serviceName}/restart`, {method: 'POST'})
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(`${serviceName} restarted successfully`, 'success');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showNotification(`Failed to restart ${serviceName}: ` + data.message, 'error');
                }
            })
            .catch(error => {
                console.log('Error restarting service');
                setTimeout(() => location.reload(), 1000);
            });
    }
}

function reloadService(serviceName, serverId) {
    showNotification(`Reloading ${serviceName} configuration...`, 'info');
    
    fetch(`/api/servers/${serverId}/services/${serviceName}/reload`, {method: 'POST'})
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(`${serviceName} configuration reloaded`, 'success');
            } else {
                showNotification(`Failed to reload ${serviceName}: ` + data.message, 'error');
            }
        })
        .catch(error => {
            console.log('Error reloading service');
        });
}

function viewServiceLogs(serviceName) {
    window.open(`/services/${serviceName.toLowerCase()}/logs`, '_blank');
}

function editServiceConfig(serviceName) {
    showNotification(`Opening ${serviceName} configuration...`, 'info');
    window.open(`/services/${serviceName.toLowerCase()}/config`, '_blank');
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

function updateServiceStatus(data) {
    // Update service status in the table based on API response
    if (data.services) {
        data.services.forEach(service => {
            updateServiceStatusInTable(service.name, service.status);
        });
    }
}

function updateServiceStatusInTable(serviceName, status) {
    const rows = document.querySelectorAll('tbody tr');
    rows.forEach(row => {
        const serviceNameCell = row.querySelector('td h6');
        if (serviceNameCell && serviceNameCell.textContent === serviceName) {
            const statusCell = row.querySelector('td:nth-child(3) span');
            if (statusCell) {
                statusCell.className = `badge bg-${status === 'active' ? 'success' : 'danger'}`;
                statusCell.textContent = status === 'active' ? 'Running' : 'Stopped';
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

// Auto-refresh services status every 30 seconds
setInterval(() => {
    if (!document.hidden) {
        refreshServices();
    }
}, 30000);

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl/Cmd + R to refresh
    if ((e.ctrlKey || e.metaKey) && e.key === 'r') {
        e.preventDefault();
        refreshServices();
    }
    
    // Ctrl/Cmd + A to start all
    if ((e.ctrlKey || e.metaKey) && e.key === 'a') {
        e.preventDefault();
        startAllServices();
    }
});
</script>
@endpush
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
