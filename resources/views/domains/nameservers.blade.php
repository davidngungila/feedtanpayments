@extends('layouts.app')

@section('title', 'Nameservers Management')
@section('description', 'Manage nameservers for domain resolution')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">Nameservers Management</h5>
                    <p class="card-subtitle">Manage nameservers for domain resolution and DNS delegation</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-success" onclick="addNameserver()">
                        <i class="bx bx-plus me-1"></i> Add Nameserver
                    </button>
                    <button class="btn btn-outline-primary" onclick="checkPropagation()">
                        <i class="bx bx-sync me-1"></i> Check Propagation
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- Nameservers Statistics -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-primary bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-server text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Domains</h6>
                                <h4 class="mb-0">5</h4>
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
                                <h4 class="mb-0 text-success">4</h4>
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
                                <h6 class="mb-0">Total NS</h6>
                                <h4 class="mb-0 text-info">10</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Nameservers Configuration -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Domain</th>
                                <th>Nameservers</th>
                                <th>Status</th>
                                <th>Last Sync</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($domains as $domain)
                            <tr>
                                <td><strong>{{ $domain['name'] }}</strong></td>
                                <td>
                                    <div class="d-flex flex-wrap gap-1">
                                        @foreach($domain['nameservers'] as $ns)
                                        <span class="badge bg-{{ $ns['status'] == 'active' ? 'success' : 'warning' }}">
                                            {{ $ns['server'] }}
                                        </span>
                                        @endforeach
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $domain['status'] == 'active' ? 'success' : 'warning' }}">
                                        {{ $domain['status'] }}
                                    </span>
                                </td>
                                <td>
                                    <small class="text-muted">{{ \Carbon\Carbon::now()->subMinutes(30)->format('H:i') }}</small>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a href="#" class="dropdown-item" onclick="editNameservers('{{ $domain['name'] }}')">
                                                <i class="bx bx-edit me-2"></i> Edit Nameservers
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="testNameservers('{{ $domain['name'] }}')">
                                                <i class="bx bx-test-tube me-2"></i> Test Resolution
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="checkPropagation('{{ $domain['name'] }}')">
                                                <i class="bx bx-sync me-2"></i> Check Propagation
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item text-warning" onclick="syncNameservers('{{ $domain['name'] }}')">
                                                <i class="bx bx-sync me-2"></i> Sync Nameservers
                                            </a>
                                            <a href="#" class="dropdown-item text-danger" onclick="resetNameservers('{{ $domain['name'] }}')">
                                                <i class="bx bx-reset me-2"></i> Reset to Default
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Nameserver Details -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Nameserver Health Status</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Nameserver</th>
                                                <th>IP Address</th>
                                                <th>Status</th>
                                                <th>Response Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><code>ns1.example.com</code></td>
                                                <td><code>192.168.1.100</code></td>
                                                <td><span class="badge bg-success">Online</span></td>
                                                <td>12ms</td>
                                            </tr>
                                            <tr>
                                                <td><code>ns2.example.com</code></td>
                                                <td><code>192.168.1.101</code></td>
                                                <td><span class="badge bg-success">Online</span></td>
                                                <td>15ms</td>
                                            </tr>
                                            <tr>
                                                <td><code>ns1.mydomain.net</code></td>
                                                <td><code>192.168.1.102</code></td>
                                                <td><span class="badge bg-success">Online</span></td>
                                                <td>18ms</td>
                                            </tr>
                                            <tr>
                                                <td><code>ns2.mydomain.net</code></td>
                                                <td><code>192.168.1.103</code></td>
                                                <td><span class="badge bg-success">Online</span></td>
                                                <td>20ms</td>
                                            </tr>
                                            <tr>
                                                <td><code>ns1.test.org</code></td>
                                                <td><code>192.168.1.104</code></td>
                                                <td><span class="badge bg-warning">Pending</span></td>
                                                <td>-</td>
                                            </tr>
                                            <tr>
                                                <td><code>ns2.test.org</code></td>
                                                <td><code>192.168.1.105</code></td>
                                                <td><span class="badge bg-warning">Pending</span></td>
                                                <td>-</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <button class="btn btn-outline-primary btn-sm w-100 mt-2" onclick="refreshNameserverHealth()">
                                    <i class="bx bx-refresh me-1"></i> Refresh Health
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">DNS Propagation Status</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Domain</th>
                                                <th>Global</th>
                                                <th>US</th>
                                                <th>EU</th>
                                                <th>Asia</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><strong>example.com</strong></td>
                                                <td><span class="badge bg-success">100%</span></td>
                                                <td><span class="badge bg-success">100%</span></td>
                                                <td><span class="badge bg-success">100%</span></td>
                                                <td><span class="badge bg-success">100%</span></td>
                                                <td><span class="badge bg-success">Complete</span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>mydomain.net</strong></td>
                                                <td><span class="badge bg-success">95%</span></td>
                                                <td><span class="badge bg-success">100%</span></td>
                                                <td><span class="badge bg-warning">85%</span></td>
                                                <td><span class="badge bg-success">100%</span></td>
                                                <td><span class="badge bg-warning">In Progress</span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>test.org</strong></td>
                                                <td><span class="badge bg-warning">25%</span></td>
                                                <td><span class="badge bg-success">50%</span></td>
                                                <td><span class="badge bg-warning">15%</span></td>
                                                <td><span class="badge bg-warning">10%</span></td>
                                                <td><span class="badge bg-warning">Just Started</span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>site.co</strong></td>
                                                <td><span class="badge bg-success">100%</span></td>
                                                <td><span class="badge bg-success">100%</span></td>
                                                <td><span class="badge bg-success">100%</span></td>
                                                <td><span class="badge bg-success">100%</span></td>
                                                <td><span class="badge bg-success">Complete</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <button class="btn btn-outline-info btn-sm w-100 mt-2" onclick="runPropagationCheck()">
                                    <i class="bx bx-sync me-1"></i> Check All Propagation
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Nameserver Configuration Templates -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Nameserver Configuration Templates</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body text-center">
                                                <h6 class="card-title">Standard Setup</h6>
                                                <p class="card-text small">2 nameservers with standard configuration</p>
                                                <button class="btn btn-outline-primary btn-sm" onclick="applyTemplate('standard')">
                                                    Apply Template
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body text-center">
                                                <h6 class="card-title">High Availability</h6>
                                                <p class="card-text small">4 nameservers for maximum uptime</p>
                                                <button class="btn btn-outline-success btn-sm" onclick="applyTemplate('ha')">
                                                    Apply Template
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body text-center">
                                                <h6 class="card-title">Geo-Distributed</h6>
                                                <p class="card-text small">Nameservers across multiple regions</p>
                                                <button class="btn btn-outline-info btn-sm" onclick="applyTemplate('geo')">
                                                    Apply Template
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body text-center">
                                                <h6 class="card-title">Custom Setup</h6>
                                                <p class="card-text small">Configure custom nameservers</p>
                                                <button class="btn btn-outline-warning btn-sm" onclick="applyTemplate('custom')">
                                                    Configure
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- DNS Records Test -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Nameserver Resolution Test</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="testDomain" placeholder="Enter domain to test (e.g., example.com)">
                                            <button class="btn btn-outline-primary" onclick="testNameserverResolution()">
                                                <i class="bx bx-search me-1"></i> Test Resolution
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <button class="btn btn-outline-success w-100" onclick="runBatchNSTest()">
                                            <i class="bx bx-test-tube me-1"></i> Test All Domains
                                        </button>
                                    </div>
                                </div>
                                <div id="nsTestResults" class="mt-3"></div>
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
function addNameserver() {
    showNotification('Add Nameserver dialog opened', 'info');
}

function checkPropagation() {
    showNotification('Checking DNS propagation for all domains...', 'info');
}

function editNameservers(domain) {
    showNotification(`Editing nameservers for ${domain}`, 'info');
}

function testNameservers(domain) {
    showNotification(`Testing nameserver resolution for ${domain}`, 'info');
}

function syncNameservers(domain) {
    showNotification(`Syncing nameservers for ${domain}`, 'info');
}

function resetNameservers(domain) {
    if (confirm(`Are you sure you want to reset nameservers for ${domain} to default?`)) {
        showNotification(`Nameservers reset for ${domain}`, 'warning');
    }
}

function refreshNameserverHealth() {
    showNotification('Refreshing nameserver health status...', 'info');
}

function runPropagationCheck() {
    showNotification('Running DNS propagation check for all domains...', 'info');
}

function applyTemplate(template) {
    showNotification(`Applying ${template} nameserver template...`, 'info');
}

function testNameserverResolution() {
    const domain = document.getElementById('testDomain').value;
    if (!domain) {
        showNotification('Please enter a domain to test', 'warning');
        return;
    }
    showNotification(`Testing nameserver resolution for ${domain}...`, 'info');
}

function runBatchNSTest() {
    showNotification('Running batch nameserver resolution test...', 'info');
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
