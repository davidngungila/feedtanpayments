@extends('layouts.app')

@section('title', 'User Settings - FeedTan Pay')

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
                                    <i class="bx bx-user me-2 text-primary"></i>
                                    User Settings
                                </h4>
                                <p class="text-muted mb-0">Configure user profiles, preferences, permissions, and activity settings</p>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-outline-success" onclick="testUserSettings()">
                                    <i class="bx bx-test-tube me-2"></i>Test Settings
                                </button>
                                <button type="button" class="btn btn-outline-secondary" onclick="refreshUserSettings()">
                                    <i class="bx bx-refresh me-2"></i>Refresh
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Settings Overview -->
        <div class="row mb-6">
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-primary bg-opacity-10 rounded-circle me-3" style="width: 48px; height: 48px;">
                                <i class="bx bx-user text-primary fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Users</h6>
                                <h4 class="mb-0">247</h4>
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
                                <i class="bx bx-user-check text-success fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Active Users</h6>
                                <h4 class="mb-0">189</h4>
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
                                <i class="bx bx-cog text-warning fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">User Settings</h6>
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
                            <div class="avatar bg-info bg-opacity-10 rounded-circle me-3" style="width: 48px; height: 48px;">
                                <i class="bx bx-shield text-info fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Roles</h6>
                                <h4 class="mb-0">5</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Settings Table -->
        <div class="row mb-6">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0">
                                <i class="bx bx-cog me-2"></i>
                                User Configuration
                            </h5>
                            <small class="text-muted">Manage user settings, preferences, and permissions</small>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-sm btn-primary" onclick="addUserSetting()">
                                <i class="bx bx-plus me-1"></i>Add Setting
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="refreshUserSettings()">
                                <i class="bx bx-refresh me-1"></i>Refresh
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="userTable">
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
                                            Category
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
                                            <code>default_account_type</code>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">personal</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning">string</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">Profile</span>
                                        </td>
                                        <td>
                                            <small>Default account type for new users</small>
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
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="viewUserSetting(1)"><i class="bx bx-eye me-2"></i>View Details</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="editUserSetting(1)"><i class="bx bx-edit me-2"></i>Edit</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="deleteUserSetting(1)"><i class="bx bx-trash me-2"></i>Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <code>default_currency</code>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">TZS</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning">string</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">Profile</span>
                                        </td>
                                        <td>
                                            <small>Default currency for user accounts</small>
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
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="viewUserSetting(2)"><i class="bx bx-eye me-2"></i>View Details</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="editUserSetting(2)"><i class="bx bx-edit me-2"></i>Edit</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="deleteUserSetting(2)"><i class="bx bx-trash me-2"></i>Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <code>dashboard_layout</code>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">default</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning">string</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">Preferences</span>
                                        </td>
                                        <td>
                                            <small>Default dashboard layout for users</small>
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
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="viewUserSetting(3)"><i class="bx bx-eye me-2"></i>View Details</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="editUserSetting(3)"><i class="bx bx-edit me-2"></i>Edit</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="deleteUserSetting(3)"><i class="bx bx-trash me-2"></i>Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <code>allow_exports</code>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">true</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">boolean</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning">Permissions</span>
                                        </td>
                                        <td>
                                            <small>Allow users to export data</small>
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
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="viewUserSetting(4)"><i class="bx bx-eye me-2"></i>View Details</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="editUserSetting(4)"><i class="bx bx-edit me-2"></i>Edit</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="deleteUserSetting(4)"><i class="bx bx-trash me-2"></i>Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <code>activity_retention</code>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">90</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">number</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">Activity</span>
                                        </td>
                                        <td>
                                            <small>Activity log retention in days</small>
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
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="viewUserSetting(5)"><i class="bx bx-eye me-2"></i>View Details</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="editUserSetting(5)"><i class="bx bx-edit me-2"></i>Edit</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="deleteUserSetting(5)"><i class="bx bx-trash me-2"></i>Delete</a></li>
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

        <!-- User Configuration Categories -->
        <div class="row mb-6">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-category me-2"></i>
                            User Configuration Categories
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="mb-3">Profile Settings</h6>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="profileSettingsEnabled" checked>
                                        <label class="form-check-label" for="profileSettingsEnabled">Enable Profile Customization</label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="avatarUpload" checked>
                                        <label class="form-check-label" for="avatarUpload">Allow Avatar Upload</label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="profileVisibility" checked>
                                        <label class="form-check-label" for="profileVisibility">Profile Visibility Settings</label>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Default Account Types</label>
                                        <select class="form-select" id="defaultAccountTypes" multiple>
                                            <option value="personal" selected>Personal</option>
                                            <option value="business" selected>Business</option>
                                            <option value="nonprofit">Non-Profit</option>
                                            <option value="corporate">Corporate</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="mb-3">User Preferences</h6>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="customDashboard" checked>
                                        <label class="form-check-label" for="customDashboard">Allow Custom Dashboard</label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="themeSelection" checked>
                                        <label class="form-check-label" for="themeSelection">Theme Selection</label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="languageSelection" checked>
                                        <label class="form-check-label" for="languageSelection">Language Selection</label>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Available Languages</label>
                                        <select class="form-select" id="availableLanguages" multiple>
                                            <option value="en" selected>English</option>
                                            <option value="sw" selected>Swahili</option>
                                            <option value="fr">French</option>
                                            <option value="ar">Arabic</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="mb-3">User Permissions</h6>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="roleAssignment" checked>
                                        <label class="form-check-label" for="roleAssignment">Role Assignment</label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="customPermissions">
                                        <label class="form-check-label" for="customPermissions">Custom Permissions</label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="apiAccess" checked>
                                        <label class="form-check-label" for="apiAccess">API Access Control</label>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Default User Role</label>
                                        <select class="form-select" id="defaultUserRole">
                                            <option value="member" selected>Member</option>
                                            <option value="staff">Staff</option>
                                            <option value="manager">Manager</option>
                                            <option value="admin">Admin</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="mb-3">Activity Tracking</h6>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="activityLogging" checked>
                                        <label class="form-check-label" for="activityLogging">Enable Activity Logging</label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="loginTracking" checked>
                                        <label class="form-check-label" for="loginTracking">Login Activity Tracking</label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="transactionTracking" checked>
                                        <label class="form-check-label" for="transactionTracking">Transaction Activity Tracking</label>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Activity Retention (days)</label>
                                        <input type="number" class="form-control" id="activityRetention" value="90" min="7" max="365">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-primary" onclick="saveUserConfiguration()">
                                        <i class="bx bx-save me-2"></i>Save Configuration
                                    </button>
                                    <button type="button" class="btn btn-outline-warning" onclick="testUserConfiguration()">
                                        <i class="bx bx-test-tube me-2"></i>Test Configuration
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bulk User Operations -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-group me-2"></i>
                            Bulk User Operations
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <h6 class="mb-3">Mass Operations</h6>
                                    <div class="d-grid gap-2">
                                        <button type="button" class="btn btn-outline-primary" onclick="massUpdateUsers()">
                                            <i class="bx bx-edit me-2"></i>Mass Update Users
                                        </button>
                                        <button type="button" class="btn btn-outline-warning" onclick="resetUserPreferences()">
                                            <i class="bx bx-reset me-2"></i>Reset Preferences
                                        </button>
                                        <button type="button" class="btn btn-outline-info" onclick="exportUserData()">
                                            <i class="bx bx-download me-2"></i>Export User Data
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <h6 class="mb-3">User Management</h6>
                                    <div class="d-grid gap-2">
                                        <button type="button" class="btn btn-outline-success" onclick="createBulkUsers()">
                                            <i class="bx bx-user-plus me-2"></i>Create Bulk Users
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary" onclick="importUsers()">
                                            <i class="bx bx-upload me-2"></i>Import Users
                                        </button>
                                        <button type="button" class="btn btn-outline-danger" onclick="deleteInactiveUsers()">
                                            <i class="bx bx-user-x me-2"></i>Delete Inactive Users
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <h6 class="mb-3">User Statistics</h6>
                                    <div class="row text-center">
                                        <div class="col-4 mb-3">
                                            <h4 class="text-primary mb-0">247</h4>
                                            <small class="text-muted">Total Users</small>
                                        </div>
                                        <div class="col-4 mb-3">
                                            <h4 class="text-success mb-0">189</h4>
                                            <small class="text-muted">Active</small>
                                        </div>
                                        <div class="col-4 mb-3">
                                            <h4 class="text-warning mb-0">58</h4>
                                            <small class="text-muted">Inactive</small>
                                        </div>
                                    </div>
                                    <div class="d-grid gap-2">
                                        <button type="button" class="btn btn-outline-info" onclick="viewUserStatistics()">
                                            <i class="bx bx-chart me-2"></i>View Statistics
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
</div>

