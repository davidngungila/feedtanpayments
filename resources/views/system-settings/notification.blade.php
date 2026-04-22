@extends('layouts.app')

@section('title', 'Notification Settings - FeedTan Pay')

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
                                <p class="text-muted mb-0">Configure email, SMS, push, and in-app notifications with templates and delivery settings</p>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-outline-success" onclick="testNotifications()">
                                    <i class="bx bx-test-tube me-2"></i>Test Notifications
                                </button>
                                <button type="button" class="btn btn-outline-secondary" onclick="refreshNotificationSettings()">
                                    <i class="bx bx-refresh me-2"></i>Refresh
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notification Settings Overview -->
        <div class="row mb-6">
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-primary bg-opacity-10 rounded-circle me-3" style="width: 48px; height: 48px;">
                                <i class="bx bx-envelope text-primary fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Email Templates</h6>
                                <h4 class="mb-0">12</h4>
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
                                <i class="bx bx-message-square-dots text-success fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">SMS Templates</h6>
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
                            <div class="avatar bg-warning bg-opacity-10 rounded-circle me-3" style="width: 48px; height: 48px;">
                                <i class="bx bx-bell text-warning fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Push Templates</h6>
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
                                <i class="bx bx-desktop text-info fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">In-App Settings</h6>
                                <h4 class="mb-0">4</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notification Settings Table -->
        <div class="row mb-6">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0">
                                <i class="bx bx-cog me-2"></i>
                                Notification Configuration
                            </h5>
                            <small class="text-muted">Manage notification settings, templates, and delivery preferences</small>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-sm btn-primary" onclick="addNotificationSetting()">
                                <i class="bx bx-plus me-1"></i>Add Setting
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="refreshNotificationSettings()">
                                <i class="bx bx-refresh me-1"></i>Refresh
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="notificationTable">
                                <thead>
                                    <tr>
                                        <th>
                                            <i class="bx bx-tag me-1"></i>
                                            Setting Key
                                        </th>
                                        <th>
                                            <i class="bx bx-text me-1"></i>
                                            Value
                                        </th>
                                        <th>
                                            <i class="bx bx-category me-1"></i>
                                            Type
                                        </th>
                                        <th>
                                            <i class="bx bx-layer me-1"></i>
                                            Channel
                                        </th>
                                        <th>
                                            <i class="bx bx-info-circle me-1"></i>
                                            Description
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
                                            <code>email_transactions_enabled</code>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">true</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">boolean</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">Email</span>
                                        </td>
                                        <td>
                                            <small>Enable transaction email notifications</small>
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
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="viewNotificationSetting(1)"><i class="bx bx-eye me-2"></i>View Details</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="editNotificationSetting(1)"><i class="bx bx-edit me-2"></i>Edit</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="deleteNotificationSetting(1)"><i class="bx bx-trash me-2"></i>Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <code>sms_security_alerts</code>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">true</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">boolean</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning">SMS</span>
                                        </td>
                                        <td>
                                            <small>Send SMS for security alerts</small>
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
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="viewNotificationSetting(2)"><i class="bx bx-eye me-2"></i>View Details</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="editNotificationSetting(2)"><i class="bx bx-edit me-2"></i>Edit</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="deleteNotificationSetting(2)"><i class="bx bx-trash me-2"></i>Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <code>push_bill_reminders</code>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">true</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">boolean</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning">Push</span>
                                        </td>
                                        <td>
                                            <small>Push notifications for bill reminders</small>
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
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="viewNotificationSetting(3)"><i class="bx bx-eye me-2"></i>View Details</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="editNotificationSetting(3)"><i class="bx bx-edit me-2"></i>Edit</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="deleteNotificationSetting(3)"><i class="bx bx-trash me-2"></i>Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <code>email_frequency</code>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">immediate</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning">string</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">Email</span>
                                        </td>
                                        <td>
                                            <small>Email delivery frequency</small>
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
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="viewNotificationSetting(4)"><i class="bx bx-eye me-2"></i>View Details</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="editNotificationSetting(4)"><i class="bx bx-edit me-2"></i>Edit</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="deleteNotificationSetting(4)"><i class="bx bx-trash me-2"></i>Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <code>app_notification_position</code>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">top-right</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning">string</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">In-App</span>
                                        </td>
                                        <td>
                                            <small>In-app notification position</small>
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
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="viewNotificationSetting(5)"><i class="bx bx-eye me-2"></i>View Details</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="editNotificationSetting(5)"><i class="bx bx-edit me-2"></i>Edit</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="deleteNotificationSetting(5)"><i class="bx bx-trash me-2"></i>Delete</a></li>
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
        <div class="row mb-6">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0">
                                <i class="bx bx-file me-2"></i>
                                Notification Templates
                            </h5>
                            <small class="text-muted">Manage email, SMS, and push notification templates</small>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-sm btn-primary" onclick="addNotificationTemplate()">
                                <i class="bx bx-plus me-1"></i>Add Template
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Template Name</th>
                                        <th>Channel</th>
                                        <th>Subject</th>
                                        <th>Content Preview</th>
                                        <th>Variables</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>Payment Success</strong></td>
                                        <td><span class="badge bg-info">Email</span></td>
                                        <td>Payment Successful</td>
                                        <td><small>Your payment of TZS 250,000 was successful...</small></td>
                                        <td><small>{amount}, {recipient}, {transaction_id}</small></td>
                                        <td><span class="badge bg-success">Active</span></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-horizontal-rounded"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="editTemplate(1)"><i class="bx bx-edit me-2"></i>Edit</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="previewTemplate(1)"><i class="bx bx-eye me-2"></i>Preview</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="testTemplate(1)"><i class="bx bx-test-tube me-2"></i>Test</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Bill Due Reminder</strong></td>
                                        <td><span class="badge bg-warning">SMS</span></td>
                                        <td>-</td>
                                        <td><small>Your bill is due on {due_date}. Amount: TZS {amount}...</small></td>
                                        <td><small>{bill_name}, {amount}, {due_date}</small></td>
                                        <td><span class="badge bg-success">Active</span></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-horizontal-rounded"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="editTemplate(2)"><i class="bx bx-edit me-2"></i>Edit</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="previewTemplate(2)"><i class="bx bx-eye me-2"></i>Preview</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="testTemplate(2)"><i class="bx bx-test-tube me-2"></i>Test</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Security Alert</strong></td>
                                        <td><span class="badge bg-warning">Push</span></td>
                                        <td>Security Alert</td>
                                        <td><small>Suspicious activity detected on your account...</small></td>
                                        <td><small>{alert_type}, {ip_address}, {time}</small></td>
                                        <td><span class="badge bg-success">Active</span></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-horizontal-rounded"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="editTemplate(3)"><i class="bx bx-edit me-2"></i>Edit</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="previewTemplate(3)"><i class="bx bx-eye me-2"></i>Preview</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="testTemplate(3)"><i class="bx bx-test-tube me-2"></i>Test</a></li>
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

        <!-- Channel Configuration -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-cog me-2"></i>
                            Channel Configuration
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="mb-3">Email Settings</h6>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="emailEnabled" checked>
                                        <label class="form-check-label" for="emailEnabled">Enable Email Notifications</label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="emailQueue" checked>
                                        <label class="form-check-label" for="emailQueue">Use Queue for Bulk Emails</label>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Default From Email</label>
                                        <input type="email" class="form-control" value="noreply@feedtanpay.com" placeholder="noreply@feedtanpay.com">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Default From Name</label>
                                        <input type="text" class="form-control" value="FeedTan Pay" placeholder="FeedTan Pay">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="mb-3">SMS Settings</h6>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="smsEnabled">
                                        <label class="form-check-label" for="smsEnabled">Enable SMS Notifications</label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="smsQueue" checked>
                                        <label class="form-check-label" for="smsQueue">Use Queue for SMS</label>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">SMS Provider</label>
                                        <select class="form-select">
                                            <option value="twilio">Twilio</option>
                                            <option value="africastalking">AfricasTalking</option>
                                            <option value="infobip">Infobip</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Default Sender ID</label>
                                        <input type="text" class="form-control" value="FeedTan" placeholder="FeedTan">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="mb-3">Push Settings</h6>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="pushEnabled" checked>
                                        <label class="form-check-label" for="pushEnabled">Enable Push Notifications</label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="pushBatch" checked>
                                        <label class="form-check-label" for="pushBatch">Enable Batch Push</label>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Push Service</label>
                                        <select class="form-select">
                                            <option value="firebase">Firebase Cloud Messaging</option>
                                            <option value="onesignal">OneSignal</option>
                                            <option value="apns">Apple Push Notification Service</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="mb-3">In-App Settings</h6>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="appEnabled" checked>
                                        <label class="form-check-label" for="appEnabled">Enable In-App Notifications</label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="appSounds" checked>
                                        <label class="form-check-label" for="appSounds">Enable Sound Effects</label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="appVibration" checked>
                                        <label class="form-check-label" for="appVibration">Enable Vibration</label>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Auto-dismiss After (seconds)</label>
                                        <input type="number" class="form-control" value="5" min="0" max="60">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-primary" onclick="saveChannelSettings()">
                                        <i class="bx bx-save me-2"></i>Save Channel Settings
                                    </button>
                                    <button type="button" class="btn btn-outline-warning" onclick="testAllChannels()">
                                        <i class="bx bx-test-tube me-2"></i>Test All Channels
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit Notification Setting Modal -->
<div class="modal fade" id="notificationSettingModal" tabindex="-1" aria-labelledby="notificationSettingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="notificationSettingModalLabel">
                    <i class="bx bx-cog me-2"></i>
                    <span id="modalTitle">Add Notification Setting</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="notificationSettingForm">
                    <input type="hidden" id="settingId" name="settingId">
                    <div class="mb-3">
                        <label for="settingKey" class="form-label">
                            <i class="bx bx-tag me-1"></i>Setting Key
                        </label>
                        <input type="text" class="form-control" id="settingKey" name="settingKey" required placeholder="e.g., email_transactions_enabled">
                    </div>
                    <div class="mb-3">
                        <label for="settingValue" class="form-label">
                            <i class="bx bx-text me-1"></i>Value
                        </label>
                        <input type="text" class="form-control" id="settingValue" name="settingValue" required placeholder="e.g., true, immediate, top-right">
                    </div>
                    <div class="mb-3">
                        <label for="settingType" class="form-label">
                            <i class="bx bx-category me-1"></i>Type
                        </label>
                        <select class="form-select" id="settingType" name="settingType" required>
                            <option value="boolean">Boolean</option>
                            <option value="string">String</option>
                            <option value="number">Number</option>
                            <option value="json">JSON</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="settingChannel" class="form-label">
                            <i class="bx bx-layer me-1"></i>Channel
                        </label>
                        <select class="form-select" id="settingChannel" name="settingChannel" required>
                            <option value="email">Email</option>
                            <option value="sms">SMS</option>
                            <option value="push">Push</option>
                            <option value="in-app">In-App</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="settingDescription" class="form-label">
                            <i class="bx bx-info-circle me-1"></i>Description
                        </label>
                        <textarea class="form-control" id="settingDescription" name="settingDescription" rows="3" placeholder="Describe this notification setting"></textarea>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="isPublic" name="isPublic" checked>
                        <label class="form-check-label" for="isPublic">Public Setting</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x me-2"></i>Cancel
                </button>
                <button type="button" class="btn btn-primary" onclick="saveNotificationSetting()">
                    <i class="bx bx-save me-2"></i>Save Setting
                </button>
            </div>
        </div>
    </div>
