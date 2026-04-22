@extends('layouts.app')

@section('title', 'Account Settings - FeedTan Pay')
@section('description', 'FeedTan Pay - Manage your account settings and preferences')

@section('content')
<div class="row">
    <div class="col-md-8">
        <!-- General Settings -->
        <div class="card mb-6">
            <div class="card-header">
                <h5 class="card-title mb-0">General Settings</h5>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" value="johndoe" readonly>
                </div>
                <div class="mb-4">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" value="john.doe@example.com">
                </div>
                <div class="mb-4">
                    <label for="language" class="form-label">Language</label>
                    <select class="form-select" id="language">
                        <option value="en" selected>English</option>
                        <option value="es">Español</option>
                        <option value="fr">Français</option>
                        <option value="de">Deutsch</option>
                        <option value="zh">中文</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="timezone" class="form-label">Timezone</label>
                    <select class="form-select" id="timezone">
                        <option value="UTC-8" selected>Pacific Time (PT)</option>
                        <option value="UTC-5">Eastern Time (ET)</option>
                        <option value="UTC-6">Central Time (CT)</option>
                        <option value="UTC-7">Mountain Time (MT)</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="currency" class="form-label">Currency</label>
                    <select class="form-select" id="currency">
                        <option value="USD" selected>USD - US Dollar</option>
                        <option value="EUR">EUR - Euro</option>
                        <option value="GBP">GBP - British Pound</option>
                        <option value="JPY">JPY - Japanese Yen</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="dateFormat" class="form-label">Date Format</label>
                    <select class="form-select" id="dateFormat">
                        <option value="MM/DD/YYYY" selected>MM/DD/YYYY</option>
                        <option value="DD/MM/YYYY">DD/MM/YYYY</option>
                        <option value="YYYY-MM-DD">YYYY-MM-DD</option>
                    </select>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-primary">Save Changes</button>
                    <button class="btn btn-outline-secondary">Cancel</button>
                </div>
            </div>
        </div>

        <!-- Privacy Settings -->
        <div class="card mb-6">
            <div class="card-header">
                <h5 class="card-title mb-0">Privacy Settings</h5>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="profileVisibility" checked>
                        <label class="form-check-label" for="profileVisibility">
                            <div>
                                <h6 class="mb-0">Profile Visibility</h6>
                                <small class="text-muted">Make your profile visible to other users</small>
                            </div>
                        </label>
                    </div>
                </div>
                <div class="mb-4">
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="showEmail" checked>
                        <label class="form-check-label" for="showEmail">
                            <div>
                                <h6 class="mb-0">Show Email</h6>
                                <small class="text-muted">Display email address on your profile</small>
                            </div>
                        </label>
                    </div>
                </div>
                <div class="mb-4">
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="showPhone">
                        <label class="form-check-label" for="showPhone">
                            <div>
                                <h6 class="mb-0">Show Phone</h6>
                                <small class="text-muted">Display phone number on your profile</small>
                            </div>
                        </label>
                    </div>
                </div>
                <div class="mb-4">
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="twoFactorAuth" checked>
                        <label class="form-check-label" for="twoFactorAuth">
                            <div>
                                <h6 class="mb-0">Two-Factor Authentication</h6>
                                <small class="text-muted">Add an extra layer of security</small>
                            </div>
                        </label>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-primary">Update Privacy</button>
                    <button class="btn btn-outline-secondary">Reset to Default</button>
                </div>
            </div>
        </div>

        <!-- Account Preferences -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Account Preferences</h5>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <label for="theme" class="form-label">Theme</label>
                    <select class="form-select" id="theme">
                        <option value="light" selected>Light</option>
                        <option value="dark">Dark</option>
                        <option value="auto">Auto</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="notifications" class="form-label">Email Notifications</label>
                    <select class="form-select" id="notifications">
                        <option value="all" selected>All Notifications</option>
                        <option value="important">Important Only</option>
                        <option value="none">None</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="autoLogout" class="form-label">Auto Logout</label>
                    <select class="form-select" id="autoLogout">
                        <option value="never">Never</option>
                        <option value="15" selected>15 minutes</option>
                        <option value="30">30 minutes</option>
                        <option value="60">1 hour</option>
                    </select>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-primary">Save Preferences</button>
                    <button class="btn btn-outline-warning">Export Data</button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Quick Stats -->
        <div class="card mb-6">
            <div class="card-header">
                <h5 class="card-title mb-0">Account Stats</h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <h3 class="mb-2">2 Years</h3>
                    <p class="text-muted">Account Age</p>
                </div>
                <div class="row text-center">
                    <div class="col-6">
                        <h5 class="mb-0 text-primary">1,247</h5>
                        <small class="text-muted">Total Transactions</small>
                    </div>
                    <div class="col-6">
                        <h5 class="mb-0 text-success">98.5%</h5>
                        <small class="text-muted">Success Rate</small>
                    </div>
                </div>
                <div class="progress" style="height: 8px;">
                    <div class="progress-bar bg-primary" style="width: 75%"></div>
                </div>
                <small class="text-muted">Profile Completion</small>
            </div>
        </div>

        <!-- Security Tips -->
        <div class="card mb-6">
            <div class="card-header">
                <h5 class="card-title mb-0">Security Tips</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info mb-3">
                    <i class="bx bx-info-circle me-2"></i>
                    <strong>Security Score:</strong> 85/100 - Good
                </div>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <i class="bx bx-check-circle text-success me-2"></i>
                        <span>Use a strong, unique password</span>
                    </li>
                    <li class="mb-2">
                        <i class="bx bx-check-circle text-success me-2"></i>
                        <span>Enable two-factor authentication</span>
                    </li>
                    <li class="mb-2">
                        <i class="bx bx-check-circle text-success me-2"></i>
                        <span>Regular security checkups</span>
                    </li>
                    <li class="mb-2">
                        <i class="bx bx-x-circle text-danger me-2"></i>
                        <span>Avoid public WiFi for transactions</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('profile') }}" class="btn btn-outline-primary">
                        <i class="bx bx-user me-2"></i>Edit Profile
                    </a>
                    <a href="{{ route('security') }}" class="btn btn-outline-success">
                        <i class="bx bx-shield me-2"></i>Security Settings
                    </a>
                    <a href="{{ route('account-settings.notifications') }}" class="btn btn-outline-info">
                        <i class="bx bx-bell me-2"></i>Notifications
                    </a>
                    <a href="{{ route('account-settings.connections') }}" class="btn btn-outline-warning">
                        <i class="bx bx-link me-2"></i>Connected Accounts
                    </a>
                    <button class="btn btn-outline-danger">
                        <i class="bx bx-download me-2"></i>Download Data
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
