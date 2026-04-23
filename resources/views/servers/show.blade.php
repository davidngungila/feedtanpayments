@extends('layouts.app')

@section('title', 'Server Details - ' . $server['name'])
@section('description', 'View detailed information and manage server ' . $server['name'])

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
                        <h5 class="card-title mb-0">{{ $server['name'] }}</h5>
                        <p class="card-subtitle mb-0">{{ $server['type'] }} • {{ $server['os'] }}</p>
                    </div>
                </div>
                <div class="d-flex gap-2 align-items-center">
                    <span class="badge bg-success">Online</span>
                    <a href="{{ route('servers.edit', $server['id']) }}" class="btn btn-outline-primary btn-sm">
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
                                                <div class="progress-bar bg-warning" style="width: {{ $server['cpu_usage'] }}%"></div>
                                            </div>
                                            <span class="fw-medium">{{ $server['cpu_usage'] }}%</span>
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
                                                <div class="progress-bar bg-warning" style="width: {{ $server['memory_usage'] }}%"></div>
                                            </div>
                                            <span class="fw-medium">{{ $server['memory_usage'] }}%</span>
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
                                                <div class="progress-bar bg-warning" style="width: {{ $server['disk_usage'] }}%"></div>
                                            </div>
                                            <span class="fw-medium">{{ $server['disk_usage'] }}%</span>
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
                                        <td><strong>{{ $server['ip_address'] }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Operating System:</td>
                                        <td>{{ $server['os'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Server Type:</td>
                                        <td>{{ $server['type'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Location:</td>
                                        <td>{{ $server['location'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Uptime:</td>
                                        <td>{{ $server['uptime'] }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h6 class="mb-3">Hardware Specifications</h6>
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="text-muted" style="width: 150px;">CPU:</td>
                                        <td>{{ $server['specs']['cpu'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Cores/Threads:</td>
                                        <td>{{ $server['specs']['cores'] }} / {{ $server['specs']['threads'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Memory:</td>
                                        <td>{{ $server['specs']['memory'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Storage:</td>
                                        <td>{{ $server['specs']['storage'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Network:</td>
                                        <td>{{ $server['specs']['network'] }}</td>
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
                                    <a href="{{ route('servers.performance', $server['id']) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="bx bx-line-chart me-2"></i> View Performance
                                    </a>
                                    <a href="{{ route('servers.logs', $server['id']) }}" class="btn btn-outline-info btn-sm">
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
                                    <strong>{{ $server['last_backup'] }}</strong>
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
                            @foreach($server['services'] as $service)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar bg-primary bg-opacity-10 rounded-circle me-2" style="width: 28px; height: 28px;">
                                            <i class="bx bx-cog text-primary"></i>
                                        </div>
                                        <span>{{ $service['name'] }}</span>
                                    </div>
                                </td>
                                <td>
                                    @if($service['status'] == 'running')
                                        <span class="badge bg-success">Running</span>
                                    @else
                                        <span class="badge bg-danger">Stopped</span>
                                    @endif
                                </td>
                                <td>{{ $service['port'] ?? '-' }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            @if($service['status'] == 'running')
                                                <a href="#" class="dropdown-item text-warning">
                                                    <i class="bx bx-stop me-2"></i> Stop
                                                </a>
                                                <a href="#" class="dropdown-item text-info">
                                                    <i class="bx bx-refresh me-2"></i> Restart
                                                </a>
                                            @else
                                                <a href="#" class="dropdown-item text-success">
                                                    <i class="bx bx-play me-2"></i> Start
                                                </a>
                                            @endif
                                            <a href="#" class="dropdown-item">
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
                <a href="{{ route('servers.logs', $server['id']) }}" class="btn btn-sm btn-outline-primary">
                    View All Logs
                </a>
            </div>
            <div class="card-body">
                <div class="timeline">
                    @foreach($server['logs'] as $log)
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
    showNotification('Backup initiated successfully', 'success');
}

function securityScan() {
    showNotification('Security scan started', 'info');
}

function systemUpdate() {
    showNotification('System update scheduled', 'warning');
}

function restartServer() {
    if (confirm('Are you sure you want to restart the server? This will temporarily disconnect all users.')) {
        showNotification('Server restart initiated', 'warning');
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
