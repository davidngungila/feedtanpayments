@extends('layouts.app')

@section('title', 'Security Alerts System - FeedTan Pay')

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
                                    <i class="bx bx-bell me-2 text-warning"></i>
                                    Security Alerts System
                                </h4>
                                <p class="text-muted mb-0">Login alerts, failed login notifications, transaction anomaly alerts, admin emergency alerts</p>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-outline-warning" onclick="testAlertSystem()">
                                    <i class="bx bx-test-tube me-2"></i>Test Alerts
                                </button>
                                <button type="button" class="btn btn-outline-secondary" onclick="refreshAlertSystem()">
                                    <i class="bx bx-refresh me-2"></i>Refresh
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alert System Overview -->
        <div class="row mb-6">
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-success bg-opacity-10 rounded-circle me-3" style="width: 48px; height: 48px;">
                                <i class="bx bx-check-shield text-success fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Active</h6>
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
                            <div class="avatar bg-warning bg-opacity-10 rounded-circle me-3" style="width: 48px; height: 48px;">
                                <i class="bx bx-error-alt text-warning fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Pending</h6>
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
                            <div class="avatar bg-info bg-opacity-10 rounded-circle me-3" style="width: 48px; height: 48px;">
                                <i class="bx bx-envelope text-info fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Sent Today</h6>
                                <h4 class="mb-0">47</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-danger bg-opacity-10 rounded-circle me-3" style="width: 48px; height: 48px;">
                                <i class="bx bx-error text-danger fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Critical</h6>
                                <h4 class="mb-0">1</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Login Alerts -->
        <div class="row mb-6">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-user-check me-2"></i>
                            Login Alerts (Email/SMS)
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="mb-3">Login Alert Settings</h6>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="enableLoginAlerts" checked>
                                        <label class="form-check-label" for="enableLoginAlerts">
                                            Enable login alerts
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="alertNewDevice" checked>
                                        <label class="form-check-label" for="alertNewDevice">
                                            Alert on new device login
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="alertNewLocation" checked>
                                        <label class="form-check-label" for="alertNewLocation">
                                            Alert on new location login
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="alertSuspiciousTime">
                                        <label class="form-check-label" for="alertSuspiciousTime">
                                            Alert on unusual login times
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="mb-3">Alert Delivery</h6>
                                    <div class="mb-3">
                                        <label class="form-label">Primary Alert Method</label>
                                        <select class="form-select" id="primaryAlertMethod">
                                            <option value="email" selected>Email</option>
                                            <option value="sms">SMS</option>
                                            <option value="both">Both Email & SMS</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Alert Recipients</label>
                                        <select class="form-select" id="alertRecipients" multiple>
                                            <option value="user" selected>User</option>
                                            <option value="admin">Admin</option>
                                            <option value="security">Security Team</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Alert Frequency</label>
                                        <select class="form-select" id="alertFrequency">
                                            <option value="immediate" selected>Immediate</option>
                                            <option value="hourly">Hourly Digest</option>
                                            <option value="daily">Daily Digest</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-primary" onclick="saveLoginAlertSettings()">
                                        <i class="bx bx-save me-2"></i>Save Settings
                                    </button>
                                    <button type="button" class="btn btn-outline-info" onclick="testLoginAlert()">
                                        <i class="bx bx-test-tube me-2"></i>Test Login Alert
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Failed Login Notifications -->
        <div class="row mb-6">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-user-x me-2"></i>
                            Failed Login Notifications
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="mb-3">Failed Login Settings</h6>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="enableFailedLoginAlerts" checked>
                                        <label class="form-check-label" for="enableFailedLoginAlerts">
                                            Enable failed login notifications
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="alertMultipleFailures" checked>
                                        <label class="form-check-label" for="alertMultipleFailures">
                                            Alert on multiple failed attempts
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="alertSuspiciousIP" checked>
                                        <label class="form-check-label" for="alertSuspiciousIP">
                                            Alert on suspicious IP attempts
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="alertBruteForce" checked>
                                        <label class="form-check-label" for="alertBruteForce">
                                            Alert on brute-force attacks
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="mb-3">Alert Thresholds</h6>
                                    <div class="mb-3">
                                        <label class="form-label">Alert After Failed Attempts</label>
                                        <input type="number" class="form-control" id="failedAttemptsThreshold" value="3" min="1" max="20">
                                        <small class="text-muted">Send alert after X failed attempts</small>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Alert on Suspicious Activity</label>
                                        <input type="number" class="form-control" id="suspiciousActivityThreshold" value="10" min="1" max="100">
                                        <small class="text-muted">Alert after X suspicious activities</small>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Time Window (minutes)</label>
                                        <input type="number" class="form-control" id="timeWindow" value="15" min="5" max="60">
                                        <small class="text-muted">Time window to count failed attempts</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-primary" onclick="saveFailedLoginSettings()">
                                        <i class="bx bx-save me-2"></i>Save Settings
                                    </button>
                                    <button type="button" class="btn btn-outline-warning" onclick="testFailedLoginAlert()">
                                        <i class="bx bx-test-tube me-2"></i>Test Failed Login Alert
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transaction Anomaly Alerts -->
        <div class="row mb-6">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-credit-card me-2"></i>
                            Transaction Anomaly Alerts
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="mb-3">Anomaly Detection Settings</h6>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="enableAnomalyAlerts" checked>
                                        <label class="form-check-label" for="enableAnomalyAlerts">
                                            Enable transaction anomaly alerts
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="alertUnusualAmount" checked>
                                        <label class="form-check-label" for="alertUnusualAmount">
                                            Alert on unusual transaction amounts
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="alertHighFrequency" checked>
                                        <label class="form-check-label" for="alertHighFrequency">
                                            Alert on high-frequency transactions
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="alertSuspiciousPattern" checked>
                                        <label class="form-check-label" for="alertSuspiciousPattern">
                                            Alert on suspicious patterns
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="mb-3">Anomaly Thresholds</h6>
                                    <div class="mb-3">
                                        <label class="form-label">Unusual Amount Threshold (TZS)</label>
                                        <input type="number" class="form-control" id="unusualAmountThreshold" value="1000000" min="0">
                                        <small class="text-muted">Alert for transactions above this amount</small>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Frequency Threshold</label>
                                        <input type="number" class="form-control" id="frequencyThreshold" value="10" min="1">
                                        <small class="text-muted">Alert for more than X transactions per hour</small>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Pattern Detection Sensitivity</label>
                                        <select class="form-select" id="patternSensitivity">
                                            <option value="low">Low</option>
                                            <option value="medium" selected>Medium</option>
                                            <option value="high">High</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-primary" onclick="saveAnomalySettings()">
                                        <i class="bx bx-save me-2"></i>Save Settings
                                    </button>
                                    <button type="button" class="btn btn-outline-warning" onclick="testAnomalyAlert()">
                                        <i class="bx bx-test-tube me-2"></i>Test Anomaly Alert
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Admin Emergency Alerts -->
        <div class="row mb-6">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-error me-2"></i>
                            Admin Emergency Alerts
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="mb-3">Emergency Alert Settings</h6>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="enableEmergencyAlerts" checked>
                                        <label class="form-check-label" for="enableEmergencyAlerts">
                                            Enable emergency alerts
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="alertSystemDown" checked>
                                        <label class="form-check-label" for="alertSystemDown">
                                            Alert on system downtime
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="alertSecurityBreach" checked>
                                        <label class="form-check-label" for="alertSecurityBreach">
                                            Alert on security breaches
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="alertDataLoss" checked>
                                        <label class="form-check-label" for="alertDataLoss">
                                            Alert on potential data loss
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="mb-3">Emergency Contact List</h6>
                                    <div class="mb-3">
                                        <label class="form-label">Primary Admin Contacts</label>
                                        <select class="form-select" id="emergencyContacts" multiple>
                                            <option value="admin1" selected>John Doe - +255 712 345 678</option>
                                            <option value="admin2" selected>Jane Smith - +255 713 456 789</option>
                                            <option value="admin3">Mike Johnson - +255 714 567 890</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Emergency Email List</label>
                                        <input type="email" class="form-control" id="emergencyEmail" value="admin@feedtanpay.com,security@feedtanpay.com" placeholder="Enter emergency emails">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Alert Escalation</label>
                                        <select class="form-select" id="alertEscalation">
                                            <option value="immediate" selected>Immediate to all</option>
                                            <option value="tiered">Tiered escalation</option>
                                            <option value="manual">Manual approval</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-primary" onclick="saveEmergencySettings()">
                                        <i class="bx bx-save me-2"></i>Save Settings
                                    </button>
                                    <button type="button" class="btn btn-outline-danger" onclick="triggerEmergencyAlert()">
                                        <i class="bx bx-error me-2"></i>Test Emergency Alert
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Security Alerts -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0">
                                <i class="bx bx-list-ul me-2"></i>
                                Recent Security Alerts
                            </h5>
                            <small class="text-muted">Real-time security monitoring alerts</small>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="bx bx-filter me-1"></i>Filter
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="javascript:void(0)" onclick="filterAlerts('all')">All Alerts</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0)" onclick="filterAlerts('critical')">Critical</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0)" onclick="filterAlerts('warning')">Warning</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0)" onclick="filterAlerts('info')">Info</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="alertsTable">
                                <thead>
                                    <tr>
                                        <th>
                                            <i class="bx bx-time me-1"></i>
                                            Timestamp
                                        </th>
                                        <th>
                                            <i class="bx bx-bell me-1"></i>
                                            Alert Type
                                        </th>
                                        <th>
                                            <i class="bx bx-info-circle me-1"></i>
                                            Message
                                        </th>
                                        <th>
                                            <i class="bx bx-user me-1"></i>
                                            User/Source
                                        </th>
                                        <th>
                                            <i class="bx bx-map me-1"></i>
                                            Location
                                        </th>
                                        <th>
                                            <i class="bx bx-flag me-1"></i>
                                            Priority
                                        </th>
                                        <th>
                                            <i class="bx bx-check me-1"></i>
                                            Status
                                        </th>
                                        <th>
                                            <i class="bx bx-cog me-1"></i>
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr data-priority="critical">
                                        <td><small>2024-12-22 14:35:22</small></td>
                                        <td><span class="badge bg-danger">Security Breach</span></td>
                                        <td>Multiple failed login attempts detected from suspicious IP</td>
                                        <td>Unknown</td>
                                        <td><code>203.45.67.89</code></td>
                                        <td><span class="badge bg-danger">Critical</span></td>
                                        <td><span class="badge bg-warning">Investigating</span></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-danger dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-horizontal-rounded"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="investigateAlert(1)">
                                                            <i class="bx bx-search me-2"></i>Investigate
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="escalateAlert(1)">
                                                            <i class="bx bx-up-arrow me-2"></i>Escalate
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="resolveAlert(1)">
                                                            <i class="bx bx-check me-2"></i>Resolve
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr data-priority="warning">
                                        <td><small>2024-12-22 14:32:15</small></td>
                                        <td><span class="badge bg-warning">Failed Login</span></td>
                                        <td>3 consecutive failed login attempts for user John Doe</td>
                                        <td>John Doe</td>
                                        <td><code>192.168.1.100</code></td>
                                        <td><span class="badge bg-warning">Warning</span></td>
                                        <td><span class="badge bg-success">Resolved</span></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-warning dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-horizontal-rounded"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="viewAlertDetails(2)">
                                                            <i class="bx bx-eye me-2"></i>View Details
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="acknowledgeAlert(2)">
                                                            <i class="bx bx-check me-2"></i>Acknowledge
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr data-priority="info">
                                        <td><small>2024-12-22 14:28:45</small></td>
                                        <td><span class="badge bg-info">New Device</span></td>
                                        <td>Login from new device: iPhone 14 Pro for Sarah Williams</td>
                                        <td>Sarah Williams</td>
                                        <td><code>41.202.123.45</code></td>
                                        <td><span class="badge bg-info">Info</span></td>
                                        <td><span class="badge bg-success">Resolved</span></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-info dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-horizontal-rounded"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="viewAlertDetails(3)">
                                                            <i class="bx bx-eye me-2"></i>View Details
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="ignoreSimilarAlerts(3)">
                                                            <i class="bx bx-x me-2"></i>Ignore Similar
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
    </div>
