@extends('layouts.app')

@section('title', 'Integration Settings - FeedTan Pay')

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">Integration Settings</h4>
        <div class="row">
            <!-- API Integration -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">API Integration</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">API Status</label>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-success">Active</span>
                                <button type="button" class="btn btn-sm btn-outline-secondary">Regenerate Key</button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">API Key</label>
                            <div class="input-group">
                                <input type="password" class="form-control" value="sk_live_..." readonly>
                                <button type="button" class="btn btn-outline-secondary" onclick="copyToClipboard(this)">Copy</button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Webhook URL</label>
                            <div class="input-group">
                                <input type="text" class="form-control" value="https://feedtanpay.com/webhook/api" readonly>
                                <button type="button" class="btn btn-outline-secondary" onclick="copyToClipboard(this)">Copy</button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Rate Limit (requests/minute)</label>
                            <input type="number" class="form-control" value="1000" min="1" max="10000">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">IP Whitelist</label>
                            <textarea class="form-control" rows="3" placeholder="Enter allowed IP addresses (one per line)"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Third-Party Services -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Third-Party Services</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">QuickBooks Integration</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="quickbooksEnabled">
                                <label class="form-check-label" for="quickbooksEnabled"></label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">QuickBooks API Key</label>
                            <input type="password" class="form-control" placeholder="Enter QuickBooks API key">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Xero Integration</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="xeroEnabled">
                                <label class="form-check-label" for="xeroEnabled"></label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Xero API Key</label>
                            <input type="password" class="form-control" placeholder="Enter Xero API key">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Stripe Integration</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="stripeEnabled" checked>
                                <label class="form-check-label" for="stripeEnabled"></label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Stripe Webhook Secret</label>
                            <input type="password" class="form-control" placeholder="Enter Stripe webhook secret">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Webhooks -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Webhook Configuration</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Webhook Events</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="webhookPayment" checked>
                                <label class="form-check-label" for="webhookPayment">Payment Completed</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="webhookPayout" checked>
                                <label class="form-check-label" for="webhookPayout">Payout Completed</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="webhookBill" checked>
                                <label class="form-check-label" for="webhookBill">Bill Created/Paid</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="webhookUser" checked>
                                <label class="form-check-label" for="webhookUser">User Registration</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Retry Policy</label>
                            <select class="form-select">
                                <option value="3" selected>3 attempts</option>
                                <option value="5">5 attempts</option>
                                <option value="10">10 attempts</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Timeout (seconds)</label>
                            <input type="number" class="form-control" value="30" min="5" max="300">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Signature Method</label>
                            <select class="form-select">
                                <option value="hmac-sha256" selected>HMAC-SHA256</option>
                                <option value="rsa">RSA Signature</option>
                                <option value="none">None</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Sync -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Data Synchronization</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Auto Sync Frequency</label>
                            <select class="form-select">
                                <option value="realtime" selected>Real-time</option>
                                <option value="hourly">Hourly</option>
                                <option value="daily">Daily</option>
                                <option value="manual">Manual</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Sync Direction</label>
                            <select class="form-select">
                                <option value="bidirectional" selected>Bidirectional</option>
                                <option value="import">Import Only</option>
                                <option value="export">Export Only</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Data Fields</label>
                            <textarea class="form-control" rows="3" placeholder="Specify which fields to sync (one per line)"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Last Sync</label>
                            <input type="text" class="form-control" value="2024-12-15 14:30:00" readonly>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="enableConflictResolution" checked>
                                <label class="form-check-label" for="enableConflictResolution">Enable Conflict Resolution</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Save Button -->
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <button type="button" class="btn btn-primary me-2">Save Integration Settings</button>
                        <button type="button" class="btn btn-outline-secondary">Test Webhook</button>
                        <button type="button" class="btn btn-outline-info">View API Documentation</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function copyToClipboard(element) {
    const input = element.previousElementSibling;
    input.select();
    document.execCommand('copy');
    
    // Show feedback
    const originalText = element.textContent;
    element.textContent = 'Copied!';
    element.classList.add('btn-success');
    
    setTimeout(() => {
        element.textContent = originalText;
        element.classList.remove('btn-success');
    }, 2000);
}
</script>
@endpush
