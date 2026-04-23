@extends('layouts.app')

@section('title', 'CNAME Records Management')
@section('description', 'Manage CNAME records for domain aliases')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">CNAME Records Management</h5>
                    <p class="card-subtitle">Manage CNAME records for domain aliases and subdomains</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-success" onclick="addCNAMERecord()">
                        <i class="bx bx-plus me-1"></i> Add CNAME
                    </button>
                    <button class="btn btn-outline-primary" onclick="validateCNAMERecords()">
                        <i class="bx bx-test-tube me-1"></i> Validate All
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- CNAME Records Statistics -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-primary bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-link text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total CNAMEs</h6>
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
                                <i class="bx bx-globe text-info"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Domains</h6>
                                <h4 class="mb-0 text-info">5</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CNAME Records Table -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Domain</th>
                                <th>Alias Name</th>
                                <th>Target Domain</th>
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
                                <td><code>{{ $record['target'] }}</code></td>
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
                                            <a href="#" class="dropdown-item" onclick="editCNAMERecord('{{ $record['domain'] }}', '{{ $record['name'] }}')">
                                                <i class="bx bx-edit me-2"></i> Edit
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="testCNAMERecord('{{ $record['domain'] }}', '{{ $record['name'] }}')">
                                                <i class="bx bx-test-tube me-2"></i> Test
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="traceCNAMERecord('{{ $record['domain'] }}', '{{ $record['name'] }}')">
                                                <i class="bx bx-route me-2"></i> Trace
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item text-warning" onclick="disableCNAMERecord('{{ $record['domain'] }}', '{{ $record['name'] }}')">
                                                <i class="bx bx-pause me-2"></i> Disable
                                            </a>
                                            <a href="#" class="dropdown-item text-danger" onclick="deleteCNAMERecord('{{ $record['domain'] }}', '{{ $record['name'] }}')">
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

                <!-- CNAME Chain Analysis -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">CNAME Chain Analysis</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Alias</th>
                                                <th>Chain Length</th>
                                                <th>Final Target</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><code>blog.example.com</code></td>
                                                <td>2</td>
                                                <td><code>wordpress.example.com</code></td>
                                                <td><span class="badge bg-success">OK</span></td>
                                            </tr>
                                            <tr>
                                                <td><code>shop.example.com</code></td>
                                                <td>2</td>
                                                <td><code>store.example.com</code></td>
                                                <td><span class="badge bg-success">OK</span></td>
                                            </tr>
                                            <tr>
                                                <td><code>mail.mydomain.net</code></td>
                                                <td>1</td>
                                                <td><code>google.com</code></td>
                                                <td><span class="badge bg-success">OK</span></td>
                                            </tr>
                                            <tr>
                                                <td><code>www.test.org</code></td>
                                                <td>1</td>
                                                <td><code>test.org</code></td>
                                                <td><span class="badge bg-warning">Pending</span></td>
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
                                <h6 class="mb-0">Common Targets</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Target Domain</th>
                                                <th>Aliases</th>
                                                <th>Type</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><code>wordpress.example.com</code></td>
                                                <td>1</td>
                                                <td><span class="badge bg-info">CMS</span></td>
                                            </tr>
                                            <tr>
                                                <td><code>store.example.com</code></td>
                                                <td>1</td>
                                                <td><span class="badge bg-warning">E-commerce</span></td>
                                            </tr>
                                            <tr>
                                                <td><code>google.com</code></td>
                                                <td>1</td>
                                                <td><span class="badge bg-primary">External</span></td>
                                            </tr>
                                            <tr>
                                                <td><code>backend.app.io</code></td>
                                                <td>1</td>
                                                <td><span class="badge bg-success">Internal</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- DNS Resolution Test -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">DNS Resolution Test</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="testDomain" placeholder="Enter domain to test (e.g., blog.example.com)">
                                            <button class="btn btn-outline-primary" onclick="testDNSResolution()">
                                                <i class="bx bx-search me-1"></i> Test Resolution
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <button class="btn btn-outline-success w-100" onclick="runBatchTest()">
                                            <i class="bx bx-test-tube me-1"></i> Batch Test All
                                        </button>
                                    </div>
                                </div>
                                <div id="testResults" class="mt-3"></div>
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
function addCNAMERecord() {
    showNotification('Add CNAME Record dialog opened', 'info');
}

function validateCNAMERecords() {
    showNotification('Validating all CNAME records...', 'info');
}

function editCNAMERecord(domain, name) {
    showNotification(`Editing CNAME record for ${domain} - ${name}`, 'info');
}

function testCNAMERecord(domain, name) {
    showNotification(`Testing CNAME record for ${domain} - ${name}`, 'info');
}

function traceCNAMERecord(domain, name) {
    showNotification(`Tracing CNAME chain for ${domain} - ${name}`, 'info');
}

function disableCNAMERecord(domain, name) {
    if (confirm(`Are you sure you want to disable CNAME record for ${domain} - ${name}?`)) {
        showNotification(`CNAME record disabled for ${domain} - ${name}`, 'warning');
    }
}

function deleteCNAMERecord(domain, name) {
    if (confirm(`Are you sure you want to delete CNAME record for ${domain} - ${name}?`)) {
        showNotification(`CNAME record deleted for ${domain} - ${name}`, 'danger');
    }
}

function testDNSResolution() {
    const domain = document.getElementById('testDomain').value;
    if (!domain) {
        showNotification('Please enter a domain to test', 'warning');
        return;
    }
    showNotification(`Testing DNS resolution for ${domain}...`, 'info');
}

function runBatchTest() {
    showNotification('Running batch DNS resolution test...', 'info');
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
