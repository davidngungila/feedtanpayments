@extends('layouts.app')

@section('title', 'Server Management - All Servers')
@section('description', 'Manage and monitor all servers in your infrastructure')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">All Servers</h5>
                    <p class="card-subtitle">Monitor and manage your server infrastructure</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('servers.create') }}" class="btn btn-primary">
                        <i class="bx bx-plus me-1"></i> Add Server
                    </a>
                    <button class="btn btn-outline-success" onclick="refreshServers()">
                        <i class="bx bx-refresh me-1"></i> Refresh
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- Server Statistics -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-success bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-server text-success"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Servers</h6>
                                <h4 class="mb-0">6</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-success bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-check-circle text-success"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Online</h6>
                                <h4 class="mb-0 text-success">5</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-danger bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-x-circle text-danger"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Offline</h6>
                                <h4 class="mb-0 text-danger">1</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-warning bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-alert text-warning"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Warnings</h6>
                                <h4 class="mb-0 text-warning">2</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Server Table -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Server Name</th>
                                <th>IP Address</th>
                                <th>Status</th>
                                <th>CPU</th>
                                <th>Memory</th>
                                <th>Disk</th>
                                <th>Uptime</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($servers as $server)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar bg-primary bg-opacity-10 rounded-circle me-2" style="width: 32px; height: 32px;">
                                            <i class="bx bx-server text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $server['name'] }}</h6>
                                            <small class="text-muted">{{ $server['type'] }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $server['ip_address'] }}</td>
                                <td>
                                    @if($server['status'] == 'online')
                                        <span class="badge bg-success">Online</span>
                                    @else
                                        <span class="badge bg-danger">Offline</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress me-2" style="width: 60px; height: 6px;">
                                            <div class="progress-bar {{ $server['cpu_usage'] > 80 ? 'bg-danger' : ($server['cpu_usage'] > 60 ? 'bg-warning' : 'bg-success') }}" 
                                                 style="width: {{ $server['cpu_usage'] }}%"></div>
                                        </div>
                                        <small>{{ $server['cpu_usage'] }}%</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress me-2" style="width: 60px; height: 6px;">
                                            <div class="progress-bar {{ $server['memory_usage'] > 80 ? 'bg-danger' : ($server['memory_usage'] > 60 ? 'bg-warning' : 'bg-success') }}" 
                                                 style="width: {{ $server['memory_usage'] }}%"></div>
                                        </div>
                                        <small>{{ $server['memory_usage'] }}%</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress me-2" style="width: 60px; height: 6px;">
                                            <div class="progress-bar {{ $server['disk_usage'] > 80 ? 'bg-danger' : ($server['disk_usage'] > 60 ? 'bg-warning' : 'bg-success') }}" 
                                                 style="width: {{ $server['disk_usage'] }}%"></div>
                                        </div>
                                        <small>{{ $server['disk_usage'] }}%</small>
                                    </div>
                                </td>
                                <td>
                                    <small class="text-muted">{{ $server['uptime'] }}</small>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a href="{{ route('servers.show', $server['id']) }}" class="dropdown-item">
                                                <i class="bx bx-eye me-2"></i> View Details
                                            </a>
                                            <a href="{{ route('servers.edit', $server['id']) }}" class="dropdown-item">
                                                <i class="bx bx-edit me-2"></i> Edit
                                            </a>
                                            <a href="{{ route('servers.performance', $server['id']) }}" class="dropdown-item">
                                                <i class="bx bx-line-chart me-2"></i> Performance
                                            </a>
                                            <a href="{{ route('servers.logs', $server['id']) }}" class="dropdown-item">
                                                <i class="bx bx-file me-2"></i> View Logs
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item text-success">
                                                <i class="bx bx-play me-2"></i> Start
                                            </a>
                                            <a href="#" class="dropdown-item text-warning">
                                                <i class="bx bx-stop me-2"></i> Stop
                                            </a>
                                            <a href="#" class="dropdown-item text-danger">
                                                <i class="bx bx-power-off me-2"></i> Restart
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

<!-- Quick Actions Modal -->
<div class="modal fade" id="quickActionsModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Quick Actions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="d-grid gap-2">
                    <button class="btn btn-outline-primary">
                        <i class="bx bx-refresh me-2"></i> Refresh All Servers
                    </button>
                    <button class="btn btn-outline-success">
                        <i class="bx bx-play me-2"></i> Start All Offline
                    </button>
                    <button class="btn btn-outline-warning">
                        <i class="bx bx-cloud-download me-2"></i> Backup All Servers
                    </button>
                    <button class="btn btn-outline-info">
                        <i class="bx bx-shield me-2"></i> Security Scan All
                    </button>
                    <button class="btn btn-outline-secondary">
                        <i class="bx bx-cog me-2"></i> Update All Systems
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function refreshServers() {
    // Simulate server refresh
    const button = event.target;
    button.disabled = true;
    button.innerHTML = '<i class="bx bx-loader-alt bx-spin me-1"></i> Refreshing...';
    
    setTimeout(() => {
        button.disabled = false;
        button.innerHTML = '<i class="bx bx-refresh me-1"></i> Refresh';
        // Show success message
        showNotification('Servers refreshed successfully', 'success');
    }, 2000);
}

function showNotification(message, type) {
    // Simple notification implementation
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
