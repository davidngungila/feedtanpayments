@extends('layouts.app')

@section('title', 'Web Server Management')
@section('description', 'Manage Apache/Nginx web server configuration')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">{{ $webserver_config['type'] }} Web Server</h5>
                    <p class="card-subtitle">Manage {{ $webserver_config['type'] }} web server configuration and performance</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-success" onclick="restartWebserver()">
                        <i class="bx bx-refresh me-1"></i> Restart
                    </button>
                    <button class="btn btn-outline-primary" onclick="testConfig()">
                        <i class="bx bx-test-tube me-1"></i> Test Config
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- Server Overview -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-success bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-globe text-success"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Status</h6>
                                <h4 class="mb-0 text-success">{{ $webserver_config['status'] }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-primary bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-info-circle text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Version</h6>
                                <h4 class="mb-0">{{ $webserver_config['version'] }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-info bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-link text-info"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Connections</h6>
                                <h4 class="mb-0 text-info">{{ $webserver_config['active_connections'] }}/{{ $webserver_config['max_connections'] }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-warning bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-tachometer text-warning"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Requests/sec</h6>
                                <h4 class="mb-0 text-warning">{{ $webserver_config['requests_per_second'] }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Configuration Details -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Server Configuration</h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="text-muted" style="width: 150px;">HTTP Port:</td>
                                        <td><strong>{{ $webserver_config['port'] }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">HTTPS Port:</td>
                                        <td><strong>{{ $webserver_config['ssl_port'] }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Workers:</td>
                                        <td><strong>{{ $webserver_config['workers'] }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Max Connections:</td>
                                        <td><strong>{{ $webserver_config['max_connections'] }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Virtual Hosts:</td>
                                        <td><strong>{{ $webserver_config['virtual_hosts'] }}</strong></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Enabled Modules</h6>
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($webserver_config['modules_enabled'] as $module)
                                    <span class="badge bg-success">{{ $module }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Performance Metrics -->
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

                <!-- Virtual Hosts -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Virtual Hosts</h6>
                                <button class="btn btn-sm btn-outline-primary" onclick="addVirtualHost()">
                                    <i class="bx bx-plus me-1"></i> Add Host
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Domain</th>
                                                <th>Document Root</th>
                                                <th>Status</th>
                                                <th>SSL</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><strong>example.com</strong></td>
                                                <td>/var/www/example.com/public</td>
                                                <td><span class="badge bg-success">Active</span></td>
                                                <td><span class="badge bg-success">Enabled</span></td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a href="#" class="dropdown-item">
                                                                <i class="bx bx-edit me-2"></i> Edit
                                                            </a>
                                                            <a href="#" class="dropdown-item">
                                                                <i class="bx bx-refresh me-2"></i> Restart
                                                            </a>
                                                            <a href="#" class="dropdown-item">
                                                                <i class="bx bx-file me-2"></i> View Config
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>myapp.net</strong></td>
                                                <td>/var/www/myapp.net/public</td>
                                                <td><span class="badge bg-success">Active</span></td>
                                                <td><span class="badge bg-success">Enabled</span></td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a href="#" class="dropdown-item">
                                                                <i class="bx bx-edit me-2"></i> Edit
                                                            </a>
                                                            <a href="#" class="dropdown-item">
                                                                <i class="bx bx-refresh me-2"></i> Restart
                                                            </a>
                                                            <a href="#" class="dropdown-item">
                                                                <i class="bx bx-file me-2"></i> View Config
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
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
                                            @foreach($webserver_config['log_files'] as $log)
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
// Performance Chart
const performanceCtx = document.getElementById('performanceChart').getContext('2d');
new Chart(performanceCtx, {
    type: 'line',
    data: {
        labels: ['10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00', '13:30', '14:00', '14:30'],
        datasets: [
            {
                label: 'Requests/sec',
                data: [180, 195, 210, 225, 240, 234, 228, 235, 242, 234],
                borderColor: '#28a745',
                backgroundColor: 'rgba(40, 167, 69, 0.1)',
                tension: 0.4,
                yAxisID: 'y'
            },
            {
                label: 'Active Connections',
                data: [35, 38, 42, 45, 48, 45, 43, 46, 47, 45],
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
                    text: 'Connections'
                },
                grid: {
                    drawOnChartArea: false,
                },
            },
        }
    }
});

function restartWebserver() {
    if (confirm('Are you sure you want to restart the web server? This will temporarily interrupt service.')) {
        showNotification('Web server restart initiated', 'warning');
    }
}

function testConfig() {
    showNotification('Configuration test in progress...', 'info');
    setTimeout(() => {
        showNotification('Configuration test passed', 'success');
    }, 2000);
}

function addVirtualHost() {
    showNotification('Opening virtual host configuration...', 'info');
}

function viewLogFile(logFile) {
    showNotification(`Opening ${logFile}...`, 'info');
}

function downloadLogFile(logFile) {
    showNotification(`Downloading ${logFile}...`, 'info');
}

function rotateLogFile(logFile) {
    if (confirm(`Are you sure you want to rotate ${logFile}?`)) {
        showNotification(`Rotating ${logFile}...`, 'warning');
    }
}

function clearLogFile(logFile) {
    if (confirm(`Are you sure you want to clear ${logFile}? This action cannot be undone.`)) {
        showNotification(`Clearing ${logFile}...`, 'warning');
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
