@extends('layouts.app')

@section('title', 'Security Settings')
@section('description', 'Manage your security settings and preferences')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Security Settings</h5>
                <p class="card-subtitle">Manage your account security and authentication preferences</p>
            </div>
            <div class="card-body">
                <!-- Password Change -->
                <div class="mb-6">
                    <h6 class="mb-3">Change Password</h6>
                    <form>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="currentPassword" class="form-label">Current Password</label>
                                <input type="password" class="form-control" id="currentPassword">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="newPassword" class="form-label">New Password</label>
                                <input type="password" class="form-control" id="newPassword">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="confirmPassword" class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" id="confirmPassword">
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary" onclick="changePassword()">Update Password</button>
                    </form>
                </div>

                <!-- Two-Factor Authentication -->
                <div class="mb-6">
                    <h6 class="mb-3">Two-Factor Authentication</h6>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h6 class="mb-1">Authenticator App</h6>
                                    <small class="text-muted">Use an authenticator app to generate one-time passwords</small>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="2faEnabled">
                                    <label class="form-check-label" for="2faEnabled"></label>
                                </div>
                            </div>
                            <p class="text-muted mb-3">When enabled, you'll need to enter a code from your authenticator app when logging in.</p>
                            <button class="btn btn-outline-primary btn-sm">Setup Authenticator</button>
                        </div>
                    </div>
                </div>

                <!-- Login Activity -->
                <div class="mb-6">
                    <h6 class="mb-3">Recent Login Activity</h6>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Date & Time</th>
                                    <th>IP Address</th>
                                    <th>Device</th>
                                    <th>Location</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Dec 22, 2024 14:30:00</td>
                                    <td>192.168.1.100</td>
                                    <td>Chrome / Windows</td>
                                    <td>New York, US</td>
                                    <td><span class="badge bg-success">Success</span></td>
                                </tr>
                                <tr>
                                    <td>Dec 22, 2024 09:15:00</td>
                                    <td>192.168.1.100</td>
                                    <td>Chrome / Windows</td>
                                    <td>New York, US</td>
                                    <td><span class="badge bg-success">Success</span></td>
                                </tr>
                                <tr>
                                    <td>Dec 21, 2024 16:45:00</td>
                                    <td>192.168.1.101</td>
                                    <td>Firefox / Mac</td>
                                    <td>Los Angeles, US</td>
                                    <td><span class="badge bg-danger">Failed</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Active Sessions -->
                <div class="mb-6">
                    <h6 class="mb-3">Active Sessions</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="card border">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1">Chrome on Windows</h6>
                                            <small class="text-muted">192.168.1.100 • New York, US</small>
                                            <br><small class="text-muted">Last active: 2 minutes ago</small>
                                        </div>
                                        <span class="badge bg-success">Current</span>
                                    </div>
                                    <button class="btn btn-outline-danger btn-sm mt-2">Revoke</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card border">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1">Safari on iPhone</h6>
                                            <small class="text-muted">192.168.1.102 • New York, US</small>
                                            <br><small class="text-muted">Last active: 1 hour ago</small>
                                        </div>
                                        <span class="badge bg-secondary">Active</span>
                                    </div>
                                    <button class="btn btn-outline-danger btn-sm mt-2">Revoke</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Security Preferences -->
                <div class="mb-6">
                    <h6 class="mb-3">Security Preferences</h6>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="emailNotifications" checked>
                                <label class="form-check-label" for="emailNotifications">
                                    Email notifications for login attempts
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="smsAlerts">
                                <label class="form-check-label" for="smsAlerts">
                                    SMS alerts for suspicious activity
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="sessionTimeout" checked>
                                <label class="form-check-label" for="sessionTimeout">
                                    Auto-logout after 30 minutes of inactivity
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="ipWhitelist">
                                <label class="form-check-label" for="ipWhitelist">
                                    Restrict access to trusted IP addresses only
                                </label>
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
function changePassword() {
    showNotification('Password updated successfully', 'success');
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
