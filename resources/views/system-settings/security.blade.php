@extends('layouts.app')

@section('title', 'Security Settings - FeedTan Pay')

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">Security Settings</h4>
        <div class="row">
            <!-- Password Policy -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Password Policy</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Minimum Password Length</label>
                            <input type="number" class="form-control" value="8" min="6" max="32">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password Complexity</label>
                            <select class="form-select">
                                <option value="medium" selected>Medium (1 uppercase, 1 lowercase, 1 number, 1 special)</option>
                                <option value="strong">Strong (2 uppercase, 2 lowercase, 2 numbers, 2 special)</option>
                                <option value="high">Very Strong (3 uppercase, 3 lowercase, 3 numbers, 3 special)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password Expiry (days)</label>
                            <input type="number" class="form-control" value="90" min="30" max="365">
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="preventReuse" checked>
                                <label class="form-check-label" for="preventReuse">Prevent Password Reuse (last 5 passwords)</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Two-Factor Authentication -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Two-Factor Authentication</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">2FA Requirement</label>
                            <select class="form-select">
                                <option value="optional" selected>Optional</option>
                                <option value="required">Required for all users</option>
                                <option value="admin">Required for admin users only</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">2FA Methods</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="2faSms" checked>
                                <label class="form-check-label" for="2faSms">SMS Authentication</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="2faEmail" checked>
                                <label class="form-check-label" for="2faEmail">Email Authentication</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="2faApp" checked>
                                <label class="form-check-label" for="2faApp">Authenticator App</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">2FA Code Validity (minutes)</label>
                            <input type="number" class="form-control" value="5" min="1" max="30">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Session Management -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Session Management</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Session Timeout (minutes)</label>
                            <input type="number" class="form-control" value="30" min="5" max="480">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Maximum Concurrent Sessions</label>
                            <input type="number" class="form-control" value="3" min="1" max="10">
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="rememberDevice" checked>
                                <label class="form-check-label" for="rememberDevice">Remember Trusted Devices</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="autoLogout" checked>
                                <label class="form-check-label" for="autoLogout">Auto-logout on suspicious activity</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- IP & Access Control -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">IP & Access Control</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">IP Whitelist</label>
                            <textarea class="form-control" rows="3" placeholder="Enter allowed IP addresses (one per line)"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">IP Blacklist</label>
                            <textarea class="form-control" rows="3" placeholder="Enter blocked IP addresses (one per line)"></textarea>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="geoBlocking">
                                <label class="form-check-label" for="geoBlocking">Enable Geographic Blocking</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Allowed Countries</label>
                            <select class="form-select" multiple>
                                <option value="US" selected>United States</option>
                                <option value="CA">Canada</option>
                                <option value="GB">United Kingdom</option>
                                <option value="AU">Australia</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Security Logs -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Security Logs</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Log Retention Period</label>
                            <select class="form-select">
                                <option value="30" selected>30 Days</option>
                                <option value="60">60 Days</option>
                                <option value="90">90 Days</option>
                                <option value="180">180 Days</option>
                                <option value="365">1 Year</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="logFailedAttempts" checked>
                                <label class="form-check-label" for="logFailedAttempts">Log Failed Login Attempts</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="logPasswordChanges" checked>
                                <label class="form-check-label" for="logPasswordChanges">Log Password Changes</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="log2faChanges" checked>
                                <label class="form-check-label" for="log2faChanges">Log 2FA Changes</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alert Threshold</label>
                            <select class="form-select">
                                <option value="3" selected>3 failed attempts</option>
                                <option value="5">5 failed attempts</option>
                                <option value="10">10 failed attempts</option>
                                <option value="disabled">Disabled</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Save Button -->
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <button type="button" class="btn btn-primary me-2">Save Security Settings</button>
                        <button type="button" class="btn btn-outline-secondary">View Security Logs</button>
                        <button type="button" class="btn btn-outline-danger">Force Password Reset</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
