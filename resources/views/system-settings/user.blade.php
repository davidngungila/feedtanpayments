@extends('layouts.app')

@section('title', 'User Settings - FeedTan Pay')

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">User Settings</h4>
        <div class="row">
            <!-- User Profile Settings -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">User Profile Settings</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Default Account Type</label>
                            <select class="form-select">
                                <option value="personal" selected>Personal Account</option>
                                <option value="business">Business Account</option>
                                <option value="nonprofit">Non-Profit Account</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Default Payment Method</label>
                            <select class="form-select">
                                <option value="wallet" selected>Wallet</option>
                                <option value="card">Credit Card</option>
                                <option value="bank">Bank Transfer</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Default Currency</label>
                            <select class="form-select">
                                <option value="USD" selected>USD - US Dollar</option>
                                <option value="EUR">EUR - Euro</option>
                                <option value="GBP">GBP - British Pound</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Language Preference</label>
                            <select class="form-select">
                                <option value="en" selected>English</option>
                                <option value="es">Spanish</option>
                                <option value="fr">French</option>
                                <option value="de">German</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Timezone</label>
                            <select class="form-select">
                                <option value="America/New_York" selected>America/New_York</option>
                                <option value="Europe/London">Europe/London</option>
                                <option value="Asia/Tokyo">Asia/Tokyo</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Preferences -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">User Preferences</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Dashboard Layout</label>
                            <select class="form-select">
                                <option value="default" selected>Default Layout</option>
                                <option value="compact">Compact Layout</option>
                                <option value="detailed">Detailed Layout</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Items Per Page</label>
                            <select class="form-select">
                                <option value="10" selected>10 items</option>
                                <option value="25">25 items</option>
                                <option value="50">50 items</option>
                                <option value="100">100 items</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Date Format</label>
                            <select class="form-select">
                                <option value="MM/DD/YYYY" selected>MM/DD/YYYY</option>
                                <option value="DD/MM/YYYY">DD/MM/YYYY</option>
                                <option value="YYYY-MM-DD">YYYY-MM-DD</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="showTooltips" checked>
                                <label class="form-check-label" for="showTooltips">Show Tooltips</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="enableAnimations" checked>
                                <label class="form-check-label" for="enableAnimations">Enable Animations</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="autoSave" checked>
                                <label class="form-check-label" for="autoSave">Auto-save Forms</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Permissions -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">User Permissions</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Default User Role</label>
                            <select class="form-select">
                                <option value="user" selected>Standard User</option>
                                <option value="admin">Administrator</option>
                                <option value="moderator">Moderator</option>
                                <option value="viewer">Read-only User</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="allowExports" checked>
                                <label class="form-check-label" for="allowExports">Allow Data Exports</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="allowImports" checked>
                                <label class="form-check-label" for="allowImports">Allow Data Imports</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="allowApiAccess">
                                <label class="form-check-label" for="allowApiAccess">Allow API Access</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="allowThirdParty">
                                <label class="form-check-label" for="allowThirdParty">Allow Third-party Integrations</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Activity -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">User Activity</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Activity Log Retention</label>
                            <select class="form-select">
                                <option value="30" selected>30 Days</option>
                                <option value="60">60 Days</option>
                                <option value="90">90 Days</option>
                                <option value="365">1 Year</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="logLogins" checked>
                                <label class="form-check-label" for="logLogins">Log Login Activity</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="logTransactions" checked>
                                <label class="form-check-label" for="logTransactions">Log Transaction Activity</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="logProfileChanges" checked>
                                <label class="form-check-label" for="logProfileChanges">Log Profile Changes</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="sendActivityReports" checked>
                                <label class="form-check-label" for="sendActivityReports">Send Weekly Activity Reports</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Save Button -->
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <button type="button" class="btn btn-primary me-2">Save User Settings</button>
                        <button type="button" class="btn btn-outline-secondary">Reset to Default</button>
                        <button type="button" class="btn btn-outline-danger">Delete User Data</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
