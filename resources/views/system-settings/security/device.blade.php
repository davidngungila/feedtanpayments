@extends('layouts.app')

@section('title', 'IP & Device Security - FeedTan Pay')

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
                                    <i class="bx bx-desktop me-2 text-primary"></i>
                                    IP & Device Security
                                </h4>
                                <p class="text-muted mb-0">IP blocking, trusted devices, new device approval, and geo-location tracking</p>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-outline-danger" onclick="scanDevices()">
                                    <i class="bx bx-scan me-2"></i>Scan Devices
                                </button>
                                <button type="button" class="btn btn-outline-secondary" onclick="refreshDeviceSecurity()">
                                    <i class="bx bx-refresh me-2"></i>Refresh
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Device Security Overview -->
        <div class="row mb-6">
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-success bg-opacity-10 rounded-circle me-3" style="width: 48px; height: 48px;">
                                <i class="bx bx-check-shield text-success fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Trusted Devices</h6>
                                <h4 class="mb-0">42</h4>
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
                                <i class="bx bx-block text-danger fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Blocked IPs</h6>
                                <h4 class="mb-0">18</h4>
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
                                <i class="bx bx-time text-warning fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Pending Approval</h6>
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
                                <i class="bx bx-map text-info fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Countries</h6>
                                <h4 class="mb-0">12</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- IP Address Management -->
        <div class="row mb-6">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-block me-2"></i>
                            Allow / Block Specific IP Addresses
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="mb-3">IP Management Settings</h6>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="enableIPFiltering" checked>
                                        <label class="form-check-label" for="enableIPFiltering">
                                            Enable IP filtering
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="whitelistMode">
                                        <label class="form-check-label" for="whitelistMode">
                                            Use whitelist mode (block all except allowed)
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="autoBlockSuspicious" checked>
                                        <label class="form-check-label" for="autoBlockSuspicious">
                                            Auto-block suspicious IPs
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="logBlockedAttempts" checked>
                                        <label class="form-check-label" for="logBlockedAttempts">
                                            Log blocked attempts
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="mb-3">Add IP Rule</h6>
                                    <div class="mb-3">
                                        <label class="form-label">IP Address or Range</label>
                                        <input type="text" class="form-control" id="ipAddress" placeholder="e.g., 192.168.1.100 or 192.168.1.0/24">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Action</label>
                                        <select class="form-select" id="ipAction">
                                            <option value="allow">Allow</option>
                                            <option value="block">Block</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Reason</label>
                                        <input type="text" class="form-control" id="ipReason" placeholder="Reason for this rule">
                                    </div>
                                    <button type="button" class="btn btn-primary" onclick="addIPRule()">
                                        <i class="bx bx-plus me-2"></i>Add IP Rule
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <h6>Current IP Rules</h6>
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>IP Address/Range</th>
                                                    <th>Action</th>
                                                    <th>Reason</th>
                                                    <th>Added</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><code>192.168.1.0/24</code></td>
                                                    <td><span class="badge bg-success">Allow</span></td>
                                                    <td>Office Network</td>
                                                    <td>2024-12-15</td>
                                                    <td><span class="badge bg-success">Active</span></td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeIPRule(1)">
                                                            <i class="bx bx-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><code>203.45.67.89</code></td>
                                                    <td><span class="badge bg-danger">Block</span></td>
                                                    <td>Suspicious Activity</td>
                                                    <td>2024-12-18</td>
                                                    <td><span class="badge bg-success">Active</span></td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeIPRule(2)">
                                                            <i class="bx bx-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><code>185.220.101.182</code></td>
                                                    <td><span class="badge bg-danger">Block</span></td>
                                                    <td>Blacklisted Country</td>
                                                    <td>2024-12-20</td>
                                                    <td><span class="badge bg-success">Active</span></td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeIPRule(3)">
                                                            <i class="bx bx-trash"></i>
                                                        </button>
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
        </div>

        <!-- Trusted Devices List -->
        <div class="row mb-6">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-desktop me-2"></i>
                            Trusted Devices List
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="mb-3">Device Management</h6>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="enableDeviceTrust" checked>
                                        <label class="form-check-label" for="enableDeviceTrust">
                                            Enable device trust management
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="requireDeviceApproval" checked>
                                        <label class="form-check-label" for="requireDeviceApproval">
                                            Require approval for new devices
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="deviceFingerprinting" checked>
                                        <label class="form-check-label" for="deviceFingerprinting">
                                            Enable device fingerprinting
                                        </label>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Max Trusted Devices per User</label>
                                        <input type="number" class="form-control" id="maxTrustedDevices" value="5" min="1" max="20">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="mb-3">Device Statistics</h6>
                                    <div class="row text-center">
                                        <div class="col-4 mb-3">
                                            <h4 class="text-primary mb-0">42</h4>
                                            <small class="text-muted">Total Devices</small>
                                        </div>
                                        <div class="col-4 mb-3">
                                            <h4 class="text-success mb-0">38</h4>
                                            <small class="text-muted">Active</small>
                                        </div>
                                        <div class="col-4 mb-3">
                                            <h4 class="text-warning mb-0">4</h4>
                                            <small class="text-muted">Inactive</small>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-outline-warning" onclick="clearInactiveDevices()">
                                            <i class="bx bx-trash me-2"></i>Clear Inactive
                                        </button>
                                        <button type="button" class="btn btn-outline-danger" onclick="clearAllDevices()">
                                            <i class="bx bx-trash me-2"></i>Clear All
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>User</th>
                                                <th>Device Name</th>
                                                <th>Type</th>
                                                <th>Browser/OS</th>
                                                <th>IP Address</th>
                                                <th>First Seen</th>
                                                <th>Last Used</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>John Doe</td>
                                                <td>John's Laptop</td>
                                                <td><span class="badge bg-primary">Desktop</span></td>
                                                <td>Chrome / Windows</td>
                                                <td><code>192.168.1.100</code></td>
                                                <td>2024-12-15</td>
                                                <td>2 hours ago</td>
                                                <td><span class="badge bg-success">Active</span></td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeDevice(1)">
                                                        <i class="bx bx-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Jane Smith</td>
                                                <td>iPhone 14 Pro</td>
                                                <td><span class="badge bg-success">Mobile</span></td>
                                                <td>Safari / iOS</td>
                                                <td><code>192.168.1.105</code></td>
                                                <td>2024-12-16</td>
                                                <td>1 day ago</td>
                                                <td><span class="badge bg-success">Active</span></td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeDevice(2)">
                                                        <i class="bx bx-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Mike Johnson</td>
                                                <td>Office Computer</td>
                                                <td><span class="badge bg-primary">Desktop</span></td>
                                                <td>Firefox / Linux</td>
                                                <td><code>192.168.1.110</code></td>
                                                <td>2024-12-14</td>
                                                <td>3 days ago</td>
                                                <td><span class="badge bg-warning">Inactive</span></td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeDevice(3)">
                                                        <i class="bx bx-trash"></i>
                                                    </button>
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

        <!-- New Device Approval -->
        <div class="row mb-6">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-time me-2"></i>
                            New Device Approval
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Timestamp</th>
                                        <th>User</th>
                                        <th>Device Details</th>
                                        <th>IP Address</th>
                                        <th>Location</th>
                                        <th>Risk Score</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><small>2024-12-22 14:35:22</small></td>
                                        <td>Sarah Williams</td>
                                        <td>
                                            <div>
                                                <strong>New iPad</strong><br>
                                                <small class="text-muted">Safari / iPadOS</small>
                                            </div>
                                        </td>
                                        <td><code>203.45.67.89</code></td>
                                        <td>Dar es Salaam, TZ</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="progress me-2" style="width: 60px; height: 8px;">
                                                    <div class="progress-bar bg-warning" style="width: 45%"></div>
                                                </div>
                                                <span class="text-warning">45%</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-success" onclick="approveDevice(1)">
                                                    <i class="bx bx-check"></i> Approve
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger" onclick="denyDevice(1)">
                                                    <i class="bx bx-x"></i> Deny
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><small>2024-12-22 14:32:15</small></td>
                                        <td>Robert Brown</td>
                                        <td>
                                            <div>
                                                <strong>Android Phone</strong><br>
                                                <small class="text-muted">Chrome / Android</small>
                                            </div>
                                        </td>
                                        <td><code>41.202.123.45</code></td>
                                        <td>Unknown Location</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="progress me-2" style="width: 60px; height: 8px;">
                                                    <div class="progress-bar bg-danger" style="width: 78%"></div>
                                                </div>
                                                <span class="text-danger">78%</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-success" onclick="approveDevice(2)">
                                                    <i class="bx bx-check"></i> Approve
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger" onclick="denyDevice(2)">
                                                    <i class="bx bx-x"></i> Deny
                                                </button>
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

        <!-- Geo-location Tracking -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-map me-2"></i>
                            Geo-location Tracking of Login
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="mb-3">Geo-location Settings</h6>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="enableGeoTracking" checked>
                                        <label class="form-check-label" for="enableGeoTracking">
                                            Enable geo-location tracking
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="blockForeignCountries">
                                        <label class="form-check-label" for="blockForeignCountries">
                                            Block foreign countries
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="alertNewLocation" checked>
                                        <label class="form-check-label" for="alertNewLocation">
                                            Alert on new location
                                        </label>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Allowed Countries</label>
                                        <select class="form-select" id="allowedCountries" multiple>
                                            <option value="TZ" selected>Tanzania</option>
                                            <option value="KE" selected>Kenya</option>
                                            <option value="UG" selected>Uganda</option>
                                            <option value="RW">Rwanda</option>
                                            <option value="BI">Burundi</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="mb-3">Location Statistics</h6>
                                    <div class="row text-center">
                                        <div class="col-4 mb-3">
                                            <h4 class="text-info mb-0">12</h4>
                                            <small class="text-muted">Countries</small>
                                        </div>
                                        <div class="col-4 mb-3">
                                            <h4 class="text-success mb-0">156</h4>
                                            <small class="text-muted">Cities</small>
                                        </div>
                                        <div class="col-4 mb-3">
                                            <h4 class="text-warning mb-0">3</h4>
                                            <small class="text-muted">Blocked</small>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <h6>Recent Login Locations</h6>
                                        <div class="list-group">
                                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                                <div>
                                                    <strong>Dar es Salaam, TZ</strong><br>
                                                    <small class="text-muted">89 logins today</small>
                                                </div>
                                                <span class="badge bg-success">Allowed</span>
                                            </div>
                                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                                <div>
                                                    <strong>Nairobi, KE</strong><br>
                                                    <small class="text-muted">12 logins today</small>
                                                </div>
                                                <span class="badge bg-success">Allowed</span>
                                            </div>
                                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                                <div>
                                                    <strong>Moscow, RU</strong><br>
                                                    <small class="text-muted">3 attempts blocked</small>
                                                </div>
                                                <span class="badge bg-danger">Blocked</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-primary" onclick="saveGeoSettings()">
                                        <i class="bx bx-save me-2"></i>Save Geo Settings
                                    </button>
                                    <button type="button" class="btn btn-outline-info" onclick="viewLocationMap()">
                                        <i class="bx bx-map me-2"></i>View Map
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