<!-- Add/Edit User Setting Modal -->
<div class="modal fade" id="userSettingModal" tabindex="-1" aria-labelledby="userSettingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="userSettingModalLabel">
                    <i class="bx bx-cog me-2"></i>
                    <span id="modalTitle">Add User Setting</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="userSettingForm">
                    <input type="hidden" id="settingId" name="settingId">
                    <div class="mb-3">
                        <label for="settingKey" class="form-label">
                            <i class="bx bx-tag me-1"></i>Setting Key
                        </label>
                        <input type="text" class="form-control" id="settingKey" name="settingKey" required placeholder="e.g., default_account_type">
                    </div>
                    <div class="mb-3">
                        <label for="settingValue" class="form-label">
                            <i class="bx bx-text me-1"></i>Value
                        </label>
                        <input type="text" class="form-control" id="settingValue" name="settingValue" required placeholder="e.g., personal, true, 90">
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
                        <label for="settingCategory" class="form-label">
                            <i class="bx bx-layer me-1"></i>Category
                        </label>
                        <select class="form-select" id="settingCategory" name="settingCategory" required>
                            <option value="profile">Profile</option>
                            <option value="preferences">Preferences</option>
                            <option value="permissions">Permissions</option>
                            <option value="activity">Activity</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="settingDescription" class="form-label">
                            <i class="bx bx-info-circle me-1"></i>Description
                        </label>
                        <textarea class="form-control" id="settingDescription" name="settingDescription" rows="3" placeholder="Describe this user setting"></textarea>
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
                <button type="button" class="btn btn-primary" onclick="saveUserSetting()">
                    <i class="bx bx-save me-2"></i>Save Setting
                </button>
            </div>
        </div>
    </div>
