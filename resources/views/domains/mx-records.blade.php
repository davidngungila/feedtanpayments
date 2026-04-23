@extends('layouts.app')

@section('title', 'MX Records Management')
@section('description', 'Manage MX records for email routing')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">MX Records Management</h5>
                    <p class="card-subtitle">Manage MX records for email routing and mail servers</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-success" onclick="addMXRecord()">
                        <i class="bx bx-plus me-1"></i> Add MX Record
                    </button>
                    <button class="btn btn-outline-primary" onclick="testEmailRouting()">
                        <i class="bx bx-envelope me-1"></i> Test Email Routing
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- MX Records Statistics -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-primary bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-envelope text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total MX Records</h6>
                                <h4 class="mb-0">6</h4>
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
                                <h4 class="mb-0 text-success">5</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-warning bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-alert text-warning"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Pending</h6>
                                <h4 class="mb-0 text-warning">1</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-info bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-server text-info"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Mail Servers</h6>
                                <h4 class="mb-0 text-info">6</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- MX Records Table -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Domain</th>
                                <th>Name</th>
                                <th>Mail Server</th>
                                <th>Priority</th>
                                <th>TTL</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($records as $record)
                            <tr>
                                <td><strong>{{ $record['domain'] }}</strong></td>
                                <td><code>{{ $record['name'] }}</code></td>
                                <td><code>{{ $record['mail_server'] }}</code></td>
                                <td>
                                    <span class="badge bg-{{ $record['priority'] <= 10 ? 'success' : ($record['priority'] <= 20 ? 'warning' : 'info') }}">
                                        {{ $record['priority'] }}
                                    </span>
                                </td>
                                <td>{{ $record['ttl'] }}s</td>
                                <td>
                                    <span class="badge bg-{{ $record['status'] == 'active' ? 'success' : 'warning' }}">
                                        {{ $record['status'] }}
                                    </span>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a href="#" class="dropdown-item" onclick="editMXRecord('{{ $record['domain'] }}', '{{ $record['mail_server'] }}')">
                                                <i class="bx bx-edit me-2"></i> Edit
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="testMXRecord('{{ $record['domain'] }}', '{{ $record['mail_server'] }}')">
                                                <i class="bx bx-test-tube me-2"></i> Test
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="checkMailServer('{{ $record['mail_server'] }}')">
                                                <i class="bx bx-server me-2"></i> Check Server
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item text-warning" onclick="disableMXRecord('{{ $record['domain'] }}', '{{ $record['mail_server'] }}')">
                                                <i class="bx bx-pause me-2"></i> Disable
                                            </a>
                                            <a href="#" class="dropdown-item text-danger" onclick="deleteMXRecord('{{ $record['domain'] }}', '{{ $record['mail_server'] }}')">
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

                <!-- Mail Server Configuration -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Mail Server Priority Groups</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Domain</th>
                                                <th>Primary (10)</th>
                                                <th>Secondary (20)</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><strong>example.com</strong></td>
                                                <td><code>mail.example.com</code></td>
                                                <td><code>backup.example.com</code></td>
                                                <td><span class="badge bg-success">Active</span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>mydomain.net</strong></td>
                                                <td><code>mail.mydomain.net</code></td>
                                                <td>-</td>
                                                <td><span class="badge bg-success">Active</span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>test.org</strong></td>
                                                <td><code>test.org</code></td>
                                                <td>-</td>
                                                <td><span class="badge bg-warning">Pending</span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>site.co</strong></td>
                                                <td><code>mail.site.co</code></td>
                                                <td>-</td>
                                                <td><span class="badge bg-success">Active</span></td>
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
                                <h6 class="mb-0">Mail Server Health</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Mail Server</th>
                                                <th>Status</th>
                                                <th>Response Time</th>
                                                <th>Last Check</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><code>mail.example.com</code></td>
                                                <td><span class="badge bg-success">Online</span></td>
                                                <td>45ms</td>
                                                <td>2 min ago</td>
                                            </tr>
                                            <tr>
                                                <td><code>backup.example.com</code></td>
                                                <td><span class="badge bg-success">Online</span></td>
                                                <td>52ms</td>
                                                <td>2 min ago</td>
                                            </tr>
                                            <tr>
                                                <td><code>mail.mydomain.net</code></td>
                                                <td><span class="badge bg-success">Online</span></td>
                                                <td>38ms</td>
                                                <td>3 min ago</td>
                                            </tr>
                                            <tr>
                                                <td><code>google.com</code></td>
                                                <td><span class="badge bg-success">Online</span></td>
                                                <td>125ms</td>
                                                <td>5 min ago</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <button class="btn btn-outline-primary btn-sm w-100 mt-2" onclick="refreshServerHealth()">
                                    <i class="bx bx-refresh me-1"></i> Refresh Health
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Email Routing Test -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Email Routing Test</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <input type="email" class="form-control" id="testEmail" placeholder="Enter email address to test (e.g., test@example.com)">
                                            <button class="btn btn-outline-primary" onclick="testEmailDelivery()">
                                                <i class="bx bx-envelope me-1"></i> Test Delivery
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <button class="btn btn-outline-success w-100" onclick="runBatchEmailTest()">
                                            <i class="bx bx-test-tube me-1"></i> Test All Domains
                                        </button>
                                    </div>
                                </div>
                                <div id="emailTestResults" class="mt-3"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SPF and DKIM Status -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Email Security Configuration</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Domain</th>
                                                <th>SPF Record</th>
                                                <th>DKIM Record</th>
                                                <th>DMARC Record</th>
                                                <th>Security Score</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><strong>example.com</strong></td>
                                                <td><span class="badge bg-success">Configured</span></td>
                                                <td><span class="badge bg-success">Configured</span></td>
                                                <td><span class="badge bg-success">Configured</span></td>
                                                <td><span class="badge bg-success">Excellent</span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>mydomain.net</strong></td>
                                                <td><span class="badge bg-success">Configured</span></td>
                                                <td><span class="badge bg-warning">Missing</span></td>
                                                <td><span class="badge bg-warning">Missing</span></td>
                                                <td><span class="badge bg-warning">Good</span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>test.org</strong></td>
                                                <td><span class="badge bg-warning">Missing</span></td>
                                                <td><span class="badge bg-danger">Missing</span></td>
                                                <td><span class="badge bg-danger">Missing</span></td>
                                                <td><span class="badge bg-danger">Poor</span></td>
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
<script>
function addMXRecord() {
    showNotification('Add MX Record dialog opened', 'info');
}

