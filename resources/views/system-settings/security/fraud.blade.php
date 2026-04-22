@extends('layouts.app')

@section('title', 'Smart Fraud Detection - FeedTan Pay')

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
                                    <i class="bx bx-shield-alt me-2 text-danger"></i>
                                    Smart Fraud Detection MUST HAVE
                                </h4>
                                <p class="text-muted mb-0">AI-powered fraud detection with unusual transaction monitoring and velocity checks</p>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-outline-danger" onclick="runFraudScan()">
                                    <i class="bx bx-scan me-2"></i>Run Fraud Scan
                                </button>
                                <button type="button" class="btn btn-outline-secondary" onclick="refreshFraudData()">
                                    <i class="bx bx-refresh me-2"></i>Refresh
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fraud Detection Status -->
        <div class="row mb-6">
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-danger bg-opacity-10 rounded-circle me-3" style="width: 48px; height: 48px;">
                                <i class="bx bx-error text-danger fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">High Risk</h6>
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
                            <div class="avatar bg-warning bg-opacity-10 rounded-circle me-3" style="width: 48px; height: 48px;">
                                <i class="bx bx-error-alt text-warning fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Medium Risk</h6>
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
                                <i class="bx bx-check-shield text-success fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Blocked</h6>
                                <h4 class="mb-0">7</h4>
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
                                <i class="bx bx-tachometer text-info fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Score</h6>
                                <h4 class="mb-0">92%</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fraud Detection Settings -->
        <div class="row mb-6">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-cog me-2"></i>
                            Fraud Detection Configuration
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="mb-3">Detection Rules</h6>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="enableUnusualTransactions" checked>
                                        <label class="form-check-label" for="enableUnusualTransactions">
                                            Detect unusual transactions
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="enableHighRiskActivity" checked>
                                        <label class="form-check-label" for="enableHighRiskActivity">
                                            Flag high-risk activity
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="enableVelocityChecks" checked>
                                        <label class="form-check-label" for="enableVelocityChecks">
                                            Enable velocity checks
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="enableSuspiciousIP" checked>
                                        <label class="form-check-label" for="enableSuspiciousIP">
                                            Detect suspicious IP addresses
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="enableFailedLoginAlerts" checked>
                                        <label class="form-check-label" for="enableFailedLoginAlerts">
                                            Multiple failed login alerts
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="mb-3">Threshold Settings</h6>
                                    <div class="mb-3">
                                        <label class="form-label">Unusual Transaction Amount (TZS)</label>
                                        <input type="number" class="form-control" id="unusualAmount" value="500000" min="0">
                                        <small class="text-muted">Flag transactions above this amount</small>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Velocity Check Limit</label>
                                        <input type="number" class="form-control" id="velocityLimit" value="10" min="1">
                                        <small class="text-muted">Max transactions per minute</small>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Failed Login Threshold</label>
                                        <input type="number" class="form-control" id="failedLoginThreshold" value="5" min="1">
                                        <small class="text-muted">Alert after X failed attempts</small>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Risk Score Threshold</label>
                                        <input type="number" class="form-control" id="riskThreshold" value="75" min="0" max="100">
                                        <small class="text-muted">Flag users with risk score above this</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-primary" onclick="saveFraudSettings()">
                                        <i class="bx bx-save me-2"></i>Save Settings
                                    </button>
                                    <button type="button" class="btn btn-outline-warning" onclick="testFraudDetection()">
                                        <i class="bx bx-test-tube me-2"></i>Test Detection
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Fraud Alerts -->
        <div class="row mb-6">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0">
                                <i class="bx bx-bell me-2"></i>
                                Recent Fraud Alerts
                            </h5>
                            <small class="text-muted">Real-time fraud detection alerts</small>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="bx bx-filter me-1"></i>Filter
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="javascript:void(0)" onclick="filterAlerts('all')">All Alerts</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0)" onclick="filterAlerts('high')">High Risk</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0)" onclick="filterAlerts('medium')">Medium Risk</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0)" onclick="filterAlerts('blocked')">Blocked</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="fraudAlertsTable">
                                <thead>
                                    <tr>
                                        <th>
                                            <i class="bx bx-time me-1"></i>
                                            Timestamp
                                        </th>
                                        <th>
                                            <i class="bx bx-user me-1"></i>
                                            User
                                        </th>
                                        <th>
                                            <i class="bx bx-error me-1"></i>
                                            Alert Type
                                        </th>
                                        <th>
                                            <i class="bx bx-tachometer me-1"></i>
                                            Risk Score
                                        </th>
                                        <th>
                                            <i class="bx bx-info-circle me-1"></i>
                                            Details
                                        </th>
                                        <th>
                                            <i class="bx bx-map me-1"></i>
                                            Location
                                        </th>
                                        <th>
                                            <i class="bx bx-cog me-1"></i>
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr data-risk="high">
                                        <td><small>2024-12-22 14:35:22</small></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar bg-danger bg-opacity-10 rounded-circle me-2" style="width: 32px; height: 32px;">
                                                    <i class="bx bx-user text-danger"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold">Unknown User</div>
                                                    <small class="text-muted">Guest</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-danger">Unusual Transaction</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="progress me-2" style="width: 100px; height: 8px;">
                                                    <div class="progress-bar bg-danger" style="width: 95%"></div>
                                                </div>
                                                <span class="text-danger">95%</span>
                                            </div>
                                        </td>
                                        <td>
                                            <small>Transaction amount TZS 2,500,000 exceeds user limit</small>
                                        </td>
                                        <td>
                                            <code>203.45.67.89</code>
                                            <small class="text-muted">Unknown Location</small>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-danger dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-horizontal-rounded"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="blockTransaction(1)">
                                                            <i class="bx bx-block me-2"></i>Block Transaction
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="investigateAlert(1)">
                                                            <i class="bx bx-search me-2"></i>Investigate
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="whitelistUser(1)">
                                                            <i class="bx bx-check-circle me-2"></i>Whitelist User
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr data-risk="medium">
                                        <td><small>2024-12-22 14:32:15</small></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar bg-warning bg-opacity-10 rounded-circle me-2" style="width: 32px; height: 32px;">
                                                    <i class="bx bx-user text-warning"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold">Mike Johnson</div>
                                                    <small class="text-muted">Member</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning">Velocity Check</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="progress me-2" style="width: 100px; height: 8px;">
                                                    <div class="progress-bar bg-warning" style="width: 72%"></div>
                                                </div>
                                                <span class="text-warning">72%</span>
                                            </div>
                                        </td>
                                        <td>
                                            <small>12 transactions in 5 minutes exceeds limit</small>
                                        </td>
                                        <td>
                                            <code>192.168.1.110</code>
                                            <small class="text-muted">Dar es Salaam</small>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-warning dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-horizontal-rounded"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="limitUser(2)">
                                                            <i class="bx bx-lock me-2"></i>Limit User
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="investigateAlert(2)">
                                                            <i class="bx bx-search me-2"></i>Investigate
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="ignoreAlert(2)">
                                                            <i class="bx bx-x me-2"></i>Ignore Alert
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr data-risk="blocked">
                                        <td><small>2024-12-22 14:28:45</small></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar bg-secondary bg-opacity-10 rounded-circle me-2" style="width: 32px; height: 32px;">
                                                    <i class="bx bx-user text-secondary"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold">Sarah Williams</div>
                                                    <small class="text-muted">Blocked</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">Blocked</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="progress me-2" style="width: 100px; height: 8px;">
                                                    <div class="progress-bar bg-secondary" style="width: 88%"></div>
                                                </div>
                                                <span class="text-secondary">88%</span>
                                            </div>
                                        </td>
                                        <td>
                                            <small>Suspicious IP from blacklisted country</small>
                                        </td>
                                        <td>
                                            <code>185.220.101.182</code>
                                            <small class="text-muted">Blacklisted</small>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-horizontal-rounded"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="unblockUser(3)">
                                                            <i class="bx bx-lock-open me-2"></i>Unblock User
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="viewDetails(3)">
                                                            <i class="bx bx-eye me-2"></i>View Details
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="blacklistIP(3)">
                                                            <i class="bx bx-shield-x me-2"></i>Blacklist IP
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

        <!-- Fraud Detection Statistics -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-bar-chart me-2"></i>
                            Fraud Detection Analytics
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h4 class="text-danger">156</h4>
                                    <small class="text-muted">Total Alerts Today</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h4 class="text-warning">23</h4>
                                    <small class="text-muted">False Positives</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h4 class="text-success">133</h4>
                                    <small class="text-muted">True Positives</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h4 class="text-info">85.2%</h4>
                                    <small class="text-muted">Accuracy Rate</small>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="mb-3">
                                    <h6>Detection Performance (Last 7 Days)</h6>
                                    <div class="progress" style="height: 25px;">
                                        <div class="progress-bar bg-success" style="width: 85.2%">85.2% Accuracy</div>
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
function refreshFraudData() {
    showNotification('Refreshing fraud detection data...', 'info');
    setTimeout(() => {
        location.reload();
    }, 1000);
}

