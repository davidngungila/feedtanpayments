@extends('layouts.app')

@section('title', 'Security Settings - FeedTan Pay')
@section('description', 'FeedTan Pay - Manage your account security settings')

@section('content')
<div class="row">
    <div class="col-md-4">
        <!-- Security Score -->
        <div class="card mb-6">
            <div class="card-body">
                <div class="text-center">
                    <div class="position-relative d-inline-block">
                        <div class="circular-progress mb-4">
                            <svg width="120" height="120">
                                <circle cx="60" cy="60" r="50" fill="none" stroke="#e9ecef" stroke-width="10"/>
                                <circle cx="60" cy="60" r="50" fill="none" stroke="#28a745" stroke-width="10"
                                        stroke-dasharray="314" stroke-dashoffset="63" stroke-linecap="round"
                                        transform="rotate(-90 60 60)"/>
                            </svg>
                            <div class="progress-text">
                                <h3 class="mb-0">85%</h3>
                                <small class="text-muted">Secure</small>
                            </div>
                        </div>
                    </div>
                    <h5 class="mb-2">Security Score</h5>
                    <p class="text-muted">Your account is well protected. Keep up the good work!</p>
                </div>
                
                <div class="mt-4">
                    <div class="d-flex justify-content-between mb-2">
                        <small>Strong Password</small>
                        <i class="bx bx-check-circle text-success"></i>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <small>2FA Enabled</small>
                        <i class="bx bx-check-circle text-success"></i>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <small>Recent Login Check</small>
                        <i class="bx bx-check-circle text-success"></i>
                    </div>
                    <div class="d-flex justify-content-between">
                        <small>Security Questions</small>
                        <i class="bx bx-x-circle text-danger"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button class="btn btn-outline-primary" onclick="changePassword()">
                        <i class="bx bx-key me-2"></i>Change Password
                    </button>
                    <button class="btn btn-outline-success" onclick="setup2FA()">
                        <i class="bx bx-shield me-2"></i>Setup 2FA
                    </button>
                    <button class="btn btn-outline-warning" onclick="reviewSessions()">
                        <i class="bx bx-devices me-2"></i>Active Sessions
                    </button>
                    <button class="btn btn-outline-info" onclick="securityCheckup()">
                        <i class="bx bx-check-shield me-2"></i>Security Checkup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <!-- Password Settings -->
        <div class="card mb-6">
            <div class="card-header">
                <h5 class="card-title mb-0">Password Settings</h5>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <h6 class="mb-1">Password Strength</h6>
                        <p class="text-muted mb-0">Last changed: 30 days ago</p>
                    </div>
                    <div class="text-end">
                        <div class="badge bg-success mb-2">Strong</div>
                        <div class="progress" style="width: 150px; height: 8px;">
                            <div class="progress-bar bg-success" style="width: 85%"></div>
                        </div>
                    </div>
                </div>
                
                <div class="alert alert-info">
                    <i class="bx bx-info-circle me-2"></i>
                    <strong>Tip:</strong> Use a mix of uppercase, lowercase, numbers, and special characters for maximum security.
                </div>
                
                <button class="btn btn-primary" onclick="changePassword()">
                    <i class="bx bx-key me-2"></i>Change Password
                </button>
            </div>
        </div>

        <!-- Two-Factor Authentication -->
        <div class="card mb-6">
            <div class="card-header">
                <h5 class="card-title mb-0">Two-Factor Authentication</h5>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <h6 class="mb-1">Authentication Status</h6>
                        <p class="text-muted mb-0">Add an extra layer of security to your account</p>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="2faToggle" checked>
                        <label class="form-check-label" for="2faToggle"></label>
                    </div>
                </div>
                
                <div class="mb-4">
                    <h6 class="mb-3">Enabled Methods</h6>
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-success bg-opacity-10 rounded-circle me-3">
                                <i class="bx bx-mobile text-success"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">SMS Authentication</h6>
                                <small class="text-muted">+1 (555) ***-4567</small>
                            </div>
                        </div>
                        <button class="btn btn-sm btn-outline-primary">Configure</button>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-primary bg-opacity-10 rounded-circle me-3">
                                <i class="bx bx-mobile-alt text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Authenticator App</h6>
                                <small class="text-muted">Google Authenticator</small>
                            </div>
                        </div>
                        <button class="btn btn-sm btn-outline-primary">Configure</button>
                    </div>
                </div>
                
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-success" onclick="setup2FA()">
                        <i class="bx bx-plus me-2"></i>Add Method
                    </button>
                    <button class="btn btn-outline-warning" onclick="generateBackupCodes()">
                        <i class="bx bx-key me-2"></i>Backup Codes
                    </button>
                </div>
            </div>
        </div>

        <!-- Active Sessions -->
        <div class="card mb-6">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Active Sessions</h5>
                <button class="btn btn-sm btn-outline-danger" onclick="terminateAllSessions()">
                    <i class="bx bx-x-circle me-1"></i>Terminate All
                </button>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="d-flex align-items-center">
                        <div class="avatar bg-primary bg-opacity-10 rounded-circle me-3">
                            <i class="bx bx-laptop text-primary"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">Chrome on Windows</h6>
                            <small class="text-muted">San Francisco, CA - Current session</small>
                        </div>
                    </div>
                    <span class="badge bg-success">Current</span>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="d-flex align-items-center">
                        <div class="avatar bg-info bg-opacity-10 rounded-circle me-3">
                            <i class="bx bx-mobile text-info"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">iPhone 13 Pro</h6>
                            <small class="text-muted">San Francisco, CA - 2 hours ago</small>
                        </div>
                    </div>
                    <button class="btn btn-sm btn-outline-danger">Terminate</button>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="d-flex align-items-center">
                        <div class="avatar bg-warning bg-opacity-10 rounded-circle me-3">
                            <i class="bx bx-tablet text-warning"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">iPad Pro</h6>
                            <small class="text-muted">Los Angeles, CA - 1 day ago</small>
                        </div>
                    </div>
                    <button class="btn btn-sm btn-outline-danger">Terminate</button>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="avatar bg-secondary bg-opacity-10 rounded-circle me-3">
                            <i class="bx bx-desktop text-secondary"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">Chrome on macOS</h6>
                            <small class="text-muted">New York, NY - 3 days ago</small>
                        </div>
                    </div>
                    <button class="btn btn-sm btn-outline-danger">Terminate</button>
                </div>
            </div>
        </div>

        <!-- Login History -->
        <div class="card mb-6">
            <div class="card-header">
                <h5 class="card-title mb-0">Login History</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Date & Time</th>
                                <th>Device</th>
                                <th>Location</th>
                                <th>IP Address</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Dec 15, 2024 10:30 AM</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-laptop me-2"></i>
                                        Chrome on Windows
                                    </div>
                                </td>
                                <td>San Francisco, CA</td>
                                <td>192.168.1.100</td>
                                <td><span class="badge bg-success">Success</span></td>
                            </tr>
                            <tr>
                                <td>Dec 15, 2024 08:15 AM</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-mobile me-2"></i>
                                        iPhone 13 Pro
                                    </div>
                                </td>
                                <td>San Francisco, CA</td>
                                <td>192.168.1.101</td>
                                <td><span class="badge bg-success">Success</span></td>
                            </tr>
                            <tr>
                                <td>Dec 14, 2024 09:45 PM</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-tablet me-2"></i>
                                        iPad Pro
                                    </div>
                                </td>
                                <td>Los Angeles, CA</td>
                                <td>192.168.1.102</td>
                                <td><span class="badge bg-success">Success</span></td>
                            </tr>
                            <tr>
                                <td>Dec 13, 2024 11:20 AM</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-desktop me-2"></i>
                                        Chrome on macOS
                                    </div>
                                </td>
                                <td>New York, NY</td>
                                <td>192.168.1.103</td>
                                <td><span class="badge bg-danger">Failed</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Security Alerts -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Security Alerts</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-warning mb-3">
                    <i class="bx bx-error me-2"></i>
                    <strong>Suspicious Login Attempt:</strong> Failed login from unusual location detected on Dec 13, 2024.
                </div>
                <div class="alert alert-info mb-3">
                    <i class="bx bx-info-circle me-2"></i>
                    <strong>New Device:</strong> New iPad Pro device registered on Dec 14, 2024.
                </div>
                <div class="alert alert-success">
                    <i class="bx bx-check-circle me-2"></i>
                    <strong>Password Changed:</strong> Your password was successfully changed on Nov 15, 2024.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="changePasswordForm">
                    <div class="mb-4">
                        <label for="currentPassword" class="form-label">Current Password</label>
                        <input type="password" class="form-control" id="currentPassword" required>
                    </div>
                    <div class="mb-4">
                        <label for="newPassword" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="newPassword" required>
                        <div class="progress mt-2" style="height: 6px;">
                            <div class="progress-bar" id="passwordStrength" style="width: 0%"></div>
                        </div>
                        <small class="text-muted">Use 8+ characters with mixed case, numbers, and symbols</small>
                    </div>
                    <div class="mb-4">
                        <label for="confirmPassword" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="confirmPassword" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="updatePassword()">Update Password</button>
            </div>
        </div>
    </div>
