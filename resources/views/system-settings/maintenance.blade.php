@extends('layouts.app')

@section('title', 'System Maintenance - FeedTan Pay')

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">System Maintenance</h4>
        <div class="row">
            <!-- Maintenance Mode -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Maintenance Mode</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="maintenanceMode">
                                <label class="form-check-label" for="maintenanceMode">Enable Maintenance Mode</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Maintenance Message</label>
                            <textarea class="form-control" rows="4" placeholder="System is currently under maintenance. We'll be back shortly.">System is currently under maintenance. We'll be back shortly.</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Scheduled Maintenance</label>
                            <div class="input-group">
                                <input type="datetime-local" class="form-control" value="2024-12-25T02:00">
                                <span class="input-group-text">to</span>
                                <input type="datetime-local" class="form-control" value="2024-12-25T04:00">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Allowed IP Addresses</label>
                            <textarea class="form-control" rows="3" placeholder="Enter IP addresses that can bypass maintenance (one per line)"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Bypass Code</label>
                            <input type="text" class="form-control" placeholder="Enter maintenance bypass code">
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Health -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">System Health</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Server Status</label>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-success">Online</span>
                                <span class="text-muted">Uptime: 99.9%</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Database Status</label>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-success">Connected</span>
                                <span class="text-muted">Last backup: 2 hours ago</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">API Status</label>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-success">Operational</span>
                                <span class="text-muted">Response time: 45ms</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Storage Usage</label>
                            <div class="progress mb-2" style="height: 8px;">
                                <div class="progress-bar bg-success" style="width: 65%;">65%</div>
                            </div>
                            <small class="text-muted">6.5 GB of 10 GB used</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Memory Usage</label>
                            <div class="progress mb-2" style="height: 8px;">
                                <div class="progress-bar bg-warning" style="width: 78%;">78%</div>
                            </div>
                            <small class="text-muted">3.9 GB of 5 GB used</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Backup Management -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Backup Management</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Auto Backup Frequency</label>
                            <select class="form-select">
                                <option value="disabled" selected>Disabled</option>
                                <option value="hourly">Hourly</option>
                                <option value="daily">Daily</option>
                                <option value="weekly">Weekly</option>
                                <option value="monthly">Monthly</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Backup Retention</label>
                            <select class="form-select">
                                <option value="7" selected>7 Days</option>
                                <option value="30">30 Days</option>
                                <option value="90">90 Days</option>
                                <option value="365">1 Year</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Backup Location</label>
                            <select class="form-select">
                                <option value="local" selected>Local Storage</option>
                                <option value="cloud">Cloud Storage</option>
                                <option value="both">Both</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Last Backup</label>
                            <input type="text" class="form-control" value="2024-12-15 03:45:00" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Backup Size</label>
                            <input type="text" class="form-control" value="2.3 GB" readonly>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-primary">Create Backup Now</button>
                                <button type="button" class="btn btn-outline-secondary">Schedule Backup</button>
                                <button type="button" class="btn btn-outline-info">Restore Backup</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Logs -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">System Logs</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Log Level</label>
                            <select class="form-select">
                                <option value="error" selected>Errors Only</option>
                                <option value="warning">Warnings & Errors</option>
                                <option value="info">All Activity</option>
                                <option value="debug">Debug Mode</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Log Retention</label>
                            <select class="form-select">
                                <option value="7" selected>7 Days</option>
                                <option value="30">30 Days</option>
                                <option value="90">90 Days</option>
                                <option value="365">1 Year</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-primary">Download Logs</button>
                                <button type="button" class="btn btn-outline-secondary">Clear Logs</button>
                                <button type="button" class="btn btn-outline-danger">Rotate Logs</button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Recent Errors</label>
                            <div class="alert alert-danger">
                                <small><strong>2 hours ago:</strong> Database connection timeout</small><br>
                                <small><strong>5 hours ago:</strong> Payment gateway API rate limit exceeded</small><br>
                                <small><strong>1 day ago:</strong> Failed to send notification emails</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Performance Metrics -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Performance Metrics</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">CPU Usage</label>
                            <div class="progress mb-2" style="height: 8px;">
                                <div class="progress-bar bg-info" style="width: 42%;">42%</div>
                            </div>
                            <small class="text-muted">Average over last 24 hours</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Response Time</label>
                            <div class="d-flex align-items-center gap-2">
                                <span class="text-success fw-bold">245ms</span>
                                <span class="text-muted">Average</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Active Users</label>
                            <div class="d-flex align-items-center gap-2">
                                <span class="text-primary fw-bold">1,247</span>
                                <span class="text-muted">Currently online</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Queue Size</label>
                            <div class="d-flex align-items-center gap-2">
                                <span class="text-warning fw-bold">23</span>
                                <span class="text-muted">Jobs pending</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Cache Hit Rate</label>
                            <div class="d-flex align-items-center gap-2">
                                <span class="text-success fw-bold">94.2%</span>
                                <span class="text-muted">Excellent</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Save Button -->
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <button type="button" class="btn btn-primary me-2">Save Maintenance Settings</button>
                        <button type="button" class="btn btn-outline-warning">Test Maintenance Mode</button>
                        <button type="button" class="btn btn-outline-danger">Emergency Restart</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
