@extends('layouts.app')

@section('title', 'Email Forwarders')
@section('description', 'Manage email forwarders and redirection')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">Email Forwarders</h5>
                    <p class="card-subtitle">Manage email forwarders and redirection</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-success" onclick="addForwarder()">
                        <i class="bx bx-plus me-1"></i> Add Forwarder
                    </button>
                    <button class="btn btn-outline-primary" onclick="testAllForwarders()">
                        <i class="bx bx-test-tube me-1"></i> Test All
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- Forwarders Statistics -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-primary bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-right-arrow text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Forwarders</h6>
                                <h4 class="mb-0">{{ $stats['total_forwarders'] }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-success bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-check-circle text-success"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Active</h6>
                                <h4 class="mb-0 text-success">{{ $stats['active_forwarders'] }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-warning bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-pause text-warning"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Disabled</h6>
                                <h4 class="mb-0 text-warning">{{ $stats['disabled_forwarders'] }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-info bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-envelope text-info"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Forwarded Today</h6>
                                <h4 class="mb-0 text-info">{{ $stats['total_forwarded_today'] }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Forwarders List -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Source Email</th>
                                <th>Destination</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Forwarded</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($forwarders as $forwarder)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-envelope text-primary me-2"></i>
                                        <strong>{{ $forwarder['source'] }}</strong>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-right-arrow text-success me-2"></i>
                                        <code>{{ $forwarder['destination'] }}</code>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $forwarder['status'] == 'active' ? 'success' : 'secondary' }}">
                                        {{ $forwarder['status'] }}
                                    </span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($forwarder['created'])->format('M d, Y') }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <strong>{{ $forwarder['emails_forwarded'] }}</strong>
                                        <small class="text-muted ms-1">emails</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a href="#" class="dropdown-item" onclick="testForwarder('{{ $forwarder['source'] }}')">
                                                <i class="bx bx-test-tube me-2"></i> Test Forwarder
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="viewLogs('{{ $forwarder['source'] }}')">
                                                <i class="bx bx-history me-2"></i> View Logs
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="editForwarder('{{ $forwarder['source'] }}')">
                                                <i class="bx bx-edit me-2"></i> Edit
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            @if($forwarder['status'] == 'active')
                                            <a href="#" class="dropdown-item text-warning" onclick="disableForwarder('{{ $forwarder['source'] }}')">
                                                <i class="bx bx-pause me-2"></i> Disable
                                            </a>
                                            @else
                                            <a href="#" class="dropdown-item text-success" onclick="enableForwarder('{{ $forwarder['source'] }}')">
                                                <i class="bx bx-play me-2"></i> Enable
                                            </a>
                                            @endif
                                            <a href="#" class="dropdown-item text-danger" onclick="deleteForwarder('{{ $forwarder['source'] }}')">
                                                <i class="bx bx-trash me-2"></i> Delete
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Forwarding Statistics -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Top Forwarders</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Source</th>
                                                <th>Destination</th>
                                                <th>Forwarded</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><strong>sales@example.com</strong></td>
                                                <td><code>sales-team@example.com</code></td>
                                                <td><strong>234</strong></td>
                                            </tr>
                                            <tr>
                                                <td><strong>info@example.com</strong></td>
                                                <td><code>admin@example.com</code></td>
                                                <td><strong>156</strong></td>
                                            </tr>
                                            <tr>
                                                <td><strong>support@example.com</strong></td>
                                                <td><code>support-team@example.com</code></td>
                                                <td><strong>89</strong></td>
                                            </tr>
                                            <tr>
                                                <td><strong>billing@example.com</strong></td>
                                                <td><code>finance@example.com</code></td>
                                                <td><strong>45</strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Forwarding Activity</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="forwardingChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Forwarding Rules -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Forwarding Rules</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="mb-3">Global Forwarding Settings</h6>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="enableForwarding" checked>
                                            <label class="form-check-label" for="enableForwarding">
                                                Enable email forwarding
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="logForwarding" checked>
                                            <label class="form-check-label" for="logForwarding">
                                                Log forwarding activity
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="notifyForwarding" checked>
                                            <label class="form-check-label" for="notifyForwarding">
                                                Notify on forwarding errors
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="limitForwarding">
                                            <label class="form-check-label" for="limitForwarding">
                                                Limit forwarding per hour
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="mb-3">Forwarding Limits</h6>
                                        <div class="mb-3">
                                            <label for="maxForwarders" class="form-label">Max Forwarders per Domain</label>
                                            <input type="number" class="form-control" id="maxForwarders" value="50" min="1" max="1000">
                                        </div>
                                        <div class="mb-3">
                                            <label for="maxForwardPerHour" class="form-label">Max Forward per Hour</label>
                                            <input type="number" class="form-control" id="maxForwardPerHour" value="100" min="1" max="10000">
                                        </div>
                                        <div class="mb-3">
                                            <label for="forwardingTimeout" class="form-label">Forwarding Timeout (seconds)</label>
                                            <input type="number" class="form-control" id="forwardingTimeout" value="30" min="5" max="300">
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-primary" onclick="saveForwardingSettings()">
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
// Forwarding Activity Chart
const forwardingCtx = document.getElementById('forwardingChart').getContext('2d');
new Chart(forwardingCtx, {
    type: 'line',
    data: {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        datasets: [{
            label: 'Emails Forwarded',
            data: [45, 52, 38, 65, 59, 42, 35],
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

function addForwarder() {
    showNotification('Add forwarder dialog opened', 'info');
}

function testAllForwarders() {
    if (confirm('Are you sure you want to test all forwarders?')) {
        showNotification('Testing all forwarders...', 'info');
    }
}

function testForwarder(email) {
    showNotification(`Testing forwarder for ${email}...`, 'info');
}

function viewLogs(email) {
    showNotification(`Viewing logs for ${email}...`, 'info');
}

function editForwarder(email) {
    showNotification(`Editing forwarder for ${email}...`, 'info');
}

function disableForwarder(email) {
    if (confirm(`Are you sure you want to disable forwarder for ${email}?`)) {
        showNotification(`Forwarder disabled for ${email}`, 'warning');
    }
}

function enableForwarder(email) {
    if (confirm(`Are you sure you want to enable forwarder for ${email}?`)) {
        showNotification(`Forwarder enabled for ${email}`, 'success');
    }
}

function deleteForwarder(email) {
    if (confirm(`Are you sure you want to delete forwarder for ${email}?`)) {
        showNotification(`Forwarder deleted for ${email}`, 'danger');
    }
}

function saveForwardingSettings() {
    showNotification('Forwarding settings saved successfully', 'success');
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
