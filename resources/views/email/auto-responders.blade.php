@extends('layouts.app')

@section('title', 'Auto Responders')
@section('description', 'Manage email auto responders')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">Auto Responders</h5>
                    <p class="card-subtitle">Manage email auto responders</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-success" onclick="addAutoResponder()">
                        <i class="bx bx-plus me-1"></i> Add Auto Responder
                    </button>
                    <button class="btn btn-outline-primary" onclick="testAllResponders()">
                        <i class="bx bx-test-tube me-1"></i> Test All
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- Auto Responders Statistics -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-primary bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-bot text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Responders</h6>
                                <h4 class="mb-0">{{ $stats['total_responders'] }}</h4>
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
                                <h4 class="mb-0 text-success">{{ $stats['active_responders'] }}</h4>
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
                                <h4 class="mb-0 text-warning">{{ $stats['disabled_responders'] }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-info bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-envelope text-info"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Sent Today</h6>
                                <h4 class="mb-0 text-info">{{ $stats['sent_today'] }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Auto Responders List -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Email</th>
                                <th>Subject</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Sent Today</th>
                                <th>Total Sent</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($autoResponders as $responder)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-envelope text-primary me-2"></i>
                                        <strong>{{ $responder['email'] }}</strong>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-truncate" style="max-width: 200px;">
                                        <small>{{ $responder['subject'] }}</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $responder['status'] == 'active' ? 'success' : 'secondary' }}">
                                        {{ $responder['status'] }}
                                    </span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($responder['created'])->format('M d, Y') }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <strong>{{ $responder['sent_today'] }}</strong>
                                        <small class="text-muted ms-1">emails</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <strong>{{ $responder['total_sent'] }}</strong>
                                        <small class="text-muted ms-1">total</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a href="#" class="dropdown-item" onclick="viewMessage('{{ $responder['email'] }}')">
                                                <i class="bx bx-message me-2"></i> View Message
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="testResponder('{{ $responder['email'] }}')">
                                                <i class="bx bx-test-tube me-2"></i> Test Responder
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="viewStats('{{ $responder['email'] }}')">
                                                <i class="bx bx-bar-chart me-2"></i> View Stats
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="editResponder('{{ $responder['email'] }}')">
                                                <i class="bx bx-edit me-2"></i> Edit
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            @if($responder['status'] == 'active')
                                            <a href="#" class="dropdown-item text-warning" onclick="disableResponder('{{ $responder['email'] }}')">
                                                <i class="bx bx-pause me-2"></i> Disable
                                            </a>
                                            @else
                                            <a href="#" class="dropdown-item text-success" onclick="enableResponder('{{ $responder['email'] }}')">
                                                <i class="bx bx-play me-2"></i> Enable
                                            </a>
                                            @endif
                                            <a href="#" class="dropdown-item text-danger" onclick="deleteResponder('{{ $responder['email'] }}')">
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

                <!-- Responder Templates -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Auto Responder Templates</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body text-center">
                                                <h6 class="card-title">Out of Office</h6>
                                                <p class="card-text small">Standard out of office message</p>
                                                <button class="btn btn-outline-primary btn-sm" onclick="useTemplate('out-of-office')">
                                                    Use Template
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body text-center">
                                                <h6 class="card-title">Vacation</h6>
                                                <p class="card-text small">Vacation auto response</p>
                                                <button class="btn btn-outline-success btn-sm" onclick="useTemplate('vacation')">
                                                    Use Template
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body text-center">
                                                <h6 class="card-title">Support</h6>
                                                <p class="card-text small">Support ticket confirmation</p>
                                                <button class="btn btn-outline-info btn-sm" onclick="useTemplate('support')">
                                                    Use Template
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body text-center">
                                                <h6 class="card-title">Sales</h6>
                                                <p class="card-text small">Sales inquiry response</p>
                                                <button class="btn btn-outline-warning btn-sm" onclick="useTemplate('sales')">
                                                    Use Template
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Responder Settings -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Auto Responder Settings</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="mb-3">Global Settings</h6>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="enableResponders" checked>
                                            <label class="form-check-label" for="enableResponders">
                                                Enable auto responders
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="logResponders" checked>
                                            <label class="form-check-label" for="logResponders">
                                                Log responder activity
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="preventLoops" checked>
                                            <label class="form-check-label" for="preventLoops">
                                                Prevent response loops
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="rateLimit" checked>
                                            <label class="form-check-label" for="rateLimit">
                                                Enable rate limiting
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="mb-3">Rate Limiting</h6>
                                        <div class="mb-3">
                                            <label for="maxResponses" class="form-label">Max Responses per Hour</label>
                                            <input type="number" class="form-control" id="maxResponses" value="50" min="1" max="1000">
                                        </div>
                                        <div class="mb-3">
                                            <label for="responseDelay" class="form-label">Response Delay (minutes)</label>
                                            <input type="number" class="form-control" id="responseDelay" value="5" min="0" max="60">
                                        </div>
                                        <div class="mb-3">
                                            <label for="maxPerSender" class="form-label">Max per Sender per Day</label>
                                            <input type="number" class="form-control" id="maxPerSender" value="3" min="1" max="50">
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-primary" onclick="saveResponderSettings()">
                                        <i class="bx bx-save me-1"></i> Save Settings
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Response Statistics -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Response Activity</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="responseChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Top Responders</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Email</th>
                                                <th>Sent Today</th>
                                                <th>Total Sent</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><strong>info@example.com</strong></td>
                                                <td><strong>12</strong></td>
                                                <td><strong>156</strong></td>
                                            </tr>
                                            <tr>
                                                <td><strong>support@example.com</strong></td>
                                                <td><strong>8</strong></td>
                                                <td><strong>89</strong></td>
                                            </tr>
                                            <tr>
                                                <td><strong>billing@example.com</strong></td>
                                                <td><strong>3</strong></td>
                                                <td><strong>67</strong></td>
                                            </tr>
                                            <tr>
                                                <td><strong>sales@example.com</strong></td>
                                                <td><strong>0</strong></td>
                                                <td><strong>45</strong></td>
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
// Response Activity Chart
const responseCtx = document.getElementById('responseChart').getContext('2d');
new Chart(responseCtx, {
    type: 'bar',
    data: {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        datasets: [{
            label: 'Auto Responses Sent',
            data: [28, 35, 42, 38, 45, 22, 18],
            backgroundColor: '#28a745'
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

function addAutoResponder() {
    showNotification('Add auto responder dialog opened', 'info');
}

function testAllResponders() {
    if (confirm('Are you sure you want to test all auto responders?')) {
        showNotification('Testing all auto responders...', 'info');
    }
}

function viewMessage(email) {
    showNotification(`Viewing message for ${email}...`, 'info');
}

function testResponder(email) {
    showNotification(`Testing auto responder for ${email}...`, 'info');
}

function viewStats(email) {
    showNotification(`Viewing stats for ${email}...`, 'info');
}

function editResponder(email) {
    showNotification(`Editing auto responder for ${email}...`, 'info');
}

function disableResponder(email) {
    if (confirm(`Are you sure you want to disable auto responder for ${email}?`)) {
        showNotification(`Auto responder disabled for ${email}`, 'warning');
    }
}

function enableResponder(email) {
    if (confirm(`Are you sure you want to enable auto responder for ${email}?`)) {
        showNotification(`Auto responder enabled for ${email}`, 'success');
    }
}

function deleteResponder(email) {
    if (confirm(`Are you sure you want to delete auto responder for ${email}?`)) {
        showNotification(`Auto responder deleted for ${email}`, 'danger');
    }
}

function useTemplate(template) {
    showNotification(`Using ${template} template...`, 'info');
}

function saveResponderSettings() {
    showNotification('Auto responder settings saved successfully', 'success');
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
