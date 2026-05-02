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
                    <select class="form-select form-select-sm" id="refreshInterval" onchange="updateRefreshInterval()">
                        <option value="5">Auto-refresh: 5s</option>
                        <option value="10" selected>Auto-refresh: 10s</option>
                        <option value="30">Auto-refresh: 30s</option>
                        <option value="60">Auto-refresh: 1min</option>
                        <option value="0">Manual</option>
                    </select>
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
                                <h4 class="mb-0">{{ $servers->count() }}</h4>
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
                                <h4 class="mb-0 text-success">{{ $servers->where('status', 'online')->count() }}</h4>
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
                                <h4 class="mb-0 text-danger">{{ $servers->where('status', 'offline')->count() }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-warning bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-error text-warning"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Warnings</h6>
                                <h4 class="mb-0 text-warning">{{ $servers->filter(function($server) { return $server->cpu_usage > 80 || $server->memory_usage > 80 || $server->disk_usage > 80; })->count() }}</h4>
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
                                <h4 class="mb-0 text-info">{{ $servers->avg('cpu_usage') ? number_format($servers->avg('cpu_usage'), 1) : '0' }}%</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-secondary bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-memory text-secondary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Avg Memory</h6>
                                <h4 class="mb-0 text-secondary">{{ $servers->avg('memory_usage') ? number_format($servers->avg('memory_usage'), 1) : '0' }}%</h4>
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
                                        <h6 class="mb-1">{{ $server->name }}</h6>
                                        <small class="text-muted">{{ $server->hostname }} • {{ $server->location }}</small>
                                    </div>
                                    <span class="badge bg-{{ $server->status == 'online' ? 'success' : 'danger' }}">
                                        {{ ucfirst($server->status) }}
                                    </span>
                                </div>
                                
                                <div class="row mb-2">
                                    <div class="col-6">
                                        <small class="text-muted">CPU</small>
                                        <div class="d-flex align-items-center">
                                            <div class="progress me-2" style="width: 40px; height: 6px;">
                                                <div class="progress-bar {{ $server->cpu_usage > 80 ? 'bg-danger' : ($server->cpu_usage > 60 ? 'bg-warning' : 'bg-success') }}" 
                                                     style="width: {{ $server->cpu_usage }}%"></div>
                                            </div>
                                            <small>{{ number_format($server->cpu_usage, 1) }}%</small>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Memory</small>
                                        <div class="d-flex align-items-center">
                                            <div class="progress me-2" style="width: 40px; height: 6px;">
                                                <div class="progress-bar {{ $server->memory_usage > 80 ? 'bg-danger' : ($server->memory_usage > 60 ? 'bg-warning' : 'bg-success') }}" 
                                                     style="width: {{ $server->memory_usage }}%"></div>
                                            </div>
                                            <small>{{ number_format($server->memory_usage, 1) }}%</small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-6">
                                        <small class="text-muted">Disk</small>
                                        <div class="d-flex align-items-center">
                                            <div class="progress me-2" style="width: 40px; height: 6px;">
                                                <div class="progress-bar {{ $server->disk_usage > 80 ? 'bg-danger' : ($server->disk_usage > 60 ? 'bg-warning' : 'bg-success') }}" 
                                                     style="width: {{ $server->disk_usage }}%"></div>
                                            </div>
                                            <small>{{ number_format($server->disk_usage, 1) }}%</small>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Last Check</small>
                                        <div>
                                            <small class="text-muted">{{ $server->last_checked ? $server->last_checked->diffForHumans() : 'Never' }}</small>
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
                                            @php
                                                $alerts = [];
                                                foreach($servers as $server) {
                                                    if($server->cpu_usage > 80) {
                                                        $alerts[] = [
                                                            'server' => $server->name,
                                                            'type' => 'warning',
                                                            'message' => 'High CPU usage: ' . number_format($server->cpu_usage, 1) . '%',
                                                            'time' => $server->last_checked ? $server->last_checked->format('H:i') : 'Unknown'
                                                        ];
                                                    }
                                                    if($server->memory_usage > 80) {
                                                        $alerts[] = [
                                                            'server' => $server->name,
                                                            'type' => 'warning',
                                                            'message' => 'High memory usage: ' . number_format($server->memory_usage, 1) . '%',
                                                            'time' => $server->last_checked ? $server->last_checked->format('H:i') : 'Unknown'
                                                        ];
                                                    }
                                                    if($server->disk_usage > 80) {
                                                        $alerts[] = [
                                                            'server' => $server->name,
                                                            'type' => 'error',
                                                            'message' => 'High disk usage: ' . number_format($server->disk_usage, 1) . '%',
                                                            'time' => $server->last_checked ? $server->last_checked->format('H:i') : 'Unknown'
                                                        ];
                                                    }
                                                    if($server->status == 'offline') {
                                                        $alerts[] = [
                                                            'server' => $server->name,
                                                            'type' => 'error',
                                                            'message' => 'Server is offline',
                                                            'time' => $server->last_checked ? $server->last_checked->format('H:i') : 'Unknown'
                                                        ];
                                                    }
                                                }
                                            @endphp
                                            @foreach($alerts as $alert)
                                            <tr>
                                                <td>{{ $alert['server'] }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $alert['type'] == 'error' ? 'danger' : ($alert['type'] == 'warning' ? 'warning' : 'info') }}">
                                                        {{ ucfirst($alert['type']) }}
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
                                            @if(empty($alerts))
                                            <tr>
                                                <td colspan="5" class="text-center text-muted">No alerts at this time</td>
                                            </tr>
                                            @endif
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
let refreshInterval = 10000; // Default 10 seconds
let refreshTimer = null;

