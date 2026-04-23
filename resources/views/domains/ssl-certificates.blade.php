@extends('layouts.app')

@section('title', 'SSL Certificates Management')
@section('description', 'Manage SSL certificates for domain security')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">SSL Certificates Management</h5>
                    <p class="card-subtitle">Manage SSL certificates for domain security and HTTPS</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-success" onclick="requestCertificate()">
                        <i class="bx bx-plus me-1"></i> Request Certificate
                    </button>
                    <button class="btn btn-outline-primary" onclick="renewAllCertificates()">
                        <i class="bx bx-refresh me-1"></i> Renew All
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- SSL Certificates Statistics -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-primary bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-shield text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Certificates</h6>
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
                                <h4 class="mb-0 text-success">3</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-warning bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-alert text-warning"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Expiring Soon</h6>
                                <h4 class="mb-0 text-warning">1</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-danger bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-x-circle text-danger"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Expired</h6>
                                <h4 class="mb-0 text-danger">1</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SSL Certificates Table -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Domain</th>
                                <th>Status</th>
                                <th>Issuer</th>
                                <th>Valid From</th>
                                <th>Valid Until</th>
                                <th>Days Remaining</th>
                                <th>Auto Renew</th>
                                <th>Protocol</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($certificates as $cert)
                            <tr>
                                <td><strong>{{ $cert['domain'] }}</strong></td>
                                <td>
                                    <span class="badge bg-{{ $cert['status'] == 'active' ? 'success' : ($cert['status'] == 'pending' ? 'warning' : 'danger') }}">
                                        {{ $cert['status'] }}
                                    </span>
                                </td>
                                <td>{{ $cert['issuer'] }}</td>
                                <td>{{ \Carbon\Carbon::parse($cert['valid_from'])->format('M d, Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($cert['valid_until'])->format('M d, Y') }}</td>
                                <td>
                                    <span class="badge bg-{{ $cert['days_remaining'] > 30 ? 'success' : ($cert['days_remaining'] > 7 ? 'warning' : 'danger') }}">
                                        {{ $cert['days_remaining'] > 0 ? $cert['days_remaining'] . ' days' : 'Expired' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $cert['auto_renew'] ? 'success' : 'secondary' }}">
                                        {{ $cert['auto_renew'] ? 'Enabled' : 'Disabled' }}
                                    </span>
                                </td>
                                <td><span class="badge bg-info">{{ $cert['protocol'] }}</span></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a href="#" class="dropdown-item" onclick="viewCertificate('{{ $cert['domain'] }}')">
                                                <i class="bx bx-eye me-2"></i> View Details
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="downloadCertificate('{{ $cert['domain'] }}')">
                                                <i class="bx bx-download me-2"></i> Download
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="testCertificate('{{ $cert['domain'] }}')">
                                                <i class="bx bx-test-tube me-2"></i> Test
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            @if($cert['status'] == 'active')
                                            <a href="#" class="dropdown-item text-warning" onclick="renewCertificate('{{ $cert['domain'] }}')">
                                                <i class="bx bx-refresh me-2"></i> Renew
                                            </a>
                                            @endif
                                            @if($cert['status'] == 'expired')
                                            <a href="#" class="dropdown-item text-success" onclick="reissueCertificate('{{ $cert['domain'] }}')">
                                                <i class="bx bx-reset me-2"></i> Reissue
                                            </a>
                                            @endif
                                            <a href="#" class="dropdown-item" onclick="toggleAutoRenew('{{ $cert['domain'] }}', '{{ $cert['auto_renew'] }}')">
                                                <i class="bx bx-sync me-2"></i> {{ $cert['auto_renew'] ? 'Disable' : 'Enable' }} Auto Renew
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item text-danger" onclick="revokeCertificate('{{ $cert['domain'] }}')">
                                                <i class="bx bx-shield-x me-2"></i> Revoke
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Certificate Health Overview -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Certificate Expiry Timeline</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="expiryChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Certificate Providers</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="providerChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SSL Configuration -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">SSL Configuration</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="mb-3">Global SSL Settings</h6>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="forceHTTPS" checked>
                                            <label class="form-check-label" for="forceHTTPS">
                                                Force HTTPS for all domains
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="hsts" checked>
                                            <label class="form-check-label" for="hsts">
                                                Enable HSTS (HTTP Strict Transport Security)
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="autoRenew" checked>
                                            <label class="form-check-label" for="autoRenew">
                                                Enable automatic renewal for all certificates
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="emailAlerts" checked>
                                            <label class="form-check-label" for="emailAlerts">
                                                Send email alerts for expiry notifications
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="mb-3">Certificate Preferences</h6>
                                        <div class="mb-3">
                                            <label for="defaultProvider" class="form-label">Default Certificate Provider</label>
                                            <select class="form-select" id="defaultProvider">
                                                <option value="letsencrypt" selected>Let's Encrypt (Free)</option>
                                                <option value="digicert">DigiCert (Paid)</option>
                                                <option value="comodo">Comodo (Paid)</option>
                                                <option value="godaddy">GoDaddy (Paid)</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="renewalDays" class="form-label">Auto-Renewal Days Before Expiry</label>
                                            <input type="number" class="form-control" id="renewalDays" value="30" min="7" max="90">
                                        </div>
                                        <div class="mb-3">
                                            <label for="keySize" class="form-label">Default Key Size</label>
                                            <select class="form-select" id="keySize">
                                                <option value="2048" selected>2048-bit</option>
                                                <option value="4096">4096-bit</option>
                                                <option value="8192">8192-bit</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-primary" onclick="saveSSLSettings()">
                                        <i class="bx bx-save me-1"></i> Save Settings
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SSL Test Tool -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">SSL Test Tool</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="testDomain" placeholder="Enter domain to test SSL (e.g., example.com)">
                                            <button class="btn btn-outline-primary" onclick="testSSL()">
                                                <i class="bx bx-shield me-1"></i> Test SSL
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <button class="btn btn-outline-success w-100" onclick="runBatchSSLTest()">
                                            <i class="bx bx-test-tube me-1"></i> Test All Domains
                                        </button>
                                    </div>
                                </div>
                                <div id="sslTestResults" class="mt-3"></div>
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
// Certificate Expiry Timeline Chart
const expiryCtx = document.getElementById('expiryChart').getContext('2d');
new Chart(expiryCtx, {
    type: 'bar',
    data: {
        labels: ['example.com', 'mydomain.net', 'test.org', 'site.co', 'app.io'],
        datasets: [{
            label: 'Days Remaining',
            data: [60, 69, 88, 298, -3],
            backgroundColor: [
                '#28a745',
                '#28a745',
                '#ffc107',
                '#28a745',
                '#dc3545'
            ]
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

// Certificate Providers Chart
const providerCtx = document.getElementById('providerChart').getContext('2d');
new Chart(providerCtx, {
    type: 'doughnut',
    data: {
        labels: ['Let\'s Encrypt', 'DigiCert'],
        datasets: [{
            data: [4, 1],
            backgroundColor: ['#28a745', '#007bff']
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

function requestCertificate() {
    showNotification('Certificate request dialog opened', 'info');
}

function renewAllCertificates() {
    if (confirm('Are you sure you want to renew all certificates?')) {
        showNotification('Renewing all certificates...', 'info');
    }
}

function viewCertificate(domain) {
    showNotification(`Viewing certificate details for ${domain}`, 'info');
}

function downloadCertificate(domain) {
    showNotification(`Downloading certificate for ${domain}`, 'info');
}

function testCertificate(domain) {
    showNotification(`Testing certificate for ${domain}`, 'info');
}

function renewCertificate(domain) {
    showNotification(`Renewing certificate for ${domain}`, 'info');
}

function reissueCertificate(domain) {
    showNotification(`Reissuing certificate for ${domain}`, 'warning');
}

function toggleAutoRenew(domain, currentStatus) {
    const newStatus = currentStatus ? 'disable' : 'enable';
    if (confirm(`Are you sure you want to ${newStatus} auto-renew for ${domain}?`)) {
        showNotification(`Auto-renew ${newStatus}d for ${domain}`, 'success');
    }
}

function revokeCertificate(domain) {
    if (confirm(`Are you sure you want to revoke certificate for ${domain}? This action cannot be undone.`)) {
        showNotification(`Certificate revoked for ${domain}`, 'danger');
    }
}

function saveSSLSettings() {
    showNotification('SSL settings saved successfully', 'success');
}

function testSSL() {
    const domain = document.getElementById('testDomain').value;
    if (!domain) {
        showNotification('Please enter a domain to test', 'warning');
        return;
    }
    showNotification(`Testing SSL certificate for ${domain}...`, 'info');
}

function runBatchSSLTest() {
    showNotification('Running batch SSL test for all domains...', 'info');
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
