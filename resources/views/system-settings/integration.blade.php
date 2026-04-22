@extends('layouts.app')

@section('title', 'Integration Settings - FeedTan Pay')

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
                                    Integration Settings
                                </h4>
                                <p class="text-muted mb-0">Manage API integrations for SMS, Email, and Payment services</p>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('system-settings.integration.create') }}" class="btn btn-primary">
                                    <i class="bx bx-plus me-2"></i>Add New Integration
                                </a>
                                <button type="button" class="btn btn-outline-secondary" onclick="refreshIntegrations()">
                                    <i class="bx bx-refresh me-2"></i>Refresh
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Integration Statistics -->
        <div class="row mb-6">
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-primary bg-opacity-10 rounded-circle me-3" style="width: 48px; height: 48px;">
                                <i class="bx bx-message-square-dots text-primary fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">SMS APIs</h6>
                                <h4 class="mb-0">3</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-success bg-opacity-10 rounded-circle me-3" style="width: 48px; height: 48px;">
                                <i class="bx bx-envelope text-success fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Email APIs</h6>
                                <h4 class="mb-0">2</h4>
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
                                <i class="bx bx-credit-card text-warning fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Payment APIs</h6>
                                <h4 class="mb-0">5</h4>
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
                                <i class="bx bx-check-shield text-info fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Active</h6>
                                <h4 class="mb-0">8</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Integration Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0">
                                <i class="bx bx-list-ul me-2"></i>
                                API Integrations
                            </h5>
                            <small class="text-muted">Manage all third-party API integrations</small>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="bx bx-filter me-1"></i>Filter
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="javascript:void(0)" onclick="filterIntegrations('all')">All Integrations</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0)" onclick="filterIntegrations('sms')">SMS APIs</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0)" onclick="filterIntegrations('email')">Email APIs</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0)" onclick="filterIntegrations('payment')">Payment APIs</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="javascript:void(0)" onclick="filterIntegrations('active')">Active Only</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0)" onclick="filterIntegrations('inactive')">Inactive Only</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="integrationsTable">
                                <thead>
                                    <tr>
                                        <th>
                                            <i class="bx bx-tag me-1"></i>
                                            API Type
                                        </th>
                                        <th>
                                            <i class="bx bx-building me-1"></i>
                                            Provider
                                        </th>
                                        <th>
                                            <i class="bx bx-key me-1"></i>
                                            API Key
                                        </th>
                                        <th>
                                            <i class="bx bx-link me-1"></i>
                                            Endpoint URL
                                        </th>
                                        <th>
                                            <i class="bx bx-toggle me-1"></i>
                                            Status
                                        </th>
                                        <th>
                                            <i class="bx bx-time me-1"></i>
                                            Last Used
                                        </th>
                                        <th>
                                            <i class="bx bx-cog me-1"></i>
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- SMS APIs -->
                                    <tr data-type="sms" data-status="active">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar bg-primary bg-opacity-10 rounded-circle me-2" style="width: 32px; height: 32px;">
                                                    <i class="bx bx-message-square-dots text-primary"></i>
                                                </div>
                                                <span class="badge bg-primary">SMS API</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <strong>Twilio</strong>
                                                <small class="text-muted ms-2">International SMS</small>
                                            </div>
                                        </td>
                                        <td>
                                            <code class="bg-light p-1 rounded">ACf3...8jK2</code>
                                        </td>
                                        <td>
                                            <code class="text-primary">https://api.twilio.com/2010-04-01</code>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">Active</span>
                                        </td>
                                        <td>
                                            <small class="text-muted">2 hours ago</small>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-horizontal-rounded"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="viewIntegration('twilio-sms')">
                                                            <i class="bx bx-eye me-2"></i>View Details
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('system-settings.integration.edit', 'twilio-sms') }}">
                                                            <i class="bx bx-edit me-2"></i>Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="testIntegration('twilio-sms')">
                                                            <i class="bx bx-test-tube me-2"></i>Test Connection
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="toggleIntegration('twilio-sms')">
                                                            <i class="bx bx-toggle-left me-2"></i>Deactivate
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr data-type="sms" data-status="active">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar bg-primary bg-opacity-10 rounded-circle me-2" style="width: 32px; height: 32px;">
                                                    <i class="bx bx-message-square-dots text-primary"></i>
                                                </div>
                                                <span class="badge bg-primary">SMS API</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <strong>AfricasTalking</strong>
                                                <small class="text-muted ms-2">Local SMS</small>
                                            </div>
                                        </td>
                                        <td>
                                            <code class="bg-light p-1 rounded">ATf8...3mN9</code>
                                        </td>
                                        <td>
                                            <code class="text-primary">https://api.africastalking.com</code>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">Active</span>
                                        </td>
                                        <td>
                                            <small class="text-muted">5 minutes ago</small>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-horizontal-rounded"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="viewIntegration('at-sms')">
                                                            <i class="bx bx-eye me-2"></i>View Details
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('system-settings.integration.edit', 'at-sms') }}">
                                                            <i class="bx bx-edit me-2"></i>Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="testIntegration('at-sms')">
                                                            <i class="bx bx-test-tube me-2"></i>Test Connection
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="toggleIntegration('at-sms')">
                                                            <i class="bx bx-toggle-left me-2"></i>Deactivate
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr data-type="sms" data-status="inactive">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar bg-primary bg-opacity-10 rounded-circle me-2" style="width: 32px; height: 32px;">
                                                    <i class="bx bx-message-square-dots text-primary"></i>
                                                </div>
                                                <span class="badge bg-primary">SMS API</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <strong>Infobip</strong>
                                                <small class="text-muted ms-2">Global SMS</small>
                                            </div>
                                        </td>
                                        <td>
                                            <code class="bg-light p-1 rounded">IBf2...9kL1</code>
                                        </td>
                                        <td>
                                            <code class="text-primary">https://api.infobip.com</code>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">Inactive</span>
                                        </td>
                                        <td>
                                            <small class="text-muted">3 days ago</small>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-horizontal-rounded"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="viewIntegration('infobip-sms')">
                                                            <i class="bx bx-eye me-2"></i>View Details
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('system-settings.integration.edit', 'infobip-sms') }}">
                                                            <i class="bx bx-edit me-2"></i>Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="testIntegration('infobip-sms')">
                                                            <i class="bx bx-test-tube me-2"></i>Test Connection
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="toggleIntegration('infobip-sms')">
                                                            <i class="bx bx-toggle-right me-2"></i>Activate
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Email APIs -->
                                    <tr data-type="email" data-status="active">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar bg-success bg-opacity-10 rounded-circle me-2" style="width: 32px; height: 32px;">
                                                    <i class="bx bx-envelope text-success"></i>
                                                </div>
                                                <span class="badge bg-success">Email API</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <strong>SendGrid</strong>
                                                <small class="text-muted ms-2">Transactional Email</small>
                                            </div>
                                        </td>
                                        <td>
                                            <code class="bg-light p-1 rounded">SG.k8...mN2</code>
                                        </td>
                                        <td>
                                            <code class="text-primary">https://api.sendgrid.com/v3</code>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">Active</span>
                                        </td>
                                        <td>
                                            <small class="text-muted">1 hour ago</small>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-horizontal-rounded"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="viewIntegration('sendgrid-email')">
                                                            <i class="bx bx-eye me-2"></i>View Details
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('system-settings.integration.edit', 'sendgrid-email') }}">
                                                            <i class="bx bx-edit me-2"></i>Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="testIntegration('sendgrid-email')">
                                                            <i class="bx bx-test-tube me-2"></i>Test Connection
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="toggleIntegration('sendgrid-email')">
                                                            <i class="bx bx-toggle-left me-2"></i>Deactivate
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr data-type="email" data-status="active">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar bg-success bg-opacity-10 rounded-circle me-2" style="width: 32px; height: 32px;">
                                                    <i class="bx bx-envelope text-success"></i>
                                                </div>
                                                <span class="badge bg-success">Email API</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <strong>Mailgun</strong>
                                                <small class="text-muted ms-2">Email Service</small>
                                            </div>
                                        </td>
                                        <td>
                                            <code class="bg-light p-1 rounded">MG.p3...kL8</code>
                                        </td>
                                        <td>
                                            <code class="text-primary">https://api.mailgun.net/v3</code>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">Active</span>
                                        </td>
                                        <td>
                                            <small class="text-muted">30 minutes ago</small>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-horizontal-rounded"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="viewIntegration('mailgun-email')">
                                                            <i class="bx bx-eye me-2"></i>View Details
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('system-settings.integration.edit', 'mailgun-email') }}">
                                                            <i class="bx bx-edit me-2"></i>Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="testIntegration('mailgun-email')">
                                                            <i class="bx bx-test-tube me-2"></i>Test Connection
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="toggleIntegration('mailgun-email')">
                                                            <i class="bx bx-toggle-left me-2"></i>Deactivate
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Payment APIs -->
                                    <tr data-type="payment" data-status="active">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar bg-warning bg-opacity-10 rounded-circle me-2" style="width: 32px; height: 32px;">
                                                    <i class="bx bx-credit-card text-warning"></i>
                                                </div>
                                                <span class="badge bg-warning">Payment API</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <strong>M-Pesa</strong>
                                                <small class="text-muted ms-2">Mobile Money</small>
                                            </div>
                                        </td>
                                        <td>
                                            <code class="bg-light p-1 rounded">MP.s9...2kL4</code>
                                        </td>
                                        <td>
                                            <code class="text-primary">https://api.safaricom.co.ke</code>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">Active</span>
                                        </td>
                                        <td>
                                            <small class="text-muted">Just now</small>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-horizontal-rounded"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="viewIntegration('mpesa-payment')">
                                                            <i class="bx bx-eye me-2"></i>View Details
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('system-settings.integration.edit', 'mpesa-payment') }}">
                                                            <i class="bx bx-edit me-2"></i>Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="testIntegration('mpesa-payment')">
                                                            <i class="bx bx-test-tube me-2"></i>Test Connection
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="toggleIntegration('mpesa-payment')">
                                                            <i class="bx bx-toggle-left me-2"></i>Deactivate
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr data-type="payment" data-status="active">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar bg-warning bg-opacity-10 rounded-circle me-2" style="width: 32px; height: 32px;">
                                                    <i class="bx bx-credit-card text-warning"></i>
                                                </div>
                                                <span class="badge bg-warning">Payment API</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <strong>Tigo Pesa</strong>
                                                <small class="text-muted ms-2">Mobile Money</small>
                                            </div>
                                        </td>
                                        <td>
                                            <code class="bg-light p-1 rounded">TP.m7...3kN5</code>
                                        </td>
                                        <td>
                                            <code class="text-primary">https://api.tigopesa.co.tz</code>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">Active</span>
                                        </td>
                                        <td>
                                            <small class="text-muted">15 minutes ago</small>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-horizontal-rounded"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="viewIntegration('tigo-payment')">
                                                            <i class="bx bx-eye me-2"></i>View Details
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('system-settings.integration.edit', 'tigo-payment') }}">
                                                            <i class="bx bx-edit me-2"></i>Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="testIntegration('tigo-payment')">
                                                            <i class="bx bx-test-tube me-2"></i>Test Connection
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="toggleIntegration('tigo-payment')">
                                                            <i class="bx bx-toggle-left me-2"></i>Deactivate
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr data-type="payment" data-status="active">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar bg-warning bg-opacity-10 rounded-circle me-2" style="width: 32px; height: 32px;">
                                                    <i class="bx bx-credit-card text-warning"></i>
                                                </div>
                                                <span class="badge bg-warning">Payment API</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <strong>Airtel Money</strong>
                                                <small class="text-muted ms-2">Mobile Money</small>
                                            </div>
                                        </td>
                                        <td>
                                            <code class="bg-light p-1 rounded">AM.l8...4kM6</code>
                                        </td>
                                        <td>
                                            <code class="text-primary">https://api.airtelmoney.co.tz</code>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning">Slow</span>
                                        </td>
                                        <td>
                                            <small class="text-muted">45 minutes ago</small>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-horizontal-rounded"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="viewIntegration('airtel-payment')">
                                                            <i class="bx bx-eye me-2"></i>View Details
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('system-settings.integration.edit', 'airtel-payment') }}">
                                                            <i class="bx bx-edit me-2"></i>Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="testIntegration('airtel-payment')">
                                                            <i class="bx bx-test-tube me-2"></i>Test Connection
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="toggleIntegration('airtel-payment')">
                                                            <i class="bx bx-toggle-left me-2"></i>Deactivate
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr data-type="payment" data-status="active">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar bg-warning bg-opacity-10 rounded-circle me-2" style="width: 32px; height: 32px;">
                                                    <i class="bx bx-credit-card text-warning"></i>
                                                </div>
                                                <span class="badge bg-warning">Payment API</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <strong>Halopesa</strong>
                                                <small class="text-muted ms-2">Mobile Money</small>
                                            </div>
                                        </td>
                                        <td>
                                            <code class="bg-light p-1 rounded">HP.n4...7kL9</code>
                                        </td>
                                        <td>
                                            <code class="text-primary">https://api.halopesa.co.tz</code>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">Active</span>
                                        </td>
                                        <td>
                                            <small class="text-muted">2 hours ago</small>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-horizontal-rounded"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="viewIntegration('halopesa-payment')">
                                                            <i class="bx bx-eye me-2"></i>View Details
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('system-settings.integration.edit', 'halopesa-payment') }}">
                                                            <i class="bx bx-edit me-2"></i>Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="testIntegration('halopesa-payment')">
                                                            <i class="bx bx-test-tube me-2"></i>Test Connection
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="toggleIntegration('halopesa-payment')">
                                                            <i class="bx bx-toggle-left me-2"></i>Deactivate
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr data-type="payment" data-status="inactive">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar bg-warning bg-opacity-10 rounded-circle me-2" style="width: 32px; height: 32px;">
                                                    <i class="bx bx-credit-card text-warning"></i>
                                                </div>
                                                <span class="badge bg-warning">Payment API</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <strong>Stripe</strong>
                                                <small class="text-muted ms-2">Card Payments</small>
                                            </div>
                                        </td>
                                        <td>
                                            <code class="bg-light p-1 rounded">ST.r5...8mK3</code>
                                        </td>
                                        <td>
                                            <code class="text-primary">https://api.stripe.com/v1</code>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">Inactive</span>
                                        </td>
                                        <td>
                                            <small class="text-muted">1 week ago</small>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-horizontal-rounded"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="viewIntegration('stripe-payment')">
                                                            <i class="bx bx-eye me-2"></i>View Details
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('system-settings.integration.edit', 'stripe-payment') }}">
                                                            <i class="bx bx-edit me-2"></i>Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="testIntegration('stripe-payment')">
                                                            <i class="bx bx-test-tube me-2"></i>Test Connection
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="toggleIntegration('stripe-payment')">
                                                            <i class="bx bx-toggle-right me-2"></i>Activate
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="d-flex gap-2 justify-content-center">
                    <a href="{{ route('system-settings.integration.create') }}" class="btn btn-primary">
                        <i class="bx bx-plus me-2"></i>Add New Integration
                    </a>
                    <button class="btn btn-outline-success" onclick="testAllIntegrations()">
                        <i class="bx bx-test-tube me-2"></i>Test All Connections
                    </button>
                    <button class="btn btn-outline-info" onclick="exportIntegrations()">
                        <i class="bx bx-download me-2"></i>Export Configuration
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- View Integration Modal -->
<div class="modal fade" id="viewIntegrationModal" tabindex="-1" aria-labelledby="viewIntegrationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="viewIntegrationModalLabel">
                    <i class="bx bx-eye me-2"></i>Integration Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="integrationDetails"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x me-2"></i>Close
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function refreshIntegrations() {
    // Simulate data refresh
    console.log('Refreshing integrations...');
    location.reload();
}

