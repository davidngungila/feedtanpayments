@extends('layouts.app')

@section('title', 'Domains Limit Management')
@section('description', 'Monitor and manage client domain limits')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">Domains Limit Management</h5>
                    <p class="card-subtitle">Monitor and manage client domain limits</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-success" onclick="addDomain()">
                        <i class="bx bx-plus me-1"></i> Add Domain
                    </button>
                    <button class="btn btn-outline-primary" onclick="exportDomains()">
                        <i class="bx bx-download me-1"></i> Export
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- Domain Statistics -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-primary bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-globe text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Domains</h6>
                                <h4 class="mb-0">{{ collect($clients)->sum('domains_used') }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-success bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-check-circle text-success"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Active Domains</h6>
                                <h4 class="mb-0 text-success">{{ collect($clients)->sum(function($c) { return collect($c['domains'])->where('status', 'active')->count(); }) }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-warning bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-pause text-warning"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Suspended</h6>
                                <h4 class="mb-0 text-warning">{{ collect($clients)->sum(function($c) { return collect($c['domains'])->where('status', 'suspended')->count(); }) }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-info bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-user text-info"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Clients</h6>
                                <h4 class="mb-0 text-info">{{ count($clients) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Domain Limits Table -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Client</th>
                                <th>Domain Usage</th>
                                <th>Usage %</th>
                                <th>Status</th>
                                <th>Domains</th>
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
                                        <strong>{{ $client['domains_used'] }} / {{ $client['domains_limit'] }}</strong>
                                    </div>
                                    <div class="progress" style="height: 8px;">
                                        @php
                                            $domainsPercent = ($client['domains_used'] / $client['domains_limit']) * 100;
                                        @endphp
                                        <div class="progress-bar bg-{{ $domainsPercent > 80 ? 'danger' : ($domainsPercent > 60 ? 'warning' : 'success') }}" 
                                             style="width: {{ min($domainsPercent, 100) }}%"></div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $domainsPercent > 80 ? 'danger' : ($domainsPercent > 60 ? 'warning' : 'success') }}">
                                        {{ number_format($domainsPercent, 1) }}%
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $client['status'] == 'normal' ? 'success' : 'warning' }}">
                                        {{ $client['status'] }}
                                    </span>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-globe"></i> {{ count($client['domains']) }}
                                        </button>
                                        <div class="dropdown-menu">
                                            @foreach($client['domains'] as $domain)
                                            <div class="dropdown-item">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <small>{{ $domain['name'] }}</small>
                                                        <br>
                                                        <span class="badge bg-{{ $domain['status'] == 'active' ? 'success' : 'warning' }}">
                                                            {{ $domain['status'] }}
                                                        </span>
                                                    </div>
                                                    <small class="text-muted">{{ \Carbon\Carbon::parse($domain['created'])->format('M d, Y') }}</small>
                                                </div>
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
                                            <a href="#" class="dropdown-item" onclick="viewDomains({{ $client['id'] }})">
                                                <i class="bx bx-globe me-2"></i> View Domains
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="addClientDomain({{ $client['id'] }})">
                                                <i class="bx bx-plus me-2"></i> Add Domain
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="increaseLimit({{ $client['id'] }})">
                                                <i class="bx bx-expand me-2"></i> Increase Limit
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="manageDns({{ $client['id'] }})">
                                                <i class="bx bx-dns me-2"></i> Manage DNS
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item text-warning" onclick="suspendDomains({{ $client['id'] }})">
                                                <i class="bx bx-pause me-2"></i> Suspend All
                                            </a>
                                            <a href="#" class="dropdown-item text-danger" onclick="deleteDomains({{ $client['id'] }})">
                                                <i class="bx bx-trash me-2"></i> Delete All
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Domain Charts -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Domain Distribution</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="domainChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Domain Status</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="statusChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Domain Management Settings -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Domain Management Settings</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="mb-3">Domain Registration</h6>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="allowRegistration" checked>
                                            <label class="form-check-label" for="allowRegistration">
                                                Allow domain registration
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="autoDNS" checked>
                                            <label class="form-check-label" for="autoDNS">
                                                Auto-configure DNS records
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="autoSSL" checked>
                                            <label class="form-check-label" for="autoSSL">
                                                Auto-generate SSL certificates
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="domainVerification" checked>
                                            <label class="form-check-label" for="domainVerification">
                                                Require domain verification
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="mb-3">Domain Limits</h6>
                                        <div class="mb-3">
                                            <label for="defaultLimit" class="form-label">Default Domain Limit</label>
                                            <input type="number" class="form-control" id="defaultLimit" value="1" min="1" max="100">
                                        </div>
                                        <div class="mb-3">
                                            <label for="maxLimit" class="form-label">Maximum Domain Limit</label>
                                            <input type="number" class="form-control" id="maxLimit" value="50" min="1" max="1000">
                                        </div>
                                        <div class="mb-3">
                                            <label for="warningThreshold" class="form-label">Warning Threshold (%)</label>
                                            <input type="number" class="form-control" id="warningThreshold" value="80" min="50" max="95">
                                        </div>
                                        <div class="mb-3">
                                            <label for="gracePeriod" class="form-label">Grace Period (days)</label>
                                            <input type="number" class="form-control" id="gracePeriod" value="7" min="1" max="30">
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-primary" onclick="saveDomainSettings()">
                                        <i class="bx bx-save me-1"></i> Save Settings
                                    </button>
                                    <button class="btn btn-outline-warning" onclick="checkDomains()">
                                        <i class="bx bx-search me-1"></i> Check All Domains
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Domain Activity -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Recent Domain Activity</h6>
                                <button class="btn btn-outline-info btn-sm" onclick="viewAllActivity()">
                                    <i class="bx bx-history me-1"></i> View All Activity
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Client</th>
                                                <th>Domain</th>
                                                <th>Action</th>
                                                <th>Time</th>
                                                <th>Status</th>
                                                <th>Details</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><strong>John Doe</strong></td>
                                                <td><code>example.com</code></td>
                                                <td>Domain added</td>
                                                <td>14:30:00</td>
                                                <td><span class="badge bg-success">Success</span></td>
                                                <td><small>Auto-configured DNS and SSL</small></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Jane Smith</strong></td>
                                                <td><code>test.org</code></td>
                                                <td>Domain suspended</td>
                                                <td>14:25:00</td>
                                                <td><span class="badge bg-warning">Suspended</span></td>
                                                <td><small>Payment overdue</small></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Bob Johnson</strong></td>
                                                <td><code>business3.org</code></td>
                                                <td>SSL renewed</td>
                                                <td>14:20:00</td>
                                                <td><span class="badge bg-success">Success</span></td>
                                                <td><small>Auto-renewed for 90 days</small></td>
                                            </tr>
                                            <tr>
                                                <td><strong>John Doe</strong></td>
                                                <td><code>mydomain.net</code></td>
                                                <td>DNS updated</td>
                                                <td>14:15:00</td>
                                                <td><span class="badge bg-success">Success</span></td>
                                                <td><small>A record updated</small></td>
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
// Domain Distribution Chart
const domainCtx = document.getElementById('domainChart').getContext('2d');
new Chart(domainCtx, {
    type: 'doughnut',
    data: {
        labels: ['John Doe', 'Jane Smith', 'Bob Johnson'],
        datasets: [{
            data: [3, 1, 18],
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

// Domain Status Chart
const statusCtx = document.getElementById('statusChart').getContext('2d');
new Chart(statusCtx, {
    type: 'doughnut',
    data: {
        labels: ['Active', 'Suspended'],
        datasets: [{
            data: [20, 1],
            backgroundColor: ['#28a745', '#ffc107']
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

function addDomain() {
    showNotification('Add domain dialog opened', 'info');
}

function exportDomains() {
    showNotification('Exporting domain report...', 'info');
}

function viewDomains(id) {
    showNotification(`Viewing domains for client ${id}...`, 'info');
}

function addClientDomain(id) {
    showNotification(`Adding domain for client ${id}...`, 'info');
}

function increaseLimit(id) {
    showNotification(`Increasing domain limit for client ${id}...`, 'info');
}

function manageDns(id) {
    showNotification(`Opening DNS management for client ${id}...`, 'info');
}

function suspendDomains(id) {
    if (confirm('Are you sure you want to suspend all domains for this client?')) {
        showNotification(`Suspending all domains for client ${id}...`, 'warning');
    }
}

function deleteDomains(id) {
    if (confirm('Are you sure you want to delete all domains for this client?')) {
        if (confirm('This action cannot be undone. Are you absolutely sure?')) {
            showNotification(`Deleting all domains for client ${id}...`, 'danger');
        }
    }
}

function saveDomainSettings() {
    showNotification('Domain management settings saved successfully', 'success');
}

function checkDomains() {
    showNotification('Checking all domains...', 'info');
}

function viewAllActivity() {
    showNotification('Opening all domain activity...', 'info');
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
