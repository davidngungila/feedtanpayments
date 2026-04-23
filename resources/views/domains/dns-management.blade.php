@extends('layouts.app')

@section('title', 'DNS Management')
@section('description', 'Manage DNS records and settings for all domains')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">DNS Management</h5>
                    <p class="card-subtitle">Manage DNS records and settings for all domains</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-success" onclick="syncDNS()">
                        <i class="bx bx-sync me-1"></i> Sync DNS
                    </button>
                    <button class="btn btn-outline-primary" onclick="addRecord()">
                        <i class="bx bx-plus me-1"></i> Add Record
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- DNS Statistics -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-primary bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-globe text-primary"></i>
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
                                <i class="bx bx-list-check text-info"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Records</h6>
                                <h4 class="mb-0 text-info">45</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- DNS Records Overview -->
                <div class="row mb-4">
                    <div class="col-md-2">
                        <div class="text-center">
                            <h4 class="text-primary mb-0">18</h4>
                            <small class="text-muted">A Records</small>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="text-center">
                            <h4 class="text-success mb-0">6</h4>
                            <small class="text-muted">CNAME Records</small>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="text-center">
                            <h4 class="text-warning mb-0">6</h4>
                            <small class="text-muted">MX Records</small>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="text-center">
                            <h4 class="text-info mb-0">10</h4>
                            <small class="text-muted">NS Records</small>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="text-center">
                            <h4 class="text-secondary mb-0">3</h4>
                            <small class="text-muted">TXT Records</small>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="text-center">
                            <h4 class="text-danger mb-0">2</h4>
                            <small class="text-muted">SRV Records</small>
                        </div>
                    </div>
                </div>

                <!-- Domain List -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Domain</th>
                                <th>Records</th>
                                <th>Status</th>
                                <th>Last Sync</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($domains as $domain)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-globe text-primary me-2"></i>
                                        <strong>{{ $domain['name'] }}</strong>
                                    </div>
                                </td>
                                <td>{{ $domain['records'] }}</td>
                                <td>
                                    <span class="badge bg-{{ $domain['status'] == 'active' ? 'success' : 'warning' }}">
                                        {{ $domain['status'] }}
                                    </span>
                                </td>
                                <td>
                                    <small class="text-muted">{{ \Carbon\Carbon::now()->subMinutes(15)->format('H:i') }}</small>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a href="{{ route('domains.a-records') }}" class="dropdown-item">
                                                <i class="bx bx-right-arrow me-2"></i> A Records
                                            </a>
                                            <a href="{{ route('domains.cname-records') }}" class="dropdown-item">
                                                <i class="bx bx-right-arrow me-2"></i> CNAME Records
                                            </a>
                                            <a href="{{ route('domains.mx-records') }}" class="dropdown-item">
                                                <i class="bx bx-right-arrow me-2"></i> MX Records
                                            </a>
                                            <a href="{{ route('domains.nameservers') }}" class="dropdown-item">
                                                <i class="bx bx-server me-2"></i> Nameservers
                                            </a>
                                            <a href="{{ route('domains.ssl-certificates') }}" class="dropdown-item">
                                                <i class="bx bx-shield me-2"></i> SSL Certificates
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item" onclick="syncDomain('{{ $domain['name'] }}')">
                                                <i class="bx bx-sync me-2"></i> Sync Domain
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="testDNS('{{ $domain['name'] }}')">
                                                <i class="bx bx-test-tube me-2"></i> Test DNS
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Quick Actions -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Quick Actions</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="d-grid">
                                            <a href="{{ route('domains.a-records') }}" class="btn btn-outline-primary">
                                                <i class="bx bx-right-arrow me-2"></i> Manage A Records
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="d-grid">
                                            <a href="{{ route('domains.cname-records') }}" class="btn btn-outline-success">
                                                <i class="bx bx-right-arrow me-2"></i> Manage CNAME Records
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="d-grid">
                                            <a href="{{ route('domains.mx-records') }}" class="btn btn-outline-warning">
                                                <i class="bx bx-right-arrow me-2"></i> Manage MX Records
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="d-grid">
                                            <a href="{{ route('domains.nameservers') }}" class="btn btn-outline-info">
                                                <i class="bx bx-server me-2"></i> Manage Nameservers
                                            </a>
                                        </div>
                                    </div>
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
function syncDNS() {
    showNotification('DNS synchronization initiated', 'info');
}

function addRecord() {
    showNotification('Add record dialog opened', 'info');
}

function syncDomain(domain) {
    showNotification(`Synchronizing DNS for ${domain}`, 'info');
}

function testDNS(domain) {
    showNotification(`Testing DNS for ${domain}`, 'info');
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
