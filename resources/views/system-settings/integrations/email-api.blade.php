@extends('layouts.app')

@section('title', 'Email API Integration - FeedTan Pay')
@section('description', 'Configure Email API services for transactional emails')

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
                                    <i class="bx bx-envelope me-2 text-success"></i>
                                    Email API Integration
                                </h4>
                                <p class="text-muted mb-0">Integrate email services for transactional emails</p>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('system-settings.integration') }}" class="btn btn-outline-secondary">
                                    <i class="bx bx-arrow-back me-2"></i>Back to Integrations
                                </a>
                                <button type="button" class="btn btn-outline-success" onclick="testAllConnections()">
                                    <i class="bx bx-test-tube me-2"></i>Test All
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Integration Overview -->
        <div class="row mb-6">
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-success bg-opacity-10 rounded-circle me-3" style="width: 48px; height: 48px;">
                                <i class="bx bx-check-circle text-success fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Active Services</h6>
                                <h4 class="mb-0">2</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-info bg-opacity-10 rounded-circle me-3" style="width: 48px; height: 48px;">
                                <i class="bx bx-envelope text-info fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Emails Sent</h6>
                                <h4 class="mb-0">3,842</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-warning bg-opacity-10 rounded-circle me-3" style="width: 48px; height: 48px;">
                                <i class="bx bx-envelope-open text-warning fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Open Rate</h6>
                                <h4 class="mb-0">67.3%</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Email Services Configuration -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0">
                                <i class="bx bx-cog me-2"></i>
                                Email Service Configurations
                            </h5>
                            <small class="text-muted">Configure your email API providers</small>
                        </div>
                        <button type="button" class="btn btn-primary" onclick="addEmailService()">
                            <i class="bx bx-plus me-2"></i>Add Email Service
                        </button>
                    </div>
                    <div class="card-body">
                        <!-- Primary Email Service -->
                        <div class="border rounded p-4 mb-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h6 class="mb-1">
                                        <i class="bx bx-star text-warning me-2"></i>
                                        Primary Email Service
                                    </h6>
                                    <small class="text-muted">SendGrid - Transactional Email API</small>
                                </div>
                                <div>
                                    <span class="badge bg-success">Active</span>
                                    <span class="badge bg-info ms-1">Primary</span>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Service Name</label>
                                        <input type="text" class="form-control" value="SendGrid API" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">API Endpoint</label>
                                        <input type="url" class="form-control" value="https://api.sendgrid.com/v3" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">From Email</label>
                                        <input type="email" class="form-control" value="noreply@feedtanpay.co.tz" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">From Name</label>
                                        <input type="text" class="form-control" value="FeedTan Pay" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">API Key</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" value="SG.xxxxxxxxxxxxxxxxxxxxxxxxxxxx" readonly>
                                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword(this)">
                                                <i class="bx bx-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Daily Limit</label>
                                        <input type="text" class="form-control" value="10,000 emails/day" readonly>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-outline-primary" onclick="editEmailService(1)">
                                    <i class="bx bx-edit me-2"></i>Edit
                                </button>
                                <button type="button" class="btn btn-outline-success" onclick="testEmailService(1)">
                                    <i class="bx bx-test-tube me-2"></i>Test Connection
                                </button>
                                <button type="button" class="btn btn-outline-warning" onclick="toggleService(1)">
                                    <i class="bx bx-pause me-2"></i>Deactivate
                                </button>
                            </div>
                        </div>

                        <!-- Backup Email Service -->
                        <div class="border rounded p-4 mb-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h6 class="mb-1">
                                        <i class="bx bx-shield text-info me-2"></i>
                                        Backup Email Service
                                    </h6>
                                    <small class="text-muted">Mailgun - Email API Service</small>
                                </div>
                                <div>
                                    <span class="badge bg-success">Active</span>
                                    <span class="badge bg-secondary ms-1">Backup</span>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Service Name</label>
                                        <input type="text" class="form-control" value="Mailgun API" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">API Endpoint</label>
                                        <input type="url" class="form-control" value="https://api.mailgun.net/v3" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Domain</label>
                                        <input type="text" class="form-control" value="feedtanpay.co.tz" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">API Key</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" value="key-xxxxxxxxxxxxxxxxxxxxxxxxxxx" readonly>
                                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword(this)">
                                                <i class="bx bx-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Daily Limit</label>
                                        <input type="text" class="form-control" value="5,000 emails/day" readonly>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-outline-primary" onclick="editEmailService(2)">
                                    <i class="bx bx-edit me-2"></i>Edit
                                </button>
                                <button type="button" class="btn btn-outline-success" onclick="testEmailService(2)">
                                    <i class="bx bx-test-tube me-2"></i>Test Connection
                                </button>
                                <button type="button" class="btn btn-outline-warning" onclick="toggleService(2)">
                                    <i class="bx bx-pause me-2"></i>Deactivate
                                </button>
                            </div>
                        </div>

                        <!-- Test Email Service -->
                        <div class="border rounded p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h6 class="mb-1">
                                        <i class="bx bx-test-tube text-warning me-2"></i>
                                        Test Email Service
                                    </h6>
                                    <small class="text-muted">Development/Testing - No charges</small>
                                </div>
                                <div>
                                    <span class="badge bg-warning">Test Mode</span>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Service Name</label>
                                        <input type="text" class="form-control" value="Test Email Service" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">API Endpoint</label>
                                        <input type="url" class="form-control" value="https://api.test-email.com" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Mode</label>
                                        <input type="text" class="form-control" value="Test Mode (No charges)" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Response Type</label>
                                        <input type="text" class="form-control" value="Dummy success response" readonly>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-outline-primary" onclick="editEmailService(3)">
                                    <i class="bx bx-edit me-2"></i>Edit
                                </button>
                                <button type="button" class="btn btn-outline-success" onclick="testEmailService(3)">
                                    <i class="bx bx-test-tube me-2"></i>Test Connection
                                </button>
                                <button type="button" class="btn btn-outline-danger" onclick="deleteEmailService(3)">
                                    <i class="bx bx-trash me-2"></i>Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Email Settings -->
        <div class="row mt-6">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-cog me-2"></i>
                            Email Settings
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Default From Name</label>
                            <input type="text" class="form-control" value="FeedTan Pay">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Default From Email</label>
                            <input type="email" class="form-control" value="noreply@feedtanpay.co.tz">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Reply-To Email</label>
                            <input type="email" class="form-control" value="support@feedtanpay.co.tz">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email Format</label>
                            <select class="form-select">
                                <option value="html" selected>HTML (Recommended)</option>
                                <option value="text">Plain Text</option>
                                <option value="both">HTML + Plain Text</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Track Opens</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="trackOpens" checked>
                                <label class="form-check-label" for="trackOpens">
                                    Enable email open tracking
                                </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Track Clicks</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="trackClicks" checked>
                                <label class="form-check-label" for="trackClicks">
                                    Enable link click tracking
                                </label>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary" onclick="saveEmailSettings()">
                            <i class="bx bx-save me-2"></i>Save Settings
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-test-tube me-2"></i>
                            Test Email
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Test Email Address</label>
                            <input type="email" class="form-control" id="testEmail" placeholder="test@example.com" value="test@feedtanpay.co.tz">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Test Subject</label>
                            <input type="text" class="form-control" id="testSubject" value="Test Email from FeedTan Pay">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Test Message</label>
                            <textarea class="form-control" id="testMessage" rows="4" placeholder="Enter test message...">This is a test email from FeedTan Pay Email API integration.

