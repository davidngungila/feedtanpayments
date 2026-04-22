@extends('layouts.app')

@section('title', 'SMS API Integration - FeedTan Pay')
@section('description', 'Configure SMS API services for notifications and alerts')

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
                                    <i class="bx bx-mobile-alt me-2 text-primary"></i>
                                    SMS API Integration
                                </h4>
                                <p class="text-muted mb-0">Integrate SMS services for notifications and alerts</p>
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
                                <i class="bx bx-message-square-dots text-info fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Messages Sent</h6>
                                <h4 class="mb-0">1,247</h4>
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
                                <i class="bx bx-dollar text-warning fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Cost</h6>
                                <h4 class="mb-0">TZS 19,952</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SMS Services Configuration -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0">
                                <i class="bx bx-cog me-2"></i>
                                SMS Service Configurations
                            </h5>
                            <small class="text-muted">Configure your SMS API providers</small>
                        </div>
                        <button type="button" class="btn btn-primary" onclick="addSmsService()">
                            <i class="bx bx-plus me-2"></i>Add SMS Service
                        </button>
                    </div>
                    <div class="card-body">
                        <!-- Primary SMS Service -->
                        <div class="border rounded p-4 mb-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h6 class="mb-1">
                                        <i class="bx bx-star text-warning me-2"></i>
                                        Primary SMS Service
                                    </h6>
                                    <small class="text-muted">Messaging Service Co. TZ - API V2</small>
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
                                        <input type="text" class="form-control" value="Main SMS Service" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">API Base URL</label>
                                        <input type="url" class="form-control" value="https://messaging-service.co.tz" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Sender ID</label>
                                        <input type="text" class="form-control" value="FeedTanPay" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Authentication Method</label>
                                        <input type="text" class="form-control" value="Bearer Token" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Bearer Token</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" value="d983d9d1d54176047e68547aba079ba4" readonly>
                                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword(this)">
                                                <i class="bx bx-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Cost per SMS</label>
                                        <input type="text" class="form-control" value="TZS 0.0160" readonly>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-outline-primary" onclick="editSmsService(1)">
                                    <i class="bx bx-edit me-2"></i>Edit
                                </button>
                                <button type="button" class="btn btn-outline-success" onclick="testSmsService(1)">
                                    <i class="bx bx-test-tube me-2"></i>Test Connection
                                </button>
                                <button type="button" class="btn btn-outline-warning" onclick="toggleService(1)">
                                    <i class="bx bx-pause me-2"></i>Deactivate
                                </button>
                            </div>
                        </div>

                        <!-- Backup SMS Service -->
                        <div class="border rounded p-4 mb-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h6 class="mb-1">
                                        <i class="bx bx-shield text-info me-2"></i>
                                        Backup SMS Service
                                    </h6>
                                    <small class="text-muted">Alternative SMS Provider - API V2</small>
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
                                        <input type="text" class="form-control" value="Backup SMS Service" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">API Base URL</label>
                                        <input type="url" class="form-control" value="https://backup-sms-provider.com" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Sender ID</label>
                                        <input type="text" class="form-control" value="FeedTanPay" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Authentication Method</label>
                                        <input type="text" class="form-control" value="Basic Auth" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Username</label>
                                        <input type="text" class="form-control" value="feedtanpay_api" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Cost per SMS</label>
                                        <input type="text" class="form-control" value="TZS 0.0180" readonly>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-outline-primary" onclick="editSmsService(2)">
                                    <i class="bx bx-edit me-2"></i>Edit
                                </button>
                                <button type="button" class="btn btn-outline-success" onclick="testSmsService(2)">
                                    <i class="bx bx-test-tube me-2"></i>Test Connection
                                </button>
                                <button type="button" class="btn btn-outline-warning" onclick="toggleService(2)">
                                    <i class="bx bx-pause me-2"></i>Deactivate
                                </button>
                            </div>
                        </div>

                        <!-- Test SMS Service -->
                        <div class="border rounded p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h6 class="mb-1">
                                        <i class="bx bx-test-tube text-warning me-2"></i>
                                        Test SMS Service
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
                                        <input type="text" class="form-control" value="Test SMS Service" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">API Base URL</label>
                                        <input type="url" class="form-control" value="https://messaging-service.co.tz" readonly>
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
                                <button type="button" class="btn btn-outline-primary" onclick="editSmsService(3)">
                                    <i class="bx bx-edit me-2"></i>Edit
                                </button>
                                <button type="button" class="btn btn-outline-success" onclick="testSmsService(3)">
                                    <i class="bx bx-test-tube me-2"></i>Test Connection
                                </button>
                                <button type="button" class="btn btn-outline-danger" onclick="deleteSmsService(3)">
                                    <i class="bx bx-trash me-2"></i>Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SMS Settings -->
        <div class="row mt-6">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-cog me-2"></i>
                            SMS Settings
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Default Sender ID</label>
                            <input type="text" class="form-control" value="FeedTanPay">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Character Encoding</label>
                            <select class="form-select">
                                <option value="UTF-8" selected>UTF-8 (Recommended)</option>
                                <option value="GSM-7">GSM-7</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Max SMS Length</label>
                            <input type="number" class="form-control" value="1600" min="1" max="1600">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Auto Retry Failed SMS</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="autoRetry" checked>
                                <label class="form-check-label" for="autoRetry">
                                    Enable automatic retry for failed messages
                                </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Retry Attempts</label>
                            <input type="number" class="form-control" value="3" min="1" max="10">
                        </div>
                        <button type="button" class="btn btn-primary" onclick="saveSmsSettings()">
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
                            Test SMS
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Test Phone Number</label>
                            <input type="text" class="form-control" id="testPhone" placeholder="255712345678" value="255700000000">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Test Message</label>
                            <textarea class="form-control" id="testMessage" rows="3" placeholder="Enter test message...">This is a test message from FeedTan Pay SMS API integration.</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Select Service</label>
                            <select class="form-select" id="testService">
                                <option value="1">Primary SMS Service</option>
                                <option value="2">Backup SMS Service</option>
                                <option value="3">Test SMS Service</option>
                            </select>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="useTestMode" checked>
                            <label class="form-check-label" for="useTestMode">
                                Use test mode (no charges)
                            </label>
                        </div>
                        <button type="button" class="btn btn-success" onclick="sendTestSms()">
                            <i class="bx bx-send me-2"></i>Send Test SMS
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit SMS Service Modal -->
<div class="modal fade" id="smsServiceModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="bx bx-mobile-alt me-2"></i>
                    Add SMS Service
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="smsServiceForm">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="serviceName" class="form-label">Service Name *</label>
                            <input type="text" class="form-control" id="serviceName" required placeholder="e.g., Main SMS Service">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="serviceProvider" class="form-label">Provider *</label>
                            <input type="text" class="form-control" id="serviceProvider" required placeholder="e.g., messaging-service.co.tz">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="apiBaseUrl" class="form-label">API Base URL *</label>
                            <input type="url" class="form-control" id="apiBaseUrl" required placeholder="https://messaging-service.co.tz">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="apiVersion" class="form-label">API Version</label>
                            <select class="form-select" id="apiVersion">
                                <option value="v2" selected>v2</option>
                                <option value="v1">v1</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="senderId" class="form-label">Sender ID</label>
                            <input type="text" class="form-control" id="senderId" placeholder="FeedTanPay" maxlength="11">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="costPerSms" class="form-label">Cost per SMS</label>
                            <input type="number" class="form-control" id="costPerSms" value="0.0160" step="0.0001" min="0">
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
                                    <input class="form-check-input" type="radio" name="authMethod" id="authBearer" value="bearer" checked>
                                    <label class="form-check-label" for="authBearer">
                                        Bearer Token (Recommended)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="authMethod" id="authBasic" value="basic">
                                    <label class="form-check-label" for="authBasic">
                                        Basic Authentication
                                    </label>
                                </div>
                            </div>
                            
                            <div id="bearerAuthFields">
                                <div class="mb-3">
                                    <label for="bearerToken" class="form-label">Bearer Token *</label>
                                    <textarea class="form-control" id="bearerToken" rows="3" placeholder="d983d9d1d54176047e68547aba079ba4"></textarea>
                                </div>
                            </div>
                            
                            <div id="basicAuthFields" style="display: none;">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="username" class="form-label">Username *</label>
                                        <input type="text" class="form-control" id="username" placeholder="username">
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
                        <div class="col-md-6 mb-3">
                            <label for="rateLimit" class="form-label">Rate Limit (per hour)</label>
                            <input type="number" class="form-control" id="rateLimit" value="100" min="1">
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-check mt-4">
                                <input class="form-check-input" type="checkbox" id="testMode">
                                <label class="form-check-label" for="testMode">
                                    Test Mode (No charges)
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
                <button type="button" class="btn btn-primary" onclick="saveSmsService()">Save Service</button>
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
        const bearerFields = document.getElementById('bearerAuthFields');
        const basicFields = document.getElementById('basicAuthFields');
        
        if (this.value === 'bearer') {
            bearerFields.style.display = 'block';
            basicFields.style.display = 'none';
        } else {
            bearerFields.style.display = 'none';
            basicFields.style.display = 'block';
        }
    });
});

