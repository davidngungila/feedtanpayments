@extends('layouts.app')

@section('title', 'Create Integration - FeedTan Pay')

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
                                    <i class="bx bx-plus me-2 text-primary"></i>
                                    Create New Integration
                                </h4>
                                <p class="text-muted mb-0">Add a new API integration for SMS, Email, or Payment services</p>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('system-settings.integration') }}" class="btn btn-outline-secondary">
                                    <i class="bx bx-arrow-back me-2"></i>Back to Integrations
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Integration Type Selection -->
        <div class="row mb-6">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-tag me-2"></i>
                            Select Integration Type
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 border-2 border-primary cursor-pointer" onclick="selectIntegrationType('sms')">
                                    <div class="card-body text-center">
                                        <div class="avatar bg-primary bg-opacity-10 rounded-circle mx-auto mb-3" style="width: 64px; height: 64px;">
                                            <i class="bx bx-message-square-dots text-primary fs-1"></i>
                                        </div>
                                        <h5 class="card-title">SMS API</h5>
                                        <p class="text-muted">Integrate SMS services for notifications and alerts</p>
                                        <div class="badge bg-primary">Popular</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 border-2 border-success cursor-pointer" onclick="selectIntegrationType('email')">
                                    <div class="card-body text-center">
                                        <div class="avatar bg-success bg-opacity-10 rounded-circle mx-auto mb-3" style="width: 64px; height: 64px;">
                                            <i class="bx bx-envelope text-success fs-1"></i>
                                        </div>
                                        <h5 class="card-title">Email API</h5>
                                        <p class="text-muted">Integrate email services for transactional emails</p>
                                        <div class="badge bg-success">Recommended</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 border-2 border-warning cursor-pointer" onclick="selectIntegrationType('payment')">
                                    <div class="card-body text-center">
                                        <div class="avatar bg-warning bg-opacity-10 rounded-circle mx-auto mb-3" style="width: 64px; height: 64px;">
                                            <i class="bx bx-credit-card text-warning fs-1"></i>
                                        </div>
                                        <h5 class="card-title">Payment API</h5>
                                        <p class="text-muted">Integrate payment gateways and mobile money</p>
                                        <div class="badge bg-warning">Essential</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Integration Form -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-cog me-2"></i>
                            Integration Configuration
                        </h5>
                    </div>
                    <div class="card-body">
                        <form id="integrationForm">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="integrationType" class="form-label">
                                            <i class="bx bx-tag me-1"></i>Integration Type
                                        </label>
                                        <select class="form-select" id="integrationType" name="integration_type" required onchange="updateProviderOptions()">
                                            <option value="">Select Integration Type</option>
                                            <option value="sms">SMS API</option>
                                            <option value="email">Email API</option>
                                            <option value="payment">Payment API</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="provider" class="form-label">
                                            <i class="bx bx-building me-1"></i>Provider
                                        </label>
                                        <select class="form-select" id="provider" name="provider" required>
                                            <option value="">Select Provider</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="integrationName" class="form-label">
                                            <i class="bx bx-label me-1"></i>Integration Name
                                        </label>
                                        <input type="text" class="form-control" id="integrationName" name="integration_name" required placeholder="e.g., Twilio SMS API">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="environment" class="form-label">
                                            <i class="bx bx-globe me-1"></i>Environment
                                        </label>
                                        <select class="form-select" id="environment" name="environment" required>
                                            <option value="sandbox">Sandbox</option>
                                            <option value="production">Production</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="apiKey" class="form-label">
                                            <i class="bx bx-key me-1"></i>API Key / Client ID
                                        </label>
                                        <input type="text" class="form-control" id="apiKey" name="api_key" required placeholder="Enter API key or client ID">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="apiSecret" class="form-label">
                                            <i class="bx bx-lock me-1"></i>API Secret / Client Secret
                                        </label>
                                        <input type="password" class="form-control" id="apiSecret" name="api_secret" placeholder="Enter API secret (if required)">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="endpointUrl" class="form-label">
                                            <i class="bx bx-link me-1"></i>Endpoint URL
                                        </label>
                                        <input type="url" class="form-control" id="endpointUrl" name="endpoint_url" placeholder="https://api.provider.com">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="description" class="form-label">
                                            <i class="bx bx-info-circle me-1"></i>Description
                                        </label>
                                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Describe this integration..."></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="webhookUrl" class="form-label">
                                            <i class="bx bx-link me-1"></i>Webhook URL (Optional)
                                        </label>
                                        <input type="url" class="form-control" id="webhookUrl" name="webhook_url" placeholder="https://yourdomain.com/webhook">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="timeout" class="form-label">
                                            <i class="bx bx-time me-1"></i>Timeout (seconds)
                                        </label>
                                        <input type="number" class="form-control" id="timeout" name="timeout" value="30" min="5" max="300">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="isActive" name="is_active" checked>
                                            <label class="form-check-label" for="isActive">
                                                Enable this integration immediately
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bx bx-save me-2"></i>Create Integration
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary" onclick="testConnection()">
                                            <i class="bx bx-test-tube me-2"></i>Test Connection
                                        </button>
                                        <a href="{{ route('system-settings.integration') }}" class="btn btn-outline-danger">
                                            <i class="bx bx-x me-2"></i>Cancel
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
const providerOptions = {
    sms: [
        { value: 'twilio', text: 'Twilio' },
        { value: 'africastalking', text: 'AfricasTalking' },
        { value: 'infobip', text: 'Infobip' },
        { value: 'messagebird', text: 'MessageBird' },
        { value: 'nexmo', text: 'Nexmo (Vonage)' }
    ],
    email: [
        { value: 'sendgrid', text: 'SendGrid' },
        { value: 'mailgun', text: 'Mailgun' },
        { value: 'ses', text: 'Amazon SES' },
        { value: 'postmark', text: 'Postmark' },
        { value: 'sparkpost', text: 'SparkPost' }
    ],
    payment: [
        { value: 'mpesa', text: 'M-Pesa' },
        { value: 'tigopesa', text: 'Tigo Pesa' },
        { value: 'airtelmoney', text: 'Airtel Money' },
        { value: 'halopesa', text: 'Halopesa' },
        { value: 'stripe', text: 'Stripe' },
        { value: 'paypal', text: 'PayPal' }
    ]
};