</div>

<!-- Setup 2FA Modal -->
<div class="modal fade" id="setup2FAModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Setup Two-Factor Authentication</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <div class="qr-code mb-3">
                        <div class="bg-light p-4 rounded" style="width: 200px; height: 200px; margin: 0 auto; display: flex; align-items: center; justify-content: center;">
                            <i class="bx bx-qr" style="font-size: 4rem;"></i>
                        </div>
                    </div>
                    <p class="text-muted">Scan this QR code with your authenticator app</p>
                </div>
                <div class="mb-4">
                    <label for="verificationCode" class="form-label">Verification Code</label>
                    <input type="text" class="form-control" id="verificationCode" placeholder="Enter 6-digit code" maxlength="6">
                </div>
                <div class="alert alert-info">
                    <i class="bx bx-info-circle me-2"></i>
                    <strong>Can't scan?</strong> Enter this code manually: <code>123456</code>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="verify2FA()">Verify & Enable</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.circular-progress {
    position: relative;
    display: inline-block;
}

.progress-text {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
}

.qr-code {
    background: #f8f9fa;
    border: 2px dashed #dee2e6;
    border-radius: 8px;
    padding: 20px;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Password strength checker
    const newPasswordInput = document.getElementById('newPassword');
    const passwordStrengthBar = document.getElementById('passwordStrength');
    
    if (newPasswordInput) {
        newPasswordInput.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;
            
            if (password.length >= 8) strength += 25;
            if (password.match(/[a-z]/)) strength += 25;
            if (password.match(/[A-Z]/)) strength += 25;
            if (password.match(/[0-9]/)) strength += 25;
            
            passwordStrengthBar.style.width = strength + '%';
            
            if (strength < 50) {
                passwordStrengthBar.className = 'progress-bar bg-danger';
            } else if (strength < 75) {
                passwordStrengthBar.className = 'progress-bar bg-warning';
            } else {
                passwordStrengthBar.className = 'progress-bar bg-success';
            }
        });
    }
});

