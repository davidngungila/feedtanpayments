@extends('layouts.app')

@section('title', 'Server Performance - ' . $server['name'])
@section('description', 'Monitor server performance metrics and trends')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">Server Performance</h5>
                    <p class="card-subtitle">{{ $server['name'] }} - Real-time performance monitoring</p>
                </div>
                <div class="d-flex gap-2">
                    <select class="form-select form-select-sm" style="width: auto;">
                        <option>Last Hour</option>
                        <option selected>Last 24 Hours</option>
                        <option>Last Week</option>
                        <option>Last Month</option>
                    </select>
                    <button class="btn btn-outline-primary btn-sm" onclick="refreshCharts()">
                        <i class="bx bx-refresh me-1"></i> Refresh
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- Performance Overview -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="avatar bg-success bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                        <i class="bx bx-chip text-success"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">CPU Usage</h6>
                                        <h4 class="mb-0 text-success">45.2%</h4>
                                        <small class="text-success">+2.1% from last hour</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="avatar bg-warning bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                        <i class="bx bx-memory text-warning"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Memory Usage</h6>
                                        <h4 class="mb-0 text-warning">68.5%</h4>
                                        <small class="text-warning">-1.3% from last hour</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="avatar bg-info bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                        <i class="bx bx-hard-drive text-info"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Disk Usage</h6>
                                        <h4 class="mb-0 text-info">72.1%</h4>
                                        <small class="text-muted">No change</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="avatar bg-primary bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                        <i class="bx bx-wifi text-primary"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Network I/O</h6>
                                        <h4 class="mb-0 text-primary">142 MB/s</h4>
                                        <small class="text-primary">+15.2% from last hour</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Performance Charts -->
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">CPU Usage Trend</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="cpuChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Memory Usage Trend</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="memoryChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Disk Usage Trend</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="diskChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Network I/O Trend</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="networkChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Process Information -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Top Processes</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Process Name</th>
                                                <th>PID</th>
                                                <th>CPU %</th>
                                                <th>Memory %</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar bg-primary bg-opacity-10 rounded-circle me-2" style="width: 28px; height: 28px;">
                                                            <i class="bx bx-data text-primary"></i>
                                                        </div>
                                                        <span>mysql</span>
                                                    </div>
                                                </td>
                                                <td>1234</td>
                                                <td>18.5%</td>
                                                <td>22.3%</td>
                                                <td><span class="badge bg-success">Running</span></td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a href="#" class="dropdown-item text-warning">
                                                                <i class="bx bx-pause me-2"></i> Pause
                                                            </a>
                                                            <a href="#" class="dropdown-item text-danger">
                                                                <i class="bx bx-stop me-2"></i> Kill
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar bg-success bg-opacity-10 rounded-circle me-2" style="width: 28px; height: 28px;">
                                                            <i class="bx bx-globe text-success"></i>
                                                        </div>
                                                        <span>apache2</span>
                                                    </div>
                                                </td>
                                                <td>5678</td>
                                                <td>12.3%</td>
                                                <td>15.7%</td>
                                                <td><span class="badge bg-success">Running</span></td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a href="#" class="dropdown-item text-warning">
                                                                <i class="bx bx-pause me-2"></i> Pause
                                                            </a>
                                                            <a href="#" class="dropdown-item text-danger">
                                                                <i class="bx bx-stop me-2"></i> Kill
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar bg-warning bg-opacity-10 rounded-circle me-2" style="width: 28px; height: 28px;">
                                                            <i class="bx bx-code text-warning"></i>
                                                        </div>
                                                        <span>php-fpm</span>
                                                    </div>
                                                </td>
                                                <td>9012</td>
                                                <td>8.7%</td>
                                                <td>12.1%</td>
                                                <td><span class="badge bg-success">Running</span></td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a href="#" class="dropdown-item text-warning">
                                                                <i class="bx bx-pause me-2"></i> Pause
                                                            </a>
                                                            <a href="#" class="dropdown-item text-danger">
                                                                <i class="bx bx-stop me-2"></i> Kill
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
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Performance data
const cpuData = [45, 48, 42, 50, 47, 45, 43, 46, 44, 45];
const memoryData = [68, 70, 65, 72, 69, 68, 66, 67, 68, 68];
const diskData = [72, 72, 73, 72, 72, 71, 72, 72, 72, 72];
const networkData = [120, 150, 180, 140, 160, 130, 170, 145, 155, 142];

// Chart configurations
const chartOptions = {
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
};

// CPU Chart
const cpuCtx = document.getElementById('cpuChart').getContext('2d');
new Chart(cpuCtx, {
    type: 'line',
    data: {
        labels: ['10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00', '13:30', '14:00', '14:30'],
        datasets: [{
            label: 'CPU Usage (%)',
            data: cpuData,
            borderColor: '#28a745',
            backgroundColor: 'rgba(40, 167, 69, 0.1)',
            tension: 0.4
        }]
    },
    options: chartOptions
});

// Memory Chart
const memoryCtx = document.getElementById('memoryChart').getContext('2d');
new Chart(memoryCtx, {
    type: 'line',
    data: {
        labels: ['10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00', '13:30', '14:00', '14:30'],
        datasets: [{
            label: 'Memory Usage (%)',
            data: memoryData,
            borderColor: '#ffc107',
            backgroundColor: 'rgba(255, 193, 7, 0.1)',
            tension: 0.4
        }]
    },
    options: chartOptions
});

// Disk Chart
const diskCtx = document.getElementById('diskChart').getContext('2d');
new Chart(diskCtx, {
    type: 'line',
    data: {
        labels: ['10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00', '13:30', '14:00', '14:30'],
        datasets: [{
            label: 'Disk Usage (%)',
            data: diskData,
            borderColor: '#17a2b8',
            backgroundColor: 'rgba(23, 162, 184, 0.1)',
            tension: 0.4
        }]
    },
    options: chartOptions
});

// Network Chart
const networkCtx = document.getElementById('networkChart').getContext('2d');
new Chart(networkCtx, {
    type: 'line',
    data: {
        labels: ['10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00', '13:30', '14:00', '14:30'],
        datasets: [{
            label: 'Network I/O (MB/s)',
            data: networkData,
            borderColor: '#007bff',
            backgroundColor: 'rgba(0, 123, 255, 0.1)',
            tension: 0.4
        }]
    },
    options: {
        ...chartOptions,
        scales: {
            y: {
                beginAtZero: true,
                max: 200
            }
        }
    }
});

function refreshCharts() {
    // Simulate chart refresh
    showNotification('Performance data refreshed', 'success');
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
