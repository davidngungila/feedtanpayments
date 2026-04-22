@extends('layouts.app')

@section('title', 'Account Settings - FeedTan Pay')
@section('description', 'Manage your account settings, profile, and preferences')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
@endpush

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
                                    Account Settings
                                </h4>
                                <p class="text-muted mb-0">Manage your profile, preferences, and account settings</p>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-outline-success" onclick="exportAccountData()">
                                    <i class="bx bx-download me-2"></i>Export Data
                                </button>
                                <button type="button" class="btn btn-outline-secondary" onclick="refreshAccountSettings()">
                                    <i class="bx bx-refresh me-2"></i>Refresh
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="row">
            <div class="col-12">
                <div class="nav-align-top mb-6">
                    <ul class="nav nav-pills flex-column flex-md-row mb-6 gap-md-0 gap-2">
                        <li class="nav-item">
                            <a class="nav-link active" href="javascript:void(0);" onclick="showTab('profile')">
                                <i class="bx bx-user me-2"></i> Profile
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" onclick="showTab('preferences')">
                                <i class="bx bx-cog me-2"></i> Preferences
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" onclick="showTab('security')">
                                <i class="bx bx-shield me-2"></i> Security
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" onclick="showTab('notifications')">
                                <i class="bx bx-bell me-2"></i> Notifications
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" onclick="showTab('connections')">
                                <i class="bx bx-link-alt me-2"></i> Connections
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Profile Tab -->
        <div id="profileTab" class="tab-content">
            <div class="card mb-6">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="bx bx-user me-2"></i>
                        Profile Information
                    </h5>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="editProfile()">
                            <i class="bx bx-edit me-1"></i>Edit Profile
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-start align-items-sm-center gap-6 pb-4 border-bottom">
                        <div class="position-relative">
                            <img
                                src="{{ asset('assets/img/avatars/1.png') }}"
                                alt="user-avatar"
                                class="d-block w-px-100 h-px-100 rounded"
                                id="uploadedAvatar" />
                            <div class="position-absolute bottom-0 end-0">
                                <button type="button" class="btn btn-icon btn-primary rounded-circle" onclick="changeAvatar()">
                                    <i class="bx bx-camera"></i>
                                </button>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h4 class="mb-2">{{ Auth::user()->name ?? 'John Doe' }}</h4>
                            <p class="text-muted mb-0">{{ Auth::user()->email ?? 'john.doe@example.com' }}</p>
                            <div class="mt-2">
                                <span class="badge bg-success">Active</span>
                                <span class="badge bg-info">{{ Auth::user()->role ?? 'Member' }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row g-6 mt-4">
                        <div class="col-md-6">
                            <label class="form-label text-muted">First Name</label>
                            <div class="fw-bold">{{ Auth::user()->name ?? 'John' }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">Last Name</label>
                            <div class="fw-bold">Doe</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">Email</label>
                            <div class="fw-bold">{{ Auth::user()->email ?? 'john.doe@example.com' }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">Phone</label>
                            <div class="fw-bold">+255 712 345 678</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">Organization</label>
                            <div class="fw-bold">FeedTan Pay</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">Member Since</label>
                            <div class="fw-bold">January 15, 2024</div>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label text-muted">Address</label>
                            <div class="fw-bold">123 Main Street, Dar es Salaam, Tanzania</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Preferences Tab -->
        <div id="preferencesTab" class="tab-content" style="display: none;">
            <div class="card mb-6">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="bx bx-cog me-2"></i>
                        User Preferences
                    </h5>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="editPreferences()">
                            <i class="bx bx-edit me-1"></i>Edit Preferences
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h6 class="mb-3">Display Settings</h6>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span>Language</span>
                                    <span class="badge bg-info">English</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span>Timezone</span>
                                    <span class="badge bg-info">Africa/Dar es Salaam</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span>Currency</span>
                                    <span class="badge bg-info">TZS</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span>Date Format</span>
                                    <span class="badge bg-info">DD/MM/YYYY</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>Theme</span>
                                    <span class="badge bg-info">Light</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h6 class="mb-3">Interface Settings</h6>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span>Dashboard Layout</span>
                                    <span class="badge bg-info">Default</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span>Items Per Page</span>
                                    <span class="badge bg-info">25</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span>Show Tooltips</span>
                                    <span class="badge bg-success">Enabled</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span>Enable Animations</span>
                                    <span class="badge bg-success">Enabled</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>Auto-save Forms</span>
                                    <span class="badge bg-success">Enabled</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Security Tab -->
        <div id="securityTab" class="tab-content" style="display: none;">
            <div class="card mb-6">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="bx bx-shield me-2"></i>
                        Security Settings
                    </h5>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="editSecurity()">
                            <i class="bx bx-edit me-1"></i>Edit Security
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h6 class="mb-3">Password & Authentication</h6>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span>Last Password Change</span>
                                    <span class="badge bg-info">30 days ago</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span>Two-Factor Authentication</span>
                                    <span class="badge bg-success">Enabled</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span>Login Alerts</span>
                                    <span class="badge bg-success">Enabled</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>Session Timeout</span>
                                    <span class="badge bg-info">30 minutes</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h6 class="mb-3">Device & Location</h6>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span>Trusted Devices</span>
                                    <span class="badge bg-info">3 devices</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span>Active Sessions</span>
                                    <span class="badge bg-warning">2 sessions</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span>Last Login</span>
                                    <span class="badge bg-info">2 hours ago</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>Login Location</span>
                                    <span class="badge bg-info">Dar es Salaam, TZ</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notifications Tab -->
        <div id="notificationsTab" class="tab-content" style="display: none;">
            <div class="card mb-6">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="bx bx-bell me-2"></i>
                        Notification Preferences
                    </h5>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="editNotifications()">
                            <i class="bx bx-edit me-1"></i>Edit Notifications
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h6 class="mb-3">Email Notifications</h6>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span>Transaction Updates</span>
                                    <span class="badge bg-success">Enabled</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span>Security Alerts</span>
                                    <span class="badge bg-success">Enabled</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span>Marketing Emails</span>
                                    <span class="badge bg-secondary">Disabled</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>Bill Reminders</span>
                                    <span class="badge bg-success">Enabled</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h6 class="mb-3">SMS Notifications</h6>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span>Transaction Alerts</span>
                                    <span class="badge bg-success">Enabled</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span>Security Alerts</span>
                                    <span class="badge bg-success">Enabled</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span>Bill Reminders</span>
                                    <span class="badge bg-secondary">Disabled</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>System Updates</span>
                                    <span class="badge bg-secondary">Disabled</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Connections Tab -->
        <div id="connectionsTab" class="tab-content" style="display: none;">
            <div class="card mb-6">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="bx bx-link-alt me-2"></i>
                        Connected Accounts
                    </h5>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-sm btn-primary" onclick="addConnection()">
                            <i class="bx bx-plus me-1"></i>Add Connection
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h6 class="mb-3">Social Accounts</h6>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="d-flex align-items-center">
                                        <i class="bx bxl-google text-danger me-2"></i>
                                        <span>Google</span>
                                    </div>
                                    <span class="badge bg-success">Connected</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="d-flex align-items-center">
                                        <i class="bx bxl-facebook text-primary me-2"></i>
                                        <span>Facebook</span>
                                    </div>
                                    <span class="badge bg-secondary">Not Connected</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i class="bx bxl-linkedin text-info me-2"></i>
                                        <span>LinkedIn</span>
                                    </div>
                                    <span class="badge bg-secondary">Not Connected</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h6 class="mb-3">Payment Methods</h6>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-credit-card text-success me-2"></i>
                                        <span>Visa ****1234</span>
                                    </div>
                                    <span class="badge bg-success">Connected</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-mobile-alt text-warning me-2"></i>
                                        <span>M-Pesa</span>
                                    </div>
                                    <span class="badge bg-success">Connected</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-wallet text-info me-2"></i>
                                        <span>Bank Account</span>
                                    </div>
                                    <span class="badge bg-secondary">Not Connected</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Account Management -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-download me-2"></i>
                            Data Management
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="button" class="btn btn-outline-info" onclick="exportAccountData()">
                                <i class="bx bx-download me-2"></i>Export Account Data
                            </button>
                            <button type="button" class="btn btn-outline-warning" onclick="downloadActivityLog()">
                                <i class="bx bx-history me-2"></i>Download Activity Log
                            </button>
                            <button type="button" class="btn btn-outline-secondary" onclick="requestDataReport()">
                                <i class="bx bx-file me-2"></i>Request Data Report
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-x-circle me-2"></i>
                            Account Actions
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="alert alert-warning">
                                <h6 class="alert-heading mb-1">Danger Zone</h6>
                                <p class="mb-0">These actions are irreversible. Please be careful.</p>
                            </div>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="button" class="btn btn-outline-warning" onclick="deactivateAccount()">
                                <i class="bx bx-pause me-2"></i>Deactivate Account
                            </button>
                            <button type="button" class="btn btn-outline-danger" onclick="deleteAccount()">
                                <i class="bx bx-trash me-2"></i>Delete Account
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editProfileModalLabel">
                    <i class="bx bx-user me-2"></i>
                    Edit Profile
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editProfileForm">
                    <div class="row g-6">
                        <div class="col-md-6">
                            <label for="editFirstName" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="editFirstName" value="{{ Auth::user()->name ?? 'John' }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="editLastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="editLastName" value="Doe" required>
                        </div>
                        <div class="col-md-6">
                            <label for="editEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="editEmail" value="{{ Auth::user()->email ?? 'john.doe@example.com' }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="editPhone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="editPhone" value="+255 712 345 678">
                        </div>
                        <div class="col-md-6">
                            <label for="editOrganization" class="form-label">Organization</label>
                            <input type="text" class="form-control" id="editOrganization" value="FeedTan Pay">
                        </div>
                        <div class="col-md-6">
                            <label for="editAddress" class="form-label">Address</label>
                            <input type="text" class="form-control" id="editAddress" value="123 Main Street">
                        </div>
                        <div class="col-md-6">
                            <label for="editCity" class="form-label">City</label>
                            <input type="text" class="form-control" id="editCity" value="Dar es Salaam">
                        </div>
                        <div class="col-md-6">
                            <label for="editCountry" class="form-label">Country</label>
                            <select class="form-select" id="editCountry">
                                <option value="Tanzania" selected>Tanzania</option>
                                <option value="Kenya">Kenya</option>
                                <option value="Uganda">Uganda</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x me-2"></i>Cancel
                </button>
                <button type="button" class="btn btn-primary" onclick="saveProfile()">
                    <i class="bx bx-save me-2"></i>Save Changes
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Preferences Modal -->
<div class="modal fade" id="editPreferencesModal" tabindex="-1" aria-labelledby="editPreferencesModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editPreferencesModalLabel">
                    <i class="bx bx-cog me-2"></i>
                    Edit Preferences
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editPreferencesForm">
                    <div class="mb-3">
                        <label for="prefLanguage" class="form-label">Language</label>
                        <select class="form-select" id="prefLanguage">
                            <option value="en" selected>English</option>
                            <option value="sw">Swahili</option>
                            <option value="fr">French</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="prefTimezone" class="form-label">Timezone</label>
                        <select class="form-select" id="prefTimezone">
                            <option value="Africa/Dar_es_Salaam" selected>Africa/Dar es Salaam</option>
                            <option value="Africa/Nairobi">Africa/Nairobi</option>
                            <option value="Africa/Kampala">Africa/Kampala</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="prefCurrency" class="form-label">Currency</label>
                        <select class="form-select" id="prefCurrency">
                            <option value="TZS" selected>TZS - Tanzanian Shilling</option>
                            <option value="KES">KES - Kenyan Shilling</option>
                            <option value="UGX">UGX - Ugandan Shilling</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="prefTheme" class="form-label">Theme</label>
                        <select class="form-select" id="prefTheme">
                            <option value="light" selected>Light</option>
                            <option value="dark">Dark</option>
                            <option value="auto">Auto</option>
                        </select>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="prefTooltips" checked>
                        <label class="form-check-label" for="prefTooltips">Show Tooltips</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x me-2"></i>Cancel
                </button>
                <button type="button" class="btn btn-primary" onclick="savePreferences()">
                    <i class="bx bx-save me-2"></i>Save Changes
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Select2
    $('.select2').select2({
        theme: 'bootstrap-5'
    });
});

function showTab(tabName) {
    // Hide all tabs
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.style.display = 'none';
    });
    
    // Remove active class from all nav links
    document.querySelectorAll('.nav-link').forEach(link => {
        link.classList.remove('active');
    });
    
    // Show selected tab
    document.getElementById(tabName + 'Tab').style.display = 'block';
    
    // Add active class to clicked nav link
    event.target.classList.add('active');
}

