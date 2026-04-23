@extends('layouts.app')

@section('title', 'Resource Limits')
@section('description', 'Monitor and manage client resource limits')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">Resource Limits</h5>
                    <p class="card-subtitle">Monitor and manage client resource limits</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-success" onclick="addLimits()">
                        <i class="bx bx-plus me-1"></i> Add Limits
                    </button>
                    <button class="btn btn-outline-primary" onclick="exportLimits()">
                        <i class="bx bx-download me-1"></i> Export
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- Resource Statistics -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-primary bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-user text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Clients</h6>
                                <h4 class="mb-0">{{ count($clients) }}</h4>
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
                                <h4 class="mb-0 text-success">{{ collect($clients)->where('status', 'active')->count() }}</h4>
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

                <!-- Resource Limits Table -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Client</th>
                                <th>Package</th>
                                <th>Disk Space</th>
                                <th>Bandwidth</th>
                                <th>Domains</th>
                                <th>Email</th>
                                <th>Status</th>
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
                                <td><span class="badge bg-info">{{ $client['package'] }}</span></td>
                                <td>
                                    <div class="mb-1">
                                        <small>{{ $client['disk_used'] }} / {{ $client['disk_limit'] }}</small>
                                    </div>
                                    <div class="progress" style="height: 6px;">
                                        @php
                                            $diskPercent = (floatval(str_replace(' GB', '', $client['disk_used'])) / floatval(str_replace(' GB', '', $client['disk_limit']))) * 100;
                                        @endphp
                                        <div class="progress-bar bg-{{ $diskPercent > 80 ? 'danger' : ($diskPercent > 60 ? 'warning' : 'success') }}" 
                                             style="width: {{ min($diskPercent, 100) }}%"></div>
                                    </div>
                                </td>
                                <td>
                                    <div class="mb-1">
                                        <small>{{ $client['bandwidth_used'] }} / {{ $client['bandwidth_limit'] }}</small>
                                    </div>
                                    <div class="progress" style="height: 6px;">
                                        @php
                                            $bandwidthPercent = (floatval(str_replace([' GB', ' TB'], ['', '1024'], $client['bandwidth_used'])) / floatval(str_replace([' GB', 'TB'], ['', '1024'], $client['bandwidth_limit']))) * 100;
                                        @endphp
                                        <div class="progress-bar bg-{{ $bandwidthPercent > 80 ? 'danger' : ($bandwidthPercent > 60 ? 'warning' : 'success') }}" 
                                             style="width: {{ min($bandwidthPercent, 100) }}%"></div>
                                    </div>
                                </td>
                                <td>
                                    <div class="mb-1">
                                        <small>{{ $client['domains_used'] }} / {{ $client['domains_limit'] }}</small>
                                    </div>
                                    <div class="progress" style="height: 6px;">
                                        @php
                                            $domainsPercent = ($client['domains_used'] / $client['domains_limit']) * 100;
                                        @endphp
                                        <div class="progress-bar bg-{{ $domainsPercent > 80 ? 'danger' : ($domainsPercent > 60 ? 'warning' : 'success') }}" 
                                             style="width: {{ min($domainsPercent, 100) }}%"></div>
                                    </div>
                                </td>
                                <td>
                                    <div class="mb-1">
                                        <small>{{ $client['email_used'] }} / {{ $client['email_limit'] }}</small>
                                    </div>
                                    <div class="progress" style="height: 6px;">
                                        @php
                                            $emailPercent = ($client['email_used'] / $client['email_limit']) * 100;
                                        @endphp
                                        <div class="progress-bar bg-{{ $emailPercent > 80 ? 'danger' : ($emailPercent > 60 ? 'warning' : 'success') }}" 
                                             style="width: {{ min($emailPercent, 100) }}%"></div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $client['status'] == 'active' ? 'success' : ($client['status'] == 'warning' ? 'warning' : 'danger') }}">
                                        {{ $client['status'] }}
                                    </span>
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
                                            <a href="#" class="dropdown-item" onclick="adjustLimits({{ $client['id'] }})">
                                                <i class="bx bx-adjust me-2"></i> Adjust Limits
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="upgradePackage({{ $client['id'] }})">
                                                <i class="bx bx-upgrade me-2"></i> Upgrade Package
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="sendWarning({{ $client['id'] }})">
                                                <i class="bx bx-bell me-2"></i> Send Warning
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item text-warning" onclick="suspendClient({{ $client['id'] }})">
                                                <i class="bx bx-pause me-2"></i> Suspend
                                            </a>
                                            <a href="#" class="dropdown-item text-danger" onclick="terminateClient({{ $client['id'] }})">
                                                <i class="bx bx-x-circle me-2"></i> Terminate
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Resource Usage Charts -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Disk Space Usage Distribution</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="diskChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Bandwidth Usage Distribution</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="bandwidthChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Resource Limit Settings -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Resource Limit Settings</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="mb-3">Warning Thresholds</h6>
                                        <div class="mb-3">
                                            <label for="diskWarning" class="form-label">Disk Space Warning (%)</label>
                                            <input type="number" class="form-control" id="diskWarning" value="80" min="50" max="95">
                                        </div>
                                        <div class="mb-3">
                                            <label for="bandwidthWarning" class="form-label">Bandwidth Warning (%)</label>
                                            <input type="number" class="form-control" id="bandwidthWarning" value="80" min="50" max="95">
                                        </div>
                                        <div class="mb-3">
                                            <label for="domainsWarning" class="form-label">Domains Warning (%)</label>
                                            <input type="number" class="form-control" id="domainsWarning" value="80" min="50" max="95">
                                        </div>
                                        <div class="mb-3">
                                            <label for="emailWarning" class="form-label">Email Warning (%)</label>
                                            <input type="number" class="form-control" id="emailWarning" value="80" min="50" max="95">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="mb-3">Notification Settings</h6>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="emailNotifications" checked>
                                            <label class="form-check-label" for="emailNotifications">
                                                Send email notifications to clients
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="adminNotifications" checked>
                                            <label class="form-check-label" for="adminNotifications">
                                                Send notifications to administrators
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="autoSuspend" checked>
                                            <label class="form-check-label" for="autoSuspend">
                                                Auto-suspend on limit exceeded
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="dailyReports" checked>
                                            <label class="form-check-label" for="dailyReports">
                                                Send daily usage reports
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-primary" onclick="saveResourceSettings()">
                                        <i class="bx bx-save me-1"></i> Save Settings
                                    </button>
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
// Disk Space Usage Chart
const diskCtx = document.getElementById('diskChart').getContext('2d');
new Chart(diskCtx, {
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

// Bandwidth Usage Chart
const bandwidthCtx = document.getElementById('bandwidthChart').getContext('2d');
new Chart(bandwidthCtx, {
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

function addLimits() {
    showNotification('Add resource limits dialog opened', 'info');
}

function exportLimits() {
    showNotification('Exporting resource limits...', 'info');
}

function viewDetails(id) {
    showNotification(`Viewing resource details for client ${id}...`, 'info');
}

function adjustLimits(id) {
    showNotification(`Adjusting limits for client ${id}...`, 'info');
}

function upgradePackage(id) {
    showNotification(`Upgrading package for client ${id}...`, 'info');
}

function sendWarning(id) {
    if (confirm('Are you sure you want to send a warning to this client?')) {
        showNotification(`Warning sent to client ${id}`, 'success');
    }
}

function suspendClient(id) {
    if (confirm('Are you sure you want to suspend this client?')) {
        showNotification(`Client ${id} suspended`, 'warning');
    }
}

function terminateClient(id) {
    if (confirm('Are you sure you want to terminate this client?')) {
        if (confirm('This action cannot be undone. Are you absolutely sure?')) {
            showNotification(`Client ${id} terminated`, 'danger');
        }
    }
}

function saveResourceSettings() {
    showNotification('Resource limit settings saved successfully', 'success');
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
