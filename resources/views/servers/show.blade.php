@extends('layouts.app')

@section('title', 'Server Details - ' . $server->name)
@section('description', 'View detailed information and manage server ' . $server->name)

@section('content')
<div class="row">
    <!-- Server Overview -->
    <div class="col-12 mb-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="avatar bg-primary bg-opacity-10 rounded-circle me-3" style="width: 48px; height: 48px;">
                        <i class="bx bx-server text-primary"></i>
                    </div>
                    <div>
                        <h5 class="card-title mb-0">{{ $server->name }}</h5>
                        <p class="card-subtitle mb-0">{{ $server->os_type }} {{ $server->os_version }} • {{ $server->location }}</p>
                    </div>
                </div>
                <div class="d-flex gap-2 align-items-center">
                    @if($server->status == 'online')
                        <span class="badge bg-success">Online</span>
                    @else
                        <span class="badge bg-danger">Offline</span>
                    @endif
                    <a href="{{ route('servers.edit', $server->id) }}" class="btn btn-outline-primary btn-sm">
                        <i class="bx bx-edit me-1"></i> Edit
                    </a>
                    <div class="dropdown">
                        <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="dropdown">
                            <i class="bx bx-dots-horizontal-rounded"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="#" class="dropdown-item text-success">
                                <i class="bx bx-play me-2"></i> Start Server
                            </a>
                            <a href="#" class="dropdown-item text-warning">
                                <i class="bx bx-stop me-2"></i> Stop Server
                            </a>
                            <a href="#" class="dropdown-item text-danger">
                                <i class="bx bx-power-off me-2"></i> Restart Server
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                <i class="bx bx-cloud-download me-2"></i> Create Backup
                            </a>
                            <a href="#" class="dropdown-item">
                                <i class="bx bx-shield me-2"></i> Security Scan
                            </a>
                            <a href="#" class="dropdown-item">
                                <i class="bx bx-cog me-2"></i> System Update
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <!-- Performance Metrics -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="avatar bg-success bg-opacity-10 rounded-circle me-2" style="width: 32px; height: 32px;">
                                        <i class="bx bx-chip text-success"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">CPU Usage</h6>
                                        <div class="d-flex align-items-center">
                                            <div class="progress me-2" style="width: 60px; height: 8px;">
                                                <div class="progress-bar {{ $server->cpu_usage > 80 ? 'bg-danger' : ($server->cpu_usage > 60 ? 'bg-warning' : 'bg-success') }}" style="width: {{ $server->cpu_usage }}%"></div>
                                            </div>
                                            <span class="fw-medium">{{ number_format($server->cpu_usage, 1) }}%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="avatar bg-info bg-opacity-10 rounded-circle me-2" style="width: 32px; height: 32px;">
                                        <i class="bx bx-memory text-info"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Memory Usage</h6>
                                        <div class="d-flex align-items-center">
                                            <div class="progress me-2" style="width: 60px; height: 8px;">
                                                <div class="progress-bar {{ $server->memory_usage > 80 ? 'bg-danger' : ($server->memory_usage > 60 ? 'bg-warning' : 'bg-success') }}" style="width: {{ $server->memory_usage }}%"></div>
                                            </div>
                                            <span class="fw-medium">{{ number_format($server->memory_usage, 1) }}%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="avatar bg-primary bg-opacity-10 rounded-circle me-2" style="width: 32px; height: 32px;">
                                        <i class="bx bx-hard-drive text-primary"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Disk Usage</h6>
                                        <div class="d-flex align-items-center">
                                            <div class="progress me-2" style="width: 60px; height: 8px;">
                                                <div class="progress-bar {{ $server->disk_usage > 80 ? 'bg-danger' : ($server->disk_usage > 60 ? 'bg-warning' : 'bg-success') }}" style="width: {{ $server->disk_usage }}%"></div>
                                            </div>
                                            <span class="fw-medium">{{ number_format($server->disk_usage, 1) }}%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Server Information -->
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="mb-3">Server Information</h6>
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="text-muted" style="width: 150px;">IP Address:</td>
                                        <td><strong>{{ $server->ip_address }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Hostname:</td>
                                        <td>{{ $server->hostname }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Operating System:</td>
                                        <td>{{ $server->os_type }} {{ $server->os_version }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Location:</td>
                                        <td>{{ $server->location }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Status:</td>
                                        <td>
                                            @if($server->status == 'online')
                                                <span class="badge bg-success">Online</span>
                                            @else
                                                <span class="badge bg-danger">Offline</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Last Checked:</td>
                                        <td>{{ $server->last_checked ? $server->last_checked->diffForHumans() : 'Never' }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h6 class="mb-3">Hardware Specifications</h6>
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="text-muted" style="width: 150px;">CPU Cores:</td>
                                        <td>{{ $server->cpu_cores }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Memory:</td>
                                        <td>{{ $server->memory }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Disk Space:</td>
                                        <td>{{ $server->disk_space }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Notes:</td>
                                        <td>{{ $server->notes ?: 'No notes' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <!-- Quick Actions -->
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Quick Actions</h6>
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <a href="{{ route('servers.performance', $server->id) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="bx bx-line-chart me-2"></i> View Performance
                                    </a>
                                    <a href="{{ route('servers.logs', $server->id) }}" class="btn btn-outline-info btn-sm">
                                        <i class="bx bx-file me-2"></i> View Logs
                                    </a>
                                    <button class="btn btn-outline-success btn-sm" onclick="createBackup()">
                                        <i class="bx bx-cloud-download me-2"></i> Create Backup
                                    </button>
                                    <button class="btn btn-outline-warning btn-sm" onclick="securityScan()">
                                        <i class="bx bx-shield me-2"></i> Security Scan
                                    </button>
                                    <button class="btn btn-outline-secondary btn-sm" onclick="systemUpdate()">
                                        <i class="bx bx-cog me-2"></i> System Update
                                    </button>
                                    <button class="btn btn-outline-danger btn-sm" onclick="restartServer()">
                                        <i class="bx bx-power-off me-2"></i> Restart Server
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Last Backup -->
                        <div class="card border-0 shadow-sm mt-3">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Last Backup</h6>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted">Date:</span>
                                    <strong>{{ $server->last_checked ? $server->last_checked->format('Y-m-d H:i') : 'Never' }}</strong>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted">Status:</span>
                                    <span class="badge bg-success">Completed</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">Size:</span>
                                    <strong>2.4 GB</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Services Status -->
    <div class="col-md-6 mb-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Services Status</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Service</th>
                                <th>Status</th>
                                <th>Port</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $services = $server->services ?? [];
                                $servicePorts = [
                                    'nginx' => 80,
                                    'apache' => 80,
                                    'mysql' => 3306,
                                    'mariadb' => 3306,
                                    'php-fpm' => 9000,
                                    'ssh' => 22,
                                    'ufw' => null,
                                    'fail2ban' => null
                                ];
                            @endphp
                            @foreach($services as $serviceName => $status)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar bg-primary bg-opacity-10 rounded-circle me-2" style="width: 28px; height: 28px;">
                                            <i class="bx bx-cog text-primary"></i>
                                        </div>
                                        <span>{{ ucfirst($serviceName) }}</span>
                                    </div>
                                </td>
                                <td>
                                    @if($status == 'active')
                                        <span class="badge bg-success">Running</span>
                                    @else
                                        <span class="badge bg-danger">Stopped</span>
                                    @endif
                                </td>
                                <td>{{ $servicePorts[$serviceName] ?? '-' }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            @if($status == 'active')
                                                <a href="#" class="dropdown-item text-warning" onclick="restartService('{{ $serviceName }}')">
                                                    <i class="bx bx-refresh me-2"></i> Restart
                                                </a>
                                            @else
                                                <a href="#" class="dropdown-item text-success" onclick="startService('{{ $serviceName }}')">
                                                    <i class="bx bx-play me-2"></i> Start
                                                </a>
                                            @endif
                                            <a href="#" class="dropdown-item" onclick="viewServiceLogs('{{ $serviceName }}')">
                                                <i class="bx bx-file me-2"></i> View Logs
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

    <!-- Recent Logs -->
    <div class="col-md-6 mb-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Recent Logs</h5>
                <a href="{{ route('servers.logs', $server->id) }}" class="btn btn-sm btn-outline-primary">
                    View All Logs
                </a>
            </div>
            <div class="card-body">
                <div class="timeline">
                    @php
                        $sampleLogs = [
                            ['timestamp' => now()->subMinutes(5)->format('H:i'), 'message' => 'Server status check completed successfully', 'level' => 'info'],
                            ['timestamp' => now()->subMinutes(15)->format('H:i'), 'message' => 'Nginx configuration reloaded', 'level' => 'success'],
                            ['timestamp' => now()->subMinutes(30)->format('H:i'), 'message' => 'Database backup completed', 'level' => 'success'],
                            ['timestamp' => now()->subHours(1)->format('H:i'), 'message' => 'System update available', 'level' => 'warning'],
                            ['timestamp' => now()->subHours(2)->format('H:i'), 'message' => 'SSL certificate renewed successfully', 'level' => 'success'],
                        ];
                    @endphp
                    @foreach($sampleLogs as $log)
                    <div class="timeline-item">
                        <div class="timeline-point {{ $log['level'] == 'error' ? 'bg-danger' : ($log['level'] == 'warning' ? 'bg-warning' : 'bg-success') }}"></div>
                        <div class="timeline-content">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <small class="text-muted">{{ $log['timestamp'] }}</small>
                                    <p class="mb-1 mt-1">{{ $log['message'] }}</p>
                                </div>
                                <span class="badge bg-label-{{ $log['level'] == 'error' ? 'danger' : ($log['level'] == 'warning' ? 'warning' : 'success') }}">
                                    {{ $log['level'] }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function createBackup() {
    const serverId = {{ $server->id }};
    showNotification('Backup initiated successfully', 'success');
    
    // Simulate API call
    fetch(`/api/servers/${serverId}/backup`, {method: 'POST'})
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Backup completed successfully', 'success');
            } else {
                showNotification('Backup failed: ' + data.message, 'error');
            }
        })
        .catch(error => {
            console.log('Backup simulation');
        });
}

function securityScan() {
    const serverId = {{ $server->id }};
    showNotification('Security scan started', 'info');
    
    fetch(`/api/servers/${serverId}/security-scan`, {method: 'POST'})
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Security scan completed - No threats found', 'success');
            } else {
                showNotification('Security scan found issues', 'warning');
            }
        })
        .catch(error => {
            console.log('Security scan simulation');
        });
}

function systemUpdate() {
    const serverId = {{ $server->id }};
    if (confirm('Are you sure you want to update the system? This may take some time.')) {
        showNotification('System update scheduled', 'warning');
        
        fetch(`/api/servers/${serverId}/update`, {method: 'POST'})
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('System update completed successfully', 'success');
                } else {
                    showNotification('System update failed', 'error');
                }
            })
            .catch(error => {
                console.log('System update simulation');
            });
    }
}

function restartServer() {
    const serverId = {{ $server->id }};
    if (confirm('Are you sure you want to restart the server? This will temporarily disconnect all users.')) {
        showNotification('Server restart initiated', 'warning');
        
        fetch(`/api/servers/${serverId}/restart`, {method: 'POST'})
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Server restarted successfully', 'success');
                    setTimeout(() => location.reload(), 2000);
                } else {
                    showNotification('Server restart failed', 'error');
                }
            })
            .catch(error => {
                console.log('Server restart simulation');
                setTimeout(() => location.reload(), 2000);
            });
    }
}