function refreshAccountSettings() {
    showNotification('Refreshing account settings...', 'info');
    setTimeout(() => {
        location.reload();
    }, 1000);
}

function exportAccountData() {
    showNotification('Exporting account data...', 'info');
    setTimeout(() => {
        showNotification('Account data exported successfully!', 'success');
    }, 1500);
}

function editProfile() {
    const modal = new bootstrap.Modal(document.getElementById('editProfileModal'));
    modal.show();
}

function saveProfile() {
    showNotification('Saving profile...', 'info');
    setTimeout(() => {
        showNotification('Profile saved successfully!', 'success');
        bootstrap.Modal.getInstance(document.getElementById('editProfileModal')).hide();
        location.reload();
    }, 1500);
}

function editPreferences() {
    const modal = new bootstrap.Modal(document.getElementById('editPreferencesModal'));
    modal.show();
}

function savePreferences() {
    showNotification('Saving preferences...', 'info');
    setTimeout(() => {
        showNotification('Preferences saved successfully!', 'success');
        bootstrap.Modal.getInstance(document.getElementById('editPreferencesModal')).hide();
    }, 1500);
}

function editSecurity() {
    showNotification('Opening security settings...', 'info');
    setTimeout(() => {
        showNotification('Security settings opened!', 'success');
    }, 1000);
}