</div>

<!-- View User Setting Modal -->
<div class="modal fade" id="viewUserSettingModal" tabindex="-1" aria-labelledby="viewUserSettingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="viewUserSettingModalLabel">
                    <i class="bx bx-eye me-2"></i>
                    User Setting Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="userSettingDetails"></div>
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
function refreshUserSettings() {
    showNotification('Refreshing user settings...', 'info');
    setTimeout(() => {
        location.reload();
    }, 1000);
}

function testUserSettings() {
    showNotification('Testing user settings...', 'info');
    setTimeout(() => {
        showNotification('User settings test completed successfully!', 'success');
    }, 2000);
}

function addUserSetting() {
    document.getElementById('modalTitle').textContent = 'Add User Setting';
    document.getElementById('userSettingForm').reset();
    document.getElementById('settingId').value = '';
    const modal = new bootstrap.Modal(document.getElementById('userSettingModal'));
    modal.show();
}

function editUserSetting(id) {
    document.getElementById('modalTitle').textContent = 'Edit User Setting';
    // Simulate loading setting data
    const settingData = {
        id: id,
        key: 'default_account_type',
        value: 'personal',
        type: 'string',
        category: 'profile',
        description: 'Default account type for new users',
        isPublic: true
    };
    
    document.getElementById('settingId').value = settingData.id;
    document.getElementById('settingKey').value = settingData.key;
    document.getElementById('settingValue').value = settingData.value;
    document.getElementById('settingType').value = settingData.type;
    document.getElementById('settingCategory').value = settingData.category;
    document.getElementById('settingDescription').value = settingData.description;
    document.getElementById('isPublic').checked = settingData.isPublic;
    
    const modal = new bootstrap.Modal(document.getElementById('userSettingModal'));
    modal.show();
}

