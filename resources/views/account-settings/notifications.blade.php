@extends('layouts.app')

@section('title', 'Notifications')
@section('description', 'Manage your notification preferences')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card mb-6">
            <div class="card-header">
                <h5 class="card-title mb-0">Notification Preferences</h5>
            </div>
            <div class="card-body">
                <div class="mb-6">
                    <h6 class="mb-4">Email Notifications</h6>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="emailTransactions" checked>
                        <label class="form-check-label" for="emailTransactions">
                            <div>
                                <h6 class="mb-0">Transaction Updates</h6>
                                <small class="text-muted">Get notified when payments are sent or received</small>
                            </div>
                        </label>
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="emailSecurity" checked>
                        <label class="form-check-label" for="emailSecurity">
                            <div>
                                <h6 class="mb-0">Security Alerts</h6>
                                <small class="text-muted">Important security notifications about your account</small>
                            </div>
                        </label>
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="emailMarketing">
                        <label class="form-check-label" for="emailMarketing">
                            <div>
                                <h6 class="mb-0">Marketing Emails</h6>
                                <small class="text-muted">Updates about new features and promotions</small>
                            </div>
                        </label>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="emailBills" checked>
                        <label class="form-check-label" for="emailBills">
                            <div>
                                <h6 class="mb-0">Bill Reminders</h6>
                                <small class="text-muted">Remind you before bills are due</small>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="mb-6">
                    <h6 class="mb-4">Push Notifications</h6>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="pushTransactions" checked>
                        <label class="form-check-label" for="pushTransactions">
                            <div>
                                <h6 class="mb-0">Transaction Updates</h6>
                                <small class="text-muted">Real-time transaction notifications</small>
                            </div>
                        </label>
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="pushSecurity" checked>
                        <label class="form-check-label" for="pushSecurity">
                            <div>
                                <h6 class="mb-0">Security Alerts</h6>
                                <small class="text-muted">Instant security notifications</small>
                            </div>
                        </label>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="pushBills" checked>
                        <label class="form-check-label" for="pushBills">
                            <div>
                                <h6 class="mb-0">Bill Reminders</h6>
                                <small class="text-muted">Push notifications for upcoming bills</small>
                            </div>
                        </label>
                    </div>
                </div>

                <div>
                    <h6 class="mb-4">SMS Notifications</h6>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="smsSecurity" checked>
                        <label class="form-check-label" for="smsSecurity">
                            <div>
                                <h6 class="mb-0">Security Alerts</h6>
                                <small class="text-muted">Critical security updates via SMS</small>
                            </div>
                        </label>
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="smsTransactions">
                        <label class="form-check-label" for="smsTransactions">
                            <div>
                                <h6 class="mb-0">Large Transactions</h6>
                                <small class="text-muted">SMS for transactions over $1,000</small>
                            </div>
                        </label>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="smsLogin">
                        <label class="form-check-label" for="smsLogin">
                            <div>
                                <h6 class="mb-0">New Logins</h6>
                                <small class="text-muted">SMS when logging in from new device</small>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Recent Notifications</h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-point bg-success"></div>
                        <div class="timeline-content">
                            <h6 class="mb-1">Payment Received</h6>
                            <p class="text-muted mb-0">$500.00 from John Smith</p>
                            <small class="text-muted">2 hours ago</small>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-point bg-warning"></div>
                        <div class="timeline-content">
                            <h6 class="mb-1">Bill Due Soon</h6>
                            <p class="text-muted mb-0">Electric bill due in 3 days</p>
                            <small class="text-muted">5 hours ago</small>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-point bg-info"></div>
                        <div class="timeline-content">
                            <h6 class="mb-1">New Login</h6>
                            <p class="text-muted mb-0">Login from Chrome on Windows</p>
                            <small class="text-muted">1 day ago</small>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-point bg-primary"></div>
                        <div class="timeline-content">
                            <h6 class="mb-1">System Update</h6>
                            <p class="text-muted mb-0">New features available</p>
                            <small class="text-muted">2 days ago</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card mb-6">
            <div class="card-header">
                <h5 class="card-title mb-0">Quick Stats</h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <h2 class="mb-2">247</h2>
                    <p class="text-muted">Total Notifications</p>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <div class="text-center">
                        <h5 class="mb-0 text-success">142</h5>
                        <small class="text-muted">This Week</small>
                    </div>
                    <div class="text-center">
                        <h5 class="mb-0 text-warning">89</h5>
                        <small class="text-muted">Unread</small>
                    </div>
                </div>
                <div class="progress" style="height: 8px;">
                    <div class="progress-bar bg-success" style="width: 64%"></div>
                </div>
                <small class="text-muted">64% read rate</small>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Notification Channels</h5>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="d-flex align-items-center">
                        <div class="avatar bg-primary bg-opacity-10 rounded-circle me-3">
                            <i class="bx bx-envelope text-primary"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">Email</h6>
                            <small class="text-muted">john.doe@example.com</small>
                        </div>
                    </div>
                    <span class="badge bg-success">Active</span>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="d-flex align-items-center">
                        <div class="avatar bg-success bg-opacity-10 rounded-circle me-3">
                            <i class="bx bx-mobile text-success"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">Push</h6>
                            <small class="text-muted">Browser notifications</small>
                        </div>
                    </div>
                    <span class="badge bg-success">Active</span>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="avatar bg-info bg-opacity-10 rounded-circle me-3">
                            <i class="bx bx-message-square text-info"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">SMS</h6>
                            <small class="text-muted">+1 (555) 123-4567</small>
                        </div>
                    </div>
                    <span class="badge bg-success">Active</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 8px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e9ecef;
}

.timeline-item {
    position: relative;
    padding-bottom: 20px;
}

.timeline-point {
    position: absolute;
    left: -22px;
    top: 0;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    border: 2px solid #fff;
}

.timeline-content {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
}
</style>
@endpush