If you receive this email, your email service is working correctly.

Thank you,
FeedTan Pay Team</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Select Service</label>
                            <select class="form-select" id="testService">
                                <option value="1">SendGrid API</option>
                                <option value="2">Mailgun API</option>
                                <option value="3">Test Email Service</option>
                            </select>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="useTestMode" checked>
                            <label class="form-check-label" for="useTestMode">
                                Use test mode (no charges)
                            </label>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="sendHtml" checked>
                            <label class="form-check-label" for="sendHtml">
                                Send as HTML
                            </label>
                        </div>
                        <button type="button" class="btn btn-success" onclick="sendTestEmail()">
                            <i class="bx bx-send me-2"></i>Send Test Email
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit Email Service Modal -->
<div class="modal fade" id="emailServiceModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="bx bx-envelope me-2"></i>
                    Add Email Service
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="emailServiceForm">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="serviceName" class="form-label">Service Name *</label>
                            <input type="text" class="form-control" id="serviceName" required placeholder="e.g., SendGrid API">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="provider" class="form-label">Provider *</label>
                            <select class="form-select" id="provider" required>
                                <option value="">Select Provider</option>
                                <option value="sendgrid">SendGrid</option>
                                <option value="mailgun">Mailgun</option>
                                <option value="ses">Amazon SES</option>
                                <option value="postmark">Postmark</option>
                                <option value="custom">Custom API</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="apiEndpoint" class="form-label">API Endpoint *</label>
                            <input type="url" class="form-control" id="apiEndpoint" required placeholder="https://api.sendgrid.com/v3">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="domain" class="form-label">Domain</label>
                            <input type="text" class="form-control" id="domain" placeholder="feedtanpay.co.tz">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="fromEmail" class="form-label">From Email *</label>
                            <input type="email" class="form-control" id="fromEmail" required placeholder="noreply@feedtanpay.co.tz">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="fromName" class="form-label">From Name</label>
                            <input type="text" class="form-control" id="fromName" placeholder="FeedTan Pay">
                        </div>
                    </div>
                    
                    <!-- Authentication -->
                    <div class="card mb-3">
                        <div class="card-header">
                            <h6 class="mb-0">Authentication</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Authentication Method</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="authMethod" id="authApiKey" value="apikey" checked>
                                    <label class="form-check-label" for="authApiKey">
                                        API Key (Recommended)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="authMethod" id="authBasic" value="basic">
                                    <label class="form-check-label" for="authBasic">
                                        Basic Authentication
                                    </label>
                                </div>
                            </div>
                            
                            <div id="apiKeyFields">
                                <div class="mb-3">
                                    <label for="apiKey" class="form-label">API Key *</label>
                                    <textarea class="form-control" id="apiKey" rows="3" placeholder="SG.xxxxxxxxxxxxxxxxxxxxxxxxxxxx"></textarea>
                                </div>
                            </div>
                            
                            <div id="basicAuthFields" style="display: none;">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="username" class="form-label">Username *</label>
                                        <input type="text" class="form-control" id="username" placeholder="api">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="password" class="form-label">Password *</label>
                                        <input type="password" class="form-control" id="password" placeholder="password">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="dailyLimit" class="form-label">Daily Limit</label>
                            <input type="number" class="form-control" id="dailyLimit" value="10000" min="1">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="hourlyLimit" class="form-label">Hourly Limit</label>
                            <input type="number" class="form-control" id="hourlyLimit" value="1000" min="1">
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-check mt-4">
                                <input class="form-check-input" type="checkbox" id="testMode">
                                <label class="form-check-label" for="testMode">
                                    Test Mode
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea class="form-control" id="notes" rows="2" placeholder="Additional notes..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" onclick="saveEmailService()">Save Service</button>
            </div>
        </div>
    </div>