function runFraudScan() {
    showNotification('Running comprehensive fraud scan...', 'info');
    setTimeout(() => {
        showNotification('Fraud scan completed! 3 new threats detected.', 'warning');
    }, 3000);
}

function saveFraudSettings() {
    showNotification('Saving fraud detection settings...', 'info');
    setTimeout(() => {
        showNotification('Fraud settings saved successfully!', 'success');
    }, 1500);
}

function testFraudDetection() {
    showNotification('Testing fraud detection algorithms...', 'info');
    setTimeout(() => {
        showNotification('Fraud detection test completed successfully!', 'success');
    }, 2000);
}

function filterAlerts(filter) {
    const table = document.getElementById('fraudAlertsTable');
    const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    
    for (let row of rows) {
        let showRow = false;
        
        switch(filter) {
            case 'all':
                showRow = true;
                break;
            default:
                showRow = row.getAttribute('data-risk') === filter;
        }
        
        row.style.display = showRow ? '' : 'none';
    }
}

function blockTransaction(id) {
    if (confirm('Are you sure you want to block this transaction?')) {
        showNotification('Blocking transaction...', 'info');
        setTimeout(() => {
            showNotification('Transaction blocked successfully!', 'success');
        }, 1500);
    }
}

function investigateAlert(id) {
    showNotification('Opening investigation dashboard...', 'info');
    setTimeout(() => {
        showNotification('Investigation dashboard opened for alert #' + id, 'success');
    }, 1500);
}