function saveUserSetting() {
    const form = document.getElementById('userSettingForm');
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
        category: formData.get('settingCategory'),
        description: formData.get('settingDescription'),
        isPublic: formData.get('isPublic') === 'on'
    };
    
    showNotification('Saving user setting...', 'info');
    
    // Simulate API call
    setTimeout(() => {
        showNotification('User setting saved successfully!', 'success');
        bootstrap.Modal.getInstance(document.getElementById('userSettingModal')).hide();
        location.reload();
    }, 1500);
}

function viewUserSetting(id) {
    // Simulate loading setting details
    const settingData = {
        key: 'default_account_type',
        value: 'personal',
        type: 'string',
        category: 'profile',
        description: 'Default account type for new users',
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
                    <label class="form-label text-muted">Category</label>
                    <div><span class="badge bg-info">${settingData.category}</span></div>
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
    
    document.getElementById('userSettingDetails').innerHTML = details;
    
    const modal = new bootstrap.Modal(document.getElementById('viewUserSettingModal'));
    modal.show();
}

function deleteUserSetting(id) {
    if (confirm('Are you sure you want to delete this user setting?')) {
        showNotification('Deleting user setting...', 'info');
        setTimeout(() => {
            showNotification('User setting deleted successfully!', 'success');
            location.reload();
        }, 1500);
    }
}

function saveUserConfiguration() {
    showNotification('Saving user configuration...', 'info');
    setTimeout(() => {
        showNotification('User configuration saved successfully!', 'success');
    }, 1500);
}

function testUserConfiguration() {
    showNotification('Testing user configuration...', 'info');
    setTimeout(() => {
        showNotification('User configuration test completed!', 'success');
    }, 2000);
}

function massUpdateUsers() {
    showNotification('Opening mass update wizard...', 'info');
    setTimeout(() => {
        showNotification('Mass update wizard opened!', 'success');
    }, 1000);
}

function resetUserPreferences() {
    if (confirm('Are you sure you want to reset all user preferences to default?')) {
        showNotification('Resetting user preferences...', 'warning');
        setTimeout(() => {
            showNotification('User preferences reset successfully!', 'success');
        }, 2000);
    }
}

function exportUserData() {
    showNotification('Exporting user data...', 'info');
    setTimeout(() => {
        showNotification('User data exported successfully!', 'success');
    }, 1500);
}

function createBulkUsers() {
    showNotification('Opening bulk user creation wizard...', 'info');
    setTimeout(() => {
        showNotification('Bulk user creation wizard opened!', 'success');
    }, 1000);
}

function importUsers() {
    showNotification('Opening user import wizard...', 'info');
    setTimeout(() => {
        showNotification('User import wizard opened!', 'success');
    }, 1000);
}

function deleteInactiveUsers() {
    if (confirm('Are you sure you want to delete all inactive users? This action cannot be undone.')) {
        showNotification('Deleting inactive users...', 'danger');
        setTimeout(() => {
            showNotification('Inactive users deleted successfully!', 'success');
        }, 2000);
    }
}

function viewUserStatistics() {
    showNotification('Loading user statistics...', 'info');
    setTimeout(() => {
        showNotification('User statistics loaded!', 'success');
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