</div>

<!-- Test Result Modal -->
<div class="modal fade" id="testResultModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="bx bx-test-tube me-2"></i>
                    Connection Test Result
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="testResultContent"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Authentication method toggle
document.querySelectorAll('input[name="authMethod"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const apiKeyFields = document.getElementById('apiKeyFields');
        const basicAuthFields = document.getElementById('basicAuthFields');
        
        if (this.value === 'apikey') {
            apiKeyFields.style.display = 'block';
            basicAuthFields.style.display = 'none';
        } else {
            apiKeyFields.style.display = 'none';
            basicAuthFields.style.display = 'block';
        }
    });
});

function addEmailService() {
    document.getElementById('emailServiceForm').reset();
    document.getElementById('apiKeyFields').style.display = 'block';
    document.getElementById('basicAuthFields').style.display = 'none';
    document.getElementById('authApiKey').checked = true;
    
    const modal = new bootstrap.Modal(document.getElementById('emailServiceModal'));
    modal.show();
}

function editEmailService(serviceId) {
    // Load service data based on ID
    const serviceData = {
        1: {
            name: 'SendGrid API',
            provider: 'sendgrid',
            apiEndpoint: 'https://api.sendgrid.com/v3',
            domain: 'feedtanpay.co.tz',
            fromEmail: 'noreply@feedtanpay.co.tz',
            fromName: 'FeedTan Pay',
            apiKey: 'SG.xxxxxxxxxxxxxxxxxxxxxxxxxxxx',
            dailyLimit: 10000,
            hourlyLimit: 1000,
            testMode: false,
            notes: 'Primary email service for all transactional emails'
        },
        2: {
            name: 'Mailgun API',
            provider: 'mailgun',
            apiEndpoint: 'https://api.mailgun.net/v3',
            domain: 'feedtanpay.co.tz',
            fromEmail: 'noreply@feedtanpay.co.tz',
            fromName: 'FeedTan Pay',
            apiKey: 'key-xxxxxxxxxxxxxxxxxxxxxxxxxxx',
            dailyLimit: 5000,
            hourlyLimit: 500,
            testMode: false,
            notes: 'Backup email service for failover'
        },
        3: {
            name: 'Test Email Service',
            provider: 'custom',
            apiEndpoint: 'https://api.test-email.com',
            domain: 'feedtanpay.co.tz',
            fromEmail: 'test@feedtanpay.co.tz',
            fromName: 'FeedTan Pay Test',
            apiKey: 'test-api-key',
            dailyLimit: 100,
            hourlyLimit: 10,
            testMode: true,
            notes: 'Test service for development'
        }
    };
    
    const data = serviceData[serviceId];
    if (data) {
        document.getElementById('serviceName').value = data.name;
        document.getElementById('provider').value = data.provider;
        document.getElementById('apiEndpoint').value = data.apiEndpoint;
        document.getElementById('domain').value = data.domain;
        document.getElementById('fromEmail').value = data.fromEmail;
        document.getElementById('fromName').value = data.fromName;
        document.getElementById('apiKey').value = data.apiKey;
        document.getElementById('dailyLimit').value = data.dailyLimit;
        document.getElementById('hourlyLimit').value = data.hourlyLimit;
        document.getElementById('testMode').checked = data.testMode;
        document.getElementById('notes').value = data.notes;
        
        document.getElementById('authApiKey').checked = true;
        document.getElementById('apiKeyFields').style.display = 'block';
        document.getElementById('basicAuthFields').style.display = 'none';
        
        const modal = new bootstrap.Modal(document.getElementById('emailServiceModal'));
        modal.show();
    }
}

