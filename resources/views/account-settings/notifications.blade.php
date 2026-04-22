@extends('layouts.app')

@section('title', 'Notification Settings - FeedTan Pay')
@section('description', 'Manage your notification preferences and settings')

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
                                    <i class="bx bx-bell me-2 text-primary"></i>
                                    Notification Settings
                                </h4>
                                <p class="text-muted mb-0">Configure your email, SMS, and push notification preferences</p>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-outline-success" onclick="testNotifications()">
                                    <i class="bx bx-test-tube me-2"></i>Test Notifications
                                </button>
                                <button type="button" class="btn btn-outline-secondary" onclick="refreshNotifications()">
                                    <i class="bx bx-refresh me-2"></i>Refresh
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notification Overview -->
        <div class="row mb-6">
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-primary bg-opacity-10 rounded-circle me-3" style="width: 48px; height: 48px;">
                                <i class="bx bx-envelope text-primary fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Email Notifications</h6>
                                <h4 class="mb-0">8</h4>
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
                                <i class="bx bx-mobile-alt text-success fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">SMS Notifications</h6>
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
                            <div class="avatar bg-warning bg-opacity-10 rounded-circle me-3" style="width: 48px; height: 48px;">
                                <i class="bx bx-bell text-warning fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Push Notifications</h6>
                                <h4 class="mb-0">6</h4>
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
                                <i class="bx bx-check-circle text-info fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Active Rules</h6>
                                <h4 class="mb-0">19</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Email Notifications -->
        <div class="row mb-6">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0">
                                <i class="bx bx-envelope me-2"></i>
                                Email Notifications
                            </h5>
                            <small class="text-muted">Configure email notification preferences</small>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-sm btn-primary" onclick="addEmailNotification()">
                                <i class="bx bx-plus me-1"></i>Add Rule
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="refreshEmailNotifications()">
                                <i class="bx bx-refresh me-1"></i>Refresh
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="emailNotificationsTable">
                                <thead>
                                    <tr>
                                        <th>
                                            <i class="bx bx-tag me-1"></i>
                                            Rule Name
                                        </th>
                                        <th>
                                            <i class="bx bx-text me-1"></i>
                                            Description
                                        </th>
                                        <th>
                                            <i class="bx bx-category me-1"></i>
                                            Type
                                        </th>
                                        <th>
                                            <i class="bx bx-time me-1"></i>
                                            Frequency
                                        </th>
                                        <th>
                                            <i class="bx bx-globe me-1"></i>
                                            Status
                                        </th>
                                        <th>
                                            <i class="bx bx-cog me-1"></i>
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <strong>Transaction Updates</strong>
                                        </td>
                                        <td>
                                            <small>Get notified when payments are sent or received</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">Transactional</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">Immediate</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">Active</span>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-horizontal-rounded"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="viewEmailNotification(1)"><i class="bx bx-eye me-2"></i>View Details</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="editEmailNotification(1)"><i class="bx bx-edit me-2"></i>Edit</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="testEmailNotification(1)"><i class="bx bx-test-tube me-2"></i>Test</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="deleteEmailNotification(1)"><i class="bx bx-trash me-2"></i>Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>Security Alerts</strong>
                                        </td>
                                        <td>
                                            <small>Important security notifications about your account</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning">Security</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">Immediate</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">Active</span>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-horizontal-rounded"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="viewEmailNotification(2)"><i class="bx bx-eye me-2"></i>View Details</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="editEmailNotification(2)"><i class="bx bx-edit me-2"></i>Edit</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="testEmailNotification(2)"><i class="bx bx-test-tube me-2"></i>Test</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="deleteEmailNotification(2)"><i class="bx bx-trash me-2"></i>Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>Marketing Emails</strong>
                                        </td>
                                        <td>
                                            <small>Updates about new features and promotions</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">Marketing</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning">Weekly</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">Disabled</span>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-horizontal-rounded"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="viewEmailNotification(3)"><i class="bx bx-eye me-2"></i>View Details</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="editEmailNotification(3)"><i class="bx bx-edit me-2"></i>Edit</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="testEmailNotification(3)"><i class="bx bx-test-tube me-2"></i>Test</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="deleteEmailNotification(3)"><i class="bx bx-trash me-2"></i>Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>Bill Reminders</strong>
                                        </td>
                                        <td>
                                            <small>Remind you before bills are due</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">Reminder</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning">Daily</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">Active</span>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-horizontal-rounded"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="viewEmailNotification(4)"><i class="bx bx-eye me-2"></i>View Details</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="editEmailNotification(4)"><i class="bx bx-edit me-2"></i>Edit</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="testEmailNotification(4)"><i class="bx bx-test-tube me-2"></i>Test</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="deleteEmailNotification(4)"><i class="bx bx-trash me-2"></i>Delete</a></li>
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

        <!-- SMS Notifications -->
        <div class="row mb-6">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0">
                                <i class="bx bx-mobile-alt me-2"></i>
                                SMS Notifications
                            </h5>
                            <small class="text-muted">Configure SMS notification preferences</small>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-sm btn-primary" onclick="addSmsNotification()">
                                <i class="bx bx-plus me-1"></i>Add Rule
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="refreshSmsNotifications()">
                                <i class="bx bx-refresh me-1"></i>Refresh
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="smsNotificationsTable">
                                <thead>
                                    <tr>
                                        <th>
                                            <i class="bx bx-tag me-1"></i>
                                            Rule Name
                                        </th>
                                        <th>
                                            <i class="bx bx-text me-1"></i>
                                            Description
                                        </th>
                                        <th>
                                            <i class="bx bx-category me-1"></i>
                                            Type
                                        </th>
                                        <th>
                                            <i class="bx bx-time me-1"></i>
                                            Frequency
                                        </th>
                                        <th>
                                            <i class="bx bx-globe me-1"></i>
                                            Status
                                        </th>
                                        <th>
                                            <i class="bx bx-cog me-1"></i>
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <strong>Transaction Alerts</strong>
                                        </td>
                                        <td>
                                            <small>Instant SMS for all transactions</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">Transactional</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">Immediate</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">Active</span>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-horizontal-rounded"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="viewSmsNotification(1)"><i class="bx bx-eye me-2"></i>View Details</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="editSmsNotification(1)"><i class="bx bx-edit me-2"></i>Edit</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="testSmsNotification(1)"><i class="bx bx-test-tube me-2"></i>Test</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="deleteSmsNotification(1)"><i class="bx bx-trash me-2"></i>Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>Security Alerts</strong>
                                        </td>
                                        <td>
                                            <small>Security notifications via SMS</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning">Security</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">Immediate</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">Active</span>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-horizontal-rounded"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="viewSmsNotification(2)"><i class="bx bx-eye me-2"></i>View Details</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="editSmsNotification(2)"><i class="bx bx-edit me-2"></i>Edit</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="testSmsNotification(2)"><i class="bx bx-test-tube me-2"></i>Test</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="deleteSmsNotification(2)"><i class="bx bx-trash me-2"></i>Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>Bill Reminders</strong>
                                        </td>
                                        <td>
                                            <small>Bill payment reminders via SMS</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">Reminder</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning">Daily</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">Disabled</span>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-horizontal-rounded"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="viewSmsNotification(3)"><i class="bx bx-eye me-2"></i>View Details</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="editSmsNotification(3)"><i class="bx bx-edit me-2"></i>Edit</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="testSmsNotification(3)"><i class="bx bx-test-tube me-2"></i>Test</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="deleteSmsNotification(3)"><i class="bx bx-trash me-2"></i>Delete</a></li>
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

        <!-- Push Notifications -->
        <div class="row mb-6">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0">
                                <i class="bx bx-bell me-2"></i>
                                Push Notifications
                            </h5>
                            <small class="text-muted">Configure push notification preferences</small>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-sm btn-primary" onclick="addPushNotification()">
                                <i class="bx bx-plus me-1"></i>Add Rule
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="refreshPushNotifications()">
                                <i class="bx bx-refresh me-1"></i>Refresh
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="pushNotificationsTable">
                                <thead>
                                    <tr>
                                        <th>
                                            <i class="bx bx-tag me-1"></i>
                                            Rule Name
                                        </th>
                                        <th>
                                            <i class="bx bx-text me-1"></i>
                                            Description
                                        </th>
                                        <th>
                                            <i class="bx bx-category me-1"></i>
                                            Type
                                        </th>
                                        <th>
                                            <i class="bx bx-time me-1"></i>
                                            Frequency
                                        </th>
                                        <th>
                                            <i class="bx bx-globe me-1"></i>
                                            Status
                                        </th>
                                        <th>
                                            <i class="bx bx-cog me-1"></i>
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <strong>App Notifications</strong>
                                        </td>
                                        <td>
                                            <small>General app notifications</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">General</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">Immediate</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">Active</span>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-horizontal-rounded"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="viewPushNotification(1)"><i class="bx bx-eye me-2"></i>View Details</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="editPushNotification(1)"><i class="bx bx-edit me-2"></i>Edit</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="testPushNotification(1)"><i class="bx bx-test-tube me-2"></i>Test</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="deletePushNotification(1)"><i class="bx bx-trash me-2"></i>Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>Transaction Updates</strong>
                                        </td>
                                        <td>
                                            <small>Push notifications for transactions</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">Transactional</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">Immediate</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">Active</span>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-horizontal-rounded"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="viewPushNotification(2)"><i class="bx bx-eye me-2"></i>View Details</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="editPushNotification(2)"><i class="bx bx-edit me-2"></i>Edit</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="testPushNotification(2)"><i class="bx bx-test-tube me-2"></i>Test</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="deletePushNotification(2)"><i class="bx bx-trash me-2"></i>Delete</a></li>
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

        <!-- Notification Templates -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0">
                                <i class="bx bx-file me-2"></i>
                                Notification Templates
                            </h5>
                            <small class="text-muted">Manage notification templates and content</small>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-sm btn-primary" onclick="addNotificationTemplate()">
                                <i class="bx bx-plus me-1"></i>Add Template
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="notificationTemplatesTable">
                                <thead>
                                    <tr>
                                        <th>
                                            <i class="bx bx-tag me-1"></i>
                                            Template Name
                                        </th>
                                        <th>
                                            <i class="bx bx-category me-1"></i>
                                            Type
                                        </th>
                                        <th>
                                            <i class="bx bx-text me-1"></i>
                                            Subject
                                        </th>
                                        <th>
                                            <i class="bx bx-calendar me-1"></i>
                                            Created
                                        </th>
                                        <th>
                                            <i class="bx bx-globe me-1"></i>
                                            Status
                                        </th>
                                        <th>
                                            <i class="bx bx-cog me-1"></i>
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <strong>Welcome Email</strong>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">Email</span>
                                        </td>
                                        <td>
                                            <small>Welcome to FeedTan Pay</small>
                                        </td>
                                        <td>
                                            <small>2024-01-15</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">Active</span>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-horizontal-rounded"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="viewNotificationTemplate(1)"><i class="bx bx-eye me-2"></i>View Details</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="editNotificationTemplate(1)"><i class="bx bx-edit me-2"></i>Edit</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="testNotificationTemplate(1)"><i class="bx bx-test-tube me-2"></i>Test</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="deleteNotificationTemplate(1)"><i class="bx bx-trash me-2"></i>Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>Payment Confirmation</strong>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">SMS</span>
                                        </td>
                                        <td>
                                            <small>Payment Received</small>
                                        </td>
                                        <td>
                                            <small>2024-01-20</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">Active</span>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-horizontal-rounded"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="viewNotificationTemplate(2)"><i class="bx bx-eye me-2"></i>View Details</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="editNotificationTemplate(2)"><i class="bx bx-edit me-2"></i>Edit</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="testNotificationTemplate(2)"><i class="bx bx-test-tube me-2"></i>Test</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="deleteNotificationTemplate(2)"><i class="bx bx-trash me-2"></i>Delete</a></li>
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
    </div>