function changePassword() {
    const modal = new bootstrap.Modal(document.getElementById('changePasswordModal'));
    modal.show();
}

function updatePassword() {
    const currentPassword = document.getElementById('currentPassword').value;
    const newPassword = document.getElementById('newPassword').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    
    if (!currentPassword || !newPassword || !confirmPassword) {
        alert('Please fill in all fields');
        return;
    }
    
    if (newPassword !== confirmPassword) {
        alert('New passwords do not match');
        return;
    }
    
    if (newPassword.length < 8) {
        alert('Password must be at least 8 characters long');
        return;
    }
    
    // Show loading state
    const updateBtn = document.querySelector('#changePasswordModal .btn-primary');
    updateBtn.disabled = true;
    updateBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin me-2"></i>Updating...';
    
    // Simulate API call
    setTimeout(() => {
        updateBtn.disabled = false;
        updateBtn.innerHTML = 'Update Password';
        
        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('changePasswordModal'));
        modal.hide();
        
        alert('Password updated successfully!');
        
        // Clear form
        document.getElementById('changePasswordForm').reset();
    }, 1500);
}

function setup2FA() {
    const modal = new bootstrap.Modal(document.getElementById('setup2FAModal'));
    modal.show();
}

function verify2FA() {
    const code = document.getElementById('verificationCode').value;
    
    if (!code || code.length !== 6) {
        alert('Please enter a valid 6-digit verification code');
        return;
    }
    
    // Show loading state
    const verifyBtn = document.querySelector('#setup2FAModal .btn-primary');
    verifyBtn.disabled = true;
    verifyBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin me-2"></i>Verifying...';
    
    // Simulate API call
    setTimeout(() => {
        verifyBtn.disabled = false;
        verifyBtn.innerHTML = 'Verify & Enable';
        
        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('setup2FAModal'));
        modal.hide();
        
        alert('Two-factor authentication enabled successfully!');
        
        // Clear form
        document.getElementById('verificationCode').value = '';
    }, 1500);
}

function generateBackupCodes() {
    alert('Generating backup codes...\n\n1. 123456\n2. 789012\n3. 345678\n4. 901234\n5. 567890\n\nSave these codes in a safe place!');
}

function reviewSessions() {
    alert('Reviewing active sessions...\n\nCurrent sessions:\n- Chrome on Windows (Current)\n- iPhone 13 Pro\n- iPad Pro\n- Chrome on macOS');
}

function securityCheckup() {
    alert('Running security checkup...\n\nSecurity Status:\n\n- Password Strength: Strong\n- 2FA Status: Enabled\n- Active Sessions: 4\n- Recent Logins: All secure\n- Connected Accounts: 3\n\nOverall Security Score: 85%');
}

function terminateAllSessions() {
    if (confirm('Are you sure you want to terminate all sessions except the current one? You will need to log in again on other devices.')) {
        alert('All other sessions terminated successfully!');
    }
}
</script>
@endpush
