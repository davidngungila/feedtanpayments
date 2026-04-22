@extends('layouts.app')

@section('title', 'Payment Settings - FeedTan Pay')

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">Payment Settings</h4>
        <div class="row">
            <!-- Payment Processing -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Payment Processing</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Default Payment Method</label>
                            <select class="form-select">
                                <option value="wallet" selected>Wallet</option>
                                <option value="card">Credit Card</option>
                                <option value="bank">Bank Transfer</option>
                                <option value="paypal">PayPal</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Transaction Fee (%)</label>
                            <input type="number" class="form-control" value="2.5" step="0.1" min="0" max="10">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Minimum Transaction Amount</label>
                            <input type="number" class="form-control" value="1.00" step="0.01" min="0.01">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Maximum Transaction Amount</label>
                            <input type="number" class="form-control" value="10000.00" step="0.01" min="0.01">
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="requireConfirmation" checked>
                                <label class="form-check-label" for="requireConfirmation">Require Confirmation for Large Transactions (> $1000)</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Currency Settings -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Currency Settings</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Supported Currencies</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="usd" checked>
                                <label class="form-check-label" for="usd">USD - US Dollar</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="eur" checked>
                                <label class="form-check-label" for="eur">EUR - Euro</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="gbp">
                                <label class="form-check-label" for="gbp">GBP - British Pound</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="jpy">
                                <label class="form-check-label" for="jpy">JPY - Japanese Yen</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Exchange Rate Provider</label>
                            <select class="form-select">
                                <option value="openexchange" selected>Open Exchange Rates</option>
                                <option value="fixer">Fixer.io</option>
                                <option value="exchangerate">ExchangeRate-API</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Rate Update Frequency</label>
                            <select class="form-select">
                                <option value="hourly" selected>Hourly</option>
                                <option value="daily">Daily</option>
                                <option value="weekly">Weekly</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Gateway -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Payment Gateway</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Primary Gateway</label>
                            <select class="form-select">
                                <option value="stripe" selected>Stripe</option>
                                <option value="paypal">PayPal</option>
                                <option value="square">Square</option>
                                <option value="braintree">Braintree</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">API Key</label>
                            <input type="password" class="form-control" value="sk_test_..." placeholder="Enter API key">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Webhook URL</label>
                            <input type="text" class="form-control" value="https://feedtanpay.com/webhook/payment" readonly>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="testMode">
                                <label class="form-check-label" for="testMode">Enable Test Mode</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Auto-Pay Settings -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Auto-Pay Settings</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Auto-Pay Enabled</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="autopayEnabled" checked>
                                <label class="form-check-label" for="autopayEnabled"></label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Auto-Pay Days Before Due</label>
                            <input type="number" class="form-control" value="3" min="1" max="30">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Maximum Auto-Pay Amount</label>
                            <input type="number" class="form-control" value="5000.00" step="0.01" min="0.01">
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="autopayNotifications" checked>
                                <label class="form-check-label" for="autopayNotifications">Send Auto-Pay Notifications</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Save Button -->
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <button type="button" class="btn btn-primary me-2">Save Payment Settings</button>
                        <button type="button" class="btn btn-outline-secondary">Test Gateway Connection</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
