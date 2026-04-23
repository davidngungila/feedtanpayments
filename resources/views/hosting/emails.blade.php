@extends('layouts.app')

@section('title', 'Email Accounts')
@section('description', 'Manage website email accounts and email settings')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">Email Accounts</h5>
                    <p class="card-subtitle">Manage website email accounts and email settings</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-success" onclick="createEmail()">
                        <i class="bx bx-plus me-1"></i> Create Email
                    </button>
                    <button class="btn btn-outline-primary" onclick="accessWebmail()">
                        <i class="bx bx-envelope-open me-1"></i> Webmail
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
                            <div class="avatar bg-info bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-right-arrow text-info"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Forwarded</h6>
                                <h4 class="mb-0 text-info">1</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-warning bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-hard-drive text-warning"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Quota Used</h6>
                                <h4 class="mb-0 text-warning">8.4 GB</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Email Accounts List -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Email Address</th>
                                <th>Status</th>
                                <th>Quota Used</th>
                                <th>Forwarding</th>
                                <th>Auto Responder</th>
                                <th>Spam Filter</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-envelope text-primary me-2"></i>
                                        <strong>info@example.com</strong>
                                    </div>
                                </td>
                                <td><span class="badge bg-success">Active</span></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress me-2" style="width: 60px; height: 6px;">
                                            <div class="progress-bar bg-success" style="width: 48%"></div>
                                        </div>
                                        <small>2.4 / 5 GB</small>
                                    </div>
                                </td>
                                <td><span class="badge bg-secondary">Disabled</span></td>
                                <td><span class="badge bg-secondary">Disabled</span></td>
                                <td><span class="badge bg-success">Active</span></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a href="#" class="dropdown-item">
                                                <i class="bx bx-envelope-open me-2"></i> Access Webmail
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="bx bx-edit me-2"></i> Edit
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="bx bx-key me-2"></i> Change Password
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="bx bx-right-arrow me-2"></i> Forwarding
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="bx bx-bot me-2"></i> Auto Responder
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="bx bx-shield me-2"></i> Spam Filter
                                            </a>
                                            <div class="dropdown-divider"></div>
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
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-envelope text-primary me-2"></i>
                                        <strong>support@example.com</strong>
                                    </div>
                                </td>
                                <td><span class="badge bg-success">Active</span></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress me-2" style="width: 60px; height: 6px;">
                                            <div class="progress-bar bg-success" style="width: 36%"></div>
                                        </div>
                                        <small>1.8 / 5 GB</small>
                                    </div>
                                </td>
                                <td><span class="badge bg-info">Enabled</span></td>
                                <td><span class="badge bg-info">Enabled</span></td>
                                <td><span class="badge bg-success">Active</span></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a href="#" class="dropdown-item">
                                                <i class="bx bx-envelope-open me-2"></i> Access Webmail
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="bx bx-edit me-2"></i> Edit
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="bx bx-key me-2"></i> Change Password
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="bx bx-right-arrow me-2"></i> Forwarding
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="bx bx-bot me-2"></i> Auto Responder
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="bx bx-shield me-2"></i> Spam Filter
                                            </a>
                                            <div class="dropdown-divider"></div>
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
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-envelope text-primary me-2"></i>
                                        <strong>admin@example.com</strong>
                                    </div>
                                </td>
                                <td><span class="badge bg-success">Active</span></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress me-2" style="width: 60px; height: 6px;">
                                            <div class="progress-bar bg-warning" style="width: 84%"></div>
                                        </div>
                                        <small>4.2 / 10 GB</small>
                                    </div>
                                </td>
                                <td><span class="badge bg-secondary">Disabled</span></td>
                                <td><span class="badge bg-secondary">Disabled</span></td>
                                <td><span class="badge bg-success">Active</span></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a href="#" class="dropdown-item">
                                                <i class="bx bx-envelope-open me-2"></i> Access Webmail
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="bx bx-edit me-2"></i> Edit
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="bx bx-key me-2"></i> Change Password
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="bx bx-right-arrow me-2"></i> Forwarding
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="bx bx-bot me-2"></i> Auto Responder
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="bx bx-shield me-2"></i> Spam Filter
                                            </a>
                                            <div class="dropdown-divider"></div>
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
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-envelope text-primary me-2"></i>
                                        <strong>sales@example.com</strong>
                                    </div>
                                </td>
                                <td><span class="badge bg-info">Forwarded</span></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress me-2" style="width: 60px; height: 6px;">
                                            <div class="progress-bar bg-success" style="width: 0%"></div>
                                        </div>
                                        <small>0 / 5 GB</small>
                                    </div>
                                </td>
                                <td><span class="badge bg-info">Enabled</span></td>
                                <td><span class="badge bg-secondary">Disabled</span></td>
                                <td><span class="badge bg-success">Active</span></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a href="#" class="dropdown-item">
                                                <i class="bx bx-envelope-open me-2"></i> Access Webmail
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="bx bx-edit me-2"></i> Edit
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="bx bx-key me-2"></i> Change Password
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="bx bx-right-arrow me-2"></i> Forwarding
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="bx bx-bot me-2"></i> Auto Responder
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="bx bx-shield me-2"></i> Spam Filter
                                            </a>
                                            <div class="dropdown-divider"></div>
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
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-envelope text-primary me-2"></i>
                                        <strong>billing@example.com</strong>
                                    </div>
                                </td>
                                <td><span class="badge bg-danger">Disabled</span></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress me-2" style="width: 60px; height: 6px;">
                                            <div class="progress-bar bg-success" style="width: 0%"></div>
                                        </div>
                                        <small>0 / 5 GB</small>
                                    </div>
                                </td>
                                <td><span class="badge bg-secondary">Disabled</span></td>
                                <td><span class="badge bg-secondary">Disabled</span></td>
                                <td><span class="badge bg-danger">Disabled</span></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a href="#" class="dropdown-item text-success">
                                                <i class="bx bx-play me-2"></i> Enable
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="bx bx-edit me-2"></i> Edit
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="bx bx-key me-2"></i> Change Password
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="bx bx-right-arrow me-2"></i> Forwarding
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="bx bx-bot me-2"></i> Auto Responder
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="bx bx-shield me-2"></i> Spam Filter
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item text-danger">
                                                <i class="bx bx-trash me-2"></i> Delete
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Email Settings -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Email Settings</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="mb-3">Default Email Settings</h6>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="catchAll" checked>
                                            <label class="form-check-label" for="catchAll">
                                                Enable catch-all email
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="spamFilter" checked>
                                            <label class="form-check-label" for="spamFilter">
                                                Enable spam filtering
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="virusScan" checked>
                                            <label class="form-check-label" for="virusScan">
                                                Enable virus scanning
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="autoBackup" checked>
                                            <label class="form-check-label" for="autoBackup">
                                                Enable automatic backup
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="mb-3">Webmail Access</h6>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="webmailEnabled" checked>
                                            <label class="form-check-label" for="webmailEnabled">
                                                Enable webmail access
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="webmailSSL" checked>
                                            <label class="form-check-label" for="webmailSSL">
                                                Force SSL for webmail
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="webmailAuth" checked>
                                            <label class="form-check-label" for="webmailAuth">
                                                Enable two-factor authentication
                                            </label>
                                        </div>
                                        <div class="mb-3">
                                            <label for="webmailUrl" class="form-label">Webmail URL</label>
                                            <input type="text" class="form-control" id="webmailUrl" value="webmail.example.com" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-primary" onclick="saveEmailSettings()">
                                        <i class="bx bx-save me-1"></i> Save Settings
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
@endsection

@push('scripts')
<script>
function createEmail() {
    showNotification('Email creation dialog opened', 'info');
}

function accessWebmail() {
    showNotification('Opening webmail interface...', 'info');
}

function saveEmailSettings() {
    showNotification('Email settings saved successfully', 'success');
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