function filterIntegrations(filter) {
    const table = document.getElementById('integrationsTable');
    const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    
    for (let row of rows) {
        let showRow = false;
        
        switch(filter) {
            case 'all':
                showRow = true;
                break;
            case 'active':
                showRow = row.getAttribute('data-status') === 'active';
                break;
            case 'inactive':
                showRow = row.getAttribute('data-status') === 'inactive';
                break;
            default:
                showRow = row.getAttribute('data-type') === filter;
        }
        
        row.style.display = showRow ? '' : 'none';
    }
}

function viewIntegration(id) {
    // Simulate fetching integration details
    const integrationData = {
        'twilio-sms': {
            name: 'Twilio SMS API',
            type: 'SMS API',
            provider: 'Twilio',
            apiKey: 'ACf3d8e9f2g7h1i4j5k6l8m9n0p2q3r4s5t6u7v8w9x0y1z2',
            endpoint: 'https://api.twilio.com/2010-04-01',
            status: 'Active',
            lastUsed: '2 hours ago',
            description: 'International SMS service for global messaging',
            features: ['International SMS', 'MMS Support', 'Delivery Reports', 'Webhook Support'],
            limits: '1000 messages/hour',
            pricing: 'TZS 120 per SMS'
        }
    };
    
    const data = integrationData[id] || integrationData['twilio-sms'];
    
    const details = `
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label text-muted">Integration Name</label>
                    <div class="fw-bold">${data.name}</div>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted">API Type</label>
                    <div><span class="badge bg-primary">${data.type}</span></div>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted">Provider</label>
                    <div class="fw-bold">${data.provider}</div>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted">Status</label>
                    <div><span class="badge bg-success">${data.status}</span></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label text-muted">API Key</label>
                    <div><code class="bg-light p-2 rounded">${data.apiKey}</code></div>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted">Endpoint URL</label>
                    <div><code class="text-primary">${data.endpoint}</code></div>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted">Last Used</label>
                    <div>${data.lastUsed}</div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <div class="mb-3">
                    <label class="form-label text-muted">Description</label>
                    <div class="bg-light p-2 rounded">${data.description}</div>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted">Features</label>
                    <div>
                        ${data.features.map(feature => `<span class="badge bg-info me-1">${feature}</span>`).join('')}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">Rate Limits</label>
                            <div>${data.limits}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">Pricing</label>
                            <div>${data.pricing}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    document.getElementById('integrationDetails').innerHTML = details;
    
    const modal = new bootstrap.Modal(document.getElementById('viewIntegrationModal'));
    modal.show();
}

function testIntegration(id) {
    // Simulate testing integration
    showNotification(`Testing connection for ${id}...`, 'info');
    
    setTimeout(() => {
        showNotification('Connection test successful!', 'success');
    }, 2000);
}

function toggleIntegration(id) {
    // Simulate toggling integration status
    showNotification(`Toggling status for ${id}...`, 'info');
    
    setTimeout(() => {
        showNotification('Integration status updated!', 'success');
        location.reload();
    }, 1000);
}

function testAllIntegrations() {
    showNotification('Testing all integrations...', 'info');
    
    setTimeout(() => {
        showNotification('All integrations tested successfully!', 'success');
    }, 3000);
}

function exportIntegrations() {
    // Simulate exporting configuration
    const config = {
        timestamp: new Date().toISOString(),
        integrations: [
            { type: 'SMS', provider: 'Twilio', status: 'Active' },
            { type: 'Email', provider: 'SendGrid', status: 'Active' },
            { type: 'Payment', provider: 'M-Pesa', status: 'Active' }
        ]
    };
    
    const dataStr = JSON.stringify(config, null, 2);
    const dataUri = 'data:application/json;charset=utf-8,'+ encodeURIComponent(dataStr);
    
    const exportFileDefaultName = `integrations-config-${new Date().toISOString().split('T')[0]}.json`;
    
    const linkElement = document.createElement('a');
    linkElement.setAttribute('href', dataUri);
    linkElement.setAttribute('download', exportFileDefaultName);
    linkElement.click();
    
    showNotification('Configuration exported successfully!', 'success');
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

// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endpush
@endsection