function restartService(serviceName) {
    const serverId = {{ $server->id }};
    if (confirm(`Are you sure you want to restart ${serviceName}?`)) {
        showNotification(`Restarting ${serviceName}...`, 'warning');
        
        fetch(`/api/servers/${serverId}/services/${serviceName}/restart`, {method: 'POST'})
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(`${serviceName} restarted successfully`, 'success');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showNotification(`Failed to restart ${serviceName}`, 'error');
                }
            })
            .catch(error => {
                console.log('Service restart simulation');
                setTimeout(() => location.reload(), 1000);
            });
    }
}

function startService(serviceName) {
    const serverId = {{ $server->id }};
    if (confirm(`Are you sure you want to start ${serviceName}?`)) {
        showNotification(`Starting ${serviceName}...`, 'info');
        
        fetch(`/api/servers/${serverId}/services/${serviceName}/start`, {method: 'POST'})
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(`${serviceName} started successfully`, 'success');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showNotification(`Failed to start ${serviceName}`, 'error');
                }
            })
            .catch(error => {
                console.log('Service start simulation');
                setTimeout(() => location.reload(), 1000);
            });
    }
}

function viewServiceLogs(serviceName) {
    const serverId = {{ $server->id }};
    window.open(`/servers/${serverId}/logs?service=${serviceName}`, '_blank');
}

function showNotification(message, type) {
    const alert = document.createElement('div');
    alert.className = `alert alert-${type} alert-dismissible fade show position-fixed top-0 end-0 m-3`;
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

// Auto-refresh server status every 30 seconds
setInterval(() => {
    if (!document.hidden) {
        fetch(`/api/servers/{{ $server->id }}/status`)
            .then(response => response.json())
            .then(data => {
                // Update performance metrics if data changed
                if (data.cpu_usage !== undefined) {
                    // Update CPU usage
                    const cpuBar = document.querySelector('.progress-bar[style*="width"]');
                    if (cpuBar) {
                        cpuBar.style.width = data.cpu_usage + '%';
                        cpuBar.className = `progress-bar ${data.cpu_usage > 80 ? 'bg-danger' : (data.cpu_usage > 60 ? 'bg-warning' : 'bg-success')}`;
                    }
                }
            })
            .catch(error => {
                console.log('Error refreshing server status');
            });
    }
}, 30000);
</script>
@endpush