function editNotifications() {
    showNotification('Opening notification settings...', 'info');
    setTimeout(() => {
        showNotification('Notification settings opened!', 'success');
    }, 1000);
}

function addConnection() {
    showNotification('Opening connection wizard...', 'info');
    setTimeout(() => {
        showNotification('Connection wizard opened!', 'success');
    }, 1000);
}

function changeAvatar() {
    showNotification('Opening avatar upload...', 'info');
    setTimeout(() => {
        showNotification('Avatar upload opened!', 'success');
    }, 1000);
}

function downloadActivityLog() {
    showNotification('Downloading activity log...', 'info');
    setTimeout(() => {
        showNotification('Activity log downloaded successfully!', 'success');
    }, 1500);
}

function requestDataReport() {
    showNotification('Requesting data report...', 'info');
    setTimeout(() => {
        showNotification('Data report request submitted!', 'success');
    }, 1500);
}

function deactivateAccount() {
    if (confirm('Are you sure you want to deactivate your account? You can reactivate it later.')) {
        showNotification('Deactivating account...', 'warning');
        setTimeout(() => {
            showNotification('Account deactivated successfully!', 'success');
        }, 2000);
    }
}

function deleteAccount() {
    if (confirm('Are you absolutely sure you want to delete your account? This action cannot be undone.')) {
        if (confirm('This is your final warning. All your data will be permanently deleted.')) {
            showNotification('Deleting account...', 'danger');
            setTimeout(() => {
                showNotification('Account deleted successfully!', 'success');
                // Redirect to login page
                window.location.href = '/login';
            }, 2000);
        }
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