</div>

@push('scripts')
<script>
function refreshAlertSystem() {
    showNotification('Refreshing alert system data...', 'info');
    setTimeout(() => {
        location.reload();
    }, 1000);
}

function testAlertSystem() {
    showNotification('Testing alert system...', 'info');
    setTimeout(() => {
        showNotification('Alert system test completed successfully!', 'success');
    }, 2000);
}

function saveLoginAlertSettings() {
    showNotification('Saving login alert settings...', 'info');
    setTimeout(() => {
        showNotification('Login alert settings saved successfully!', 'success');
    }, 1500);
}

function testLoginAlert() {
    showNotification('Sending test login alert...', 'info');
    setTimeout(() => {
        showNotification('Test login alert sent successfully!', 'success');
    }, 2000);
}

function saveFailedLoginSettings() {
    showNotification('Saving failed login settings...', 'info');
    setTimeout(() => {
        showNotification('Failed login settings saved successfully!', 'success');
    }, 1500);
}

function testFailedLoginAlert() {
    showNotification('Sending test failed login alert...', 'warning');
    setTimeout(() => {
        showNotification('Test failed login alert sent successfully!', 'success');
    }, 2000);
}

function saveAnomalySettings() {
    showNotification('Saving anomaly detection settings...', 'info');
    setTimeout(() => {
        showNotification('Anomaly settings saved successfully!', 'success');
    }, 1500);
}