</div>

<!-- View Notification Setting Modal -->
<div class="modal fade" id="viewNotificationSettingModal" tabindex="-1" aria-labelledby="viewNotificationSettingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="viewNotificationSettingModalLabel">
                    <i class="bx bx-eye me-2"></i>
                    Notification Setting Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="notificationSettingDetails"></div>
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
function refreshNotificationSettings() {
    showNotification('Refreshing notification settings...', 'info');
    setTimeout(() => {
        location.reload();
    }, 1000);
}

function testNotifications() {
    showNotification('Testing all notification channels...', 'info');
    setTimeout(() => {
        showNotification('Notification test completed successfully!', 'success');
    }, 2000);
}

function addNotificationSetting() {
    document.getElementById('modalTitle').textContent = 'Add Notification Setting';
    document.getElementById('notificationSettingForm').reset();
    document.getElementById('settingId').value = '';
    const modal = new bootstrap.Modal(document.getElementById('notificationSettingModal'));
    modal.show();
}

function editNotificationSetting(id) {
    document.getElementById('modalTitle').textContent = 'Edit Notification Setting';
    // Simulate loading setting data
    const settingData = {
        id: id,
        key: 'email_transactions_enabled',
        value: 'true',
        type: 'boolean',
        channel: 'email',
        description: 'Enable transaction email notifications',
        isPublic: true
    };
    
    document.getElementById('settingId').value = settingData.id;
    document.getElementById('settingKey').value = settingData.key;
    document.getElementById('settingValue').value = settingData.value;
    document.getElementById('settingType').value = settingData.type;
    document.getElementById('settingChannel').value = settingData.channel;
    document.getElementById('settingDescription').value = settingData.description;
    document.getElementById('isPublic').checked = settingData.isPublic;
    
    const modal = new bootstrap.Modal(document.getElementById('notificationSettingModal'));
    modal.show();
}

