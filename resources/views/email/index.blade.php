@extends('layouts.app')

@section('title', 'Email Management')
@section('description', 'Manage email accounts and email services')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">Email Management</h5>
                    <p class="card-subtitle">Manage email accounts and email services</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('email.create') }}" class="btn btn-primary">
                        <i class="bx bx-plus me-1"></i> Add Email
                    </a>
                    <button class="btn btn-outline-success" onclick="syncEmails()">
                        <i class="bx bx-sync me-1"></i> Sync All
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- Email Statistics -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-primary bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-envelope text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Accounts</h6>
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
                                <i class="bx bx-right-arrow text-warning"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Forwarded</h6>
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
                                <h6 class="mb-0">Disabled</h6>
                                <h4 class="mb-0 text-danger">1</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Email Accounts Table -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Email Address</th>
                                <th>Domain</th>
                                <th>Status</th>
                                <th>Quota Usage</th>
                                <th>Forwarding</th>
                                <th>Auto Responder</th>
                                <th>Spam Filter</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($accounts as $account)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar bg-primary bg-opacity-10 rounded-circle me-2" style="width: 32px; height: 32px;">
                                            <i class="bx bx-envelope text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $account['email'] }}</h6>
                                            <small class="text-muted">Created {{ \Carbon\Carbon::parse($account['created_at'])->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $account['domain'] }}</td>
                                <td>
                                    @switch($account['status'])
                                        @case('active')
                                            <span class="badge bg-success">Active</span>
                                            @break
                                        @case('forwarded')
                                            <span class="badge bg-warning">Forwarded</span>
                                            @break
                                        @case('disabled')
                                            <span class="badge bg-danger">Disabled</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary">{{ $account['status'] }}</span>
                                    @endswitch
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress me-2" style="width: 60px; height: 6px;">
                                            <div class="progress-bar {{ ($account['quota_used'] / $account['quota_limit']) > 0.8 ? 'bg-danger' : (($account['quota_used'] / $account['quota_limit']) > 0.6 ? 'bg-warning' : 'bg-success') }}" 
                                                 style="width: {{ ($account['quota_used'] / $account['quota_limit']) * 100 }}%"></div>
                                        </div>
                                        <small>{{ $account['quota_used'] }} / {{ $account['quota_limit'] }} GB</small>
                                    </div>
                                </td>
                                <td>
                                    @if($account['forwarding'])
                                        <span class="badge bg-warning">Enabled</span>
                                    @else
                                        <span class="badge bg-secondary">Disabled</span>
                                    @endif
                                </td>
                                <td>
                                    @if($account['auto_responder'])
                                        <span class="badge bg-info">Enabled</span>
                                    @else
                                        <span class="badge bg-secondary">Disabled</span>
                                    @endif
                                </td>
                                <td>
                                    @if($account['spam_filter'])
                                        <span class="badge bg-success">Active</span>
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
                                            <a href="{{ route('email.show', $account['id']) }}" class="dropdown-item">
                                                <i class="bx bx-eye me-2"></i> View Details
                                            </a>
                                            <a href="{{ route('email.edit', $account['id']) }}" class="dropdown-item">
                                                <i class="bx bx-edit me-2"></i> Edit
                                            </a>
                                            <a href="{{ route('email.webmail', $account['id']) }}" class="dropdown-item">
                                                <i class="bx bx-envelope-open me-2"></i> Webmail
                                            </a>
                                            <a href="{{ route('email.forwarding', $account['id']) }}" class="dropdown-item">
                                                <i class="bx bx-right-arrow me-2"></i> Forwarding
                                            </a>
                                            <a href="{{ route('email.auto-responder', $account['id']) }}" class="dropdown-item">
                                                <i class="bx bx-bot me-2"></i> Auto Responder
                                            </a>
                                            <a href="{{ route('email.spam-filter', $account['id']) }}" class="dropdown-item">
                                                <i class="bx bx-shield me-2"></i> Spam Filter
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item text-success">
                                                <i class="bx bx-play me-2"></i> Enable
                                            </a>
                                            <a href="#" class="dropdown-item text-warning">
                                                <i class="bx bx-pause me-2"></i> Disable
                                            </a>
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
@endsection

@push('scripts')
<script>
function syncEmails() {
    const button = event.target;
    button.disabled = true;
    button.innerHTML = '<i class="bx bx-loader-alt bx-spin me-1"></i> Syncing...';
    
    setTimeout(() => {
        button.disabled = false;
        button.innerHTML = '<i class="bx bx-sync me-1"></i> Sync All';
        showNotification('Email accounts synchronized successfully', 'success');
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
