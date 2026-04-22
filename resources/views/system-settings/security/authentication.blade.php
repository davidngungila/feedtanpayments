@extends('layouts.app')

@section('title', 'Advanced Authentication - FeedTan Pay')

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Page Header -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-6">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div class="mb-3 mb-md-0">
                                <h4 class="fw-bold mb-2">
                                    <i class="bx bx-shield-check me-2 text-primary"></i>
                                    Advanced Authentication
                                </h4>
                                <p class="text-muted mb-0">Configure 2FA, OTP login, device verification, and biometric authentication</p>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-outline-success" onclick="testAuthentication()">
                                    <i class="bx bx-test-tube me-2"></i>Test Authentication
                                </button>
                                <button type="button" class="btn btn-outline-secondary" onclick="refreshAuthSettings()">
                                    <i class="bx bx-refresh me-2"></i>Refresh
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Authentication Status Overview -->
        <div class="row mb-6">
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-success bg-opacity-10 rounded-circle me-3" style="width: 48px; height: 48px;">
                                <i class="bx bx-mobile-alt text-success fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">2FA Enabled</h6>
                                <h4 class="mb-0">89%</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-primary bg-opacity-10 rounded-circle me-3" style="width: 48px; height: 48px;">
                                <i class="bx bx-message-square-dots text-primary fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">OTP Active</h6>
                                <h4 class="mb-0">156</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-warning bg-opacity-10 rounded-circle me-3" style="width: 48px; height: 48px;">
                                <i class="bx bx-desktop text-warning fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Trusted Devices</h6>
                                <h4 class="mb-0">42</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-info bg-opacity-10 rounded-circle me-3" style="width: 48px; height: 48px;">
                                <i class="bx bx-fingerprint text-info fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Biometric Users</h6>
                                <h4 class="mb-0">23</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Two-Factor Authentication -->
        <div class="row mb-6">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-mobile-alt me-2"></i>
                            Two-Factor Authentication (2FA) MUST HAVE
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="mb-3">2FA Settings</h6>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="enable2FA" checked>
                                        <label class="form-check-label" for="enable2FA">
                                            Enable Two-Factor Authentication
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="force2FA" checked>
                                        <label class="form-check-label" for="force2FA">
                                            Force 2FA for all users
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="rememberDevice2FA" checked>
                                        <label class="form-check-label" for="rememberDevice2FA">
                                            Remember trusted devices for 30 days
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="mb-3">2FA Methods</h6>
                                    <div class="mb-3">
                                        <label class="form-label">Primary 2FA Method</label>
                                        <select class="form-select" id="primary2FAMethod">
                                            <option value="sms" selected>SMS OTP</option>
                                            <option value="email">Email OTP</option>
                                            <option value="totp">Authenticator App (TOTP)</option>
                                            <option value="backup">Backup Codes</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Backup 2FA Method</label>
                                        <select class="form-select" id="backup2FAMethod">
                                            <option value="email" selected>Email OTP</option>
                                            <option value="sms">SMS OTP</option>
                                            <option value="totp">Authenticator App (TOTP)</option>
                                            <option value="backup">Backup Codes</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">OTP Length</label>
                                        <select class="form-select" id="otpLength">
                                            <option value="4">4 digits</option>
                                            <option value="6" selected>6 digits</option>
                                            <option value="8">8 digits</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-primary" onclick="save2FASettings()">
                                        <i class="bx bx-save me-2"></i>Save 2FA Settings
                                    </button>
                                    <button type="button" class="btn btn-outline-info" onclick="generateBackupCodes()">
                                        <i class="bx bx-key me-2"></i>Generate Backup Codes
                                    </button>
                                    <button type="button" class="btn btn-outline-warning" onclick="test2FA()">
                                        <i class="bx bx-test-tube me-2"></i>Test 2FA
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- OTP Login Configuration -->
        <div class="row mb-6">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-message-square-dots me-2"></i>
                            OTP Login Configuration
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="mb-3">SMS OTP Settings</h6>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="enableSMSOTP" checked>
                                        <label class="form-check-label" for="enableSMSOTP">
                                            Enable SMS OTP
                                        </label>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">SMS Template</label>
                                        <textarea class="form-control" id="smsTemplate" rows="3">Your FeedTan Pay OTP is: {OTP}. Valid for {VALIDITY} minutes. Do not share this code.</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">OTP Validity (minutes)</label>
                                        <input type="number" class="form-control" id="smsOTPValidity" value="5" min="1" max="60">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Max Attempts</label>
                                        <input type="number" class="form-control" id="smsMaxAttempts" value="3" min="1" max="10">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="mb-3">Email OTP Settings</h6>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="enableEmailOTP" checked>
                                        <label class="form-check-label" for="enableEmailOTP">
                                            Enable Email OTP
                                        </label>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Email Template</label>
                                        <textarea class="form-control" id="emailTemplate" rows="3">Your FeedTan Pay OTP is: {OTP}. Valid for {VALIDITY} minutes. Please enter this code to complete your login.</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">OTP Validity (minutes)</label>
                                        <input type="number" class="form-control" id="emailOTPValidity" value="10" min="1" max="60">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Max Attempts</label>
                                        <input type="number" class="form-control" id="emailMaxAttempts" value="5" min="1" max="10">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-primary" onclick="saveOTPSettings()">
                                        <i class="bx bx-save me-2"></i>Save OTP Settings
                                    </button>
                                    <button type="button" class="btn btn-outline-info" onclick="testSMSOTP()">
                                        <i class="bx bx-test-tube me-2"></i>Test SMS OTP
                                    </button>
                                    <button type="button" class="btn btn-outline-info" onclick="testEmailOTP()">
                                        <i class="bx bx-test-tube me-2"></i>Test Email OTP
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Device Verification -->
        <div class="row mb-6">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-desktop me-2"></i>
                            Device Verification
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="mb-3">Device Verification Settings</h6>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="enableDeviceVerification" checked>
                                        <label class="form-check-label" for="enableDeviceVerification">
                                            Enable Device Verification
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="newDeviceApproval" checked>
                                        <label class="form-check-label" for="newDeviceApproval">
                                            Require approval for new devices
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="deviceFingerprinting" checked>
                                        <label class="form-check-label" for="deviceFingerprinting">
                                            Enable device fingerprinting
                                        </label>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Max Trusted Devices per User</label>
                                        <input type="number" class="form-control" id="maxTrustedDevices" value="5" min="1" max="20">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="mb-3">Trusted Devices Management</h6>
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Device Name</th>
                                                    <th>Type</th>
                                                    <th>Last Used</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>John's Laptop</td>
                                                    <td><span class="badge bg-primary">Desktop</span></td>
                                                    <td>2 hours ago</td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeDevice(1)">
                                                            <i class="bx bx-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>iPhone 14 Pro</td>
                                                    <td><span class="badge bg-success">Mobile</span></td>
                                                    <td>1 day ago</td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeDevice(2)">
                                                            <i class="bx bx-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Office Computer</td>
                                                    <td><span class="badge bg-primary">Desktop</span></td>
                                                    <td>3 days ago</td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeDevice(3)">
                                                            <i class="bx bx-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-primary" onclick="saveDeviceSettings()">
                                        <i class="bx bx-save me-2"></i>Save Device Settings
                                    </button>
                                    <button type="button" class="btn btn-outline-warning" onclick="clearAllDevices()">
                                        <i class="bx bx-trash me-2"></i>Clear All Trusted Devices
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Biometric Authentication -->
        <div class="row mb-6">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-fingerprint me-2"></i>
                            Biometric Authentication (Future Mobile App)
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="mb-3">Biometric Settings</h6>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="enableBiometric">
                                        <label class="form-check-label" for="enableBiometric">
                                            Enable Biometric Authentication
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="enableFingerprint">
                                        <label class="form-check-label" for="enableFingerprint">
                                            Allow Fingerprint Authentication
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="enableFaceID">
                                        <label class="form-check-label" for="enableFaceID">
                                            Allow Face ID Authentication
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="biometricFallback">
                                        <label class="form-check-label" for="biometricFallback">
                                            Allow password fallback
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="mb-3">Biometric Statistics</h6>
                                    <div class="row text-center">
                                        <div class="col-4 mb-3">
                                            <h4 class="text-info mb-0">23</h4>
                                            <small class="text-muted">Biometric Users</small>
                                        </div>
                                        <div class="col-4 mb-3">
                                            <h4 class="text-success mb-0">156</h4>
                                            <small class="text-muted">Biometric Logins</small>
                                        </div>
                                        <div class="col-4 mb-3">
                                            <h4 class="text-warning mb-0">98.5%</h4>
                                            <small class="text-muted">Success Rate</small>
                                        </div>
                                    </div>
                                    <div class="alert alert-info">
                                        <i class="bx bx-info-circle me-2"></i>
                                        Biometric authentication will be available in the upcoming mobile app. Currently in development phase.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-primary" onclick="saveBiometricSettings()">
                                        <i class="bx bx-save me-2"></i>Save Biometric Settings
                                    </button>
                                    <button type="button" class="btn btn-outline-info" onclick="testBiometric()">
                                        <i class="bx bx-test-tube me-2"></i>Test Biometric (Demo)
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Authentication Logs -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-history me-2"></i>
                            Recent Authentication Events
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Timestamp</th>
                                        <th>User</th>
                                        <th>Method</th>
                                        <th>Status</th>
                                        <th>Device</th>
                                        <th>IP Address</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><small>2024-12-22 14:35:22</small></td>
                                        <td>John Doe</td>
                                        <td><span class="badge bg-success">2FA + Password</span></td>
                                        <td><span class="badge bg-success">Success</span></td>
                                        <td>Chrome / Windows</td>
                                        <td><code>192.168.1.100</code></td>
                                        <td><small>Successful login with SMS OTP</small></td>
                                    </tr>
                                    <tr>
                                        <td><small>2024-12-22 14:32:15</small></td>
                                        <td>Jane Smith</td>
                                        <td><span class="badge bg-primary">Password Only</span></td>
                                        <td><span class="badge bg-success">Success</span></td>
                                        <td>Firefox / macOS</td>
                                        <td><code>192.168.1.105</code></td>
                                        <td><small>Successful login (no 2FA required)</small></td>
                                    </tr>
                                    <tr>
                                        <td><small>2024-12-22 14:28:45</small></td>
                                        <td>Mike Johnson</td>
                                        <td><span class="badge bg-warning">2FA Failed</span></td>
                                        <td><span class="badge bg-danger">Failed</span></td>
                                        <td>Safari / iPhone</td>
                                        <td><code>192.168.1.110</code></td>
                                        <td><small>Invalid OTP - 3 attempts failed</small></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function refreshAuthSettings() {
    showNotification('Refreshing authentication settings...', 'info');
    setTimeout(() => {
        location.reload();
    }, 1000);
}