</div>

<!-- Add/Edit Email Notification Modal -->
<div class="modal fade" id="emailNotificationModal" tabindex="-1" aria-labelledby="emailNotificationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="emailNotificationModalLabel">
                    <i class="bx bx-envelope me-2"></i>
                    <span id="emailModalTitle">Add Email Notification</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="emailNotificationForm">
                    <input type="hidden" id="emailNotificationId">
                    <div class="mb-3">
                        <label for="emailRuleName" class="form-label">Rule Name</label>
                        <input type="text" class="form-control" id="emailRuleName" required placeholder="e.g., Transaction Updates">
                    </div>
                    <div class="mb-3">
                        <label for="emailDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="emailDescription" rows="3" placeholder="Describe this notification rule"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="emailType" class="form-label">Type</label>
                        <select class="form-select" id="emailType" required>
                            <option value="transactional">Transactional</option>
                            <option value="security">Security</option>
                            <option value="marketing">Marketing</option>
                            <option value="reminder">Reminder</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="emailFrequency" class="form-label">Frequency</label>
                        <select class="form-select" id="emailFrequency" required>
                            <option value="immediate">Immediate</option>
                            <option value="daily">Daily</option>
                            <option value="weekly">Weekly</option>
                            <option value="monthly">Monthly</option>
                        </select>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="emailActive" checked>
                        <label class="form-check-label" for="emailActive">Active</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x me-2"></i>Cancel
                </button>
                <button type="button" class="btn btn-primary" onclick="saveEmailNotification()">
                    <i class="bx bx-save me-2"></i>Save
                </button>
            </div>
        </div>
    </div>
