@extends('layouts.app')

@section('title', 'Create Email Account')
@section('description', 'Create new email account')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Create Email Account</h5>
                <p class="card-subtitle">Create a new email account for your domain</p>
            </div>
            <div class="card-body">
                <form>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="domain" class="form-label">Domain</label>
                                <select class="form-select" id="domain" required>
                                    <option value="">Select Domain</option>
                                    @foreach($domains as $domain)
                                    <option value="{{ $domain }}">{{ $domain }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" placeholder="Enter username" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" placeholder="Enter password" required>
                                <button type="button" class="btn btn-outline-secondary btn-sm mt-2" onclick="generatePassword()">
                                    <i class="bx bx-refresh me-1"></i> Generate Password
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="confirmPassword" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm password" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="quota" class="form-label">Mailbox Quota</label>
                                <select class="form-select" id="quota" required>
                                    <option value="">Select Quota</option>
                                    @foreach($quotas as $quota)
                                    <option value="{{ $quota }}">{{ $quota }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="quotaWarning" class="form-label">Quota Warning Level (%)</label>
                                <input type="number" class="form-control" id="quotaWarning" value="80" min="50" max="95">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Additional Features</label>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="enableForwarding">
                                            <label class="form-check-label" for="enableForwarding">
                                                Enable Forwarding
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="enableAutoResponder">
                                            <label class="form-check-label" for="enableAutoResponder">
                                                Enable Auto Responder
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="enableSpamFilter" checked>
                                            <label class="form-check-label" for="enableSpamFilter">
                                                Enable Spam Filter
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="enableVirusScan" checked>
                                            <label class="form-check-label" for="enableVirusScan">
                                                Enable Virus Scan
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="forwardingOptions" style="display: none;">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="forwardTo" class="form-label">Forward To</label>
                                <input type="email" class="form-control" id="forwardTo" placeholder="Enter forwarding email address">
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" id="keepCopy">
                                    <label class="form-check-label" for="keepCopy">
                                        Keep copy in mailbox
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="autoResponderOptions" style="display: none;">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="autoResponderSubject" class="form-label">Auto Responder Subject</label>
                                <input type="text" class="form-control" id="autoResponderSubject" placeholder="Enter subject">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="autoResponderMessage" class="form-label">Auto Responder Message</label>
                                <textarea class="form-control" id="autoResponderMessage" rows="4" placeholder="Enter message"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-outline-secondary" onclick="resetForm()">
                                    <i class="bx bx-reset me-1"></i> Reset
                                </button>
                                <div>
                                    <button type="button" class="btn btn-outline-primary me-2" onclick="testEmail()">
                                        <i class="bx bx-test-tube me-1"></i> Test Email
                                    </button>
                                    <button type="submit" class="btn btn-primary" onclick="createEmailAccount()">
                                        <i class="bx bx-plus me-1"></i> Create Email Account
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Email Account Preview -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Email Account Preview</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Email Address:</strong> <span id="previewEmail">-</span></p>
                                        <p><strong>Quota:</strong> <span id="previewQuota">-</span></p>
                                        <p><strong>Features:</strong> <span id="previewFeatures">-</span></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>IMAP Server:</strong> <code>mail.example.com</code></p>
                                        <p><strong>SMTP Server:</strong> <code>mail.example.com</code></p>
                                        <p><strong>Webmail:</strong> <a href="#" onclick="openWebmail()">webmail.example.com</a></p>
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
function generatePassword() {
    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*';
    let password = '';
    for (let i = 0; i < 12; i++) {
        password += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    document.getElementById('password').value = password;
    document.getElementById('confirmPassword').value = password;
}

function resetForm() {
    document.getElementById('domain').value = '';
    document.getElementById('username').value = '';
    document.getElementById('password').value = '';
    document.getElementById('confirmPassword').value = '';
    document.getElementById('quota').value = '';
    document.getElementById('quotaWarning').value = '80';
    document.getElementById('enableForwarding').checked = false;
    document.getElementById('enableAutoResponder').checked = false;
    document.getElementById('enableSpamFilter').checked = true;
    document.getElementById('enableVirusScan').checked = true;
    document.getElementById('forwardTo').value = '';
    document.getElementById('keepCopy').checked = false;
    document.getElementById('autoResponderSubject').value = '';
    document.getElementById('autoResponderMessage').value = '';
    updatePreview();
}

function testEmail() {
    const domain = document.getElementById('domain').value;
    const username = document.getElementById('username').value;
    
    if (!domain || !username) {
        showNotification('Please select domain and enter username', 'warning');
        return;
    }
    
    showNotification('Testing email configuration...', 'info');
}

function createEmailAccount() {
    const domain = document.getElementById('domain').value;
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    
    if (!domain || !username || !password) {
        showNotification('Please fill in all required fields', 'warning');
        return;
    }
    
    if (password !== confirmPassword) {
        showNotification('Passwords do not match', 'danger');
        return;
    }
    
    showNotification('Creating email account...', 'info');
}

function updatePreview() {
    const domain = document.getElementById('domain').value;
    const username = document.getElementById('username').value;
    const quota = document.getElementById('quota').value;
    
    if (domain && username) {
        document.getElementById('previewEmail').textContent = `${username}@${domain}`;
    } else {
        document.getElementById('previewEmail').textContent = '-';
    }
    
    document.getElementById('previewQuota').textContent = quota || '-';
    
    const features = [];
    if (document.getElementById('enableForwarding').checked) features.push('Forwarding');
    if (document.getElementById('enableAutoResponder').checked) features.push('Auto Responder');
    if (document.getElementById('enableSpamFilter').checked) features.push('Spam Filter');
    if (document.getElementById('enableVirusScan').checked) features.push('Virus Scan');
    
    document.getElementById('previewFeatures').textContent = features.join(', ') || 'None';
}

function openWebmail() {
    showNotification('Opening webmail...', 'info');
}

// Event listeners
document.getElementById('domain').addEventListener('change', updatePreview);
document.getElementById('username').addEventListener('input', updatePreview);
document.getElementById('quota').addEventListener('change', updatePreview);
document.getElementById('enableForwarding').addEventListener('change', function() {
    document.getElementById('forwardingOptions').style.display = this.checked ? 'block' : 'none';
    updatePreview();
});
document.getElementById('enableAutoResponder').addEventListener('change', function() {
    document.getElementById('autoResponderOptions').style.display = this.checked ? 'block' : 'none';
    updatePreview();
});

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