function testEmailRouting() {
    showNotification('Testing email routing for all domains...', 'info');
}

function editMXRecord(domain, mailServer) {
    showNotification(`Editing MX record for ${domain} - ${mailServer}`, 'info');
}

function testMXRecord(domain, mailServer) {
    showNotification(`Testing MX record for ${domain} - ${mailServer}`, 'info');
}

function checkMailServer(mailServer) {
    showNotification(`Checking mail server: ${mailServer}`, 'info');
}

function disableMXRecord(domain, mailServer) {
    if (confirm(`Are you sure you want to disable MX record for ${domain} - ${mailServer}?`)) {
        showNotification(`MX record disabled for ${domain} - ${mailServer}`, 'warning');
    }
}

function deleteMXRecord(domain, mailServer) {
    if (confirm(`Are you sure you want to delete MX record for ${domain} - ${mailServer}?`)) {
        showNotification(`MX record deleted for ${domain} - ${mailServer}`, 'danger');
    }
}

function refreshServerHealth() {
    showNotification('Refreshing mail server health status...', 'info');
}

function testEmailDelivery() {
    const email = document.getElementById('testEmail').value;
    if (!email) {
        showNotification('Please enter an email address to test', 'warning');
        return;
    }
    showNotification(`Testing email delivery to ${email}...`, 'info');
}

function runBatchEmailTest() {
    showNotification('Running batch email delivery test...', 'info');
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
