@extends('layouts.app')

@section('title', 'Server Monitoring')
@section('description', 'Real-time monitoring of all servers')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">Server Monitoring</h5>
                    <p class="card-subtitle">Real-time monitoring of all servers in your infrastructure</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-success" onclick="refreshMonitoring()">
                        <i class="bx bx-refresh me-1"></i> Refresh
                    </button>
                    <button class="btn btn-outline-primary" onclick="exportData()">
                        <i class="bx bx-download me-1"></i> Export
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- Overview Statistics -->
                <div class="row mb-4">
                    <div class="col-md-2">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-primary bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-server text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Servers</h6>
                                <h4 class="mb-0">6</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
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
                    <div class="col-md-2">
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
                    <div class="col-md-2">
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
                    <div class="col-md-2">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-info bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-chip text-info"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Avg CPU</h6>
                                <h4 class="mb-0 text-info">36.1%</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-primary bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-memory text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Avg Memory</h6>
                                <h4 class="mb-0">45.2%</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Server Grid -->
                <div class="row mb-4">
                    @foreach($servers as $server)
                    <div class="col-md-4 mb-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <h6 class="mb-1">{{ $server['name'] }}</h6>
                                        <small class="text-muted">{{ $server['uptime'] }}</small>
                                    </div>
                                    <span class="badge bg-{{ $server['status'] == 'online' ? 'success' : 'danger' }}">
                                        {{ $server['status'] }}
                                    </span>
                                </div>
                                
                                <div class="row mb-2">
                                    <div class="col-6">
                                        <small class="text-muted">CPU</small>
                                        <div class="d-flex align-items-center">
                                            <div class="progress me-2" style="width: 40px; height: 6px;">
                                                <div class="progress-bar {{ $server['cpu'] > 80 ? 'bg-danger' : ($server['cpu'] > 60 ? 'bg-warning' : 'bg-success') }}" 
                                                     style="width: {{ $server['cpu'] }}%"></div>
                                            </div>
                                            <small>{{ $server['cpu'] }}%</small>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Memory</small>
                                        <div class="d-flex align-items-center">
                                            <div class="progress me-2" style="width: 40px; height: 6px;">
                                                <div class="progress-bar {{ $server['memory'] > 80 ? 'bg-danger' : ($server['memory'] > 60 ? 'bg-warning' : 'bg-success') }}" 
                                                     style="width: {{ $server['memory'] }}%"></div>
                                            </div>
                                            <small>{{ $server['memory'] }}%</small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-6">
                                        <small class="text-muted">Disk</small>
                                        <div class="d-flex align-items-center">
                                            <div class="progress me-2" style="width: 40px; height: 6px;">
                                                <div class="progress-bar {{ $server['disk'] > 80 ? 'bg-danger' : ($server['disk'] > 60 ? 'bg-warning' : 'bg-success') }}" 
                                                     style="width: {{ $server['disk'] }}%"></div>
                                            </div>
                                            <small>{{ $server['disk'] }}%</small>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Status</small>
                                        <div>
                                            @if($server['status'] == 'online')
                                                <span class="badge bg-success">Running</span>
                                            @else
                                                <span class="badge bg-danger">Down</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Performance Charts -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">CPU Usage Trend</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="cpuChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Memory Usage Trend</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="memoryChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Alerts Section -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Recent Alerts</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Server</th>
                                                <th>Type</th>
                                                <th>Message</th>
                                                <th>Time</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($alerts as $alert)
                                            <tr>
                                                <td>{{ $alert['server'] }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $alert['type'] == 'error' ? 'danger' : ($alert['type'] == 'warning' ? 'warning' : 'info') }}">
                                                        {{ $alert['type'] }}
                                                    </span>
                                                </td>
                                                <td>{{ $alert['message'] }}</td>
                                                <td>{{ $alert['time'] }}</td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary" onclick="viewAlertDetails('{{ $alert['server'] }}', '{{ $alert['message'] }}')">
                                                        <i class="bx bx-eye"></i>
                                                    </button>
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
// Sample data for charts
const cpuData = [45, 48, 42, 50, 47, 45, 43, 46, 44, 45, 48, 51, 49, 46, 44, 42, 45, 47, 50, 48];
const memoryData = [68, 70, 65, 72, 69, 68, 66, 67, 68, 68, 71, 74, 72, 69, 67, 65, 68, 70, 73, 71];

// CPU Chart
const cpuCtx = document.getElementById('cpuChart').getContext('2d');
new Chart(cpuCtx, {
    type: 'line',
    data: {
        labels: ['10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30', '18:00', '18:30', '19:00', '19:30'],
        datasets: [{
            label: 'CPU Usage (%)',
            data: cpuData,
            borderColor: '#28a745',
            backgroundColor: 'rgba(40, 167, 69, 0.1)',
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
                beginAtZero: true,
                max: 100
            }
        }
    }
});

// Memory Chart
const memoryCtx = document.getElementById('memoryChart').getContext('2d');
new Chart(memoryCtx, {
    type: 'line',
    data: {
        labels: ['10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30', '18:00', '18:30', '19:00', '19:30'],
        datasets: [{
            label: 'Memory Usage (%)',
            data: memoryData,
            borderColor: '#007bff',
            backgroundColor: 'rgba(0, 123, 255, 0.1)',
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
                beginAtZero: true,
                max: 100
            }
        }
    }
});

function refreshMonitoring() {
    showNotification('Monitoring data refreshed', 'success');
}

function exportData() {
    showNotification('Data export initiated', 'info');
}

function viewAlertDetails(server, message) {
    showNotification(`Alert details for ${server}: ${message}`, 'info');
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
