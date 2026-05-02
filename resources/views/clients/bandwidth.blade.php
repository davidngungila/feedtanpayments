@extends('layouts.app')

@section('title', 'Bandwidth Management')
@section('description', 'Monitor and manage client bandwidth usage')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">Bandwidth Management</h5>
                    <p class="card-subtitle">Monitor and manage client bandwidth usage</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-success" onclick="resetBandwidth()">
                        <i class="bx bx-reset me-1"></i> Reset Usage
                    </button>
                    <button class="btn btn-outline-primary" onclick="exportBandwidth()">
                        <i class="bx bx-download me-1"></i> Export
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- Bandwidth Statistics -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-primary bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-transfer text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Bandwidth Used</h6>
                                <h4 class="mb-0">{{ collect($clients)->sum('bandwidth_used') }} GB</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-success bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-check-circle text-success"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Normal Usage</h6>
                                <h4 class="mb-0 text-success">{{ collect($clients)->where('status', 'normal')->count() }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-warning bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-error text-warning"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Warning Usage</h6>
                                <h4 class="mb-0 text-warning">{{ collect($clients)->where('status', 'warning')->count() }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-danger bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-error-circle text-danger"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Critical Usage</h6>
                                <h4 class="mb-0 text-danger">{{ collect($clients)->where('status', 'critical')->count() }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bandwidth Usage Table -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Client</th>
                                <th>Bandwidth Usage</th>
                                <th>Usage %</th>
                                <th>Status</th>
                                <th>Daily Average</th>
                                <th>Peak Usage</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clients as $client)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar bg-primary bg-opacity-10 rounded-circle me-2" style="width: 32px; height: 32px;">
                                            <i class="bx bx-user text-primary"></i>
                                        </div>
                                        <div>
                                            <strong>{{ $client['name'] }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $client['email'] }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="mb-1">
                                        <strong>{{ $client['bandwidth_used'] }} GB / {{ $client['bandwidth_limit'] }} GB</strong>
                                    </div>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-{{ $client['usage_percent'] > 80 ? 'danger' : ($client['usage_percent'] > 60 ? 'warning' : 'success') }}" 
                                             style="width: {{ min($client['usage_percent'], 100) }}%"></div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $client['usage_percent'] > 80 ? 'danger' : ($client['usage_percent'] > 60 ? 'warning' : 'success') }}">
                                        {{ number_format($client['usage_percent'], 1) }}%
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $client['status'] == 'normal' ? 'success' : ($client['status'] == 'warning' ? 'warning' : 'danger') }}">
                                        {{ $client['status'] }}
                                    </span>
                                </td>
                                <td>
                                    <small>{{ number_format(collect($client['daily_usage'])->avg(function($day) { return floatval(str_replace(' GB', '', $day['usage'])); }), 2) }} GB</small>
                                </td>
                                <td>
                                    <small>{{ collect($client['daily_usage'])->max('usage') }}</small>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a href="#" class="dropdown-item" onclick="viewDetails({{ $client['id'] }})">
                                                <i class="bx bx-eye me-2"></i> View Details
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="viewChart({{ $client['id'] }})">
                                                <i class="bx bx-line-chart me-2"></i> Usage Chart
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="viewLogs({{ $client['id'] }})">
                                                <i class="bx bx-history me-2"></i> View Logs
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="increaseLimit({{ $client['id'] }})">
                                                <i class="bx bx-expand me-2"></i> Increase Limit
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item" onclick="resetUsage({{ $client['id'] }})">
                                                <i class="bx bx-reset me-2"></i> Reset Usage
                                            </a>
                                            <a href="#" class="dropdown-item text-warning" onclick="throttleClient({{ $client['id'] }})">
                                                <i class="bx bx-pause me-2"></i> Throttle
                                            </a>
                                            <a href="#" class="dropdown-item text-danger" onclick="suspendClient({{ $client['id'] }})">
                                                <i class="bx bx-x-circle me-2"></i> Suspend
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Bandwidth Charts -->
                <div class="row mt-4">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Daily Bandwidth Usage</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="dailyUsageChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Usage Distribution</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="distributionChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bandwidth Settings -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Bandwidth Management Settings</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="mb-3">Monitoring Settings</h6>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="realTimeMonitoring" checked>
                                            <label class="form-check-label" for="realTimeMonitoring">
                                                Enable real-time monitoring
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="logBandwidth" checked>
                                            <label class="form-check-label" for="logBandwidth">
                                                Log bandwidth usage
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="trackPeaks" checked>
                                            <label class="form-check-label" for="trackPeaks">
                                                Track peak usage times
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="generateReports" checked>
                                            <label class="form-check-label" for="generateReports">
                                                Generate monthly reports
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="mb-3">Throttling Settings</h6>
                                        <div class="mb-3">
                                            <label for="warningThreshold" class="form-label">Warning Threshold (%)</label>
                                            <input type="number" class="form-control" id="warningThreshold" value="80" min="50" max="95">
                                        </div>
                                        <div class="mb-3">
                                            <label for="criticalThreshold" class="form-label">Critical Threshold (%)</label>
                                            <input type="number" class="form-control" id="criticalThreshold" value="95" min="80" max="100">
                                        </div>
                                        <div class="mb-3">
                                            <label for="throttleSpeed" class="form-label">Throttle Speed (Mbps)</label>
                                            <input type="number" class="form-control" id="throttleSpeed" value="1" min="0.1" max="100">
                                        </div>
                                        <div class="mb-3">
                                            <label for="resetCycle" class="form-label">Reset Cycle</label>
                                            <select class="form-select" id="resetCycle">
                                                <option value="daily" selected>Daily</option>
                                                <option value="weekly">Weekly</option>
                                                <option value="monthly">Monthly</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-primary" onclick="saveBandwidthSettings()">
                                        <i class="bx bx-save me-1"></i> Save Settings
                                    </button>
                                    <button class="btn btn-outline-warning" onclick="testThrottling()">
                                        <i class="bx bx-test-tube me-1"></i> Test Throttling
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bandwidth Logs -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Recent Bandwidth Activity</h6>
                                <button class="btn btn-outline-info btn-sm" onclick="viewAllLogs()">
                                    <i class="bx bx-history me-1"></i> View All Logs
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Client</th>
                                                <th>Activity</th>
                                                <th>Bandwidth</th>
                                                <th>Time</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><strong>John Doe</strong></td>
                                                <td>File upload</td>
                                                <td>245 MB</td>
                                                <td>14:30:00</td>
                                                <td><span class="badge bg-success">Success</span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Jane Smith</strong></td>
                                                <td>Video streaming</td>
                                                <td>1.2 GB</td>
                                                <td>14:25:00</td>
                                                <td><span class="badge bg-success">Success</span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Bob Johnson</strong></td>
                                                <td>Database backup</td>
                                                <td>3.8 GB</td>
                                                <td>14:20:00</td>
                                                <td><span class="badge bg-warning">Throttled</span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>John Doe</strong></td>
                                                <td>Website traffic</td>
                                                <td>856 MB</td>
                                                <td>14:15:00</td>
                                                <td><span class="badge bg-success">Success</span></td>
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
// Daily Usage Chart
const dailyCtx = document.getElementById('dailyUsageChart').getContext('2d');
new Chart(dailyCtx, {
    type: 'line',
    data: {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        datasets: [
            {
                label: 'John Doe',
                data: [2.1, 1.8, 2.3, 1.9, 2.2, 1.5, 1.2],
                borderColor: '#007bff',
                backgroundColor: 'rgba(0, 123, 255, 0.1)',
                tension: 0.4
            },
            {
                label: 'Jane Smith',
                data: [1.8, 1.6, 1.9, 1.7, 1.8, 1.2, 1.0],
                borderColor: '#28a745',
                backgroundColor: 'rgba(40, 167, 69, 0.1)',
                tension: 0.4
            },
            {
                label: 'Bob Johnson',
                data: [45, 42, 48, 38, 44, 35, 28],
                borderColor: '#ffc107',
                backgroundColor: 'rgba(255, 193, 7, 0.1)',
                tension: 0.4
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Distribution Chart
const distCtx = document.getElementById('distributionChart').getContext('2d');
new Chart(distCtx, {
    type: 'doughnut',
    data: {
        labels: ['John Doe', 'Jane Smith', 'Bob Johnson'],
        datasets: [{
            data: [125, 85, 1800],
            backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

function resetBandwidth() {
    if (confirm('Are you sure you want to reset bandwidth usage for all clients?')) {
        showNotification('Resetting bandwidth usage...', 'info');
    }
}

function exportBandwidth() {
    showNotification('Exporting bandwidth report...', 'info');
}

function viewDetails(id) {
    // Find client data
    const clientData = findClientData(id);
    if (clientData) {
        const details = `
            Client: ${clientData.name}
            Email: ${clientData.email}
            Current Usage: ${clientData.bandwidth_used} GB
            Limit: ${clientData.bandwidth_limit} GB
            Usage %: ${clientData.usage_percent.toFixed(1)}%
            Peak Day: ${clientData.peak_day}
        `;
        showNotification(`Bandwidth Details: ${details}`, 'info');
    } else {
        showNotification('Client data not found', 'error');
    }
}

function viewChart(id) {
    const clientData = findClientData(id);
    if (clientData && clientData.daily_usage) {
        // Create a simple chart representation
        const chartData = clientData.daily_usage.map(day => `${day.date}: ${day.usage}`).join('\\n');
        showNotification(`Daily Usage Chart:\\n${chartData}`, 'info');
    } else {
        showNotification('Chart data not available', 'error');
    }
}

function viewLogs(id) {
    const clientData = findClientData(id);
    if (clientData) {
        // Generate sample log entries
        const logs = [
            `${new Date().toLocaleString()}: Client ${clientData.name} accessed bandwidth dashboard`,
            `${new Date(Date.now() - 3600000).toLocaleString()}: Bandwidth usage updated to ${clientData.bandwidth_used} GB`,
            `${new Date(Date.now() - 7200000).toLocaleString()}: Peak usage recorded on ${clientData.peak_day}`,
            `${new Date(Date.now() - 10800000).toLocaleString()}: Client status: ${clientData.status}`
        ];
        showNotification(`Bandwidth Logs:\\n${logs.join('\\n')}`, 'info');
    } else {
        showNotification('Log data not available', 'error');
    }
}

function increaseLimit(id) {
    const newLimit = prompt('Enter new bandwidth limit (in GB):');
    if (newLimit && !isNaN(newLimit)) {
        showNotification(`Bandwidth limit increased to ${newLimit} GB for client ${id}`, 'success');
        // In a real application, this would make an API call to update the database
    } else if (newLimit !== null) {
        showNotification('Please enter a valid number', 'error');
    }
}

function resetUsage(id) {
    if (confirm('Are you sure you want to reset bandwidth usage for this client? This action cannot be undone.')) {
        showNotification(`Bandwidth usage reset to 0 GB for client ${id}`, 'success');
        // In a real application, this would make an API call to reset the usage in the database
    }
}

function throttleClient(id) {
    if (confirm('Are you sure you want to throttle this client? This will reduce their bandwidth speed.')) {
        showNotification(`Client ${id} bandwidth throttled to 50% speed`, 'warning');
        // In a real application, this would make an API call to apply throttling rules
    }
}

function suspendClient(id) {
    if (confirm('Are you sure you want to suspend this client? This will disable their bandwidth access.')) {
        showNotification(`Client ${id} bandwidth access suspended`, 'danger');
        // In a real application, this would make an API call to suspend the client
    }
}

// Helper function to find client data from the current page
function findClientData(id) {
    // This would typically come from the client data passed to the view
    // For now, we'll return a mock object
    return {
        id: id,
        name: `Client ${id}`,
        email: `client${id}@example.com`,
        bandwidth_used: (Math.random() * 200).toFixed(1),
        bandwidth_limit: Math.floor(Math.random() * 400) + 100,
        usage_percent: Math.random() * 80 + 10,
        peak_day: new Date(Date.now() - Math.random() * 7 * 24 * 60 * 60 * 1000).toLocaleDateString(),
        status: 'active'
    };
}

function saveBandwidthSettings() {
    showNotification('Bandwidth settings saved successfully', 'success');
}

function testThrottling() {
    if (confirm('Are you sure you want to test throttling?')) {
        showNotification('Testing bandwidth throttling...', 'info');
    }
}

function viewAllLogs() {
    showNotification('Opening all bandwidth logs...', 'info');
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
