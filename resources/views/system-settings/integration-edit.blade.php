@extends('layouts.app')

@section('title', 'Edit Integration - FeedTan Pay')

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
                                    <i class="bx bx-edit me-2 text-primary"></i>
                                    Edit Integration
                                </h4>
                                <p class="text-muted mb-0">Update API integration settings and configuration</p>
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

        <!-- Integration Details -->
        <div class="row mb-6">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-info-circle me-2"></i>
                            Integration Details
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-muted">Integration ID</label>
                                    <div class="fw-bold">{{ $id }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted">Integration Type</label>
                                    <div><span class="badge bg-primary">SMS API</span></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted">Provider</label>
                                    <div class="fw-bold">Twilio</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted">Status</label>
                                    <div><span class="badge bg-success">Active</span></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-muted">Created Date</label>
                                    <div>Dec 15, 2024</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted">Last Modified</label>
                                    <div>Dec 20, 2024</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted">Last Used</label>
                                    <div>2 hours ago</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted">Environment</label>
                                    <div><span class="badge bg-info">Production</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Integration Form -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-cog me-2"></i>
                            Update Configuration
                        </h5>
                    </div>
                    <div class="card-body">
                        <form id="integrationEditForm">
                            <input type="hidden" id="integrationId" name="integration_id" value="{{ $id }}">
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="integrationType" class="form-label">
                                            <i class="bx bx-tag me-1"></i>Integration Type
                                        </label>
                                        <select class="form-select" id="integrationType" name="integration_type" required>
                                            <option value="sms" selected>SMS API</option>
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
                                            <option value="twilio" selected>Twilio</option>
                                            <option value="africastalking">AfricasTalking</option>
                                            <option value="infobip">Infobip</option>
                                            <option value="messagebird">MessageBird</option>
                                            <option value="nexmo">Nexmo (Vonage)</option>
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
                                        <input type="text" class="form-control" id="integrationName" name="integration_name" value="Twilio SMS API" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="environment" class="form-label">
                                            <i class="bx bx-globe me-1"></i>Environment
                                        </label>
                                        <select class="form-select" id="environment" name="environment" required>
                                            <option value="sandbox">Sandbox</option>
                                            <option value="production" selected>Production</option>
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
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="apiKey" name="api_key" value="ACf3d8e9f2g7h1i4j5k6l8m9n0p2q3r4s5t6u7v8w9x0y1z2" required>
                                            <button type="button" class="btn btn-outline-secondary" onclick="toggleApiKeyVisibility()">
                                                <i class="bx bx-show"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="apiSecret" class="form-label">
                                            <i class="bx bx-lock me-1"></i>API Secret / Client Secret
                                        </label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="apiSecret" name="api_secret" value="s3cr3tK3yV4lu3H3r3">
                                            <button type="button" class="btn btn-outline-secondary" onclick="toggleApiSecretVisibility()">
                                                <i class="bx bx-show"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="endpointUrl" class="form-label">
                                            <i class="bx bx-link me-1"></i>Endpoint URL
                                        </label>
                                        <input type="url" class="form-control" id="endpointUrl" name="endpoint_url" value="https://api.twilio.com/2010-04-01">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="description" class="form-label">
                                            <i class="bx bx-info-circle me-1"></i>Description
                                        </label>
                                        <textarea class="form-control" id="description" name="description" rows="3">International SMS service for global messaging with delivery reports and webhook support</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="webhookUrl" class="form-label">
                                            <i class="bx bx-link me-1"></i>Webhook URL
                                        </label>
                                        <input type="url" class="form-control" id="webhookUrl" name="webhook_url" value="https://feedtanpay.com/webhook/twilio">
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
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="rateLimit" class="form-label">
                                            <i class="bx bx-tachometer me-1"></i>Rate Limit (requests/minute)
                                        </label>
                                        <input type="number" class="form-control" id="rateLimit" name="rate_limit" value="1000" min="1" max="10000">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="retryAttempts" class="form-label">
                                            <i class="bx bx-reset me-1"></i>Retry Attempts
                                        </label>
                                        <input type="number" class="form-control" id="retryAttempts" name="retry_attempts" value="3" min="0" max="10">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="isActive" name="is_active" checked>
                                            <label class="form-check-label" for="isActive">
                                                Enable this integration
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bx bx-save me-2"></i>Update Integration
                                        </button>
                                        <button type="button" class="btn btn-outline-success" onclick="testConnection()">
                                            <i class="bx bx-test-tube me-2"></i>Test Connection
                                        </button>
                                        <button type="button" class="btn btn-outline-warning" onclick="regenerateApiKey()">
                                            <i class="bx bx-refresh me-2"></i>Regenerate API Key
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

        <!-- Usage Statistics -->
        <div class="row mt-6">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-bar-chart me-2"></i>
                            Usage Statistics
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h4 class="text-primary">15,234</h4>
                                    <small class="text-muted">Total Requests</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h4 class="text-success">99.2%</h4>
                                    <small class="text-muted">Success Rate</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h4 class="text-info">85ms</h4>
                                    <small class="text-muted">Avg Response Time</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h4 class="text-warning">2 hours</h4>
                                    <small class="text-muted">Last Used</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
function toggleApiKeyVisibility() {
    const apiKeyInput = document.getElementById('apiKey');
    const button = event.target.closest('button');
    const icon = button.querySelector('i');
    
    if (apiKeyInput.type === 'password') {
        apiKeyInput.type = 'text';
        icon.className = 'bx bx-hide';
    } else {
        apiKeyInput.type = 'password';
        icon.className = 'bx bx-show';
    }
}

function toggleApiSecretVisibility() {
    const apiSecretInput = document.getElementById('apiSecret');
    const button = event.target.closest('button');
    const icon = button.querySelector('i');
    
    if (apiSecretInput.type === 'password') {
        apiSecretInput.type = 'text';
        icon.className = 'bx bx-hide';
    } else {
        apiSecretInput.type = 'password';
        icon.className = 'bx bx-show';
    }
}

function testConnection() {
    const form = document.getElementById('integrationEditForm');
    const formData = new FormData(form);
    
    showNotification('Testing connection...', 'info');
    
    // Simulate connection test
    setTimeout(() => {
        showNotification('Connection test successful!', 'success');
    }, 2000);
}

function regenerateApiKey() {
    if (confirm('Are you sure you want to regenerate the API key? This will invalidate the current key.')) {
        showNotification('Regenerating API key...', 'info');
        
        // Simulate API key regeneration
        setTimeout(() => {
            const newApiKey = 'AC' + Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);
            document.getElementById('apiKey').value = newApiKey;
            showNotification('API key regenerated successfully!', 'success');
        }, 1500);
    }
}

// Form submission
document.getElementById('integrationEditForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    showNotification('Updating integration...', 'info');
    
    // Simulate API call
    setTimeout(() => {
        showNotification('Integration updated successfully!', 'success');
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