function saveNotificationSetting() {
    const form = document.getElementById('notificationSettingForm');
    const formData = new FormData(form);
    
    if (!form.checkValidity()) {
        showNotification('Please fill in all required fields', 'warning');
        return;
    }
    
    const settingData = {
        id: formData.get('settingId'),
        key: formData.get('settingKey'),
        value: formData.get('settingValue'),
        type: formData.get('settingType'),
        channel: formData.get('settingChannel'),
        description: formData.get('settingDescription'),
        isPublic: formData.get('isPublic') === 'on'
    };
    
    showNotification('Saving notification setting...', 'info');
    
    // Simulate API call
    setTimeout(() => {
        showNotification('Notification setting saved successfully!', 'success');
        bootstrap.Modal.getInstance(document.getElementById('notificationSettingModal')).hide();
        location.reload();
    }, 1500);
}

function viewNotificationSetting(id) {
    // Simulate loading setting details
    const settingData = {
        key: 'email_transactions_enabled',
        value: 'true',
        type: 'boolean',
        channel: 'email',
        description: 'Enable transaction email notifications',
        isPublic: true,
        createdAt: '2024-12-15 10:30:00',
        updatedAt: '2024-12-20 14:45:00'
    };
    
    const details = `
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label text-muted">Setting Key</label>
                    <div class="fw-bold"><code>${settingData.key}</code></div>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted">Value</label>
                    <div class="fw-bold">${settingData.value}</div>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted">Type</label>
                    <div><span class="badge bg-primary">${settingData.type}</span></div>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted">Channel</label>
                    <div><span class="badge bg-info">${settingData.channel}</span></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label text-muted">Description</label>
                    <div class="bg-light p-2 rounded">${settingData.description}</div>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted">Visibility</label>
                    <div><span class="badge bg-${settingData.isPublic ? 'success' : 'secondary'}">${settingData.isPublic ? 'Public' : 'Private'}</span></div>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted">Created</label>
                    <div>${settingData.createdAt}</div>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted">Last Updated</label>
                    <div>${settingData.updatedAt}</div>
                </div>
            </div>
        </div>
    `;
    
    document.getElementById('notificationSettingDetails').innerHTML = details;
    
    const modal = new bootstrap.Modal(document.getElementById('viewNotificationSettingModal'));
    modal.show();
}

