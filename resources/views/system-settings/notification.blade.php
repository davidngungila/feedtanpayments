@extends('layouts.app')

@section('title', 'Notification Settings - FeedTan Pay')

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">Notification Settings</h4>
        <div class="row">
            <!-- Email Notifications -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Email Notifications</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="emailTransactions" checked>
                                <label class="form-check-label" for="emailTransactions">Transaction Notifications</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="emailPayments" checked>
                                <label class="form-check-label" for="emailPayments">Payment Confirmations</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="emailBills" checked>
                                <label class="form-check-label" for="emailBills">Bill Due Reminders</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="emailSecurity" checked>
                                <label class="form-check-label" for="emailSecurity">Security Alerts</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email Frequency</label>
                            <select class="form-select">
                                <option value="immediate" selected>Immediate</option>
                                <option value="hourly">Hourly Digest</option>
                                <option value="daily">Daily Digest</option>
                                <option value="weekly">Weekly Digest</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SMS Notifications -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">SMS Notifications</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="smsEnabled">
                                <label class="form-check-label" for="smsEnabled">Enable SMS Notifications</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" value="+1 (555) 123-4567" placeholder="+1 (XXX) XXX-XXXX">
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="smsTransactions" checked>
                                <label class="form-check-label" for="smsTransactions">Transaction Alerts</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="smsSecurity" checked>
                                <label class="form-check-label" for="smsSecurity">Security Alerts</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="smsBills" checked>
                                <label class="form-check-label" for="smsBills">Bill Reminders</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Push Notifications -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Push Notifications</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="pushEnabled" checked>
                                <label class="form-check-label" for="pushEnabled">Enable Push Notifications</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="pushTransactions" checked>
                                <label class="form-check-label" for="pushTransactions">Real-time Updates</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="pushBills" checked>
                                <label class="form-check-label" for="pushBills">Bill Due Alerts</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="pushSecurity" checked>
                                <label class="form-check-label" for="pushSecurity">Security Warnings</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Quiet Hours</label>
                            <div class="input-group">
                                <input type="time" class="form-control" value="22:00">
                                <span class="input-group-text">to</span>
                                <input type="time" class="form-control" value="08:00">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- In-App Notifications -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">In-App Notifications</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="appSounds" checked>
                                <label class="form-check-label" for="appSounds">Enable Sound Effects</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="appVibration" checked>
                                <label class="form-check-label" for="appVibration">Enable Vibration</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="appDesktop" checked>
                                <label class="form-check-label" for="appDesktop">Desktop Notifications</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Notification Position</label>
                            <select class="form-select">
                                <option value="top-right" selected>Top Right</option>
                                <option value="top-left">Top Left</option>
                                <option value="bottom-right">Bottom Right</option>
                                <option value="bottom-left">Bottom Left</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Auto-dismiss After</label>
                            <select class="form-select">
                                <option value="5" selected>5 seconds</option>
                                <option value="10">10 seconds</option>
                                <option value="30">30 seconds</option>
                                <option value="never">Never</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notification Templates -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Notification Templates</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Payment Success Template</label>
                            <textarea class="form-control" rows="3" placeholder="Your payment of $amount to $recipient was successful. Transaction ID: $transaction_id">Your payment of $250.00 to John Doe was successful. Transaction ID: TRX123456</textarea>
                            <small class="text-muted">Available variables: {amount}, {recipient}, {transaction_id}, {date}, {time}</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Bill Due Template</label>
                            <textarea class="form-control" rows="3" placeholder="Your bill &quot;$bill_name&quot; of $amount is due on $due_date. Please ensure payment is made to avoid late fees.">Your bill "Electric Bill" of $245.50 is due on 12/20/2024. Please ensure payment is made to avoid late fees.</textarea>
                            <small class="text-muted">Available variables: {bill_name}, {amount}, {due_date}, {days_until_due}</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Security Alert Template</label>
                            <textarea class="form-control" rows="3" placeholder="Security alert: $alert_type detected from IP $ip_address at $time. Please review your account activity.">Security alert: Suspicious Login detected from IP 192.168.1.100 at 14:30. Please review your account activity.</textarea>
                            <small class="text-muted">Available variables: {alert_type}, {ip_address}, {time}, {location}, {device}</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Save Button -->
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <button type="button" class="btn btn-primary me-2">Save Notification Settings</button>
                        <button type="button" class="btn btn-outline-secondary">Test Notifications</button>
                        <button type="button" class="btn btn-outline-danger">Clear All Notifications</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