function selectIntegrationType(type) {
    document.getElementById('integrationType').value = type;
    updateProviderOptions();
    
    // Scroll to form
    document.getElementById('integrationForm').scrollIntoView({ behavior: 'smooth' });
}

function updateProviderOptions() {
    const type = document.getElementById('integrationType').value;
    const providerSelect = document.getElementById('provider');
    
    // Clear existing options
    providerSelect.innerHTML = '<option value="">Select Provider</option>';
    
    if (type && providerOptions[type]) {
        providerOptions[type].forEach(option => {
            const optionElement = document.createElement('option');
            optionElement.value = option.value;
            optionElement.textContent = option.text;
            providerSelect.appendChild(optionElement);
        });
    }
}

function testConnection() {
    const form = document.getElementById('integrationForm');
    const formData = new FormData(form);
    
    // Validate required fields
    if (!formData.get('integration_type') || !formData.get('provider') || !formData.get('api_key')) {
        showNotification('Please fill in all required fields', 'warning');
        return;
    }
    
    showNotification('Testing connection...', 'info');
    
    // Simulate connection test
    setTimeout(() => {
        showNotification('Connection test successful!', 'success');
    }, 2000);
}

// Form submission
document.getElementById('integrationForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    // Validate required fields
    if (!formData.get('integration_type') || !formData.get('provider') || !formData.get('api_key')) {
        showNotification('Please fill in all required fields', 'warning');
        return;
    }
    
    showNotification('Creating integration...', 'info');
    
    // Simulate API call
    setTimeout(() => {
        showNotification('Integration created successfully!', 'success');
        setTimeout(() => {
            window.location.href = '{{ route("system-settings.integration") }}';
        }, 1500);
    }, 2000);
});

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
