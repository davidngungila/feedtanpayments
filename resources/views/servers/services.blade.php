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
                    <p class="card-subtitle">Manage system services and processes</p>
                </div>
                <div class="d-flex gap-2">
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
                                <h4 class="mb-0">8</h4>
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
                                <h4 class="mb-0 text-success">6</h4>
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
                                <h4 class="mb-0 text-danger">2</h4>
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
                                <h4 class="mb-0 text-warning">1</h4>
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
                                <th>Status</th>
                                <th>Port</th>
                                <th>CPU Usage</th>
                                <th>Memory Usage</th>
                                <th>Uptime</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($services as $service)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar bg-primary bg-opacity-10 rounded-circle me-2" style="width: 32px; height: 32px;">
                                            <i class="bx bx-cog text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $service['name'] }}</h6>
                                            <small class="text-muted">System Service</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($service['status'] == 'running')
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
                                            <div class="progress-bar {{ $service['cpu'] > 50 ? 'bg-warning' : 'bg-success' }}" 
                                                 style="width: {{ $service['cpu'] * 5 }}%"></div>
                                        </div>
                                        <small>{{ $service['cpu'] }}%</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress me-2" style="width: 60px; height: 6px;">
                                            <div class="progress-bar {{ $service['memory'] > 50 ? 'bg-warning' : 'bg-success' }}" 
                                                 style="width: {{ $service['memory'] * 5 }}%"></div>
                                        </div>
                                        <small>{{ $service['memory'] }}%</small>
                                    </div>
                                </td>
                                <td>
                                    <small class="text-muted">{{ $service['uptime'] }}</small>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            @if($service['status'] == 'running')
                                                <a href="#" class="dropdown-item text-warning" onclick="stopService('{{ $service['name'] }}')">
                                                    <i class="bx bx-stop me-2"></i> Stop
                                                </a>
                                                <a href="#" class="dropdown-item text-info" onclick="restartService('{{ $service['name'] }}')">
                                                    <i class="bx bx-refresh me-2"></i> Restart
                                                </a>
                                                <a href="#" class="dropdown-item" onclick="reloadService('{{ $service['name'] }}')">
                                                    <i class="bx bx-sync me-2"></i> Reload Config
                                                </a>
                                            @else
                                                <a href="#" class="dropdown-item text-success" onclick="startService('{{ $service['name'] }}')">
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
// Resource Usage Chart
const resourceCtx = document.getElementById('resourceChart').getContext('2d');
new Chart(resourceCtx, {
    type: 'bar',
    data: {
        labels: ['Apache', 'MySQL', 'PHP-FPM', 'SSH', 'Postfix', 'Docker'],
        datasets: [
            {
                label: 'CPU Usage (%)',
                data: [12.3, 18.5, 8.7, 0.5, 2.1, 5.2],
                backgroundColor: 'rgba(40, 167, 69, 0.6)',
                borderColor: 'rgba(40, 167, 69, 1)',
                borderWidth: 1
            },
            {
                label: 'Memory Usage (%)',
                data: [15.7, 22.3, 12.1, 1.2, 4.5, 8.9],
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
    showNotification('Services status refreshed', 'success');
}

function startAllServices() {
    if (confirm('Are you sure you want to start all stopped services?')) {
        showNotification('Starting all services...', 'info');
    }
}

function startService(serviceName) {
    showNotification(`Starting ${serviceName}...`, 'info');
}

function stopService(serviceName) {
    if (confirm(`Are you sure you want to stop ${serviceName}?`)) {
        showNotification(`Stopping ${serviceName}...`, 'warning');
    }
}

function restartService(serviceName) {
    if (confirm(`Are you sure you want to restart ${serviceName}?`)) {
        showNotification(`Restarting ${serviceName}...`, 'info');
    }
}

function reloadService(serviceName) {
    showNotification(`Reloading ${serviceName} configuration...`, 'info');
}

function viewServiceLogs(serviceName) {
    showNotification(`Opening ${serviceName} logs...`, 'info');
}

function editServiceConfig(serviceName) {
    showNotification(`Opening ${serviceName} configuration...`, 'info');
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
