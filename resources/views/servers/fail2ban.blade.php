@extends('layouts.app')

@section('title', 'Fail2Ban Security')
@section('description', 'Manage Fail2Ban intrusion prevention system')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">Fail2Ban Security</h5>
                    <p class="card-subtitle">Manage Fail2Ban intrusion prevention system</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-success" onclick="startFail2Ban()">
                        <i class="bx bx-play me-1"></i> Start
                    </button>
                    <button class="btn btn-outline-warning" onclick="stopFail2Ban()">
                        <i class="bx bx-stop me-1"></i> Stop
                    </button>
                    <button class="btn btn-outline-primary" onclick="restartFail2Ban()">
                        <i class="bx bx-refresh me-1"></i> Restart
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- Fail2Ban Overview -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-success bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-shield text-success"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Status</h6>
                                <h4 class="mb-0 text-success">{{ $fail2ban_config['status'] }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-primary bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-info-circle text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Version</h6>
                                <h4 class="mb-0">{{ $fail2ban_config['version'] }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-warning bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-block text-warning"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Banned</h6>
                                <h4 class="mb-0 text-warning">{{ array_sum(array_column($fail2ban_config['jails'], 'banned')) }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-info bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-lock text-info"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Active Jails</h6>
                                <h4 class="mb-0 text-info">{{ count(array_filter($fail2ban_config['jails'], fn($j) => $j['enabled'])) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Jails Configuration -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Jails Configuration</h6>
                                <button class="btn btn-sm btn-outline-primary" onclick="addJail()">
                                    <i class="bx bx-plus me-1"></i> Add Jail
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Jail Name</th>
                                                <th>Status</th>
                                                <th>Banned IPs</th>
                                                <th>Max Retry</th>
                                                <th>Find Time</th>
                                                <th>Ban Time</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($fail2ban_config['jails'] as $jail)
                                            <tr>
                                                <td><strong>{{ $jail['name'] }}</strong></td>
                                                <td>
                                                    <span class="badge bg-{{ $jail['enabled'] ? 'success' : 'secondary' }}">
                                                        {{ $jail['enabled'] ? 'Enabled' : 'Disabled' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-{{ $jail['banned'] > 0 ? 'warning' : 'success' }}">
                                                        {{ $jail['banned'] }}
                                                    </span>
                                                </td>
                                                <td>{{ $jail['max_retry'] }}</td>
                                                <td>{{ $jail['find_time'] }}</td>
                                                <td>{{ $jail['bantime'] }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a href="#" class="dropdown-item" onclick="editJail('{{ $jail['name'] }}')">
                                                                <i class="bx bx-edit me-2"></i> Edit
                                                            </a>
                                                            @if($jail['enabled'])
                                                            <a href="#" class="dropdown-item text-warning" onclick="disableJail('{{ $jail['name'] }}')">
                                                                <i class="bx bx-pause me-2"></i> Disable
                                                            </a>
                                                            @else
                                                            <a href="#" class="dropdown-item text-success" onclick="enableJail('{{ $jail['name'] }}')">
                                                                <i class="bx bx-play me-2"></i> Enable
                                                            </a>
                                                            @endif
                                                            <a href="#" class="dropdown-item" onclick="restartJail('{{ $jail['name'] }}')">
                                                                <i class="bx bx-refresh me-2"></i> Restart
                                                            </a>
                                                            <a href="#" class="dropdown-item" onclick="viewJailLog('{{ $jail['name'] }}')">
                                                                <i class="bx bx-file me-2"></i> View Log
                                                            </a>
                                                            <div class="dropdown-divider"></div>
                                                            <a href="#" class="dropdown-item text-info" onclick="unbanAll('{{ $jail['name'] }}')">
                                                                <i class="bx bx-unlock me-2"></i> Unban All
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

                <!-- Banned IPs -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Currently Banned IPs</h6>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-outline-warning" onclick="unbanAll()">
                                        <i class="bx bx-unlock me-1"></i> Unban All
                                    </button>
                                    <button class="btn btn-sm btn-outline-info" onclick="refreshBannedList()">
                                        <i class="bx bx-refresh me-1"></i> Refresh
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>IP Address</th>
                                                <th>Jail</th>
                                                <th>Banned Time</th>
                                                <th>Unban Time</th>
                                                <th>Time Remaining</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($fail2ban_config['banned_ips'] as $banned)
                                            <tr>
                                                <td><code>{{ $banned['ip'] }}</code></td>
                                                <td><span class="badge bg-primary">{{ $banned['jail'] }}</span></td>
                                                <td>{{ $banned['time'] }}</td>
                                                <td>{{ $banned['unban_time'] }}</td>
                                                <td>
                                                    @php
                                                        $unbanTime = new DateTime($banned['unban_time']);
                                                        $now = new DateTime();
                                                        $remaining = $unbanTime > $now ? $unbanTime->diff($now)->format('%H:%I:%S') : '00:00:00';
                                                    @endphp
                                                    <span class="badge bg-{{ $remaining != '00:00:00' ? 'warning' : 'success' }}">
                                                        {{ $remaining }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a href="#" class="dropdown-item" onclick="viewBanDetails('{{ $banned['ip'] }}')">
                                                                <i class="bx bx-eye me-2"></i> View Details
                                                            </a>
                                                            <a href="#" class="dropdown-item text-success" onclick="unbanIP('{{ $banned['ip'] }}')">
                                                                <i class="bx bx-unlock me-2"></i> Unban
                                                            </a>
                                                            <a href="#" class="dropdown-item text-warning" onclick="extendBan('{{ $banned['ip'] }}')">
                                                                <i class="bx bx-time-five me-2"></i> Extend Ban
                                                            </a>
                                                            <a href="#" class="dropdown-item text-danger" onclick="permanentBan('{{ $banned['ip'] }}')">
                                                                <i class="bx bx-block me-2"></i> Permanent Ban
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

                <!-- Statistics -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Ban Statistics</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="banChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Jail Activity</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="jailChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Log Files -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Log Files</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Log File</th>
                                                <th>Size</th>
                                                <th>Last Modified</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($fail2ban_config['log_files'] as $log)
                                            <tr>
                                                <td><code>{{ $log['name'] }}</code></td>
                                                <td>{{ $log['size'] }}</td>
                                                <td>{{ $log['last_modified'] }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a href="#" class="dropdown-item" onclick="viewLogFile('{{ $log['name'] }}')">
                                                                <i class="bx bx-eye me-2"></i> View
                                                            </a>
                                                            <a href="#" class="dropdown-item" onclick="downloadLogFile('{{ $log['name'] }}')">
                                                                <i class="bx bx-download me-2"></i> Download
                                                            </a>
                                                            <a href="#" class="dropdown-item text-warning" onclick="rotateLogFile('{{ $log['name'] }}')">
                                                                <i class="bx bx-refresh me-2"></i> Rotate
                                                            </a>
                                                            <a href="#" class="dropdown-item text-danger" onclick="clearLogFile('{{ $log['name'] }}')">
                                                                <i class="bx bx-trash me-2"></i> Clear
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
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Ban Statistics Chart
const banCtx = document.getElementById('banChart').getContext('2d');
new Chart(banCtx, {
    type: 'line',
    data: {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        datasets: [{
            label: 'Banned IPs',
            data: [12, 19, 15, 25, 22, 30, 28],
            borderColor: '#dc3545',
            backgroundColor: 'rgba(220, 53, 69, 0.1)',
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Jail Activity Chart
const jailCtx = document.getElementById('jailChart').getContext('2d');
new Chart(jailCtx, {
    type: 'doughnut',
    data: {
        labels: ['SSH', 'Apache', 'MySQL', 'Nginx'],
        datasets: [{
            data: [5, 12, 2, 0],
            backgroundColor: [
                '#28a745',
                '#007bff',
                '#ffc107',
                '#6c757d'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

function startFail2Ban() {
    showNotification('Fail2Ban service started', 'success');
}

function stopFail2Ban() {
    if (confirm('Are you sure you want to stop Fail2Ban? This will disable intrusion protection.')) {
        showNotification('Fail2Ban service stopped', 'warning');
    }
}

function restartFail2Ban() {
    if (confirm('Are you sure you want to restart Fail2Ban?')) {
        showNotification('Fail2Ban service restarted', 'info');
    }
}

function addJail() {
    showNotification('Opening jail creation wizard...', 'info');
}

function editJail(jailName) {
    showNotification(`Editing jail: ${jailName}`, 'info');
}

function enableJail(jailName) {
    showNotification(`Jail ${jailName} enabled`, 'success');
}

function disableJail(jailName) {
    if (confirm(`Are you sure you want to disable jail: ${jailName}?`)) {
        showNotification(`Jail ${jailName} disabled`, 'warning');
    }
}

function restartJail(jailName) {
    showNotification(`Jail ${jailName} restarted`, 'info');
}

function viewJailLog(jailName) {
    showNotification(`Viewing log for jail: ${jailName}`, 'info');
}

function unbanAll(jailName) {
    if (confirm('Are you sure you want to unban all IPs?')) {
        showNotification('All IPs unbanned successfully', 'success');
    }
}

function unbanAll() {
    if (confirm('Are you sure you want to unban all IPs from all jails?')) {
        showNotification('All IPs unbanned from all jails', 'success');
    }
}

function refreshBannedList() {
    showNotification('Banned IP list refreshed', 'info');
}

function viewBanDetails(ip) {
    showNotification(`Viewing ban details for IP: ${ip}`, 'info');
}

function unbanIP(ip) {
    if (confirm(`Are you sure you want to unban IP: ${ip}?`)) {
        showNotification(`IP ${ip} unbanned successfully`, 'success');
    }
}

function extendBan(ip) {
    showNotification(`Ban extended for IP: ${ip}`, 'info');
}

function permanentBan(ip) {
    if (confirm(`Are you sure you want to permanently ban IP: ${ip}?`)) {
        showNotification(`IP ${ip} permanently banned`, 'warning');
    }
}

function viewLogFile(logFile) {
    showNotification(`Viewing log file: ${logFile}`, 'info');
}

function downloadLogFile(logFile) {
    showNotification(`Downloading log file: ${logFile}`, 'info');
}

function rotateLogFile(logFile) {
    if (confirm(`Are you sure you want to rotate log file: ${logFile}?`)) {
        showNotification(`Log file ${logFile} rotated`, 'info');
    }
}

function clearLogFile(logFile) {
    if (confirm(`Are you sure you want to clear log file: ${logFile}? This action cannot be undone.`)) {
        showNotification(`Log file ${logFile} cleared`, 'warning');
    }
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