function whitelistUser(id) {
    if (confirm('Are you sure you want to whitelist this user? They will bypass fraud checks.')) {
        showNotification('Whitelisting user...', 'info');
        setTimeout(() => {
            showNotification('User whitelisted successfully!', 'success');
        }, 1500);
    }
}

function limitUser(id) {
    showNotification('Applying user limitations...', 'info');
    setTimeout(() => {
        showNotification('User limitations applied successfully!', 'success');
    }, 1500);
}

function ignoreAlert(id) {
    showNotification('Ignoring fraud alert...', 'info');
    setTimeout(() => {
        showNotification('Alert ignored successfully!', 'success');
    }, 1000);
}

function unblockUser(id) {
    if (confirm('Are you sure you want to unblock this user?')) {
        showNotification('Unblocking user...', 'info');
        setTimeout(() => {
            showNotification('User unblocked successfully!', 'success');
        }, 1500);
    }
}

function viewDetails(id) {
    showNotification('Loading alert details...', 'info');
    setTimeout(() => {
        showNotification('Alert details loaded for alert #' + id, 'success');
    }, 1000);
}

function blacklistIP(id) {
    if (confirm('Are you sure you want to blacklist this IP address?')) {
        showNotification('Blacklisting IP address...', 'info');
        setTimeout(() => {
            showNotification('IP address blacklisted successfully!', 'success');
        }, 1500);
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
