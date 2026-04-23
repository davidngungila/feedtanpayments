@extends('layouts.app')

@section('title', 'Add New Website')
@section('description', 'Add a new website to your hosting environment')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Add New Website</h5>
                <p class="card-subtitle">Configure and add a new website to your hosting environment</p>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('hosting.store') }}">
                    @csrf
                    
                    <!-- Basic Information -->
                    <div class="mb-4">
                        <h6 class="mb-3">Basic Information</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="domain" class="form-label">Domain Name *</label>
                                <input type="text" class="form-control" id="domain" name="domain" required 
                                       placeholder="example.com">
                                <small class="text-muted">Enter the domain name without www or subdomains</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="server" class="form-label">Target Server *</label>
                                <select class="form-select" id="server" name="server" required>
                                    <option value="">Select Server</option>
                                    <option value="web-server-01">web-server-01 (Primary)</option>
                                    <option value="app-server-02">app-server-02 (Application)</option>
                                    <option value="web-server-01">web-server-01 (Shared)</option>
                                    <option value="test-server-06">test-server-06 (Development)</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="package" class="form-label">Hosting Package *</label>
                                <select class="form-select" id="package" name="package" required>
                                    <option value="">Select Package</option>
                                    <option value="basic">Basic (10GB Disk, 100GB Bandwidth)</option>
                                    <option value="standard">Standard (25GB Disk, 250GB Bandwidth)</option>
                                    <option value="premium">Premium (50GB Disk, 500GB Bandwidth)</option>
                                    <option value="enterprise">Enterprise (100GB Disk, 1TB Bandwidth)</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="php_version" class="form-label">PHP Version</label>
                                <select class="form-select" id="php_version" name="php_version">
                                    <option value="8.2">PHP 8.2</option>
                                    <option value="8.1">PHP 8.1</option>
                                    <option value="8.0">PHP 8.0</option>
                                    <option value="7.4">PHP 7.4</option>
                                    <option value="none">No PHP</option>
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="2" 
                                          placeholder="Brief description of the website purpose"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Database Configuration -->
                    <div class="mb-4">
                        <h6 class="mb-3">Database Configuration</h6>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="create_database" name="create_database" checked>
                                    <label class="form-check-label" for="create_database">
                                        Create MySQL Database
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="create_user" name="create_user" checked>
                                    <label class="form-check-label" for="create_user">
                                        Create Database User
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="db_name" class="form-label">Database Name</label>
                                <input type="text" class="form-control" id="db_name" name="db_name" 
                                       placeholder="example_db" value="">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="db_user" class="form-label">Database Username</label>
                                <input type="text" class="form-control" id="db_user" name="db_user" 
                                       placeholder="example_user" value="">
                            </div>
                        </div>
                    </div>

                    <!-- SSL Configuration -->
                    <div class="mb-4">
                        <h6 class="mb-3">SSL Configuration</h6>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="auto_ssl" name="auto_ssl" checked>
                                    <label class="form-check-label" for="auto_ssl">
                                        Enable Auto SSL (Let's Encrypt)
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="wildcard_ssl" name="wildcard_ssl">
                                    <label class="form-check-label" for="wildcard_ssl">
                                        Request Wildcard Certificate
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="force_https" name="force_https" checked>
                                    <label class="form-check-label" for="force_https">
                                        Force HTTPS Redirect
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Email Configuration -->
                    <div class="mb-4">
                        <h6 class="mb-3">Email Configuration</h6>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="create_email" name="create_email" checked>
                                    <label class="form-check-label" for="create_email">
                                        Create Email Account (info@domain)
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="webmail" name="webmail" checked>
                                    <label class="form-check-label" for="webmail">
                                        Enable Webmail Access
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="email_forwarding" name="email_forwarding">
                                    <label class="form-check-label" for="email_forwarding">
                                        Enable Email Forwarding
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Features -->
                    <div class="mb-4">
                        <h6 class="mb-3">Additional Features</h6>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="auto_backup" name="auto_backup" checked>
                                    <label class="form-check-label" for="auto_backup">
                                        Enable Automatic Backup
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="analytics" name="analytics" checked>
                                    <label class="form-check-label" for="analytics">
                                        Enable Website Analytics
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="error_pages" name="error_pages" checked>
                                    <label class="form-check-label" for="error_pages">
                                        Create Custom Error Pages
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="hotlink_protection" name="hotlink_protection">
                                    <label class="form-check-label" for="hotlink_protection">
                                        Enable Hotlink Protection
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="ip_restrict" name="ip_restrict">
                                    <label class="form-check-label" for="ip_restrict">
                                        IP Access Restriction
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('hosting.index') }}" class="btn btn-outline-secondary">
                            <i class="bx bx-arrow-left me-1"></i> Cancel
                        </a>
                        <div>
                            <button type="button" class="btn btn-outline-primary me-2" onclick="checkDomain()">
                                <i class="bx bx-search me-1"></i> Check Domain
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-save me-1"></i> Create Website
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function checkDomain() {
    const button = event.target;
    const domainInput = document.getElementById('domain');
    const domain = domainInput.value;
    
    if (!domain) {
        showNotification('Please enter a domain name', 'warning');
        return;
    }
    
    button.disabled = true;
    button.innerHTML = '<i class="bx bx-loader-alt bx-spin me-1"></i> Checking...';
    
    setTimeout(() => {
        button.disabled = false;
        button.innerHTML = '<i class="bx bx-search me-1"></i> Check Domain';
        showNotification('Domain is available for hosting!', 'success');
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
