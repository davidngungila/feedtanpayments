@extends('layouts.app')

@section('title', 'Email Account Details')
@section('description', 'View email account details and settings')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">Email Account Details</h5>
                    <p class="card-subtitle">View email account details and settings</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary" onclick="editAccount()">
                        <i class="bx bx-edit me-1"></i> Edit Account
                    </button>
                    <button class="btn btn-outline-success" onclick="accessWebmail()">
                        <i class="bx bx-envelope me-1"></i> Access Webmail
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- Account Information -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Account Information</h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm">
                                    <tbody>
                                        <tr>
                                            <td><strong>Email Address:</strong></td>
                                            <td>{{ $account['email'] }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Domain:</strong></td>
                                            <td>{{ $account['domain'] }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Status:</strong></td>
                                            <td>
                                                <span class="badge bg-{{ $account['status'] == 'active' ? 'success' : 'danger' }}">
                                                    {{ $account['status'] }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Created:</strong></td>
                                            <td>{{ \Carbon\Carbon::parse($account['created_at'])->format('M d, Y') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Last Login:</strong></td>
                                            <td>{{ \Carbon\Carbon::parse($account['last_login'])->format('M d, H:i') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Email Statistics</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="text-center">
                                            <h4 class="text-info">{{ $account['total_emails'] }}</h4>
                                            <p class="text-muted">Total Emails</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="text-center">
                                            <h4 class="text-warning">{{ $account['unread_emails'] }}</h4>
                                            <p class="text-muted">Unread</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="text-center">
                                            <h4 class="text-success">{{ $account['sent_emails'] }}</h4>
                                            <p class="text-muted">Sent</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="text-center">
                                            <h4 class="text-danger">{{ $account['deleted_emails'] }}</h4>
                                            <p class="text-muted">Deleted</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quota Information -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Quota Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <div class="mb-2">
                                            <strong>{{ $account['quota_used'] }} GB / {{ $account['quota_limit'] }} GB</strong>
                                        </div>
                                        <div class="progress" style="height: 10px;">
                                            @php
                                                $quotaPercent = ($account['quota_used'] / $account['quota_limit']) * 100;
                                            @endphp
                                            <div class="progress-bar bg-{{ $quotaPercent > 80 ? 'danger' : ($quotaPercent > 60 ? 'warning' : 'success') }}" 
                                                 style="width: {{ min($quotaPercent, 100) }}%"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <span class="badge bg-{{ $quotaPercent > 80 ? 'danger' : ($quotaPercent > 60 ? 'warning' : 'success') }}">
                                            {{ number_format($quotaPercent, 1) }}% Used
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Service Status -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Service Status</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar bg-{{ $account['imap_enabled'] ? 'success' : 'danger' }} bg-opacity-10 rounded-circle me-2" style="width: 32px; height: 32px;">
                                                <i class="bx bx-{{ $account['imap_enabled'] ? 'check' : 'x' }} text-{{ $account['imap_enabled'] ? 'success' : 'danger' }}"></i>
                                            </div>
                                            <div>
                                                <strong>IMAP</strong>
                                                <br>
                                                <small class="text-muted">{{ $account['imap_enabled'] ? 'Enabled' : 'Disabled' }}</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar bg-{{ $account['pop3_enabled'] ? 'success' : 'danger' }} bg-opacity-10 rounded-circle me-2" style="width: 32px; height: 32px;">
                                                <i class="bx bx-{{ $account['pop3_enabled'] ? 'check' : 'x' }} text-{{ $account['pop3_enabled'] ? 'success' : 'danger' }}"></i>
                                            </div>
                                            <div>
                                                <strong>POP3</strong>
                                                <br>
                                                <small class="text-muted">{{ $account['pop3_enabled'] ? 'Enabled' : 'Disabled' }}</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar bg-{{ $account['webmail_enabled'] ? 'success' : 'danger' }} bg-opacity-10 rounded-circle me-2" style="width: 32px; height: 32px;">
                                                <i class="bx bx-{{ $account['webmail_enabled'] ? 'check' : 'x' }} text-{{ $account['webmail_enabled'] ? 'success' : 'danger' }}"></i>
                                            </div>
                                            <div>
                                                <strong>Webmail</strong>
                                                <br>
                                                <small class="text-muted">{{ $account['webmail_enabled'] ? 'Enabled' : 'Disabled' }}</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar bg-{{ $account['spam_filter'] ? 'success' : 'danger' }} bg-opacity-10 rounded-circle me-2" style="width: 32px; height: 32px;">
                                                <i class="bx bx-{{ $account['spam_filter'] ? 'check' : 'x' }} text-{{ $account['spam_filter'] ? 'success' : 'danger' }}"></i>
                                            </div>
                                            <div>
                                                <strong>Spam Filter</strong>
                                                <br>
                                                <small class="text-muted">{{ $account['spam_filter'] ? 'Enabled' : 'Disabled' }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Email Features -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Email Features</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="mb-3">Forwarding</h6>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <p class="mb-0">{{ $account['forwarding'] ? 'Enabled' : 'Disabled' }}</p>
                                                @if($account['forwarding'])
                                                    <small class="text-muted">Forwarding addresses: {{ count($account['forwarding_addresses']) }}</small>
                                                @endif
                                            </div>
                                            <button class="btn btn-sm btn-outline-primary" onclick="manageForwarding()">
                                                <i class="bx bx-cog"></i> Manage
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="mb-3">Auto Responder</h6>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <p class="mb-0">{{ $account['auto_responder'] ? 'Enabled' : 'Disabled' }}</p>
                                                @if($account['auto_responder'])
                                                    <small class="text-muted">Auto-responder active</small>
                                                @endif
                                            </div>
                                            <button class="btn btn-sm btn-outline-primary" onclick="manageAutoResponder()">
                                                <i class="bx bx-cog"></i> Manage
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Quick Actions</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="d-grid">
                                            <button class="btn btn-outline-primary" onclick="changePassword()">
                                                <i class="bx bx-key me-1"></i> Change Password
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="d-grid">
                                            <button class="btn btn-outline-info" onclick="viewLogs()">
                                                <i class="bx bx-history me-1"></i> View Logs
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="d-grid">
                                            <button class="btn btn-outline-warning" onclick="backupAccount()">
                                                <i class="bx bx-cloud-download me-1"></i> Backup Account
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="d-grid">
                                            <button class="btn btn-outline-danger" onclick="suspendAccount()">
                                                <i class="bx bx-pause me-1"></i> Suspend Account
                                            </button>
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
function editAccount() {
    showNotification('Opening account edit form...', 'info');
}

function accessWebmail() {
    showNotification('Opening webmail...', 'info');
}

function manageForwarding() {
    showNotification('Opening forwarding settings...', 'info');
}

function manageAutoResponder() {
    showNotification('Opening auto-responder settings...', 'info');
}

function changePassword() {
    if (confirm('Are you sure you want to change the password for this email account?')) {
        showNotification('Password change initiated...', 'info');
    }
}

function viewLogs() {
    showNotification('Opening email logs...', 'info');
}

function backupAccount() {
    if (confirm('Are you sure you want to backup this email account?')) {
        showNotification('Creating backup...', 'info');
    }
}

function suspendAccount() {
    if (confirm('Are you sure you want to suspend this email account?')) {
        showNotification('Account suspended...', 'warning');
    }
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
