@extends('layouts.app')

@section('title', 'Domain & DNS Management')
@section('description', 'Manage domains, DNS records, and SSL certificates')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">Domain Management</h5>
                    <p class="card-subtitle">Manage your domains, DNS records, and SSL certificates</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('domains.create') }}" class="btn btn-primary">
                        <i class="bx bx-plus me-1"></i> Add Domain
                    </a>
                    <button class="btn btn-outline-success" onclick="syncDomains()">
                        <i class="bx bx-sync me-1"></i> Sync Domains
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
                                <h4 class="mb-0 text-warning">2</h4>
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

                <!-- Domain Table -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Domain</th>
                                <th>Status</th>
                                <th>Expiry Date</th>
                                <th>Registrar</th>
                                <th>SSL Status</th>
                                <th>DNS Records</th>
                                <th>Auto Renew</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($domains as $domain)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar bg-primary bg-opacity-10 rounded-circle me-2" style="width: 32px; height: 32px;">
                                            <i class="bx bx-globe text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $domain['domain'] }}</h6>
                                            <small class="text-muted">Created {{ \Carbon\Carbon::parse($domain['created_at'])->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @switch($domain['status'])
                                        @case('active')
                                            <span class="badge bg-success">Active</span>
                                            @break
                                        @case('pending')
                                            <span class="badge bg-warning">Pending</span>
                                            @break
                                        @case('expired')
                                            <span class="badge bg-danger">Expired</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary">{{ $domain['status'] }}</span>
                                    @endswitch
                                </td>
                                <td>
                                    <div>
                                        <strong>{{ \Carbon\Carbon::parse($domain['expiry_date'])->format('M d, Y') }}</strong>
                                        <br>
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($domain['expiry_date'])->diffInDays(\Carbon\Carbon::now()) }} days
                                        </small>
                                    </div>
                                </td>
                                <td>{{ $domain['registrar'] }}</td>
                                <td>
                                    @switch($domain['ssl_status'])
                                        @case('active')
                                            <span class="badge bg-success">Active</span>
                                            @break
                                        @case('expired')
                                            <span class="badge bg-danger">Expired</span>
                                            @break
                                        @case('none')
                                            <span class="badge bg-secondary">None</span>
                                            @break
                                        @default
                                            <span class="badge bg-warning">{{ $domain['ssl_status'] }}</span>
                                    @endswitch
                                </td>
                                <td>{{ $domain['dns_records'] }}</td>
                                <td>
                                    @if($domain['auto_renew'])
                                        <span class="badge bg-success">Enabled</span>
                                    @else
                                        <span class="badge bg-danger">Disabled</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a href="{{ route('domains.show', $domain['id']) }}" class="dropdown-item">
                                                <i class="bx bx-eye me-2"></i> View Details
                                            </a>
                                            <a href="{{ route('domains.edit', $domain['id']) }}" class="dropdown-item">
                                                <i class="bx bx-edit me-2"></i> Edit
                                            </a>
                                            <a href="{{ route('domains.dns', $domain['id']) }}" class="dropdown-item">
                                                <i class="bx bx-dns me-2"></i> Manage DNS
                                            </a>
                                            <a href="{{ route('domains.ssl', $domain['id']) }}" class="dropdown-item">
                                                <i class="bx bx-shield me-2"></i> SSL Certificates
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item text-success">
                                                <i class="bx bx-refresh me-2"></i> Renew Domain
                                            </a>
                                            <a href="#" class="dropdown-item text-info">
                                                <i class="bx bx-sync me-2"></i> Sync Records
                                            </a>
                                            <a href="#" class="dropdown-item text-warning">
                                                <i class="bx bx-lock me-2"></i> Transfer Lock
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item text-danger">
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
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions Modal -->
<div class="modal fade" id="quickActionsModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Domain Quick Actions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="d-grid gap-2">
                    <button class="btn btn-outline-primary">
                        <i class="bx bx-sync me-2"></i> Sync All Domains
                    </button>
                    <button class="btn btn-outline-success">
                        <i class="bx bx-refresh me-2"></i> Renew Expiring Domains
                    </button>
                    <button class="btn btn-outline-info">
                        <i class="bx bx-shield me-2"></i> Check SSL Certificates
                    </button>
                    <button class="btn btn-outline-warning">
                        <i class="bx bx-dns me-2"></i> Update DNS Records
                    </button>
                    <button class="btn btn-outline-secondary">
                        <i class="bx bx-lock me-2"></i> Enable Transfer Lock
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function syncDomains() {
    const button = event.target;
    button.disabled = true;
    button.innerHTML = '<i class="bx bx-loader-alt bx-spin me-1"></i> Syncing...';
    
    setTimeout(() => {
        button.disabled = false;
        button.innerHTML = '<i class="bx bx-sync me-1"></i> Sync Domains';
        showNotification('Domains synchronized successfully', 'success');
    }, 2000);
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
