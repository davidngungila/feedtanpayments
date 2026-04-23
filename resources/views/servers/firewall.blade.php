@extends('layouts.app')

@section('title', 'Firewall Management')
@section('description', 'Manage UFW firewall rules and security')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">Firewall Management (UFW)</h5>
                    <p class="card-subtitle">Manage UFW firewall rules and security settings</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-success" onclick="enableFirewall()">
                        <i class="bx bx-shield me-1"></i> Enable
                    </button>
                    <button class="btn btn-outline-warning" onclick="disableFirewall()">
                        <i class="bx bx-shield-x me-1"></i> Disable
                    </button>
                    <button class="btn btn-outline-primary" onclick="addRule()">
                        <i class="bx bx-plus me-1"></i> Add Rule
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- Firewall Overview -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-success bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-shield text-success"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Status</h6>
                                <h4 class="mb-0 text-success">{{ $firewall_config['status'] }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-primary bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-info-circle text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Type</h6>
                                <h4 class="mb-0">{{ $firewall_config['type'] }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-info bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-list-check text-info"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Rules</h6>
                                <h4 class="mb-0 text-info">{{ count($firewall_config['rules']) }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-warning bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-block text-warning"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Blocked</h6>
                                <h4 class="mb-0 text-warning">{{ count($firewall_config['recent_blocks']) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Default Policy -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Default Policy</h6>
                            </div>
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-md-4">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <i class="bx bx-download me-2 text-primary"></i>
                                            <div>
                                                <h6 class="mb-0">Incoming</h6>
                                                <span class="badge bg-{{ $firewall_config['default_policy']['incoming'] == 'deny' ? 'danger' : 'success' }}">
                                                    {{ strtoupper($firewall_config['default_policy']['incoming']) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <i class="bx bx-upload me-2 text-success"></i>
                                            <div>
                                                <h6 class="mb-0">Outgoing</h6>
                                                <span class="badge bg-{{ $firewall_config['default_policy']['outgoing'] == 'allow' ? 'success' : 'danger' }}">
                                                    {{ strtoupper($firewall_config['default_policy']['outgoing']) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <i class="bx bx-transfer me-2 text-warning"></i>
                                            <div>
                                                <h6 class="mb-0">Routed</h6>
                                                <span class="badge bg-{{ $firewall_config['default_policy']['routed'] == 'deny' ? 'danger' : 'success' }}">
                                                    {{ strtoupper($firewall_config['default_policy']['routed']) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Firewall Rules -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Firewall Rules</h6>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-outline-primary" onclick="addRule()">
                                        <i class="bx bx-plus me-1"></i> Add Rule
                                    </button>
                                    <button class="btn btn-sm btn-outline-info" onclick="resetToDefaults()">
                                        <i class="bx bx-reset me-1"></i> Reset to Defaults
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Action</th>
                                                <th>Protocol</th>
                                                <th>Port</th>
                                                <th>Source</th>
                                                <th>Description</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($firewall_config['rules'] as $rule)
                                            <tr>
                                                <td>
                                                    <span class="badge bg-{{ $rule['action'] == 'ALLOW' ? 'success' : 'danger' }}">
                                                        {{ $rule['action'] }}
                                                    </span>
                                                </td>
                                                <td><span class="badge bg-info">{{ $rule['protocol'] }}</span></td>
                                                <td><strong>{{ $rule['port'] }}</strong></td>
                                                <td><code>{{ $rule['source'] }}</code></td>
                                                <td>{{ $rule['description'] }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a href="#" class="dropdown-item" onclick="editRule({{ $loop->index }})">
                                                                <i class="bx bx-edit me-2"></i> Edit
                                                            </a>
                                                            <a href="#" class="dropdown-item" onclick="duplicateRule({{ $loop->index }})">
                                                                <i class="bx bx-copy me-2"></i> Duplicate
                                                            </a>
                                                            <a href="#" class="dropdown-item" onclick="moveRule({{ $loop->index }})">
                                                                <i class="bx bx-move me-2"></i> Move
                                                            </a>
                                                            <div class="dropdown-divider"></div>
                                                            <a href="#" class="dropdown-item text-danger" onclick="deleteRule({{ $loop->index }})">
                                                                <i class="bx bx-trash me-2"></i> Delete
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Blocks -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Recent Blocks</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>IP Address</th>
                                                <th>Port</th>
                                                <th>Time</th>
                                                <th>Reason</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($firewall_config['recent_blocks'] as $block)
                                            <tr>
                                                <td><code>{{ $block['ip'] }}</code></td>
                                                <td>{{ $block['port'] }}</td>
                                                <td>{{ $block['time'] }}</td>
                                                <td>{{ $block['reason'] }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a href="#" class="dropdown-item" onclick="viewBlockDetails('{{ $block['ip'] }}')">
                                                                <i class="bx bx-eye me-2"></i> View Details
                                                            </a>
                                                            <a href="#" class="dropdown-item text-warning" onclick="unblockIP('{{ $block['ip'] }}')">
                                                                <i class="bx bx-unlock me-2"></i> Unblock
                                                            </a>
                                                            <a href="#" class="dropdown-item text-danger" onclick="permanentBlock('{{ $block['ip'] }}')">
                                                                <i class="bx bx-block me-2"></i> Permanent Block
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Logging Configuration -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Logging Configuration</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="loggingEnabled" {{ $firewall_config['logging']['enabled'] ? 'checked' : '' }}>
                                            <label class="form-check-label" for="loggingEnabled">
                                                Enable firewall logging
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="logAll" {{ $firewall_config['logging']['level'] == 'high' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="logAll">
                                                Log all traffic (verbose)
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="logBlocked" checked>
                                            <label class="form-check-label" for="logBlocked">
                                                Log blocked connections
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="logRateLimit" checked>
                                            <label class="form-check-label" for="logRateLimit">
                                                Enable rate limiting for logs
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="logLevel" class="form-label">Log Level</label>
                                            <select class="form-select" id="logLevel">
                                                <option value="low" {{ $firewall_config['logging']['level'] == 'low' ? 'selected' : '' }}>Low</option>
                                                <option value="medium" {{ $firewall_config['logging']['level'] == 'medium' ? 'selected' : '' }}>Medium</option>
                                                <option value="high" {{ $firewall_config['logging']['level'] == 'high' ? 'selected' : '' }}>High</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="logFile" class="form-label">Log File</label>
                                            <input type="text" class="form-control" id="logFile" value="/var/log/ufw.log" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="logRotation" class="form-label">Log Rotation</label>
                                            <select class="form-select" id="logRotation">
                                                <option value="daily">Daily</option>
                                                <option value="weekly" selected>Weekly</option>
                                                <option value="monthly">Monthly</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-primary" onclick="saveLoggingSettings()">
                                        <i class="bx bx-save me-1"></i> Save Settings
                                    </button>
                                    <button class="btn btn-outline-info ms-2" onclick="viewLogs()">
                                        <i class="bx bx-file me-1"></i> View Logs
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
@endsection

@push('scripts')
<script>
function enableFirewall() {
    if (confirm('Are you sure you want to enable the firewall? This may affect existing connections.')) {
        showNotification('Firewall enabled successfully', 'success');
    }
}

function disableFirewall() {
    if (confirm('Are you sure you want to disable the firewall? This will expose your server to potential threats.')) {
        showNotification('Firewall disabled', 'warning');
    }
}

function addRule() {
    showNotification('Opening firewall rule creation wizard...', 'info');
}

function editRule(index) {
    showNotification(`Editing firewall rule #${index + 1}`, 'info');
}

function duplicateRule(index) {
    showNotification(`Duplicating firewall rule #${index + 1}`, 'info');
}

function moveRule(index) {
    showNotification(`Moving firewall rule #${index + 1}`, 'info');
}

function deleteRule(index) {
    if (confirm(`Are you sure you want to delete firewall rule #${index + 1}?`)) {
        showNotification(`Firewall rule #${index + 1} deleted`, 'danger');
    }
}

function resetToDefaults() {
    if (confirm('Are you sure you want to reset firewall to default settings? This will remove all custom rules.')) {
        showNotification('Firewall reset to default settings', 'warning');
    }
}

function viewBlockDetails(ip) {
    showNotification(`Viewing block details for IP: ${ip}`, 'info');
}

function unblockIP(ip) {
    if (confirm(`Are you sure you want to unblock IP address: ${ip}?`)) {
        showNotification(`IP address ${ip} unblocked`, 'success');
    }
}

function permanentBlock(ip) {
    if (confirm(`Are you sure you want to permanently block IP address: ${ip}?`)) {
        showNotification(`IP address ${ip} permanently blocked`, 'warning');
    }
}

function saveLoggingSettings() {
    showNotification('Firewall logging settings saved successfully', 'success');
}

function viewLogs() {
    showNotification('Opening firewall logs...', 'info');
}

function showNotification(message, type) {
    const alert = document.createElement('div');
    alert.className = `alert alert-${type} alert-dismissible fade show position-fixed top-0 end-0 m-3`;
    alert.style.zIndex = '9999';
    alert.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    document.body.appendChild(alert);
    
    setTimeout(() => {
        alert.remove();
    }, 3000);
}
</script>
@endpush
