@extends('layouts.app')

@section('title', 'General Settings - FeedTan Pay')

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">General Settings</h4>
        <div class="row">
            <!-- System Configuration -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">System Configuration</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">System Name</label>
                            <input type="text" class="form-control" value="FeedTan Pay" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">System Version</label>
                            <input type="text" class="form-control" value="v1.0.0" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">System Timezone</label>
                            <select class="form-select">
                                <option value="America/New_York" selected>America/New_York (TZS)</option>
                                <option value="Europe/London">Europe/London</option>
                                <option value="Asia/Tokyo">Asia/Tokyo</option>
                                <option value="Australia/Sydney">Australia/Sydney</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Default Currency</label>
                            <select class="form-select">
                                <option value="USD" selected>USD - US Dollar</option>
                                <option value="EUR">EUR - Euro</option>
                                <option value="GBP">GBP - British Pound</option>
                                <option value="JPY">JPY - Japanese Yen</option>
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
                    </div>
                </div>
            </div>

            <!-- Application Settings -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Application Settings</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Default Language</label>
                            <select class="form-select">
                                <option value="en" selected>English</option>
                                <option value="es">Spanish</option>
                                <option value="fr">French</option>
                                <option value="de">German</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Theme</label>
                            <select class="form-select">
                                <option value="light" selected>Light</option>
                                <option value="dark">Dark</option>
                                <option value="auto">Auto</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Items Per Page</label>
                            <select class="form-select">
                                <option value="10" selected>10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="enableNotifications" checked>
                                <label class="form-check-label" for="enableNotifications">Enable Desktop Notifications</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="enableSounds" checked>
                                <label class="form-check-label" for="enableSounds">Enable Sound Effects</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Security Settings -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Security Settings</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Session Timeout (minutes)</label>
                            <input type="number" class="form-control" value="30" min="5" max="120">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password Policy</label>
                            <select class="form-select">
                                <option value="medium" selected>Medium (8+ chars, 1 uppercase, 1 number)</option>
                                <option value="strong">Strong (12+ chars, 2 uppercase, 2 numbers, 1 special)</option>
                                <option value="weak">Weak (6+ chars)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="require2FA" checked>
                                <label class="form-check-label" for="require2FA">Require Two-Factor Authentication</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="loginAlerts" checked>
                                <label class="form-check-label" for="loginAlerts">Send Login Alerts</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Backup & Maintenance -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Backup & Maintenance</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Auto Backup Frequency</label>
                            <select class="form-select">
                                <option value="daily" selected>Daily</option>
                                <option value="weekly">Weekly</option>
                                <option value="monthly">Monthly</option>
                                <option value="disabled">Disabled</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Backup Retention Period</label>
                            <select class="form-select">
                                <option value="7" selected>7 Days</option>
                                <option value="30">30 Days</option>
                                <option value="90">90 Days</option>
                                <option value="365">1 Year</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="maintenanceMode">
                                <label class="form-check-label" for="maintenanceMode">Enable Maintenance Mode</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Maintenance Message</label>
                            <textarea class="form-control" rows="3" placeholder="System is currently under maintenance..."></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Save Button -->
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <button type="button" class="btn btn-primary me-2">Save Settings</button>
                        <button type="button" class="btn btn-outline-secondary">Reset to Default</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