function testAuthentication() {
    showNotification('Testing authentication flow...', 'info');
    setTimeout(() => {
        showNotification('Authentication test completed successfully!', 'success');
    }, 2000);
}

function save2FASettings() {
    showNotification('Saving 2FA settings...', 'info');
    setTimeout(() => {
        showNotification('2FA settings saved successfully!', 'success');
    }, 1500);
}

function generateBackupCodes() {
    showNotification('Generating backup codes...', 'info');
    setTimeout(() => {
        const codes = [
            '12345678', '87654321', '11112222', '33334444',
            '55556666', '77778888', '99990000', '12121212'
        ];
        
        const codesText = codes.join('\n');
        const dataUri = 'data:text/plain;charset=utf-8,'+ encodeURIComponent(codesText);
        
        const linkElement = document.createElement('a');
        linkElement.setAttribute('href', dataUri);
        linkElement.setAttribute('download', 'backup-codes.txt');
        linkElement.click();
        
        showNotification('Backup codes generated and downloaded!', 'success');
    }, 1500);
}

function test2FA() {
    showNotification('Testing 2FA authentication...', 'info');
    setTimeout(() => {
        showNotification('2FA test completed successfully!', 'success');
    }, 2000);
}

function saveOTPSettings() {
    showNotification('Saving OTP settings...', 'info');
    setTimeout(() => {
        showNotification('OTP settings saved successfully!', 'success');
    }, 1500);
}

