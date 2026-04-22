@extends('layouts.app')

@section('title', 'System Protection - FeedTan Pay')

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
                                    <i class="bx bx-shield-alt me-2 text-danger"></i>
                                    System Protection
                                </h4>
                                <p class="text-muted mb-0">Firewall rules, DDoS protection, brute-force protection, and malware scanning</p>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-outline-danger" onclick="runSecurityScan()">
                                    <i class="bx bx-scan me-2"></i>Run Security Scan
                                </button>
                                <button type="button" class="btn btn-outline-secondary" onclick="refreshProtection()">
                                    <i class="bx bx-refresh me-2"></i>Refresh
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Protection Status Overview -->
        <div class="row mb-6">
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-success bg-opacity-10 rounded-circle me-3" style="width: 48px; height: 48px;">
                                <i class="bx bx-shield-check text-success fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Firewall</h6>
                                <h4 class="mb-0">Active</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-warning bg-opacity-10 rounded-circle me-3" style="width: 48px; height: 48px;">
                                <i class="bx bx-bolt text-warning fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">DDoS</h6>
                                <h4 class="mb-0">Protected</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-info bg-opacity-10 rounded-circle me-3" style="width: 48px; height: 48px;">
                                <i class="bx bx-lock-alt text-info fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Brute-Force</h6>
                                <h4 class="mb-0">Blocked</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-danger bg-opacity-10 rounded-circle me-3" style="width: 48px; height: 48px;">
                                <i class="bx bx-bug text-danger fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Malware</h6>
                                <h4 class="mb-0">Clean</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Firewall Rules -->
        <div class="row mb-6">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-shield-check me-2"></i>
                            Firewall Rules
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="mb-3">Firewall Configuration</h6>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="enableFirewall" checked>
                                        <label class="form-check-label" for="enableFirewall">
                                            Enable firewall protection
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="stealthMode">
                                        <label class="form-check-label" for="stealthMode">
                                            Enable stealth mode (hide server)
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="logFirewall" checked>
                                        <label class="form-check-label" for="logFirewall">
                                            Log firewall events
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="autoUpdateRules" checked>
                                        <label class="form-check-label" for="autoUpdateRules">
                                            Auto-update firewall rules
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="mb-3">Firewall Statistics</h6>
                                    <div class="row text-center">
                                        <div class="col-4 mb-3">
                                            <h4 class="text-danger mb-0">1,234</h4>
                                            <small class="text-muted">Blocked Today</small>
                                        </div>
                                        <div class="col-4 mb-3">
                                            <h4 class="text-warning mb-0">45</h4>
                                            <small class="text-muted">Active Rules</small>
                                        </div>
                                        <div class="col-4 mb-3">
                                            <h4 class="text-success mb-0">99.9%</h4>
                                            <small class="text-muted">Uptime</small>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-outline-warning" onclick="testFirewall()">
                                            <i class="bx bx-test-tube me-2"></i>Test Firewall
                                        </button>
                                        <button type="button" class="btn btn-outline-info" onclick="viewFirewallLogs()">
                                            <i class="bx bx-history me-2"></i>View Logs
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <h6>Current Firewall Rules</h6>
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Rule</th>
                                                    <th>Type</th>
                                                    <th>Source</th>
                                                    <th>Destination</th>
                                                    <th>Port</th>
                                                    <th>Action</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Block Malicious IPs</td>
                                                    <td><span class="badge bg-danger">Block</span></td>
                                                    <td>Blacklist</td>
                                                    <td>Any</td>
                                                    <td>Any</td>
                                                    <td><span class="badge bg-danger">Deny</span></td>
                                                    <td><span class="badge bg-success">Active</span></td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="editFirewallRule(1)">
                                                            <i class="bx bx-edit"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Allow Office Network</td>
                                                    <td><span class="badge bg-success">Allow</span></td>
                                                    <td>192.168.1.0/24</td>
                                                    <td>Any</td>
                                                    <td>Any</td>
                                                    <td><span class="badge bg-success">Allow</span></td>
                                                    <td><span class="badge bg-success">Active</span></td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="editFirewallRule(2)">
                                                            <i class="bx bx-edit"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Rate Limit Requests</td>
                                                    <td><span class="badge bg-warning">Limit</span></td>
                                                    <td>Any</td>
                                                    <td>Web Server</td>
                                                    <td>80,443</td>
                                                    <td><span class="badge bg-warning">Rate Limit</span></td>
                                                    <td><span class="badge bg-success">Active</span></td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="editFirewallRule(3)">
                                                            <i class="bx bx-edit"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- DDoS Protection -->
        <div class="row mb-6">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-bolt me-2"></i>
                            DDoS Protection
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="mb-3">DDoS Protection Settings</h6>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="enableDDoS" checked>
                                        <label class="form-check-label" for="enableDDoS">
                                            Enable DDoS protection
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="autoMitigation" checked>
                                        <label class="form-check-label" for="autoMitigation">
                                            Enable automatic mitigation
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="rateLimiting" checked>
                                        <label class="form-check-label" for="rateLimiting">
                                            Enable intelligent rate limiting
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="challengeMode">
                                        <label class="form-check-label" for="challengeMode">
                                            Enable challenge mode for suspicious traffic
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="mb-3">DDoS Thresholds</h6>
                                    <div class="mb-3">
                                        <label class="form-label">Request Rate Threshold (req/sec)</label>
                                        <input type="number" class="form-control" id="ddosThreshold" value="1000" min="100" max="10000">
                                        <small class="text-muted">Alert if requests per second exceed this</small>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Connection Threshold (conn/sec)</label>
                                        <input type="number" class="form-control" id="connectionThreshold" value="500" min="50" max="5000">
                                        <small class="text-muted">Alert if new connections per second exceed this</small>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Bandwidth Threshold (Mbps)</label>
                                        <input type="number" class="form-control" id="bandwidthThreshold" value="100" min="10" max="1000">
                                        <small class="text-muted">Alert if bandwidth usage exceeds this</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-primary" onclick="saveDDoSSettings()">
                                        <i class="bx bx-save me-2"></i>Save DDoS Settings
                                    </button>
                                    <button type="button" class="btn btn-outline-warning" onclick="testDDoSProtection()">
                                        <i class="bx bx-test-tube me-2"></i>Test Protection
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Brute-Force Protection -->
        <div class="row mb-6">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-lock-alt me-2"></i>
                            Brute-Force Protection
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="mb-3">Brute-Force Settings</h6>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="enableBruteForce" checked>
                                        <label class="form-check-label" for="enableBruteForce">
                                            Enable brute-force protection
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="progressiveDelay" checked>
                                        <label class="form-check-label" for="progressiveDelay">
                                            Enable progressive delay
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="ipBlacklisting" checked>
                                        <label class="form-check-label" for="ipBlacklisting">
                                            Auto-blacklist offending IPs
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="captchaProtection" checked>
                                        <label class="form-check-label" for="captchaProtection">
                                            Enable CAPTCHA after failed attempts
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="mb-3">Protection Parameters</h6>
                                    <div class="mb-3">
                                        <label class="form-label">Max Failed Attempts</label>
                                        <input type="number" class="form-control" id="maxFailedAttempts" value="5" min="3" max="20">
                                        <small class="text-muted">Block after X failed attempts</small>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Lockout Duration (minutes)</label>
                                        <input type="number" class="form-control" id="lockoutDuration" value="15" min="5" max="1440">
                                        <small class="text-muted">Lockout duration in minutes</small>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Tracking Window (minutes)</label>
                                        <input type="number" class="form-control" id="trackingWindow" value="15" min="5" max="60">
                                        <small class="text-muted">Time window to count failed attempts</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-primary" onclick="saveBruteForceSettings()">
                                        <i class="bx bx-save me-2"></i>Save Settings
                                    </button>
                                    <button type="button" class="btn btn-outline-warning" onclick="testBruteForceProtection()">
                                        <i class="bx bx-test-tube me-2"></i>Test Protection
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Malware Scanning -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-bug me-2"></i>
                            Malware Scan (Server Level)
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="mb-3">Malware Scan Configuration</h6>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="enableMalwareScan" checked>
                                        <label class="form-check-label" for="enableMalwareScan">
                                            Enable malware scanning
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="realTimeScan" checked>
                                        <label class="form-check-label" for="realTimeScan">
                                            Enable real-time scanning
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="scheduledScan" checked>
                                        <label class="form-check-label" for="scheduledScan">
                                            Enable scheduled scanning
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="quarantineThreats" checked>
                                        <label class="form-check-label" for="quarantineThreats">
                                            Auto-quarantine detected threats
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="mb-3">Scan Schedule</h6>
                                    <div class="mb-3">
                                        <label class="form-label">Full Scan Frequency</label>
                                        <select class="form-select" id="scanFrequency">
                                            <option value="daily">Daily</option>
                                            <option value="weekly" selected>Weekly</option>
                                            <option value="monthly">Monthly</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Scan Time</label>
                                        <input type="time" class="form-control" id="scanTime" value="02:00">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Scan Directories</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="scanUploads" checked>
                                            <label class="form-check-label" for="scanUploads">Upload Directory</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="scanTemp" checked>
                                            <label class="form-check-label" for="scanTemp">Temporary Files</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="scanLogs">
                                            <label class="form-check-label" for="scanLogs">Log Files</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-primary" onclick="saveMalwareSettings()">
                                        <i class="bx bx-save me-2"></i>Save Scan Settings
                                    </button>
                                    <button type="button" class="btn btn-outline-warning" onclick="runQuickScan()">
                                        <i class="bx bx-scan me-2"></i>Quick Scan
                                    </button>
                                    <button type="button" class="btn btn-outline-info" onclick="viewScanReports()">
                                        <i class="bx bx-file me-2"></i>View Reports
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function refreshProtection() {
    showNotification('Refreshing system protection data...', 'info');
    setTimeout(() => {
        location.reload();
    }, 1000);
}

