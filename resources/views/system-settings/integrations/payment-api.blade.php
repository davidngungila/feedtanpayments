@extends('layouts.app')

@section('title', 'Payment API Integration - FeedTan Pay')
@section('description', 'Configure payment gateways and mobile money APIs')

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
                                    <i class="bx bx-dollar-circle me-2 text-warning"></i>
                                    Payment API Integration
                                </h4>
                                <p class="text-muted mb-0">Integrate payment gateways and mobile money services</p>
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
                                <h6 class="mb-0">Active Gateways</h6>
                                <h4 class="mb-0">4</h4>
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
                                <i class="bx bx-credit-card text-info fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Transactions</h6>
                                <h4 class="mb-0">12,847</h4>
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
                                <i class="bx bx-trending-up text-warning fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Success Rate</h6>
                                <h4 class="mb-0">94.7%</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Gateway Configuration -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0">
                                <i class="bx bx-cog me-2"></i>
                                Payment Gateway Configurations
                            </h5>
                            <small class="text-muted">Configure your payment gateway providers</small>
                        </div>
                        <button type="button" class="btn btn-primary" onclick="addPaymentGateway()">
                            <i class="bx bx-plus me-2"></i>Add Payment Gateway
                        </button>
                    </div>
                    <div class="card-body">
                        <!-- Mobile Money Gateway -->
                        <div class="border rounded p-4 mb-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h6 class="mb-1">
                                        <i class="bx bx-mobile-alt text-success me-2"></i>
                                        Tigo Pesa Mobile Money
                                    </h6>
                                    <small class="text-muted">Mobile Money Payment Gateway - Tanzania</small>
                                </div>
                                <div>
                                    <span class="badge bg-success">Active</span>
                                    <span class="badge bg-primary ms-1">Primary</span>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Gateway Name</label>
                                        <input type="text" class="form-control" value="Tigo Pesa" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">API Endpoint</label>
                                        <input type="url" class="form-control" value="https://api.tigopesa.co.tz/v2" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Business Number</label>
                                        <input type="text" class="form-control" value="255714600000" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">API Key</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" value="tp_live_xxxxxxxxxxxxxxxxxxxx" readonly>
                                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword(this)">
                                                <i class="bx bx-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Secret Key</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" value="sk_live_xxxxxxxxxxxxxxxxxxxx" readonly>
                                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword(this)">
                                                <i class="bx bx-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Transaction Fee</label>
                                        <input type="text" class="form-control" value="TZS 500 + 1.5%" readonly>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-outline-primary" onclick="editPaymentGateway(1)">
                                    <i class="bx bx-edit me-2"></i>Edit
                                </button>
                                <button type="button" class="btn btn-outline-success" onclick="testPaymentGateway(1)">
                                    <i class="bx bx-test-tube me-2"></i>Test Connection
                                </button>
                                <button type="button" class="btn btn-outline-warning" onclick="toggleGateway(1)">
                                    <i class="bx bx-pause me-2"></i>Deactivate
                                </button>
                            </div>
                        </div>

                        <!-- M-Pesa Gateway -->
                        <div class="border rounded p-4 mb-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h6 class="mb-1">
                                        <i class="bx bx-mobile-alt text-info me-2"></i>
                                        M-Pesa Mobile Money
                                    </h6>
                                    <small class="text-muted">Safaricom M-Pesa API - Kenya & Tanzania</small>
                                </div>
                                <div>
                                    <span class="badge bg-success">Active</span>
                                    <span class="badge bg-info ms-1">Secondary</span>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Gateway Name</label>
                                        <input type="text" class="form-control" value="M-Pesa" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">API Endpoint</label>
                                        <input type="url" class="form-control" value="https://api.safaricom.co.ke/mpesa" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Shortcode</label>
                                        <input type="text" class="form-control" value="174379" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Consumer Key</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" value="xxxxxxxxxxxxxxxxxxxxxxxxxxx" readonly>
                                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword(this)">
                                                <i class="bx bx-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Consumer Secret</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" value="xxxxxxxxxxxxxxxxxxxxxxxxxxx" readonly>
                                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword(this)">
                                                <i class="bx bx-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Transaction Fee</label>
                                        <input type="text" class="form-control" value="TZS 27.50" readonly>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-outline-primary" onclick="editPaymentGateway(2)">
                                    <i class="bx bx-edit me-2"></i>Edit
                                </button>
                                <button type="button" class="btn btn-outline-success" onclick="testPaymentGateway(2)">
                                    <i class="bx bx-test-tube me-2"></i>Test Connection
                                </button>
                                <button type="button" class="btn btn-outline-warning" onclick="toggleGateway(2)">
                                    <i class="bx bx-pause me-2"></i>Deactivate
                                </button>
                            </div>
                        </div>

                        <!-- Bank Transfer Gateway -->
                        <div class="border rounded p-4 mb-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h6 class="mb-1">
                                        <i class="bx bx-building text-warning me-2"></i>
                                        CRDB Bank Transfer
                                    </h6>
                                    <small class="text-muted">Bank Transfer API - Tanzania</small>
                                </div>
                                <div>
                                    <span class="badge bg-success">Active</span>
                                    <span class="badge bg-secondary ms-1">Bank</span>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Gateway Name</label>
                                        <input type="text" class="form-control" value="CRDB Bank" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">API Endpoint</label>
                                        <input type="url" class="form-control" value="https://api.crdbbank.co.tz/v1" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Account Number</label>
                                        <input type="text" class="form-control" value="0152156789001" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">API Username</label>
                                        <input type="text" class="form-control" value="feedtanpay_api" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">API Password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" value="********" readonly>
                                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword(this)">
                                                <i class="bx bx-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Transaction Fee</label>
                                        <input type="text" class="form-control" value="TZS 1,000" readonly>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-outline-primary" onclick="editPaymentGateway(3)">
                                    <i class="bx bx-edit me-2"></i>Edit
                                </button>
                                <button type="button" class="btn btn-outline-success" onclick="testPaymentGateway(3)">
                                    <i class="bx bx-test-tube me-2"></i>Test Connection
                                </button>
                                <button type="button" class="btn btn-outline-warning" onclick="toggleGateway(3)">
                                    <i class="bx bx-pause me-2"></i>Deactivate
                                </button>
                            </div>
                        </div>

                        <!-- Card Payment Gateway -->
                        <div class="border rounded p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h6 class="mb-1">
                                        <i class="bx bx-credit-card text-primary me-2"></i>
                                        Stripe Card Payment
                                    </h6>
                                    <small class="text-muted">International Card Payment Gateway</small>
                                </div>
                                <div>
                                    <span class="badge bg-success">Active</span>
                                    <span class="badge bg-info ms-1">Cards</span>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Gateway Name</label>
                                        <input type="text" class="form-control" value="Stripe" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">API Endpoint</label>
                                        <input type="url" class="form-control" value="https://api.stripe.com/v1" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Supported Cards</label>
                                        <input type="text" class="form-control" value="Visa, Mastercard, Amex" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Publishable Key</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" value="pk_live_xxxxxxxxxxxxxxxxxxxx" readonly>
                                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword(this)">
                                                <i class="bx bx-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Secret Key</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" value="sk_live_xxxxxxxxxxxxxxxxxxxx" readonly>
                                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword(this)">
                                                <i class="bx bx-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Transaction Fee</label>
                                        <input type="text" class="form-control" value="2.9% + TZS 300" readonly>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-outline-primary" onclick="editPaymentGateway(4)">
                                    <i class="bx bx-edit me-2"></i>Edit
                                </button>
                                <button type="button" class="btn btn-outline-success" onclick="testPaymentGateway(4)">
                                    <i class="bx bx-test-tube me-2"></i>Test Connection
                                </button>
                                <button type="button" class="btn btn-outline-warning" onclick="toggleGateway(4)">
                                    <i class="bx bx-pause me-2"></i>Deactivate
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Settings -->
        <div class="row mt-6">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-cog me-2"></i>
                            Payment Settings
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Default Currency</label>
                            <select class="form-select">
                                <option value="TZS" selected>Tanzanian Shilling (TZS)</option>
                                <option value="USD">US Dollar (USD)</option>
                                <option value="EUR">Euro (EUR)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Minimum Transaction Amount</label>
                            <input type="number" class="form-control" value="1000" min="0">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Maximum Transaction Amount</label>
                            <input type="number" class="form-control" value="10000000" min="0">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Transaction Timeout (minutes)</label>
                            <input type="number" class="form-control" value="15" min="1" max="60">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Auto Retry Failed Payments</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="autoRetry" checked>
                                <label class="form-check-label" for="autoRetry">
                                    Enable automatic retry for failed transactions
                                </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Retry Attempts</label>
                            <input type="number" class="form-control" value="3" min="1" max="5">
                        </div>
                        <button type="button" class="btn btn-primary" onclick="savePaymentSettings()">
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
                            Test Transaction
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Test Amount (TZS)</label>
                            <input type="number" class="form-control" id="testAmount" placeholder="1000" value="1000" min="100" max="10000">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Test Phone Number</label>
                            <input type="text" class="form-control" id="testPhone" placeholder="255712345678" value="255700000000">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Select Gateway</label>
                            <select class="form-select" id="testGateway">
                                <option value="1">Tigo Pesa</option>
                                <option value="2">M-Pesa</option>
                                <option value="3">CRDB Bank</option>
                                <option value="4">Stripe</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Payment Type</label>
                            <select class="form-select" id="paymentType">
                                <option value="mobile">Mobile Money</option>
                                <option value="bank">Bank Transfer</option>
                                <option value="card">Card Payment</option>
                            </select>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="useTestMode" checked>
                            <label class="form-check-label" for="useTestMode">
                                Use test mode (no actual charges)
                            </label>
                        </div>
                        <button type="button" class="btn btn-success" onclick="sendTestPayment()">
                            <i class="bx bx-dollar-circle me-2"></i>Send Test Payment
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit Payment Gateway Modal -->
<div class="modal fade" id="paymentGatewayModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title">
                    <i class="bx bx-dollar-circle me-2"></i>
                    Add Payment Gateway
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="paymentGatewayForm">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="gatewayName" class="form-label">Gateway Name *</label>
                            <input type="text" class="form-control" id="gatewayName" required placeholder="e.g., Tigo Pesa">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="gatewayType" class="form-label">Gateway Type *</label>
                            <select class="form-select" id="gatewayType" required>
                                <option value="">Select Type</option>
                                <option value="mobile">Mobile Money</option>
                                <option value="bank">Bank Transfer</option>
                                <option value="card">Card Payment</option>
                                <option value="crypto">Cryptocurrency</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="apiEndpoint" class="form-label">API Endpoint *</label>
                            <input type="url" class="form-control" id="apiEndpoint" required placeholder="https://api.gateway.com/v1">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="businessNumber" class="form-label">Business Number/Account</label>
                            <input type="text" class="form-control" id="businessNumber" placeholder="255714600000">
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
                                        API Key/Secret
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="authMethod" id="authBasic" value="basic">
                                    <label class="form-check-label" for="authBasic">
                                        Basic Authentication
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="authMethod" id="authOAuth" value="oauth">
                                    <label class="form-check-label" for="authOAuth">
                                        OAuth 2.0
                                    </label>
                                </div>
                            </div>
                            
                            <div id="apiKeyFields">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="apiKey" class="form-label">API Key *</label>
                                        <input type="text" class="form-control" id="apiKey" placeholder="Enter API key">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="secretKey" class="form-label">Secret Key *</label>
                                        <input type="password" class="form-control" id="secretKey" placeholder="Enter secret key">
                                    </div>
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
                            
                            <div id="oauthFields" style="display: none;">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="clientId" class="form-label">Client ID *</label>
                                        <input type="text" class="form-control" id="clientId" placeholder="client_id">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="clientSecret" class="form-label">Client Secret *</label>
                                        <input type="password" class="form-control" id="clientSecret" placeholder="client_secret">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="transactionFee" class="form-label">Transaction Fee</label>
                            <input type="text" class="form-control" id="transactionFee" placeholder="TZS 500 + 1.5%">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="dailyLimit" class="form-label">Daily Limit</label>
                            <input type="number" class="form-control" id="dailyLimit" value="1000000" min="0">
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
                <button type="button" class="btn btn-warning" onclick="savePaymentGateway()">Save Gateway</button>
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
        const oauthFields = document.getElementById('oauthFields');
        
        apiKeyFields.style.display = 'none';
        basicAuthFields.style.display = 'none';
        oauthFields.style.display = 'none';
        
        if (this.value === 'apikey') {
            apiKeyFields.style.display = 'block';
        } else if (this.value === 'basic') {
            basicAuthFields.style.display = 'block';
        } else if (this.value === 'oauth') {
            oauthFields.style.display = 'block';
        }
    });
});