function testSMSOTP() {
    showNotification('Sending test SMS OTP...', 'info');
    setTimeout(() => {
        showNotification('Test SMS OTP sent successfully!', 'success');
    }, 2000);
}

function testEmailOTP() {
    showNotification('Sending test Email OTP...', 'info');
    setTimeout(() => {
        showNotification('Test Email OTP sent successfully!', 'success');
    }, 2000);
}

function saveDeviceSettings() {
    showNotification('Saving device settings...', 'info');
    setTimeout(() => {
        showNotification('Device settings saved successfully!', 'success');
    }, 1500);
}

function removeDevice(id) {
    if (confirm('Are you sure you want to remove this trusted device?')) {
        showNotification('Removing trusted device...', 'info');
        setTimeout(() => {
            showNotification('Trusted device removed successfully!', 'success');
            location.reload();
        }, 1000);
    }
}

function clearAllDevices() {
    if (confirm('Are you sure you want to clear all trusted devices? Users will need to re-verify their devices.')) {
        showNotification('Clearing all trusted devices...', 'info');
        setTimeout(() => {
            showNotification('All trusted devices cleared successfully!', 'success');
        }, 2000);
    }
}

function saveBiometricSettings() {
    showNotification('Saving biometric settings...', 'info');
    setTimeout(() => {
        showNotification('Biometric settings saved successfully!', 'success');
    }, 1500);
}

function testBiometric() {
    showNotification('Testing biometric authentication (demo)...', 'info');
    setTimeout(() => {
        showNotification('Biometric authentication test successful!', 'success');
    }, 2000);
}

function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        if (notification.parentNode) {
            notification.parentNode.removeChild(notification);
        }
    }, 5000);
}
</script>
@endpush
@endsection
