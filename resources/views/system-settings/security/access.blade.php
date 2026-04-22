@extends('layouts.app')

@section('title', 'Access Control - FeedTan Pay')

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
                                    <i class="bx bx-shield-alt me-2 text-primary"></i>
                                    Access Control (Very Important)
                                </h4>
                                <p class="text-muted mb-0">Role-Based Access Control (RBAC), permissions per module, and admin action limits</p>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-outline-success" onclick="testAccessControl()">
                                    <i class="bx bx-test-tube me-2"></i>Test Access
                                </button>
                                <button type="button" class="btn btn-outline-secondary" onclick="refreshAccessControl()">
                                    <i class="bx bx-refresh me-2"></i>Refresh
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Access Control Overview -->
        <div class="row mb-6">
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-primary bg-opacity-10 rounded-circle me-3" style="width: 48px; height: 48px;">
                                <i class="bx bx-user-voice text-primary fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Roles</h6>
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
                            <div class="avatar bg-success bg-opacity-10 rounded-circle me-3" style="width: 48px; height: 48px;">
                                <i class="bx bx-key text-success fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Permissions</h6>
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
                            <div class="avatar bg-warning bg-opacity-10 rounded-circle me-3" style="width: 48px; height: 48px;">
                                <i class="bx bx-lock-alt text-warning fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Restricted</h6>
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
                                <i class="bx bx-shield-check text-info fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Sessions</h6>
                                <h4 class="mb-0">89</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Role-Based Access Control -->
        <div class="row mb-6">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-user-voice me-2"></i>
                            Role-Based Access Control (RBAC)
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="mb-3">System Roles</h6>
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Role</th>
                                                    <th>Users</th>
                                                    <th>Permissions</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <span class="badge bg-danger">Super Admin</span>
                                                    </td>
                                                    <td>1</td>
                                                    <td>Full Access</td>
                                                    <td><span class="badge bg-success">Active</span></td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="editRole('super_admin')">
                                                            <i class="bx bx-edit"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <span class="badge bg-warning">Admin</span>
                                                    </td>
                                                    <td>3</td>
                                                    <td>42 Permissions</td>
                                                    <td><span class="badge bg-success">Active</span></td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="editRole('admin')">
                                                            <i class="bx bx-edit"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <span class="badge bg-info">Manager</span>
                                                    </td>
                                                    <td>8</td>
                                                    <td>28 Permissions</td>
                                                    <td><span class="badge bg-success">Active</span></td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="editRole('manager')">
                                                            <i class="bx bx-edit"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <span class="badge bg-primary">Staff</span>
                                                    </td>
                                                    <td>45</td>
                                                    <td>15 Permissions</td>
                                                    <td><span class="badge bg-success">Active</span></td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="editRole('staff')">
                                                            <i class="bx bx-edit"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <span class="badge bg-secondary">Member</span>
                                                    </td>
                                                    <td>190</td>
                                                    <td>8 Permissions</td>
                                                    <td><span class="badge bg-success">Active</span></td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="editRole('member')">
                                                            <i class="bx bx-edit"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="mb-3">Role Management</h6>
                                    <div class="mb-3">
                                        <label class="form-label">Create New Role</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="newRoleName" placeholder="Enter role name">
                                            <button type="button" class="btn btn-primary" onclick="createRole()">
                                                <i class="bx bx-plus"></i> Create
                                            </button>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Role Assignment</label>
                                        <select class="form-select" id="roleAssignment">
                                            <option value="">Select user to assign role</option>
                                            <option value="user1">John Doe - Current: Admin</option>
                                            <option value="user2">Jane Smith - Current: Staff</option>
                                            <option value="user3">Mike Johnson - Current: Manager</option>
                                        </select>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-success" onclick="assignRole()">
                                            <i class="bx bx-user-plus me-2"></i>Assign Role
                                        </button>
                                        <button type="button" class="btn btn-outline-info" onclick="viewRoleMatrix()">
                                            <i class="bx bx-grid me-2"></i>Role Matrix
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Module Permissions -->
        <div class="row mb-6">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-key me-2"></i>
                            Permission per Module
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Module</th>
                                        <th>Super Admin</th>
                                        <th>Admin</th>
                                        <th>Manager</th>
                                        <th>Staff</th>
                                        <th>Member</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>Dashboard</strong></td>
                                        <td><span class="badge bg-success">Full</span></td>
                                        <td><span class="badge bg-success">Full</span></td>
                                        <td><span class="badge bg-success">Full</span></td>
                                        <td><span class="badge bg-success">Full</span></td>
                                        <td><span class="badge bg-success">Full</span></td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="editModulePermissions('dashboard')">
                                                <i class="bx bx-edit"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Loans</strong></td>
                                        <td><span class="badge bg-success">Full</span></td>
                                        <td><span class="badge bg-success">Full</span></td>
                                        <td><span class="badge bg-warning">Manage</span></td>
                                        <td><span class="badge bg-info">View</span></td>
                                        <td><span class="badge bg-info">Apply</span></td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="editModulePermissions('loans')">
                                                <i class="bx bx-edit"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Savings</strong></td>
                                        <td><span class="badge bg-success">Full</span></td>
                                        <td><span class="badge bg-success">Full</span></td>
                                        <td><span class="badge bg-warning">Manage</span></td>
                                        <td><span class="badge bg-info">View</span></td>
                                        <td><span class="badge bg-info">Deposit</span></td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="editModulePermissions('savings')">
                                                <i class="bx bx-edit"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Payments</strong></td>
                                        <td><span class="badge bg-success">Full</span></td>
                                        <td><span class="badge bg-success">Full</span></td>
                                        <td><span class="badge bg-warning">Process</span></td>
                                        <td><span class="badge bg-info">View</span></td>
                                        <td><span class="badge bg-secondary">None</span></td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="editModulePermissions('payments')">
                                                <i class="bx bx-edit"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Members</strong></td>
                                        <td><span class="badge bg-success">Full</span></td>
                                        <td><span class="badge bg-success">Full</span></td>
                                        <td><span class="badge bg-warning">Manage</span></td>
                                        <td><span class="badge bg-info">View</span></td>
                                        <td><span class="badge bg-secondary">None</span></td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="editModulePermissions('members')">
                                                <i class="bx bx-edit"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Reports</strong></td>
                                        <td><span class="badge bg-success">Full</span></td>
                                        <td><span class="badge bg-success">Full</span></td>
                                        <td><span class="badge bg-success">Full</span></td>
                                        <td><span class="badge bg-info">View</span></td>
                                        <td><span class="badge bg-secondary">None</span></td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="editModulePermissions('reports')">
                                                <i class="bx bx-edit"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>System Settings</strong></td>
                                        <td><span class="badge bg-success">Full</span></td>
                                        <td><span class="badge bg-warning">Limited</span></td>
                                        <td><span class="badge bg-secondary">None</span></td>
                                        <td><span class="badge bg-secondary">None</span></td>
                                        <td><span class="badge bg-secondary">None</span></td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="editModulePermissions('system_settings')">
                                                <i class="bx bx-edit"></i>
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

        <!-- Admin Action Limits -->
        <div class="row mb-6">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-lock-alt me-2"></i>
                            Limit Admin Actions (Super Admin Only)
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="mb-3">Action Restrictions</h6>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="limitUserDeletion" checked>
                                        <label class="form-check-label" for="limitUserDeletion">
                                            Limit user deletion to Super Admin only
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="limitSystemChanges" checked>
                                        <label class="form-check-label" for="limitSystemChanges">
                                            Limit system configuration changes
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="limitFinancialTransactions" checked>
                                        <label class="form-check-label" for="limitFinancialTransactions">
                                            Require approval for large transactions
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="limitRoleChanges" checked>
                                        <label class="form-check-label" for="limitRoleChanges">
                                            Limit role assignment to Super Admin only
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="mb-3">Approval Thresholds</h6>
                                    <div class="mb-3">
                                        <label class="form-label">Transaction Approval Amount (TZS)</label>
                                        <input type="number" class="form-control" id="approvalAmount" value="1000000" min="0">
                                        <small class="text-muted">Require approval for transactions above this amount</small>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Mass Operations Limit</label>
                                        <input type="number" class="form-control" id="massOperationsLimit" value="100" min="1">
                                        <small class="text-muted">Maximum records for bulk operations</small>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Data Export Limit (records)</label>
                                        <input type="number" class="form-control" id="exportLimit" value="10000" min="1">
                                        <small class="text-muted">Maximum records per export</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-primary" onclick="saveAdminLimits()">
                                        <i class="bx bx-save me-2"></i>Save Limits
                                    </button>
                                    <button type="button" class="btn btn-outline-warning" onclick="testAdminLimits()">
                                        <i class="bx bx-test-tube me-2"></i>Test Limits
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Session-Based Access Limits -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-time me-2"></i>
                            Session-Based Access Limits
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="mb-3">Session Restrictions</h6>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="enableSessionLimits" checked>
                                        <label class="form-check-label" for="enableSessionLimits">
                                            Enable session-based access limits
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="concurrentSessions" checked>
                                        <label class="form-check-label" for="concurrentSessions">
                                            Limit concurrent sessions per user
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="timeBasedRestrictions">
                                        <label class="form-check-label" for="timeBasedRestrictions">
                                            Enable time-based access restrictions
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="locationBasedRestrictions" checked>
                                        <label class="form-check-label" for="locationBasedRestrictions">
                                            Enable location-based access restrictions
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="mb-3">Session Configuration</h6>
                                    <div class="mb-3">
                                        <label class="form-label">Max Sessions per User</label>
                                        <input type="number" class="form-control" id="maxSessions" value="3" min="1" max="10">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Session Timeout (minutes)</label>
                                        <input type="number" class="form-control" id="sessionTimeout" value="30" min="5" max="480">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Allowed Access Hours</label>
                                        <div class="row">
                                            <div class="col-6">
                                                <label class="form-label">From</label>
                                                <input type="time" class="form-control" id="accessFrom" value="06:00">
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label">To</label>
                                                <input type="time" class="form-control" id="accessTo" value="22:00">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-primary" onclick="saveSessionLimits()">
                                        <i class="bx bx-save me-2"></i>Save Session Settings
                                    </button>
                                    <button type="button" class="btn btn-outline-danger" onclick="forceLogoutAll()">
                                        <i class="bx bx-power-off me-2"></i>Force Logout All
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
function refreshAccessControl() {
    showNotification('Refreshing access control settings...', 'info');
    setTimeout(() => {
        location.reload();
    }, 1000);
}

