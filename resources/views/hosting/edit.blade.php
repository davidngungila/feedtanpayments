@extends('layouts.app')

@section('title', 'Edit Website - ' . $website['domain'])
@section('description', 'Edit website configuration and settings')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Edit Website</h5>
                <p class="card-subtitle">Edit website configuration and settings</p>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('hosting.update', $website['id']) }}">
                    @csrf
                    @method('PUT')
                    
                    <!-- Basic Information -->
                    <div class="mb-4">
                        <h6 class="mb-3">Basic Information</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="domain" class="form-label">Domain Name</label>
                                <input type="text" class="form-control" id="domain" name="domain" value="{{ $website['domain'] }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="server" class="form-label">Target Server</label>
                                <select class="form-select" id="server" name="server">
                                    <option value="web-server-01" {{ $website['server'] == 'web-server-01' ? 'selected' : '' }}>web-server-01 (Primary)</option>
                                    <option value="app-server-02" {{ $website['server'] == 'app-server-02' ? 'selected' : '' }}>app-server-02 (Application)</option>
                                    <option value="web-server-01" {{ $website['server'] == 'web-server-01' ? 'selected' : '' }}>web-server-01 (Shared)</option>
                                    <option value="test-server-06" {{ $website['server'] == 'test-server-06' ? 'selected' : '' }}>test-server-06 (Development)</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="php_version" class="form-label">PHP Version</label>
                                <select class="form-select" id="php_version" name="php_version">
                                    <option value="8.2" {{ $website['php_version'] == '8.2' ? 'selected' : '' }}>PHP 8.2</option>
                                    <option value="8.1" {{ $website['php_version'] == '8.1' ? 'selected' : '' }}>PHP 8.1</option>
                                    <option value="8.0" {{ $website['php_version'] == '8.0' ? 'selected' : '' }}>PHP 8.0</option>
                                    <option value="7.4" {{ $website['php_version'] == '7.4' ? 'selected' : '' }}>PHP 7.4</option>
                                    <option value="none" {{ $website['php_version'] == 'none' ? 'selected' : '' }}>No PHP</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="active" {{ $website['status'] == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="suspended" {{ $website['status'] == 'suspended' ? 'selected' : '' }}>Suspended</option>
                                    <option value="disabled" {{ $website['status'] == 'disabled' ? 'selected' : '' }}>Disabled</option>
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="2" placeholder="Brief description of the website purpose"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Resource Limits -->
                    <div class="mb-4">
                        <h6 class="mb-3">Resource Limits</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="disk_limit" class="form-label">Disk Limit (GB)</label>
                                <input type="number" class="form-control" id="disk_limit" name="disk_limit" value="{{ $website['disk_limit'] }}" min="1" max="1000">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="bandwidth_limit" class="form-label">Bandwidth Limit (GB)</label>
                                <input type="number" class="form-control" id="bandwidth_limit" name="bandwidth_limit" value="{{ $website['bandwidth_limit'] }}" min="1" max="10000">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email_accounts" class="form-label">Email Accounts</label>
                                <input type="number" class="form-control" id="email_accounts" name="email_accounts" value="{{ $website['email_accounts'] }}" min="0" max="100">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="subdomains" class="form-label">Subdomains</label>
                                <input type="number" class="form-control" id="subdomains" name="subdomains" value="{{ $website['subdomains'] }}" min="0" max="50">
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

                    <!-- Features -->
                    <div class="mb-4">
                        <h6 class="mb-3">Website Features</h6>
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
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="cdn_enabled" name="cdn_enabled">
                                    <label class="form-check-label" for="cdn_enabled">
                                        Enable CDN Integration
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('hosting.show', $website['id']) }}" class="btn btn-outline-secondary">
                            <i class="bx bx-arrow-left me-1"></i> Cancel
                        </a>
                        <div>
                            <button type="button" class="btn btn-outline-warning me-2" onclick="testWebsite()">
                                <i class="bx bx-test-tube me-1"></i> Test Website
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-save me-1"></i> Update Website
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
function testWebsite() {
    showNotification('Website test initiated', 'info');
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