function addPaymentGateway() {
    document.getElementById('paymentGatewayForm').reset();
    document.getElementById('apiKeyFields').style.display = 'block';
    document.getElementById('authApiKey').checked = true;
    
    const modal = new bootstrap.Modal(document.getElementById('paymentGatewayModal'));
    modal.show();
}

function editPaymentGateway(gatewayId) {
    // Load gateway data based on ID
    const gatewayData = {
        1: {
            name: 'Tigo Pesa',
            type: 'mobile',
            apiEndpoint: 'https://api.tigopesa.co.tz/v2',
            businessNumber: '255714600000',
            apiKey: 'tp_live_xxxxxxxxxxxxxxxxxxxx',
            secretKey: 'sk_live_xxxxxxxxxxxxxxxxxxxx',
            transactionFee: 'TZS 500 + 1.5%',
            dailyLimit: 5000000,
            testMode: false,
            notes: 'Primary mobile money gateway for Tanzania'
        },
        2: {
            name: 'M-Pesa',
            type: 'mobile',
            apiEndpoint: 'https://api.safaricom.co.ke/mpesa',
            businessNumber: '174379',
            apiKey: 'xxxxxxxxxxxxxxxxxxxxxxxxxxx',
            secretKey: 'xxxxxxxxxxxxxxxxxxxxxxxxxxx',
            transactionFee: 'TZS 27.50',
            dailyLimit: 3000000,
            testMode: false,
            notes: 'Safaricom M-Pesa gateway'
        },
        3: {
            name: 'CRDB Bank',
            type: 'bank',
            apiEndpoint: 'https://api.crdbbank.co.tz/v1',
            businessNumber: '0152156789001',
            username: 'feedtanpay_api',
            password: '********',
            transactionFee: 'TZS 1,000',
            dailyLimit: 10000000,
            testMode: false,
            notes: 'CRDB Bank transfer gateway'
        },
        4: {
            name: 'Stripe',
            type: 'card',
            apiEndpoint: 'https://api.stripe.com/v1',
            businessNumber: '',
            apiKey: 'pk_live_xxxxxxxxxxxxxxxxxxxx',
            secretKey: 'sk_live_xxxxxxxxxxxxxxxxxxxx',
            transactionFee: '2.9% + TZS 300',
            dailyLimit: 20000000,
            testMode: false,
            notes: 'International card payment gateway'
        }
    };
    
    const data = gatewayData[gatewayId];
    if (data) {
        document.getElementById('gatewayName').value = data.name;
        document.getElementById('gatewayType').value = data.type;
        document.getElementById('apiEndpoint').value = data.apiEndpoint;
        document.getElementById('businessNumber').value = data.businessNumber;
        document.getElementById('transactionFee').value = data.transactionFee;
        document.getElementById('dailyLimit').value = data.dailyLimit;
        document.getElementById('testMode').checked = data.testMode;
        document.getElementById('notes').value = data.notes;
        
        // Set authentication fields based on gateway type
        if (data.username) {
            document.getElementById('authBasic').checked = true;
            document.getElementById('basicAuthFields').style.display = 'block';
            document.getElementById('apiKeyFields').style.display = 'none';
            document.getElementById('oauthFields').style.display = 'none';
            document.getElementById('username').value = data.username;
            document.getElementById('password').value = data.password;
        } else {
            document.getElementById('authApiKey').checked = true;
            document.getElementById('apiKeyFields').style.display = 'block';
            document.getElementById('basicAuthFields').style.display = 'none';
            document.getElementById('oauthFields').style.display = 'none';
            document.getElementById('apiKey').value = data.apiKey;
            document.getElementById('secretKey').value = data.secretKey;
        }
        
        const modal = new bootstrap.Modal(document.getElementById('paymentGatewayModal'));
        modal.show();
    }
}

