@extends('layouts.app')

@section('title', 'Session Security - FeedTan Pay')

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
                                    <i class="bx bx-time me-2 text-primary"></i>
                                    Session Security
                                </h4>
                                <p class="text-muted mb-0">Auto logout after inactivity, single session per user, session timeout control, force logout all devices</p>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-outline-danger" onclick="forceLogoutAll()">
                                    <i class="bx bx-power-off me-2"></i>Force Logout All
                                </button>
                                <button type="button" class="btn btn-outline-secondary" onclick="refreshSessionSecurity()">
                                    <i class="bx bx-refresh me-2"></i>Refresh
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Session Security Overview -->
        <div class="row mb-6">
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-success bg-opacity-10 rounded-circle me-3" style="width: 48px; height: 48px;">
                                <i class="bx bx-user-check text-success fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Active Sessions</h6>
                                <h4 class="mb-0">89</h4>
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
                                <i class="bx bx-time-five text-warning fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Idle Sessions</h6>
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
                            <div class="avatar bg-info bg-opacity-10 rounded-circle me-3" style="width: 48px; height: 48px;">
                                <i class="bx bx-timer text-info fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Avg Duration</h6>
                                <h4 class="mb-0">45m</h4>
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
                                <h6 class="mb-0">Blocked</h6>
                                <h4 class="mb-0">3</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Auto Logout Settings -->
        <div class="row mb-6">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-time-five me-2"></i>
                            Auto Logout After Inactivity
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="mb-3">Auto Logout Configuration</h6>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="enableAutoLogout" checked>
                                        <label class="form-check-label" for="enableAutoLogout">
                                            Enable auto logout after inactivity
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="showWarning" checked>
                                        <label class="form-check-label" for="showWarning">
                                            Show warning before auto logout
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="extendSession" checked>
                                        <label class="form-check-label" for="extendSession">
                                            Allow session extension on activity
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="logoutOnClose" checked>
                                        <label class="form-check-label" for="logoutOnClose">
                                            Logout on browser close
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="mb-3">Timeout Settings</h6>
                                    <div class="mb-3">
                                        <label class="form-label">Auto Logout Timeout (minutes)</label>
                                        <input type="number" class="form-control" id="autoLogoutTimeout" value="30" min="5" max="480">
                                        <small class="text-muted">User will be logged out after X minutes of inactivity</small>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Warning Time (minutes)</label>
                                        <input type="number" class="form-control" id="warningTime" value="5" min="1" max="30">
                                        <small class="text-muted">Show warning X minutes before logout</small>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Grace Period (minutes)</label>
                                        <input type="number" class="form-control" id="gracePeriod" value="2" min="0" max="10">
                                        <small class="text-muted">Additional time after warning before logout</small>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Different timeouts by role</label>
                                        <select class="form-select" id="roleBasedTimeout">
                                            <option value="same">Same timeout for all roles</option>
                                            <option value="different">Different timeouts per role</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-primary" onclick="saveAutoLogoutSettings()">
                                        <i class="bx bx-save me-2"></i>Save Settings
                                    </button>
                                    <button type="button" class="btn btn-outline-warning" onclick="testAutoLogout()">
                                        <i class="bx bx-test-tube me-2"></i>Test Auto Logout
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Single Session Per User -->
        <div class="row mb-6">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-user-x me-2"></i>
                            Single Session Per User (Optional)
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="mb-3">Single Session Settings</h6>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="enableSingleSession">
                                        <label class="form-check-label" for="enableSingleSession">
                                            Enable single session per user
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="forceLogoutNew">
                                        <label class="form-check-label" for="forceLogoutNew">
                                            Force logout from other devices on new login
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="notifyUser" checked>
                                        <label class="form-check-label" for="notifyUser">
                                            Notify user when logged out from other device
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="allowOverride">
                                        <label class="form-check-label" for="allowOverride">
                                            Allow admins to override single session limit
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="mb-3">Session Override Options</h6>
                                    <div class="mb-3">
                                        <label class="form-label">Session Override Behavior</label>
                                        <select class="form-select" id="overrideBehavior">
                                            <option value="ask">Ask user which session to keep</option>
                                            <option value="new">Keep new session, logout old</option>
                                            <option value="old">Keep old session, block new</option>
                                            <option value="admin">Admin decides</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Roles Excluded from Single Session</label>
                                        <select class="form-select" id="excludedRoles" multiple>
                                            <option value="super_admin">Super Admin</option>
                                            <option value="admin">Admin</option>
                                            <option value="manager">Manager</option>
                                        </select>
                                        <small class="text-muted">These roles can have multiple sessions</small>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Maximum Sessions per User</label>
                                        <input type="number" class="form-control" id="maxSessions" value="1" min="1" max="10">
                                        <small class="text-muted">Set to 1 for true single session</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-primary" onclick="saveSingleSessionSettings()">
                                        <i class="bx bx-save me-2"></i>Save Settings
                                    </button>
                                    <button type="button" class="btn btn-outline-info" onclick="viewActiveSessions()">
                                        <i class="bx bx-list-ul me-2"></i>View Active Sessions
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Session Timeout Control -->
        <div class="row mb-6">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-timer me-2"></i>
                            Session Timeout Control
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="mb-3">Timeout Configuration</h6>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="enableTimeoutControl" checked>
                                        <label class="form-check-label" for="enableTimeoutControl">
                                            Enable session timeout control
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="extendOnActivity" checked>
                                        <label class="form-check-label" for="extendOnActivity">
                                            Extend session on user activity
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="trackActivity" checked>
                                        <label class="form-check-label" for="trackActivity">
                                            Track user activity for timeout calculation
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="hardTimeout">
                                        <label class="form-check-label" for="hardTimeout">
                                            Enable hard timeout (cannot be extended)
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="mb-3">Advanced Timeout Settings</h6>
                                    <div class="mb-3">
                                        <label class="form-label">Session Lifetime (hours)</label>
                                        <input type="number" class="form-control" id="sessionLifetime" value="8" min="1" max="24">
                                        <small class="text-muted">Maximum session duration regardless of activity</small>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Inactivity Check Interval (minutes)</label>
                                        <input type="number" class="form-control" id="checkInterval" value="1" min="0.5" max="10">
                                        <small class="text-muted">How often to check for user inactivity</small>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Activity Types to Track</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="trackClicks" checked>
                                            <label class="form-check-label" for="trackClicks">Mouse Clicks</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="trackKeys" checked>
                                            <label class="form-check-label" for="trackKeys">Keyboard Input</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="trackScroll" checked>
                                            <label class="form-check-label" for="trackScroll">Page Scrolling</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-primary" onclick="saveTimeoutSettings()">
                                        <i class="bx bx-save me-2"></i>Save Settings
                                    </button>
                                    <button type="button" class="btn btn-outline-warning" onclick="testTimeoutBehavior()">
                                        <i class="bx bx-test-tube me-2"></i>Test Timeout
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Sessions Management -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0">
                                <i class="bx bx-list-ul me-2"></i>
                                Active Sessions Management
                            </h5>
                            <small class="text-muted">Monitor and manage all active user sessions</small>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-sm btn-outline-warning" onclick="refreshSessions()">
                                <i class="bx bx-refresh me-1"></i>Refresh
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="forceLogoutAll()">
                                <i class="bx bx-power-off me-1"></i>Force Logout All
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="sessionsTable">
                                <thead>
                                    <tr>
                                        <th>
                                            <i class="bx bx-user me-1"></i>
                                            User
                                        </th>
                                        <th>
                                            <i class="bx bx-desktop me-1"></i>
                                            Device
                                        </th>
                                        <th>
                                            <i class="bx bx-map me-1"></i>
                                            Location
                                        </th>
                                        <th>
                                            <i class="bx bx-time me-1"></i>
                                            Login Time
                                        </th>
                                        <th>
                                            <i class="bx bx-timer me-1"></i>
                                            Duration
                                        </th>
                                        <th>
                                            <i class="bx bx-activity me-1"></i>
                                            Last Activity
                                        </th>
                                        <th>
                                            <i class="bx bx-info-circle me-1"></i>
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
                                            <div class="d-flex align-items-center">
                                                <div class="avatar bg-primary bg-opacity-10 rounded-circle me-2" style="width: 32px; height: 32px;">
                                                    <i class="bx bx-user text-primary"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold">John Doe</div>
                                                    <small class="text-muted">Admin</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <strong>Chrome / Windows</strong><br>
                                                <small class="text-muted">192.168.1.100</small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">Dar es Salaam</span>
                                        </td>
                                        <td><small>2024-12-22 09:15:22</small></td>
                                        <td><strong>5h 20m</strong></td>
                                        <td><small>2 minutes ago</small></td>
                                        <td><span class="badge bg-success">Active</span></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-horizontal-rounded"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="extendSession(1)">
                                                            <i class="bx bx-time me-2"></i>Extend Session
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="sendWarning(1)">
                                                            <i class="bx bx-bell me-2"></i>Send Warning
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="forceLogout(1)">
                                                            <i class="bx bx-power-off me-2"></i>Force Logout
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar bg-success bg-opacity-10 rounded-circle me-2" style="width: 32px; height: 32px;">
                                                    <i class="bx bx-user text-success"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold">Jane Smith</div>
                                                    <small class="text-muted">Staff</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <strong>Firefox / macOS</strong><br>
                                                <small class="text-muted">192.168.1.105</small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">Dar es Salaam</span>
                                        </td>
                                        <td><small>2024-12-22 08:45:15</small></td>
                                        <td><strong>5h 50m</strong></td>
                                        <td><small>15 minutes ago</small></td>
                                        <td><span class="badge bg-warning">Idle</span></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-horizontal-rounded"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="extendSession(2)">
                                                            <i class="bx bx-time me-2"></i>Extend Session
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="sendWarning(2)">
                                                            <i class="bx bx-bell me-2"></i>Send Warning
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="forceLogout(2)">
                                                            <i class="bx bx-power-off me-2"></i>Force Logout
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
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
                                            <div>
                                                <strong>Safari / iPhone</strong><br>
                                                <small class="text-muted">192.168.1.110</small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">Unknown</span>
                                        </td>
                                        <td><small>2024-12-22 10:30:45</small></td>
                                        <td><strong>4h 05m</strong></td>
                                        <td><small>1 hour ago</small></td>
                                        <td><span class="badge bg-warning">Idle</span></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-horizontal-rounded"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="extendSession(3)">
                                                            <i class="bx bx-time me-2"></i>Extend Session
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="sendWarning(3)">
                                                            <i class="bx bx-bell me-2"></i>Send Warning
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="forceLogout(3)">
                                                            <i class="bx bx-power-off me-2"></i>Force Logout
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
function refreshSessionSecurity() {
    showNotification('Refreshing session security data...', 'info');
    setTimeout(() => {
        location.reload();
    }, 1000);
}

