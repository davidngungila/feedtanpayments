@extends('layouts.app')

@section('title', 'Domain Details - ' . $domain['domain'])
@section('description', 'View and manage domain details and settings')

@section('content')
<div class="row">
    <!-- Domain Overview -->
    <div class="col-12 mb-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="avatar bg-primary bg-opacity-10 rounded-circle me-3" style="width: 48px; height: 48px;">
                        <i class="bx bx-globe text-primary"></i>
                    </div>
                    <div>
                        <h5 class="card-title mb-0">{{ $domain['domain'] }}</h5>
                        <p class="card-subtitle mb-0">{{ $domain['registrar'] }} • Active</p>
                    </div>
                </div>
                <div class="d-flex gap-2 align-items-center">
                    <span class="badge bg-success">Active</span>
                    <a href="{{ route('domains.edit', $domain['id']) }}" class="btn btn-outline-primary btn-sm">
                        <i class="bx bx-edit me-1"></i> Edit
                    </a>
                    <div class="dropdown">
                        <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="dropdown">
                            <i class="bx bx-dots-horizontal-rounded"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="#" class="dropdown-item text-success">
                                <i class="bx bx-refresh me-2"></i> Renew Domain
                            </a>
                            <a href="{{ route('domains.dns', $domain['id']) }}" class="dropdown-item">
                                <i class="bx bx-dns me-2"></i> Manage DNS
                            </a>
                            <a href="{{ route('domains.ssl', $domain['id']) }}" class="dropdown-item">
                                <i class="bx bx-shield me-2"></i> SSL Certificates
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item text-info">
                                <i class="bx bx-sync me-2"></i> Sync Records
                            </a>
                            <a href="#" class="dropdown-item text-warning">
                                <i class="bx bx-lock me-2"></i> Transfer Lock
                            </a>
                            <a href="#" class="dropdown-item text-danger">
                                <i class="bx bx-trash me-2"></i> Delete Domain
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <!-- Domain Information -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6 class="mb-3">Domain Information</h6>
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="text-muted" style="width: 150px;">Domain:</td>
                                        <td><strong>{{ $domain['domain'] }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Status:</td>
                                        <td><span class="badge bg-success">Active</span></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Expiry Date:</td>
                                        <td>{{ \Carbon\Carbon::parse($domain['expiry_date'])->format('M d, Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Days Until Expiry:</td>
                                        <td><span class="text-warning">{{ \Carbon\Carbon::parse($domain['expiry_date'])->diffInDays(\Carbon\Carbon::now()) }} days</span></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Registrar:</td>
                                        <td>{{ $domain['registrar'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Created:</td>
                                        <td>{{ \Carbon\Carbon::parse($domain['created_at'])->format('M d, Y') }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h6 class="mb-3">Nameservers</h6>
                                <table class="table table-borderless">
                                    @foreach($domain['nameservers'] as $nameserver)
                                    <tr>
                                        <td class="text-muted" style="width: 150px;">NS {{ $loop->iteration }}:</td>
                                        <td><code>{{ $nameserver }}</code></td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td class="text-muted">Auto Renew:</td>
                                        <td>
                                            @if($domain['auto_renew'])
                                                <span class="badge bg-success">Enabled</span>
                                            @else
                                                <span class="badge bg-danger">Disabled</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- WHOIS Information -->
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="mb-3">WHOIS Information</h6>
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="text-muted" style="width: 150px;">Registrant:</td>
                                        <td>{{ $domain['whois']['registrant'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Email:</td>
                                        <td>{{ $domain['whois']['email'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Phone:</td>
                                        <td>{{ $domain['whois']['phone'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Address:</td>
                                        <td>{{ $domain['whois']['address'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Country:</td>
                                        <td>{{ $domain['whois']['country'] }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <!-- SSL Status -->
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">SSL Certificate</h6>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted">Status:</span>
                                    <span class="badge bg-success">Active</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted">Issuer:</span>
                                    <strong>Let's Encrypt</strong>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted">Expires:</span>
                                    <span class="text-warning">{{ \Carbon\Carbon::parse($domain['ssl_expiry'])->format('M d, Y') }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">Auto Renew:</span>
                                    <span class="badge bg-success">Enabled</span>
                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-outline-primary btn-sm w-100" onclick="renewSSL()">
                                        <i class="bx bx-refresh me-1"></i> Renew Certificate
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="card border-0 shadow-sm mt-3">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Quick Actions</h6>
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <a href="{{ route('domains.dns', $domain['id']) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="bx bx-dns me-2"></i> Manage DNS
                                    </a>
                                    <a href="{{ route('domains.ssl', $domain['id']) }}" class="btn btn-outline-info btn-sm">
                                        <i class="bx bx-shield me-2"></i> SSL Certificates
                                    </a>
                                    <button class="btn btn-outline-success btn-sm" onclick="syncDomain()">
                                        <i class="bx bx-sync me-2"></i> Sync Records
                                    </button>
                                    <button class="btn btn-outline-warning btn-sm" onclick="checkDNS()">
                                        <i class="bx bx-search me-2"></i> DNS Check
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- DNS Records -->
    <div class="col-md-6 mb-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">DNS Records</h5>
                <a href="{{ route('domains.dns', $domain['id']) }}" class="btn btn-sm btn-outline-primary">
                    Manage DNS
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Name</th>
                                <th>Value</th>
                                <th>TTL</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($domain['dns_entries'] as $record)
                            <tr>
                                <td>
                                    <span class="badge bg-primary">{{ $record['type'] }}</span>
                                </td>
                                <td><code>{{ $record['name'] }}</code></td>
                                <td><code>{{ $record['value'] }}</code></td>
                                <td>{{ $record['ttl'] }}</td>
                                <td><span class="badge bg-success">Active</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Domain Health -->
    <div class="col-md-6 mb-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Domain Health Check</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-success bg-opacity-10 rounded-circle me-2" style="width: 32px; height: 32px;">
                                <i class="bx bx-check-circle text-success"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">DNS Resolution</h6>
                                <small class="text-success">Working</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-success bg-opacity-10 rounded-circle me-2" style="width: 32px; height: 32px;">
                                <i class="bx bx-check-circle text-success"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">HTTPS</h6>
                                <small class="text-success">Valid Certificate</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-success bg-opacity-10 rounded-circle me-2" style="width: 32px; height: 32px;">
                                <i class="bx bx-check-circle text-success"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">MX Records</h6>
                                <small class="text-success">Configured</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-success bg-opacity-10 rounded-circle me-2" style="width: 32px; height: 32px;">
                                <i class="bx bx-check-circle text-success"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">SPF/DKIM</h6>
                                <small class="text-success">Valid</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <button class="btn btn-outline-primary btn-sm" onclick="runHealthCheck()">
                        <i class="bx bx-refresh me-1"></i> Run Health Check
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function renewSSL() {
    showNotification('SSL certificate renewal initiated', 'info');
}

function syncDomain() {
    showNotification('Domain synchronization started', 'info');
}

function checkDNS() {
    showNotification('DNS check completed successfully', 'success');
}

function runHealthCheck() {
    showNotification('Health check in progress...', 'info');
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