@push('scripts')

<script>
function refreshDeviceSecurity() {
    showNotification('Refreshing device security data...', 'info');
    setTimeout(() => {
        location.reload();
    }, 1000);
}

function scanDevices() {
    showNotification('Scanning for devices...', 'info');
    setTimeout(() => {
        showNotification('Device scan completed! 2 new devices detected.', 'warning');
    }, 3000);
}

function addIPRule() {
    const ipAddress = document.getElementById('ipAddress').value;
    const action = document.getElementById('ipAction').value;
    const reason = document.getElementById('ipReason').value;
    
    if (!ipAddress || !reason) {
        showNotification('Please fill in all fields', 'warning');
        return;
    }
    
    showNotification(`Adding IP rule: ${ipAddress} (${action})...`, 'info');
    setTimeout(() => {
        showNotification('IP rule added successfully!', 'success');
        document.getElementById('ipAddress').value = '';
        document.getElementById('ipReason').value = '';
    }, 1500);
}

function removeIPRule(id) {
    if (confirm('Are you sure you want to remove this IP rule?')) {
        showNotification('Removing IP rule...', 'info');
        setTimeout(() => {
            showNotification('IP rule removed successfully!', 'success');
        }, 1000);
    }
}

function removeDevice(id) {
    if (confirm('Are you sure you want to remove this trusted device?')) {
        showNotification('Removing trusted device...', 'info');
        setTimeout(() => {
            showNotification('Trusted device removed successfully!', 'success');
        }, 1000);
    }
}