</div>

<!-- View Email Notification Modal -->
<div class="modal fade" id="viewEmailNotificationModal" tabindex="-1" aria-labelledby="viewEmailNotificationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="viewEmailNotificationModalLabel">
                    <i class="bx bx-eye me-2"></i>
                    Email Notification Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="emailNotificationDetails"></div>
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
function refreshNotifications() {
    showNotification('Refreshing notifications...', 'info');
    setTimeout(() => {
        location.reload();
    }, 1000);
}

function testNotifications() {
    showNotification('Testing notification system...', 'info');
    setTimeout(() => {
        showNotification('Notification system test completed successfully!', 'success');
    }, 2000);
}

function addEmailNotification() {
    document.getElementById('emailModalTitle').textContent = 'Add Email Notification';
    document.getElementById('emailNotificationForm').reset();
    document.getElementById('emailNotificationId').value = '';
    const modal = new bootstrap.Modal(document.getElementById('emailNotificationModal'));
    modal.show();
}

function editEmailNotification(id) {
    document.getElementById('emailModalTitle').textContent = 'Edit Email Notification';
    // Simulate loading notification data
    const notificationData = {
        id: id,
        name: 'Transaction Updates',
        description: 'Get notified when payments are sent or received',
        type: 'transactional',
        frequency: 'immediate',
        active: true
    };
    
    document.getElementById('emailNotificationId').value = notificationData.id;
    document.getElementById('emailRuleName').value = notificationData.name;
    document.getElementById('emailDescription').value = notificationData.description;
    document.getElementById('emailType').value = notificationData.type;
    document.getElementById('emailFrequency').value = notificationData.frequency;
    document.getElementById('emailActive').checked = notificationData.active;
    
    const modal = new bootstrap.Modal(document.getElementById('emailNotificationModal'));
    modal.show();
}