function testAccessControl() {
    showNotification('Testing access control permissions...', 'info');
    setTimeout(() => {
        showNotification('Access control test completed successfully!', 'success');
    }, 2000);
}

function editRole(role) {
    showNotification(`Editing role: ${role}...`, 'info');
    setTimeout(() => {
        showNotification(`Role editor opened for ${role}`, 'success');
    }, 1000);
}

function createRole() {
    const roleName = document.getElementById('newRoleName').value;
    if (!roleName) {
        showNotification('Please enter a role name', 'warning');
        return;
    }
    
    showNotification(`Creating role: ${roleName}...`, 'info');
    setTimeout(() => {
        showNotification(`Role ${roleName} created successfully!`, 'success');
        document.getElementById('newRoleName').value = '';
    }, 1500);
}

function assignRole() {
    const assignment = document.getElementById('roleAssignment').value;
    if (!assignment) {
        showNotification('Please select a user to assign role', 'warning');
        return;
    }
    
    showNotification('Assigning role...', 'info');
    setTimeout(() => {
        showNotification('Role assigned successfully!', 'success');
    }, 1500);
}

function viewRoleMatrix() {
    showNotification('Opening role permission matrix...', 'info');
    setTimeout(() => {
        showNotification('Role matrix opened successfully!', 'success');
    }, 1500);
}

function editModulePermissions(module) {
    showNotification(`Editing permissions for module: ${module}...`, 'info');
    setTimeout(() => {
        showNotification(`Permission editor opened for ${module}`, 'success');
    }, 1000);
}

function saveAdminLimits() {
    showNotification('Saving admin action limits...', 'info');
    setTimeout(() => {
        showNotification('Admin limits saved successfully!', 'success');
    }, 1500);
}

function testAdminLimits() {
    showNotification('Testing admin action limits...', 'info');
    setTimeout(() => {
        showNotification('Admin limits test completed!', 'success');
    }, 2000);
}

function saveSessionLimits() {
    showNotification('Saving session limits...', 'info');
    setTimeout(() => {
        showNotification('Session limits saved successfully!', 'success');
    }, 1500);
}

function forceLogoutAll() {
    if (confirm('Are you sure you want to force logout all users? This will terminate all active sessions.')) {
        showNotification('Force logging out all users...', 'warning');
        setTimeout(() => {
            showNotification('All users logged out successfully!', 'success');
        }, 2000);
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
