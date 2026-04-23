@extends('layouts.app')

@section('title', 'A Records Management')
@section('description', 'Manage A records for domain pointing')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">A Records Management</h5>
                    <p class="card-subtitle">Manage A records for domain pointing to IP addresses</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-success" onclick="addARecord()">
                        <i class="bx bx-plus me-1"></i> Add A Record
                    </button>
                    <button class="btn btn-outline-primary" onclick="bulkImport()">
                        <i class="bx bx-upload me-1"></i> Bulk Import
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- A Records Statistics -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-primary bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-right-arrow text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total A Records</h6>
                                <h4 class="mb-0">8</h4>
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
                                <h4 class="mb-0 text-success">7</h4>
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
                                <i class="bx bx-globe text-info"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Domains</h6>
                                <h4 class="mb-0 text-info">5</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- A Records Table -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Domain</th>
                                <th>Name</th>
                                <th>IP Address</th>
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
                                <td><code>{{ $record['ip'] }}</code></td>
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
                                            <a href="#" class="dropdown-item" onclick="editRecord('{{ $record['domain'] }}', '{{ $record['name'] }}')">
                                                <i class="bx bx-edit me-2"></i> Edit
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="testRecord('{{ $record['domain'] }}', '{{ $record['name'] }}')">
                                                <i class="bx bx-test-tube me-2"></i> Test
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="pingIP('{{ $record['ip'] }}')">
                                                <i class="bx bx-pulse me-2"></i> Ping IP
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item text-warning" onclick="disableRecord('{{ $record['domain'] }}', '{{ $record['name'] }}')">
                                                <i class="bx bx-pause me-2"></i> Disable
                                            </a>
                                            <a href="#" class="dropdown-item text-danger" onclick="deleteRecord('{{ $record['domain'] }}', '{{ $record['name'] }}')">
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

                <!-- IP Address Statistics -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Top IP Addresses</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>IP Address</th>
                                                <th>Domains</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><code>192.168.1.100</code></td>
                                                <td>2</td>
                                                <td><span class="badge bg-success">Active</span></td>
                                            </tr>
                                            <tr>
                                                <td><code>192.168.1.102</code></td>
                                                <td>1</td>
                                                <td><span class="badge bg-success">Active</span></td>
                                            </tr>
                                            <tr>
                                                <td><code>192.168.1.105</code></td>
                                                <td>1</td>
                                                <td><span class="badge bg-success">Active</span></td>
                                            </tr>
                                            <tr>
                                                <td><code>192.168.1.106</code></td>
                                                <td>1</td>
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
                                <h6 class="mb-0">DNS Health Check</h6>
                            </div>
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-md-4">
                                        <h4 class="text-success mb-0">87.5%</h4>
                                        <small class="text-muted">Healthy</small>
                                    </div>
                                    <div class="col-md-4">
                                        <h4 class="text-warning mb-0">12.5%</h4>
                                        <small class="text-muted">Warning</small>
                                    </div>
                                    <div class="col-md-4">
                                        <h4 class="text-danger mb-0">0%</h4>
                                        <small class="text-muted">Failed</small>
                                    </div>
                                </div>
                                <div class="progress mt-3" style="height: 8px;">
                                    <div class="progress-bar bg-success" style="width: 87.5%"></div>
                                    <div class="progress-bar bg-warning" style="width: 12.5%"></div>
                                </div>
                                <button class="btn btn-outline-primary btn-sm w-100 mt-3" onclick="runHealthCheck()">
                                    <i class="bx bx-refresh me-1"></i> Run Health Check
                                </button>
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
function addARecord() {
    showNotification('Add A Record dialog opened', 'info');
}

function bulkImport() {
    showNotification('Bulk import dialog opened', 'info');
}

function editRecord(domain, name) {
    showNotification(`Editing A record for ${domain} - ${name}`, 'info');
}

function testRecord(domain, name) {
    showNotification(`Testing A record for ${domain} - ${name}`, 'info');
}

function pingIP(ip) {
    showNotification(`Pinging IP address: ${ip}`, 'info');
}

function disableRecord(domain, name) {
    if (confirm(`Are you sure you want to disable A record for ${domain} - ${name}?`)) {
        showNotification(`A record disabled for ${domain} - ${name}`, 'warning');
    }
}

function deleteRecord(domain, name) {
    if (confirm(`Are you sure you want to delete A record for ${domain} - ${name}?`)) {
        showNotification(`A record deleted for ${domain} - ${name}`, 'danger');
    }
}

function runHealthCheck() {
    showNotification('DNS health check initiated', 'info');
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