function saveEmailNotification() {
    const form = document.getElementById('emailNotificationForm');
    if (!form.checkValidity()) {
        showNotification('Please fill in all required fields', 'warning');
        return;
    }
    
    showNotification('Saving email notification...', 'info');
    setTimeout(() => {
        showNotification('Email notification saved successfully!', 'success');
        bootstrap.Modal.getInstance(document.getElementById('emailNotificationModal')).hide();
        location.reload();
    }, 1500);
}

function viewEmailNotification(id) {
    // Simulate loading notification details
    const notificationData = {
        name: 'Transaction Updates',
        description: 'Get notified when payments are sent or received',
        type: 'transactional',
        frequency: 'immediate',
        active: true,
        createdAt: '2024-01-15 10:30:00',
        updatedAt: '2024-01-20 14:45:00'
    };
    
    const details = `
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label text-muted">Rule Name</label>
                    <div class="fw-bold">${notificationData.name}</div>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted">Type</label>
                    <div><span class="badge bg-primary">${notificationData.type}</span></div>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted">Frequency</label>
                    <div><span class="badge bg-info">${notificationData.frequency}</span></div>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted">Status</label>
                    <div><span class="badge bg-${notificationData.active ? 'success' : 'secondary'}">${notificationData.active ? 'Active' : 'Inactive'}</span></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label text-muted">Description</label>
                    <div class="bg-light p-2 rounded">${notificationData.description}</div>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted">Created</label>
                    <div>${notificationData.createdAt}</div>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted">Last Updated</label>
                    <div>${notificationData.updatedAt}</div>
                </div>
            </div>
        </div>
    `;
    
    document.getElementById('emailNotificationDetails').innerHTML = details;
    
    const modal = new bootstrap.Modal(document.getElementById('viewEmailNotificationModal'));
    modal.show();
}