// Real server data from Blade
const serverData = @json($servers->map(function($server) {
    return [
        'id' => $server->id,
        'name' => $server->name,
        'hostname' => $server->hostname,
        'status' => $server->status,
        'cpu_usage' => $server->cpu_usage,
        'memory_usage' => $server->memory_usage,
        'disk_usage' => $server->disk_usage,
        'location' => $server->location,
        'last_checked' => $server->last_checked ? $server->last_checked->format('Y-m-d H:i:s') : null
    ];
}));

// Generate time labels for charts
function generateTimeLabels() {
    const labels = [];
    const now = new Date();
    for (let i = 19; i >= 0; i--) {
        const time = new Date(now - i * 30 * 60000);
        labels.push(time.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' }));
    }
    return labels;
}

// Generate sample trend data based on current values
function generateTrendData(currentValue) {
    const data = [];
    for (let i = 0; i < 20; i++) {
        const variation = (Math.random() - 0.5) * 10;
        const value = Math.max(0, Math.min(100, currentValue + variation));
        data.push(Math.round(value * 10) / 10);
    }
    data[data.length - 1] = currentValue; // Ensure last point is current value
    return data;
}

// CPU Chart
const cpuCtx = document.getElementById('cpuChart').getContext('2d');
const cpuChart = new Chart(cpuCtx, {
    type: 'line',
    data: {
        labels: generateTimeLabels(),
        datasets: [{
            label: 'Average CPU Usage (%)',
            data: generateTrendData(serverData.reduce((sum, server) => sum + server.cpu_usage, 0) / serverData.length),
            borderColor: '#28a745',
            backgroundColor: 'rgba(40, 167, 69, 0.1)',
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
                max: 100,
                ticks: {
                    callback: function(value) {
                        return value + '%';
                    }
                }
            }
        }
    }
});

// Memory Chart
const memoryCtx = document.getElementById('memoryChart').getContext('2d');
const memoryChart = new Chart(memoryCtx, {
    type: 'line',
    data: {
        labels: generateTimeLabels(),
        datasets: [{
            label: 'Average Memory Usage (%)',
            data: generateTrendData(serverData.reduce((sum, server) => sum + server.memory_usage, 0) / serverData.length),
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
                beginAtZero: true,
                max: 100,
                ticks: {
                    callback: function(value) {
                        return value + '%';
                    }
                }
            }
        }
    }
});

// Advanced monitoring functions
function refreshMonitoring() {
    showNotification('Refreshing monitoring data...', 'info');
    
    fetch('/api/servers/monitoring-data')
        .then(response => response.json())
        .then(data => {
            updateCharts(data);
            updateStatistics(data);
            showNotification('Monitoring data updated', 'success');
        })
        .catch(error => {
            console.log('Error fetching monitoring data');
            setTimeout(() => location.reload(), 1000);
        });
}

function updateCharts(data) {
    // Update CPU chart
    if (data.cpu_average !== undefined) {
        const cpuData = cpuChart.data.datasets[0].data;
        cpuData.shift();
        cpuData.push(data.cpu_average);
        cpuChart.update('none');
    }
    
    // Update Memory chart
    if (data.memory_average !== undefined) {
        const memData = memoryChart.data.datasets[0].data;
        memData.shift();
        memData.push(data.memory_average);
        memoryChart.update('none');
    }
}

function updateStatistics(data) {
    // Update statistics if elements exist
    const totalServers = document.querySelector('.card-body h4');
    if (totalServers && data.total_servers !== undefined) {
        totalServers.textContent = data.total_servers;
    }
}

function updateRefreshInterval() {
    const select = document.getElementById('refreshInterval');
    const interval = parseInt(select.value);
    
    if (interval === 0) {
        clearInterval(refreshTimer);
        refreshTimer = null;
        showNotification('Auto-refresh disabled', 'info');
    } else {
        refreshInterval = interval * 1000;
        clearInterval(refreshTimer);
        refreshTimer = setInterval(refreshMonitoring, refreshInterval);
        showNotification(`Auto-refresh set to ${interval} seconds`, 'success');
    }
}

function exportData() {
    const csvContent = generateCSV();
    downloadCSV(csvContent, 'server-monitoring-' + new Date().toISOString().slice(0, 10) + '.csv');
    showNotification('Monitoring data exported successfully', 'success');
}

function generateCSV() {
    let csv = 'Server,Hostname,Status,CPU Usage,Memory Usage,Disk Usage,Location,Last Checked\n';
    
    serverData.forEach(server => {
        csv += `"${server.name}","${server.hostname}","${server.status}","${server.cpu_usage}%","${server.memory_usage}%","${server.disk_usage}%","${server.location}","${server.last_checked || 'Never'}"\n`;
    });
    
    return csv;
}

function downloadCSV(content, filename) {
    const blob = new Blob([content], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    const url = URL.createObjectURL(blob);
    link.setAttribute('href', url);
    link.setAttribute('download', filename);
    link.style.visibility = 'hidden';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

function viewAlertDetails(server, message) {
    showNotification(`Alert from ${server}: ${message}`, 'info');
    
    // Could open a modal with more details
    console.log('Alert details:', { server, message });
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

// Auto-refresh on page load
document.addEventListener('DOMContentLoaded', function() {
    refreshTimer = setInterval(refreshMonitoring, refreshInterval);
    
    // Update last checked times every minute
    setInterval(() => {
        const lastCheckedElements = document.querySelectorAll('[data-last-checked]');
        lastCheckedElements.forEach(element => {
            const timestamp = element.getAttribute('data-last-checked');
            if (timestamp) {
                const date = new Date(timestamp);
                element.textContent = getRelativeTime(date);
            }
        });
    }, 60000);
});

function getRelativeTime(date) {
    const now = new Date();
    const diff = Math.floor((now - date) / 1000); // seconds
    
    if (diff < 60) return 'Just now';
    if (diff < 3600) return Math.floor(diff / 60) + ' minutes ago';
    if (diff < 86400) return Math.floor(diff / 3600) + ' hours ago';
    return Math.floor(diff / 86400) + ' days ago';
}

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl/Cmd + R to refresh
    if ((e.ctrlKey || e.metaKey) && e.key === 'r') {
        e.preventDefault();
        refreshMonitoring();
    }
    
    // Ctrl/Cmd + E to export
    if ((e.ctrlKey || e.metaKey) && e.key === 'e') {
        e.preventDefault();
        exportData();
    }
});
</script>
@endpush