function runSecurityScan() {
    showNotification('Running comprehensive security scan...', 'info');
    setTimeout(() => {
        showNotification('Security scan completed! No threats detected.', 'success');
    }, 5000);
}

function testFirewall() {
    showNotification('Testing firewall rules...', 'info');
    setTimeout(() => {
        showNotification('Firewall test completed successfully!', 'success');
    }, 2000);
}

function viewFirewallLogs() {
    showNotification('Loading firewall logs...', 'info');
    setTimeout(() => {
        showNotification('Firewall logs loaded successfully!', 'success');
    }, 1500);
}

function editFirewallRule(id) {
    showNotification(`Editing firewall rule #${id}...`, 'info');
    setTimeout(() => {
        showNotification(`Firewall rule #${id} editor opened`, 'success');
    }, 1000);
}

function saveDDoSSettings() {
    showNotification('Saving DDoS protection settings...', 'info');
    setTimeout(() => {
        showNotification('DDoS settings saved successfully!', 'success');
    }, 1500);
}

function testDDoSProtection() {
    showNotification('Testing DDoS protection...', 'warning');
    setTimeout(() => {
        showNotification('DDoS protection test completed!', 'success');
    }, 3000);
}

function saveBruteForceSettings() {
    showNotification('Saving brute-force protection settings...', 'info');
    setTimeout(() => {
        showNotification('Brute-force settings saved successfully!', 'success');
    }, 1500);
}

function testBruteForceProtection() {
    showNotification('Testing brute-force protection...', 'warning');
    setTimeout(() => {
        showNotification('Brute-force protection test completed!', 'success');
    }, 3000);
}

function saveMalwareSettings() {
    showNotification('Saving malware scan settings...', 'info');
    setTimeout(() => {
        showNotification('Malware scan settings saved successfully!', 'success');
    }, 1500);
}

function runQuickScan() {
    showNotification('Starting quick malware scan...', 'info');
    setTimeout(() => {
        showNotification('Quick scan completed! No threats found.', 'success');
    }, 3000);
}

function viewScanReports() {
    showNotification('Loading scan reports...', 'info');
    setTimeout(() => {
        showNotification('Scan reports loaded successfully!', 'success');
    }, 1500);
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