function addSmsService() {
    document.getElementById('smsServiceForm').reset();
    document.getElementById('bearerAuthFields').style.display = 'block';
    document.getElementById('basicAuthFields').style.display = 'none';
    document.getElementById('authBearer').checked = true;
    
    const modal = new bootstrap.Modal(document.getElementById('smsServiceModal'));
    modal.show();
}

function editSmsService(serviceId) {
    // Load service data based on ID
    const serviceData = {
        1: {
            name: 'Main SMS Service',
            provider: 'messaging-service.co.tz',
            baseUrl: 'https://messaging-service.co.tz',
            apiVersion: 'v2',
            senderId: 'FeedTanPay',
            costPerSms: 0.0160,
            bearerToken: 'd983d9d1d54176047e68547aba079ba4',
            rateLimit: 100,
            testMode: false,
            notes: 'Primary SMS service for all notifications'
        },
        2: {
            name: 'Backup SMS Service',
            provider: 'backup-sms-provider.com',
            baseUrl: 'https://backup-sms-provider.com',
            apiVersion: 'v2',
            senderId: 'FeedTanPay',
            costPerSms: 0.0180,
            username: 'feedtanpay_api',
            password: '********',
            rateLimit: 50,
            testMode: false,
            notes: 'Backup SMS service for failover'
        },
        3: {
            name: 'Test SMS Service',
            provider: 'messaging-service.co.tz',
            baseUrl: 'https://messaging-service.co.tz',
            apiVersion: 'v2',
            senderId: 'FeedTanPay',
            costPerSms: 0.0000,
            bearerToken: 'd983d9d1d54176047e68547aba079ba4',
            rateLimit: 10,
            testMode: true,
            notes: 'Test service for development'
        }
    };
    
    const data = serviceData[serviceId];
    if (data) {
        document.getElementById('serviceName').value = data.name;
        document.getElementById('serviceProvider').value = data.provider;
        document.getElementById('apiBaseUrl').value = data.baseUrl;
        document.getElementById('apiVersion').value = data.apiVersion;
        document.getElementById('senderId').value = data.senderId;
        document.getElementById('costPerSms').value = data.costPerSms;
        document.getElementById('rateLimit').value = data.rateLimit;
        document.getElementById('testMode').checked = data.testMode;
        document.getElementById('notes').value = data.notes;
        
        if (data.bearerToken) {
            document.getElementById('authBearer').checked = true;
            document.getElementById('bearerAuthFields').style.display = 'block';
            document.getElementById('basicAuthFields').style.display = 'none';
            document.getElementById('bearerToken').value = data.bearerToken;
        } else {
            document.getElementById('authBasic').checked = true;
            document.getElementById('bearerAuthFields').style.display = 'none';
            document.getElementById('basicAuthFields').style.display = 'block';
            document.getElementById('username').value = data.username;
            document.getElementById('password').value = data.password;
        }
        
        const modal = new bootstrap.Modal(document.getElementById('smsServiceModal'));
        modal.show();
    }
}

