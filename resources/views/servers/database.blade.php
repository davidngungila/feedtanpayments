@extends('layouts.app')

@section('title', 'Database Management')
@section('description', 'Manage MySQL/MariaDB database server')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">{{ $db_config['type'] }} Database Server</h5>
                    <p class="card-subtitle">Manage {{ $db_config['type'] }} database server configuration and performance</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-success" onclick="restartDatabase()">
                        <i class="bx bx-refresh me-1"></i> Restart
                    </button>
                    <button class="btn btn-outline-primary" onclick="optimizeDatabase()">
                        <i class="bx bx-wrench me-1"></i> Optimize
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- Database Overview -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-success bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-data text-success"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Status</h6>
                                <h4 class="mb-0 text-success">{{ $db_config['status'] }}</h4>
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
                                <h4 class="mb-0">{{ $db_config['version'] }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-info bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-link text-info"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Connections</h6>
                                <h4 class="mb-0 text-info">{{ $db_config['connections']['active'] }}/{{ $db_config['connections']['max'] }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-warning bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-tachometer text-warning"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Queries/sec</h6>
                                <h4 class="mb-0 text-warning">{{ $db_config['queries']['per_second'] }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Connection Statistics -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Connection Statistics</h6>
                            </div>
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-4">
                                        <h4 class="text-success mb-0">{{ $db_config['connections']['active'] }}</h4>
                                        <small class="text-muted">Active</small>
                                    </div>
                                    <div class="col-4">
                                        <h4 class="text-primary mb-0">{{ $db_config['connections']['max'] }}</h4>
                                        <small class="text-muted">Max</small>
                                    </div>
                                    <div class="col-4">
                                        <h4 class="text-info mb-0">{{ number_format($db_config['connections']['total']) }}</h4>
                                        <small class="text-muted">Total</small>
                                    </div>
                                </div>
                                <div class="progress mt-3" style="height: 10px;">
                                    <div class="progress-bar bg-info" style="width: {{ ($db_config['connections']['active'] / $db_config['connections']['max']) * 100 }}%"></div>
                                </div>
                                <small class="text-muted">Connection Usage: {{ round(($db_config['connections']['active'] / $db_config['connections']['max']) * 100, 1) }}%</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Query Statistics</h6>
                            </div>
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-4">
                                        <h4 class="text-primary mb-0">{{ $db_config['queries']['per_second'] }}</h4>
                                        <small class="text-muted">Queries/sec</small>
                                    </div>
                                    <div class="col-4">
                                        <h4 class="text-warning mb-0">{{ $db_config['queries']['slow_queries'] }}</h4>
                                        <small class="text-muted">Slow Queries</small>
                                    </div>
                                    <div class="col-4">
                                        <h4 class="text-info mb-0">{{ number_format($db_config['queries']['total_queries']) }}</h4>
                                        <small class="text-muted">Total Queries</small>
                                    </div>
                                </div>
                                @if($db_config['queries']['slow_queries'] > 0)
                                <div class="alert alert-warning mt-3 mb-0">
                                    <small><i class="bx bx-alert me-1"></i> {{ $db_config['queries']['slow_queries'] }} slow queries detected. Consider optimizing your queries.</small>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Database List -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Databases</h6>
                                <button class="btn btn-sm btn-outline-primary" onclick="createDatabase()">
                                    <i class="bx bx-plus me-1"></i> Create Database
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Database Name</th>
                                                <th>Size</th>
                                                <th>Tables</th>
                                                <th>Engine</th>
                                                <th>Collation</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($db_config['databases'] as $database)
                                            <tr>
                                                <td><strong>{{ $database['name'] }}</strong></td>
                                                <td>{{ $database['size'] }}</td>
                                                <td>{{ $database['tables'] }}</td>
                                                <td><span class="badge bg-success">InnoDB</span></td>
                                                <td><span class="badge bg-info">utf8mb4_unicode_ci</span></td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a href="#" class="dropdown-item" onclick="browseDatabase('{{ $database['name'] }}')">
                                                                <i class="bx bx-table me-2"></i> Browse
                                                            </a>
                                                            <a href="#" class="dropdown-item" onclick="queryDatabase('{{ $database['name'] }}')">
                                                                <i class="bx bx-terminal me-2"></i> Query
                                                            </a>
                                                            <a href="#" class="dropdown-item" onclick="backupDatabase('{{ $database['name'] }}')">
                                                                <i class="bx bx-cloud-download me-2"></i> Backup
                                                            </a>
                                                            <a href="#" class="dropdown-item text-warning" onclick="optimizeDatabase('{{ $database['name'] }}')">
                                                                <i class="bx bx-wrench me-2"></i> Optimize
                                                            </a>
                                                            <div class="dropdown-divider"></div>
                                                            <a href="#" class="dropdown-item text-danger" onclick="dropDatabase('{{ $database['name'] }}')">
                                                                <i class="bx bx-trash me-2"></i> Drop
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

                <!-- Performance Metrics -->
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

                <!-- Configuration -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Memory Configuration</h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="text-muted" style="width: 150px;">Buffer Pool Size:</td>
                                        <td><strong>{{ $db_config['performance']['buffer_pool_size'] }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Key Buffer Size:</td>
                                        <td><strong>{{ $db_config['performance']['key_buffer_size'] }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">InnoDB Buffer Pool:</td>
                                        <td><strong>{{ $db_config['performance']['innodb_buffer_pool'] }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Query Cache Size:</td>
                                        <td><strong>{{ $db_config['performance']['query_cache_size'] }}</strong></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Server Information</h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="text-muted" style="width: 150px;">Uptime:</td>
                                        <td><strong>{{ $db_config['uptime'] }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Port:</td>
                                        <td><strong>{{ $db_config['port'] }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Socket:</td>
                                        <td><strong>/var/run/mysqld/mysqld.sock</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Data Directory:</td>
                                        <td><strong>/var/lib/mysql</strong></td>
                                    </tr>
                                </table>
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
                label: 'Queries/sec',
                data: [42, 45, 48, 44, 46, 45, 47, 45, 45, 45],
                borderColor: '#28a745',
                backgroundColor: 'rgba(40, 167, 69, 0.1)',
                tension: 0.4,
                yAxisID: 'y'
            },
            {
                label: 'Active Connections',
                data: [8, 10, 12, 11, 13, 12, 11, 12, 12, 12],
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
                    text: 'Queries/sec'
                }
            },
            y1: {
                type: 'linear',
                display: true,
                position: 'right',
                title: {
                    display: true,
                    text: 'Connections'
                },
                grid: {
                    drawOnChartArea: false,
                },
            },
        }
    }
});

function restartDatabase() {
    if (confirm('Are you sure you want to restart the database server? This will interrupt all connections.')) {
        showNotification('Database server restart initiated', 'warning');
    }
}

function optimizeDatabase() {
    showNotification('Database optimization in progress...', 'info');
}

function createDatabase() {
    showNotification('Opening database creation wizard...', 'info');
}

function browseDatabase(dbName) {
    showNotification(`Browsing database: ${dbName}`, 'info');
}

function queryDatabase(dbName) {
    showNotification(`Opening query interface for: ${dbName}`, 'info');
}

function backupDatabase(dbName) {
    showNotification(`Starting backup for: ${dbName}`, 'info');
}

function optimizeDatabase(dbName) {
    showNotification(`Optimizing database: ${dbName}`, 'info');
}

function dropDatabase(dbName) {
    if (confirm(`Are you sure you want to drop database "${dbName}"? This action cannot be undone.`)) {
        showNotification(`Dropping database: ${dbName}`, 'danger');
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