function testAnomalyAlert() {
    showNotification('Sending test anomaly alert...', 'warning');
    setTimeout(() => {
        showNotification('Test anomaly alert sent successfully!', 'success');
    }, 2000);
}

function saveEmergencySettings() {
    showNotification('Saving emergency alert settings...', 'info');
    setTimeout(() => {
        showNotification('Emergency alert settings saved successfully!', 'success');
    }, 1500);
}

function triggerEmergencyAlert() {
    if (confirm('Are you sure you want to trigger a test emergency alert? This will notify all emergency contacts.')) {
        showNotification('Triggering emergency alert...', 'danger');
        setTimeout(() => {
            showNotification('Emergency alert sent to all contacts!', 'success');
        }, 2000);
    }
}

function filterAlerts(filter) {
    const table = document.getElementById('alertsTable');
    const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    
    for (let row of rows) {
        let showRow = false;
        
        switch(filter) {
            case 'all':
                showRow = true;
                break;
            default:
                showRow = row.getAttribute('data-priority') === filter;
        }
        
        row.style.display = showRow ? '' : 'none';
    }
}

function investigateAlert(id) {
    showNotification('Opening investigation dashboard...', 'info');
    setTimeout(() => {
        showNotification('Investigation dashboard opened for alert #' + id, 'success');
    }, 1500);
}

function escalateAlert(id) {
    if (confirm('Are you sure you want to escalate this alert?')) {
        showNotification('Escalating alert to emergency contacts...', 'warning');
        setTimeout(() => {
            showNotification('Alert escalated successfully!', 'success');
        }, 1500);
    }
}

function resolveAlert(id) {
    showNotification('Resolving alert...', 'info');
    setTimeout(() => {
        showNotification('Alert resolved successfully!', 'success');
    }, 1000);
}

function viewAlertDetails(id) {
    showNotification('Loading alert details...', 'info');
    setTimeout(() => {
        showNotification('Alert details loaded for alert #' + id, 'success');
    }, 1000);
}

function acknowledgeAlert(id) {
    showNotification('Acknowledging alert...', 'info');
    setTimeout(() => {
        showNotification('Alert acknowledged successfully!', 'success');
    }, 1000);
}

function ignoreSimilarAlerts(id) {
    showNotification('Ignoring similar alerts...', 'info');
    setTimeout(() => {
        showNotification('Similar alerts will be ignored!', 'success');
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