function saveAutoLogoutSettings() {
    showNotification('Saving auto logout settings...', 'info');
    setTimeout(() => {
        showNotification('Auto logout settings saved successfully!', 'success');
    }, 1500);
}

function testAutoLogout() {
    showNotification('Testing auto logout behavior...', 'warning');
    setTimeout(() => {
        showNotification('Auto logout test completed successfully!', 'success');
    }, 3000);
}

function saveSingleSessionSettings() {
    showNotification('Saving single session settings...', 'info');
    setTimeout(() => {
        showNotification('Single session settings saved successfully!', 'success');
    }, 1500);
}

function viewActiveSessions() {
    showNotification('Loading active sessions...', 'info');
    setTimeout(() => {
        showNotification('Active sessions loaded successfully!', 'success');
    }, 1000);
}

function saveTimeoutSettings() {
    showNotification('Saving timeout settings...', 'info');
    setTimeout(() => {
        showNotification('Timeout settings saved successfully!', 'success');
    }, 1500);
}

function testTimeoutBehavior() {
    showNotification('Testing timeout behavior...', 'warning');
    setTimeout(() => {
        showNotification('Timeout behavior test completed!', 'success');
    }, 3000);
}

function refreshSessions() {
    showNotification('Refreshing session list...', 'info');
    setTimeout(() => {
        showNotification('Session list refreshed!', 'success');
    }, 1000);
}

function forceLogoutAll() {
    if (confirm('Are you sure you want to force logout all users? This will terminate all active sessions immediately.')) {
        showNotification('Force logging out all users...', 'danger');
        setTimeout(() => {
            showNotification('All users logged out successfully!', 'success');
        }, 2000);
    }
}

function extendSession(id) {
    showNotification('Extending user session...', 'info');
    setTimeout(() => {
        showNotification('Session extended by 30 minutes!', 'success');
    }, 1000);
}

function sendWarning(id) {
    showNotification('Sending warning to user...', 'warning');
    setTimeout(() => {
        showNotification('Warning sent to user successfully!', 'success');
    }, 1000);
}

function forceLogout(id) {
    if (confirm('Are you sure you want to force logout this user?')) {
        showNotification('Force logging out user...', 'warning');
        setTimeout(() => {
            showNotification('User logged out successfully!', 'success');
        }, 1000);
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