function saveEmailService() {
    const form = document.getElementById('emailServiceForm');
    if (!form.checkValidity()) {
        showNotification('Please fill in all required fields', 'warning');
        return;
    }
    
    showNotification('Saving email service...', 'info');
    
    // Simulate API call
    setTimeout(() => {
        showNotification('Email service saved successfully!', 'success');
        bootstrap.Modal.getInstance(document.getElementById('emailServiceModal')).hide();
        setTimeout(() => location.reload(), 1500);
    }, 1500);
}

function testEmailService(serviceId) {
    showNotification('Testing email service connection...', 'info');
    
    // Simulate API test
    setTimeout(() => {
        const success = serviceId === 3 || Math.random() > 0.2; // Test service always succeeds
        
        if (success) {
            showTestResult(true, 'Connection successful', {
                status: 'success',
                response_time: '342ms',
                api_version: 'v3',
                domain_verified: true,
                dkim_status: 'valid',
                spf_status: 'valid'
            });
        } else {
            showTestResult(false, 'Connection failed', {
                error: 'Authentication failed',
                error_code: '401',
                suggestion: 'Check your API key or credentials'
            });
        }
    }, 2000);
}

function showTestResult(success, message, details) {
    const content = `
        <div class="text-center mb-3">
            <div class="avatar ${success ? 'bg-success bg-opacity-10' : 'bg-danger bg-opacity-10'} rounded-circle mx-auto" style="width: 64px; height: 64px;">
                <i class="bx ${success ? 'bx-check-circle text-success' : 'bx-x-circle text-danger'} fs-1"></i>
            </div>
        </div>
        <div class="text-center">
            <h5 class="${success ? 'text-success' : 'text-danger'}">${message}</h5>
            ${details ? `<pre class="bg-light p-2 rounded text-start mt-3"><small>${JSON.stringify(details, null, 2)}</small></pre>` : ''}
        </div>
    `;
    
    document.getElementById('testResultContent').innerHTML = content;
    new bootstrap.Modal(document.getElementById('testResultModal')).show();
}