function saveSmsService() {
    const form = document.getElementById('smsServiceForm');
    if (!form.checkValidity()) {
        showNotification('Please fill in all required fields', 'warning');
        return;
    }
    
    showNotification('Saving SMS service...', 'info');
    
    // Simulate API call
    setTimeout(() => {
        showNotification('SMS service saved successfully!', 'success');
        bootstrap.Modal.getInstance(document.getElementById('smsServiceModal')).hide();
        setTimeout(() => location.reload(), 1500);
    }, 1500);
}

function testSmsService(serviceId) {
    showNotification('Testing SMS service connection...', 'info');
    
    // Simulate API test
    setTimeout(() => {
        const success = serviceId === 3 || Math.random() > 0.2; // Test service always succeeds
        
        if (success) {
            showTestResult(true, 'Connection successful', {
                status: 'success',
                response_time: '245ms',
                api_version: 'v2',
                test_message_sent: true
            });
        } else {
            showTestResult(false, 'Connection failed', {
                error: 'Authentication failed',
                error_code: '401',
                suggestion: 'Check your bearer token or credentials'
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

function deleteSmsService(serviceId) {
    if (confirm('Are you sure you want to delete this SMS service? This action cannot be undone.')) {
        showNotification('Deleting SMS service...', 'info');
        setTimeout(() => {
            showNotification('SMS service deleted successfully', 'success');
            setTimeout(() => location.reload(), 1500);
        }, 1000);
    }
}

function saveSmsSettings() {
    showNotification('Saving SMS settings...', 'info');
    setTimeout(() => {
        showNotification('SMS settings saved successfully!', 'success');
    }, 1000);
}

function sendTestSms() {
    const phone = document.getElementById('testPhone').value;
    const message = document.getElementById('testMessage').value;
    const service = document.getElementById('testService').value;
    const testMode = document.getElementById('useTestMode').checked;
    
    if (!phone || !message) {
        showNotification('Please fill in phone number and message', 'warning');
        return;
    }
    
    showNotification('Sending test SMS...', 'info');
    
    // Simulate API call
    setTimeout(() => {
        showNotification('Test SMS sent successfully!', 'success');
        
        // Show result
        showTestResult(true, 'Test SMS sent', {
            phone: phone,
            service: service === '1' ? 'Primary' : (service === '2' ? 'Backup' : 'Test'),
            message_length: message.length,
            sms_count: Math.ceil(message.length / 160),
            test_mode: testMode,
            message_id: 'SMS_' + Math.random().toString(36).substr(2, 9).toUpperCase()
        });
    }, 2000);
}

function testAllConnections() {
    showNotification('Testing all SMS service connections...', 'info');
    
    setTimeout(() => {
        showNotification('Connection tests completed', 'success');
        showTestResult(true, 'All services tested', {
            primary: 'Connected',
            backup: 'Connected',
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
