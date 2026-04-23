@extends('layouts.app')

@section('title', 'PHP-FPM Management')
@section('description', 'Manage PHP-FPM process manager and configuration')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">PHP-FPM Manager</h5>
                    <p class="card-subtitle">Manage PHP-FPM process manager and configuration</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-success" onclick="restartPHPFPM()">
                        <i class="bx bx-refresh me-1"></i> Restart
                    </button>
                    <button class="btn btn-outline-primary" onclick="reloadConfig()">
                        <i class="bx bx-sync me-1"></i> Reload Config
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- PHP-FPM Overview -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-success bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-code text-success"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Status</h6>
                                <h4 class="mb-0 text-success">{{ $phpfpm_config['status'] }}</h4>
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
                                <h4 class="mb-0">{{ $phpfpm_config['version'] }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-info bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-tachometer text-info"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Requests/sec</h6>
                                <h4 class="mb-0 text-info">{{ $phpfpm_config['requests_per_second'] }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-warning bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-memory text-warning"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Memory Usage</h6>
                                <h4 class="mb-0 text-warning">{{ $phpfpm_config['memory_usage'] }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Process Manager Configuration -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Process Manager</h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="text-muted" style="width: 150px;">Manager Type:</td>
                                        <td><strong>{{ $phpfpm_config['process_manager'] }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Max Children:</td>
                                        <td><strong>{{ $phpfpm_config['max_children'] }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Active Processes:</td>
                                        <td><strong>{{ $phpfpm_config['active_processes'] }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Idle Processes:</td>
                                        <td><strong>{{ $phpfpm_config['idle_processes'] }}</strong></td>
                                    </tr>
                                </table>
                                <div class="progress mt-3" style="height: 8px;">
                                    <div class="progress-bar bg-info" style="width: {{ ($phpfpm_config['active_processes'] / $phpfpm_config['max_children']) * 100 }}%"></div>
                                </div>
                                <small class="text-muted">Process Usage: {{ round(($phpfpm_config['active_processes'] / $phpfpm_config['max_children']) * 100, 1) }}%</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Performance Metrics</h6>
                            </div>
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-4">
                                        <h4 class="text-primary mb-0">{{ $phpfpm_config['active_processes'] }}</h4>
                                        <small class="text-muted">Active</small>
                                    </div>
                                    <div class="col-4">
                                        <h4 class="text-success mb-0">{{ $phpfpm_config['idle_processes'] }}</h4>
                                        <small class="text-muted">Idle</small>
                                    </div>
                                    <div class="col-4">
                                        <h4 class="text-info mb-0">{{ $phpfpm_config['requests_per_second'] }}</h4>
                                        <small class="text-muted">Req/sec</small>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <small class="text-muted">Total Memory Usage: {{ $phpfpm_config['memory_usage'] }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- PHP-FPM Pools -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">PHP-FPM Pools</h6>
                                <button class="btn btn-sm btn-outline-primary" onclick="addPool()">
                                    <i class="bx bx-plus me-1"></i> Add Pool
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Pool Name</th>
                                                <th>Status</th>
                                                <th>Processes</th>
                                                <th>Max Children</th>
                                                <th>Listen</th>
                                                <th>Owner</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($phpfpm_config['pools'] as $pool)
                                            <tr>
                                                <td><strong>{{ $pool['name'] }}</strong></td>
                                                <td>
                                                    <span class="badge bg-{{ $pool['status'] == 'active' ? 'success' : 'danger' }}">
                                                        {{ $pool['status'] }}
                                                    </span>
                                                </td>
                                                <td>{{ $pool['processes'] }}</td>
                                                <td>{{ $pool['max_children'] }}</td>
                                                <td><code>/run/php/php{{ $phpfpm_config['version'] }}-{{ $pool['name'] }}.sock</code></td>
                                                <td><code>www-data</code></td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a href="#" class="dropdown-item" onclick="editPool('{{ $pool['name'] }}')">
                                                                <i class="bx bx-edit me-2"></i> Edit
                                                            </a>
                                                            <a href="#" class="dropdown-item text-warning" onclick="restartPool('{{ $pool['name'] }}')">
                                                                <i class="bx bx-refresh me-2"></i> Restart
                                                            </a>
                                                            <a href="#" class="dropdown-item" onclick="viewPoolStatus('{{ $pool['name'] }}')">
                                                                <i class="bx bx-bar-chart me-2"></i> Status
                                                            </a>
                                                            <a href="#" class="dropdown-item" onclick="viewPoolConfig('{{ $pool['name'] }}')">
                                                                <i class="bx bx-file me-2"></i> Config
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

                <!-- OPcache Configuration -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">OPcache Status</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <div class="text-center">
                                                    <h4 class="text-success mb-0">{{ $phpfpm_config['opcache']['enabled'] ? 'Enabled' : 'Disabled' }}</h4>
                                                    <small class="text-muted">Status</small>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="text-center">
                                                    <h4 class="text-primary mb-0">{{ $phpfpm_config['opcache']['memory_usage'] }}</h4>
                                                    <small class="text-muted">Memory Usage</small>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="text-center">
                                                    <h4 class="text-info mb-0">{{ $phpfpm_config['opcache']['hit_rate'] }}</h4>
                                                    <small class="text-muted">Hit Rate</small>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="text-center">
                                                    <h4 class="text-warning mb-0">{{ number_format($phpfpm_config['opcache']['cached_scripts']) }}</h4>
                                                    <small class="text-muted">Cached Scripts</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="progress" style="height: 10px;">
                                            <div class="progress-bar bg-success" style="width: {{ floatval(str_replace('%', '', $phpfpm_config['opcache']['hit_rate'])) }}%"></div>
                                        </div>
                                        <small class="text-muted">Cache Efficiency: {{ $phpfpm_config['opcache']['hit_rate'] }}</small>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-center">
                                            <h6 class="mb-2">Cache Statistics</h6>
                                            <div class="row">
                                                <div class="col-6">
                                                    <small class="text-muted">Hits:</small><br>
                                                    <strong>{{ number_format($phpfpm_config['opcache']['cached_scripts'] - $phpfpm_config['opcache']['misses']) }}</strong>
                                                </div>
                                                <div class="col-6">
                                                    <small class="text-muted">Misses:</small><br>
                                                    <strong>{{ $phpfpm_config['opcache']['misses'] }}</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Performance Chart -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Performance Metrics</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="performanceChart" height="100"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- PHP Extensions -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Loaded Extensions</h6>
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($phpfpm_config['extensions'] as $extension)
                                    <span class="badge bg-primary">{{ $extension }}</span>
                                    @endforeach
                                </div>
                                <div class="mt-3">
                                    <small class="text-muted">Total Extensions: {{ count($phpfpm_config['extensions']) }}</small>
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
// Performance Chart
const performanceCtx = document.getElementById('performanceChart').getContext('2d');
new Chart(performanceCtx, {
    type: 'line',
    data: {
        labels: ['10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00', '13:30', '14:00', '14:30'],
        datasets: [
            {
                label: 'Requests/sec',
                data: [142, 148, 155, 152, 158, 156, 154, 157, 156, 156],
                borderColor: '#28a745',
                backgroundColor: 'rgba(40, 167, 69, 0.1)',
                tension: 0.4,
                yAxisID: 'y'
            },
            {
                label: 'Active Processes',
                data: [6, 7, 8, 7, 9, 8, 8, 8, 8, 8],
                borderColor: '#007bff',
                backgroundColor: 'rgba(0, 123, 255, 0.1)',
                tension: 0.4,
                yAxisID: 'y1'
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: {
            mode: 'index',
            intersect: false,
        },
        scales: {
            y: {
                type: 'linear',
                display: true,
                position: 'left',
                title: {
                    display: true,
                    text: 'Requests/sec'
                }
            },
            y1: {
                type: 'linear',
                display: true,
                position: 'right',
                title: {
                    display: true,
                    text: 'Processes'
                },
                grid: {
                    drawOnChartArea: false,
                },
            },
        }
    }
});

function restartPHPFPM() {
    if (confirm('Are you sure you want to restart PHP-FPM? This will interrupt all PHP requests.')) {
        showNotification('PHP-FPM restart initiated', 'warning');
    }
}

function reloadConfig() {
    showNotification('Reloading PHP-FPM configuration...', 'info');
}

function addPool() {
    showNotification('Opening pool creation wizard...', 'info');
}

function editPool(poolName) {
    showNotification(`Editing pool: ${poolName}`, 'info');
}

function restartPool(poolName) {
    if (confirm(`Are you sure you want to restart pool "${poolName}"?`)) {
        showNotification(`Restarting pool: ${poolName}`, 'warning');
    }
}

function viewPoolStatus(poolName) {
    showNotification(`Viewing status for pool: ${poolName}`, 'info');
}

function viewPoolConfig(poolName) {
    showNotification(`Viewing configuration for pool: ${poolName}`, 'info');
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