function deleteNotificationSetting(id) {
    if (confirm('Are you sure you want to delete this notification setting?')) {
        showNotification('Deleting notification setting...', 'info');
        setTimeout(() => {
            showNotification('Notification setting deleted successfully!', 'success');
            location.reload();
        }, 1500);
    }
}

function addNotificationTemplate() {
    showNotification('Opening template editor...', 'info');
    setTimeout(() => {
        showNotification('Template editor opened!', 'success');
    }, 1000);
}

function editTemplate(id) {
    showNotification(`Editing template #${id}...`, 'info');
    setTimeout(() => {
        showNotification(`Template #${id} editor opened!`, 'success');
    }, 1000);
}

function previewTemplate(id) {
    showNotification(`Loading template preview #${id}...`, 'info');
    setTimeout(() => {
        showNotification(`Template #${id} preview loaded!`, 'success');
    }, 1000);
}

function testTemplate(id) {
    showNotification(`Testing template #${id}...`, 'info');
    setTimeout(() => {
        showNotification(`Template #${id} test sent successfully!`, 'success');
    }, 1500);
}

function saveChannelSettings() {
    showNotification('Saving channel settings...', 'info');
    setTimeout(() => {
        showNotification('Channel settings saved successfully!', 'success');
    }, 1500);
}

function testAllChannels() {
    showNotification('Testing all notification channels...', 'info');
    setTimeout(() => {
        showNotification('All channels tested successfully!', 'success');
    }, 2000);
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