function toggleService(serviceId) {
    const action = confirm('Are you sure you want to toggle this service status?');
    if (action) {
        showNotification('Toggling service status...', 'info');
        setTimeout(() => {
            showNotification('Service status updated successfully', 'success');
            setTimeout(() => location.reload(), 1500);
        }, 1000);
    }
}

function deleteEmailService(serviceId) {
    if (confirm('Are you sure you want to delete this email service? This action cannot be undone.')) {
        showNotification('Deleting email service...', 'info');
        setTimeout(() => {
            showNotification('Email service deleted successfully', 'success');
            setTimeout(() => location.reload(), 1500);
        }, 1000);
    }
}

function saveEmailSettings() {
    showNotification('Saving email settings...', 'info');
    setTimeout(() => {
        showNotification('Email settings saved successfully!', 'success');
    }, 1000);
}

function sendTestEmail() {
    const email = document.getElementById('testEmail').value;
    const subject = document.getElementById('testSubject').value;
    const message = document.getElementById('testMessage').value;
    const service = document.getElementById('testService').value;
    const testMode = document.getElementById('useTestMode').checked;
    const sendHtml = document.getElementById('sendHtml').checked;
    
    if (!email || !subject || !message) {
        showNotification('Please fill in all fields', 'warning');
        return;
    }
    
    showNotification('Sending test email...', 'info');
    
    // Simulate API call
    setTimeout(() => {
        showNotification('Test email sent successfully!', 'success');
        
        // Show result
        showTestResult(true, 'Test email sent', {
            to: email,
            service: service === '1' ? 'SendGrid' : (service === '2' ? 'Mailgun' : 'Test'),
            subject: subject,
            message_length: message.length,
            format: sendHtml ? 'HTML' : 'Plain Text',
            test_mode: testMode,
            message_id: 'EMAIL_' + Math.random().toString(36).substr(2, 9).toUpperCase()
        });
    }, 2000);
}

function testAllConnections() {
    showNotification('Testing all email service connections...', 'info');
    
    setTimeout(() => {
        showNotification('Connection tests completed', 'success');
        showTestResult(true, 'All services tested', {
            sendgrid: 'Connected',
            mailgun: 'Connected',
            test: 'Connected',
            summary: '3/3 services working properly'
        });
    }, 3000);
}

function togglePassword(button) {
    const input = button.previousElementSibling;
    const icon = button.querySelector('i');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'bx bx-hide';
    } else {
        input.type = 'password';
        icon.className = 'bx bx-eye';
    }
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