function savePaymentGateway() {
    const form = document.getElementById('paymentGatewayForm');
    if (!form.checkValidity()) {
        showNotification('Please fill in all required fields', 'warning');
        return;
    }
    
    showNotification('Saving payment gateway...', 'info');
    
    // Simulate API call
    setTimeout(() => {
        showNotification('Payment gateway saved successfully!', 'success');
        bootstrap.Modal.getInstance(document.getElementById('paymentGatewayModal')).hide();
        setTimeout(() => location.reload(), 1500);
    }, 1500);
}

function testPaymentGateway(gatewayId) {
    showNotification('Testing payment gateway connection...', 'info');
    
    // Simulate API test
    setTimeout(() => {
        const success = Math.random() > 0.2; // 80% success rate
        
        if (success) {
            showTestResult(true, 'Connection successful', {
                status: 'success',
                response_time: '456ms',
                api_version: 'v2',
                authentication: 'valid',
                business_number: 'verified'
            });
        } else {
            showTestResult(false, 'Connection failed', {
                error: 'Authentication failed',
                error_code: '401',
                suggestion: 'Check your API credentials'
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

function toggleGateway(gatewayId) {
    const action = confirm('Are you sure you want to toggle this gateway status?');
    if (action) {
        showNotification('Toggling gateway status...', 'info');
        setTimeout(() => {
            showNotification('Gateway status updated successfully', 'success');
            setTimeout(() => location.reload(), 1500);
        }, 1000);
    }
}

function savePaymentSettings() {
    showNotification('Saving payment settings...', 'info');
    setTimeout(() => {
        showNotification('Payment settings saved successfully!', 'success');
    }, 1000);
}

function sendTestPayment() {
    const amount = document.getElementById('testAmount').value;
    const phone = document.getElementById('testPhone').value;
    const gateway = document.getElementById('testGateway').value;
    const paymentType = document.getElementById('paymentType').value;
    const testMode = document.getElementById('useTestMode').checked;
    
    if (!amount || !phone) {
        showNotification('Please fill in amount and phone number', 'warning');
        return;
    }
    
    showNotification('Sending test payment...', 'info');
    
    // Simulate API call
    setTimeout(() => {
        showNotification('Test payment initiated successfully!', 'success');
        
        // Show result
        showTestResult(true, 'Test payment initiated', {
            amount: 'TZS ' + parseInt(amount).toLocaleString(),
            phone: phone,
            gateway: gateway === '1' ? 'Tigo Pesa' : (gateway === '2' ? 'M-Pesa' : (gateway === '3' ? 'CRDB Bank' : 'Stripe')),
            payment_type: paymentType,
            test_mode: testMode,
            transaction_id: 'TXN_' + Math.random().toString(36).substr(2, 9).toUpperCase(),
            status: 'pending'
        });
    }, 2000);
}

function testAllConnections() {
    showNotification('Testing all payment gateway connections...', 'info');
    
    setTimeout(() => {
        showNotification('Connection tests completed', 'success');
        showTestResult(true, 'All gateways tested', {
            tigo_pesa: 'Connected',
            m_pesa: 'Connected',
            crdb_bank: 'Connected',
            stripe: 'Connected',
            summary: '4/4 gateways working properly'
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