function testEmailNotification(id) {
    showNotification('Testing email notification...', 'info');
    setTimeout(() => {
        showNotification('Test email sent successfully!', 'success');
    }, 1500);
}

function deleteEmailNotification(id) {
    if (confirm('Are you sure you want to delete this email notification?')) {
        showNotification('Deleting email notification...', 'info');
        setTimeout(() => {
            showNotification('Email notification deleted successfully!', 'success');
            location.reload();
        }, 1500);
    }
}

function addSmsNotification() {
    showNotification('Opening SMS notification form...', 'info');
    setTimeout(() => {
        showNotification('SMS notification form opened!', 'success');
    }, 1000);
}

function editSmsNotification(id) {
    showNotification('Opening SMS notification edit form...', 'info');
    setTimeout(() => {
        showNotification('SMS notification edit form opened!', 'success');
    }, 1000);
}

function viewSmsNotification(id) {
    showNotification('Loading SMS notification details...', 'info');
    setTimeout(() => {
        showNotification('SMS notification details loaded!', 'success');
    }, 1000);
}

function testSmsNotification(id) {
    showNotification('Testing SMS notification...', 'info');
    setTimeout(() => {
        showNotification('Test SMS sent successfully!', 'success');
    }, 1500);
}

function deleteSmsNotification(id) {
    if (confirm('Are you sure you want to delete this SMS notification?')) {
        showNotification('Deleting SMS notification...', 'info');
        setTimeout(() => {
            showNotification('SMS notification deleted successfully!', 'success');
            location.reload();
        }, 1500);
    }
}

function addPushNotification() {
    showNotification('Opening push notification form...', 'info');
    setTimeout(() => {
        showNotification('Push notification form opened!', 'success');
    }, 1000);
}

function editPushNotification(id) {
    showNotification('Opening push notification edit form...', 'info');
    setTimeout(() => {
        showNotification('Push notification edit form opened!', 'success');
    }, 1000);
}

function viewPushNotification(id) {
    showNotification('Loading push notification details...', 'info');
    setTimeout(() => {
        showNotification('Push notification details loaded!', 'success');
    }, 1000);
}

function testPushNotification(id) {
    showNotification('Testing push notification...', 'info');
    setTimeout(() => {
        showNotification('Test push notification sent successfully!', 'success');
    }, 1500);
}

function deletePushNotification(id) {
    if (confirm('Are you sure you want to delete this push notification?')) {
        showNotification('Deleting push notification...', 'info');
        setTimeout(() => {
            showNotification('Push notification deleted successfully!', 'success');
            location.reload();
        }, 1500);
    }
}

function addNotificationTemplate() {
    showNotification('Opening notification template form...', 'info');
    setTimeout(() => {
        showNotification('Notification template form opened!', 'success');
    }, 1000);
}

function viewNotificationTemplate(id) {
    showNotification('Loading notification template details...', 'info');
    setTimeout(() => {
        showNotification('Notification template details loaded!', 'success');
    }, 1000);
}

function editNotificationTemplate(id) {
    showNotification('Opening notification template edit form...', 'info');
    setTimeout(() => {
        showNotification('Notification template edit form opened!', 'success');
    }, 1000);
}

function testNotificationTemplate(id) {
    showNotification('Testing notification template...', 'info');
    setTimeout(() => {
        showNotification('Test template sent successfully!', 'success');
    }, 1500);
}

function deleteNotificationTemplate(id) {
    if (confirm('Are you sure you want to delete this notification template?')) {
        showNotification('Deleting notification template...', 'info');
        setTimeout(() => {
            showNotification('Notification template deleted successfully!', 'success');
            location.reload();
        }, 1500);
    }
}

function refreshEmailNotifications() {
    showNotification('Refreshing email notifications...', 'info');
    setTimeout(() => {
        location.reload();
    }, 1000);
}

function refreshSmsNotifications() {
    showNotification('Refreshing SMS notifications...', 'info');
    setTimeout(() => {
        location.reload();
    }, 1000);
}

function refreshPushNotifications() {
    showNotification('Refreshing push notifications...', 'info');
    setTimeout(() => {
        location.reload();
    }, 1000);
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