function clearInactiveDevices() {
    if (confirm('Are you sure you want to clear all inactive devices?')) {
        showNotification('Clearing inactive devices...', 'info');
        setTimeout(() => {
            showNotification('Inactive devices cleared successfully!', 'success');
        }, 1500);
    }
}

function clearAllDevices() {
    if (confirm('Are you sure you want to clear all trusted devices? Users will need to re-verify their devices.')) {
        showNotification('Clearing all trusted devices...', 'warning');
        setTimeout(() => {
            showNotification('All trusted devices cleared successfully!', 'success');
        }, 2000);
    }
}

function approveDevice(id) {
    showNotification('Approving new device...', 'info');
    setTimeout(() => {
        showNotification('Device approved successfully!', 'success');
    }, 1000);
}

function denyDevice(id) {
    if (confirm('Are you sure you want to deny this device?')) {
        showNotification('Denying new device...', 'warning');
        setTimeout(() => {
            showNotification('Device denied and blocked!', 'success');
        }, 1000);
    }
}

function saveGeoSettings() {
    showNotification('Saving geo-location settings...', 'info');
    setTimeout(() => {
        showNotification('Geo-location settings saved successfully!', 'success');
    }, 1500);
}

function viewLocationMap() {
    showNotification('Opening location map...', 'info');
    setTimeout(() => {
        showNotification('Location map opened successfully!', 'success');
    }, 1500);
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
