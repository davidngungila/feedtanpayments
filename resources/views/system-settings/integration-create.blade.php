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
                                    <i class="bx bx-plug me-2 text-primary"></i>
                                    Integration Configuration Center
                                </h4>
                                <p class="text-muted mb-0">Select an integration type to configure and manage your API services</p>
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

        <!-- Quick Guide -->
        <div class="row mb-6">
            <div class="col-12">
                <div class="card bg-light bg-opacity-50">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-info bg-opacity-10 rounded-circle me-3" style="width: 48px; height: 48px;">
                                <i class="bx bx-info-circle text-info fs-4"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">Quick Guide</h6>
                                <p class="text-muted mb-0">Click on any integration card below to access its dedicated configuration page where you can manage multiple service providers, test connections, and configure settings.</p>
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
                            <i class="bx bx-category me-2"></i>
                            Select Integration Type
                        </h5>
                        <small class="text-muted">Choose an integration type to access its comprehensive configuration interface</small>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 border-2 border-primary cursor-pointer" onclick="goToIntegrationPage('sms')">
                                    <div class="card-body text-center">
                                        <div class="avatar bg-primary bg-opacity-10 rounded-circle mx-auto mb-3" style="width: 64px; height: 64px;">
                                            <i class="bx bx-message-square-dots text-primary fs-1"></i>
                                        </div>
                                        <h5 class="card-title">SMS API</h5>
                                        <p class="text-muted">Integrate SMS services for notifications and alerts</p>
                                        <div class="badge bg-primary">Popular</div>
                                        <div class="mt-3">
                                            <small class="text-muted">Configure SMS providers, test connections, manage services</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 border-2 border-success cursor-pointer" onclick="goToIntegrationPage('email')">
                                    <div class="card-body text-center">
                                        <div class="avatar bg-success bg-opacity-10 rounded-circle mx-auto mb-3" style="width: 64px; height: 64px;">
                                            <i class="bx bx-envelope text-success fs-1"></i>
                                        </div>
                                        <h5 class="card-title">Email API</h5>
                                        <p class="text-muted">Integrate email services for transactional emails</p>
                                        <div class="badge bg-success">Recommended</div>
                                        <div class="mt-3">
                                            <small class="text-muted">Configure email providers, test sending, track delivery</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 border-2 border-warning cursor-pointer" onclick="goToIntegrationPage('payment')">
                                    <div class="card-body text-center">
                                        <div class="avatar bg-warning bg-opacity-10 rounded-circle mx-auto mb-3" style="width: 64px; height: 64px;">
                                            <i class="bx bx-credit-card text-warning fs-1"></i>
                                        </div>
                                        <h5 class="card-title">Payment API</h5>
                                        <p class="text-muted">Integrate payment gateways and mobile money</p>
                                        <div class="badge bg-warning">Essential</div>
                                        <div class="mt-3">
                                            <small class="text-muted">Configure payment gateways, test transactions, manage fees</small>
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
</div>

@push('scripts')
<script>
function goToIntegrationPage(type) {
    const urls = {
        'sms': '{{ route("system-settings.integration.sms-api") }}',
        'email': '{{ route("system-settings.integration.email-api") }}',
        'payment': '{{ route("system-settings.integration.payment-api") }}'
    };
    
    if (urls[type]) {
        showNotification(`Redirecting to ${type.toUpperCase()} API configuration...`, 'info');
        setTimeout(() => {
            window.location.href = urls[type];
        }, 500);
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
