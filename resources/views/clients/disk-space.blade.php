@extends('layouts.app')

@section('title', 'Disk Space Management')
@section('description', 'Monitor and manage client disk space usage')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">Disk Space Management</h5>
                    <p class="card-subtitle">Monitor and manage client disk space usage</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-success" onclick="cleanupDisk()">
                        <i class="bx bx-broom me-1"></i> Cleanup
                    </button>
                    <button class="btn btn-outline-primary" onclick="exportUsage()">
                        <i class="bx bx-download me-1"></i> Export
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- Disk Space Statistics -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-primary bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-hard-disk text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Used</h6>
                                <h4 class="mb-0">{{ collect($clients)->sum('disk_used') }} GB</h4>
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

                <!-- Disk Space Usage Table -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Client</th>
                                <th>Disk Usage</th>
                                <th>Usage %</th>
                                <th>Status</th>
                                <th>Last Backup</th>
                                <th>Large Files</th>
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
                                        <strong>{{ $client['disk_used'] }} GB / {{ $client['disk_limit'] }} GB</strong>
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
                                    <small>{{ \Carbon\Carbon::parse($client['last_backup'])->format('M d, H:i') }}</small>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-file"></i> {{ count($client['large_files']) }}
                                        </button>
                                        <div class="dropdown-menu">
                                            @foreach($client['large_files'] as $file)
                                            <div class="dropdown-item">
                                                <small>{{ $file['name'] }}</small>
                                                <span class="badge bg-secondary float-end">{{ $file['size'] }}</span>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a href="#" class="dropdown-item" onclick="analyzeDisk({{ $client['id'] }})">
                                                <i class="bx bx-search me-2"></i> Analyze Disk
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="viewFiles({{ $client['id'] }})">
                                                <i class="bx bx-folder me-2"></i> View Files
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="cleanupFiles({{ $client['id'] }})">
                                                <i class="bx bx-broom me-2"></i> Cleanup Files
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="increaseQuota({{ $client['id'] }})">
                                                <i class="bx bx-expand me-2"></i> Increase Quota
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item" onclick="forceBackup({{ $client['id'] }})">
                                                <i class="bx bx-cloud-download me-2"></i> Force Backup
                                            </a>
                                            <a href="#" class="dropdown-item text-warning" onclick="sendWarning({{ $client['id'] }})">
                                                <i class="bx bx-bell me-2"></i> Send Warning
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Disk Space Charts -->
                <div class="row mt-4">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Disk Space Usage Trend</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="usageTrendChart" height="200"></canvas>
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

                <!-- File Management -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">File Management</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="mb-3">Automatic Cleanup</h6>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="autoCleanup" checked>
                                            <label class="form-check-label" for="autoCleanup">
                                                Enable automatic cleanup
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="cleanupLogs" checked>
                                            <label class="form-check-label" for="cleanupLogs">
                                                Clean old log files (30 days)
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="cleanupTemp" checked>
                                            <label class="form-check-label" for="cleanupTemp">
                                                Clean temporary files
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="cleanupCache" checked>
                                            <label class="form-check-label" for="cleanupCache">
                                                Clean cache files
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="mb-3">Quota Management</h6>
                                        <div class="mb-3">
                                            <label for="defaultQuota" class="form-label">Default Disk Quota (GB)</label>
                                            <input type="number" class="form-control" id="defaultQuota" value="10" min="1" max="1000">
                                        </div>
                                        <div class="mb-3">
                                            <label for="quotaWarning" class="form-label">Warning Threshold (%)</label>
                                            <input type="number" class="form-control" id="quotaWarning" value="80" min="50" max="95">
                                        </div>
                                        <div class="mb-3">
                                            <label for="quotaCritical" class="form-label">Critical Threshold (%)</label>
                                            <input type="number" class="form-control" id="quotaCritical" value="95" min="80" max="100">
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-primary" onclick="saveDiskSettings()">
                                        <i class="bx bx-save me-1"></i> Save Settings
                                    </button>
                                    <button class="btn btn-outline-warning" onclick="runCleanup()">
                                        <i class="bx bx-broom me-1"></i> Run Cleanup Now
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Storage Locations -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Storage Locations</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Location</th>
                                                <th>Total Space</th>
                                                <th>Used Space</th>
                                                <th>Available</th>
                                                <th>Usage %</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><strong>/var/www</strong></td>
                                                <td>500 GB</td>
                                                <td>203.7 GB</td>
                                                <td>296.3 GB</td>
                                                <td>
                                                    <div class="progress" style="height: 6px; width: 100px;">
                                                        <div class="progress-bar bg-warning" style="width: 40.7%"></div>
                                                    </div>
                                                </td>
                                                <td><span class="badge bg-warning">40.7%</span></td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-info" onclick="viewStorage('/var/www')">
                                                        <i class="bx bx-folder"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>/home</strong></td>
                                                <td>1 TB</td>
                                                <td>156.2 GB</td>
                                                <td>847.8 GB</td>
                                                <td>
                                                    <div class="progress" style="height: 6px; width: 100px;">
                                                        <div class="progress-bar bg-success" style="width: 15.6%"></div>
                                                    </div>
                                                </td>
                                                <td><span class="badge bg-success">15.6%</span></td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-info" onclick="viewStorage('/home')">
                                                        <i class="bx bx-folder"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>/var/lib/mysql</strong></td>
                                                <td>200 GB</td>
                                                <td>45.8 GB</td>
                                                <td>154.2 GB</td>
                                                <td>
                                                    <div class="progress" style="height: 6px; width: 100px;">
                                                        <div class="progress-bar bg-success" style="width: 22.9%"></div>
                                                    </div>
                                                </td>
                                                <td><span class="badge bg-success">22.9%</span></td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-info" onclick="viewStorage('/var/lib/mysql')">
                                                        <i class="bx bx-folder"></i>
                                                    </button>
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
// Usage Trend Chart
const trendCtx = document.getElementById('usageTrendChart').getContext('2d');
new Chart(trendCtx, {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [{
            label: 'Total Disk Usage (GB)',
            data: [120, 135, 142, 156, 168, 175, 182, 188, 195, 201, 208, 203],
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
            data: [15.2, 8.5, 180],
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

function cleanupDisk() {
    if (confirm('Are you sure you want to run disk cleanup for all clients?')) {
        showNotification('Running disk cleanup...', 'info');
    }
}

function exportUsage() {
    showNotification('Exporting disk usage report...', 'info');
}

function analyzeDisk(id) {
    showNotification(`Analyzing disk usage for client ${id}...`, 'info');
}

function viewFiles(id) {
    showNotification(`Opening file browser for client ${id}...`, 'info');
}

function cleanupFiles(id) {
    if (confirm('Are you sure you want to cleanup files for this client?')) {
        showNotification(`Cleaning up files for client ${id}...`, 'info');
    }
}

function increaseQuota(id) {
    showNotification(`Increasing disk quota for client ${id}...`, 'info');
}

function forceBackup(id) {
    if (confirm('Are you sure you want to force a backup for this client?')) {
        showNotification(`Forcing backup for client ${id}...`, 'info');
    }
}

function sendWarning(id) {
    if (confirm('Are you sure you want to send a disk usage warning to this client?')) {
        showNotification(`Warning sent to client ${id}`, 'success');
    }
}

function saveDiskSettings() {
    showNotification('Disk management settings saved successfully', 'success');
}

function runCleanup() {
    if (confirm('Are you sure you want to run cleanup now?')) {
        showNotification('Running cleanup process...', 'info');
    }
}

function viewStorage(location) {
    showNotification(`Opening storage location: ${location}...`, 'info');
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
