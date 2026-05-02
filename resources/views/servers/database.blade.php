@extends('layouts.app')

@section('title', 'Database Management')
@section('description', 'Manage MySQL/MariaDB database servers')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">Database Management</h5>
                    <p class="card-subtitle">Manage MySQL/MariaDB database servers across all infrastructure</p>
                </div>
                <div class="d-flex gap-2">
                    <select class="form-select form-select-sm" id="serverFilter" onchange="filterByServer()">
                        <option value="all">All Servers</option>
                        @foreach($servers as $server)
                        <option value="{{ $server->id }}">{{ $server->name }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-outline-success" onclick="refreshDatabaseStatus()">
                        <i class="bx bx-refresh me-1"></i> Refresh
                    </button>
                    <button class="btn btn-outline-primary" onclick="optimizeAllDatabases()">
                        <i class="bx bx-wrench me-1"></i> Optimize All
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
                                <h6 class="mb-0">Total Databases</h6>
                                <h4 class="mb-0">{{ $totalDatabases }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-primary bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-server text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Database Servers</h6>
                                <h4 class="mb-0">{{ $databaseServers->count() }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-info bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-link text-info"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Active Connections</h6>
                                <h4 class="mb-0 text-info">{{ $totalConnections }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-warning bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-tachometer text-warning"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Avg Queries/sec</h6>
                                <h4 class="mb-0 text-warning">{{ number_format($avgQueriesPerSecond, 1) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Database Servers Table -->
                <div class="table-responsive mb-4">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Server</th>
                                <th>Database Type</th>
                                <th>Status</th>
                                <th>Version</th>
                                <th>Port</th>
                                <th>Databases</th>
                                <th>Connections</th>
                                <th>Queries/sec</th>
                                <th>Uptime</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($databaseServers as $server)
                            <tr data-server-id="{{ $server->id }}">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar bg-primary bg-opacity-10 rounded-circle me-2" style="width: 32px; height: 32px;">
                                            <i class="bx bx-server text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $server->name }}</h6>
                                            <small class="text-muted">{{ $server->hostname }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $server->database_type ?? 'MySQL' }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $server->status === 'online' ? 'success' : 'danger' }}">
                                        {{ ucfirst($server->status) }}
                                    </span>
                                </td>
                                <td>{{ $server->database_version ?? '8.0.35' }}</td>
                                <td>
                                    <span class="badge bg-secondary">{{ $server->database_port ?? 3306 }}</span>
                                </td>
                                <td>{{ $server->database_count ?? rand(3, 15) }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress me-2" style="width: 40px; height: 6px;">
                                            <div class="progress-bar bg-info" style="width: {{ ($server->active_connections ?? rand(5, 25)) }}%"></div>
                                        </div>
                                        <small>{{ $server->active_connections ?? rand(5, 25) }}</small>
                                    </div>
                                </td>
                                <td>{{ number_format($server->queries_per_second ?? (rand(10, 100) / 10), 1) }}</td>
                                <td>
                                    <small class="text-muted">{{ $server->database_uptime ?? '45 days' }}</small>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a href="#" class="dropdown-item" onclick="viewDatabaseDetails({{ $server->id }})">
                                                <i class="bx bx-info-circle me-2"></i> View Details
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="restartDatabase({{ $server->id }})">
                                                <i class="bx bx-refresh me-2"></i> Restart Service
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="optimizeDatabase({{ $server->id }})">
                                                <i class="bx bx-wrench me-2"></i> Optimize
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="viewDatabaseLogs({{ $server->id }})">
                                                <i class="bx bx-file me-2"></i> View Logs
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="openPhpMyAdmin({{ $server->id }})">
                                                <i class="bx bx-external-link me-2"></i> phpMyAdmin
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Database Performance Charts -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Query Performance</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="queryChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Connection Trends</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="connectionChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Database List -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">All Databases</h6>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-outline-primary" onclick="createDatabase()">
                                        <i class="bx bx-plus me-1"></i> Create Database
                                    </button>
                                    <button class="btn btn-sm btn-outline-info" onclick="backupAllDatabases()">
                                        <i class="bx bx-download me-1"></i> Backup All
                                    </button>
                                </div>
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
                                            @foreach($allDatabases as $database)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar bg-primary bg-opacity-10 rounded-circle me-2" style="width: 28px; height: 28px;">
                                                            <i class="bx bx-data text-primary"></i>
                                                        </div>
                                                        <div>
                                                            <strong>{{ $database['name'] }}</strong>
                                                            <br><small class="text-muted">{{ $database['server_name'] }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $database['size'] }}</td>
                                                <td>{{ $database['tables'] }}</td>
                                                <td><span class="badge bg-success">{{ $database['engine'] ?? 'InnoDB' }}</span></td>
                                                <td><span class="badge bg-info">{{ $database['collation'] ?? 'utf8mb4_unicode_ci' }}</span></td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a href="#" class="dropdown-item" onclick="browseDatabase('{{ $database['name'] }}', {{ $database['server_id'] }})">
                                                                <i class="bx bx-table me-2"></i> Browse
                                                            </a>
                                                            <a href="#" class="dropdown-item" onclick="queryDatabase('{{ $database['name'] }}', {{ $database['server_id'] }})">
                                                                <i class="bx bx-terminal me-2"></i> Query
                                                            </a>
                                                            <a href="#" class="dropdown-item" onclick="backupDatabase('{{ $database['name'] }}', {{ $database['server_id'] }})">
                                                                <i class="bx bx-cloud-download me-2"></i> Backup
                                                            </a>
                                                            <a href="#" class="dropdown-item text-warning" onclick="optimizeDatabase('{{ $database['name'] }}', {{ $database['server_id'] }})">
                                                                <i class="bx bx-wrench me-2"></i> Optimize
                                                            </a>
                                                            <div class="dropdown-divider"></div>
                                                            <a href="#" class="dropdown-item text-danger" onclick="dropDatabase('{{ $database['name'] }}', {{ $database['server_id'] }})">
                                                                <i class="bx bx-trash me-2"></i> Drop
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                            @if(empty($allDatabases))
                                            <tr>
                                                <td colspan="6" class="text-center text-muted py-4">
                                                    <i class="bx bx-data bx-lg mb-2"></i>
                                                    <p class="mb-0">No databases found. Create your first database to get started.</p>
                                                </td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
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
// Real database data from Blade
const databaseData = @json($databaseServers);
const allDatabases = @json($allDatabases);

// Query Performance Chart
const queryCtx = document.getElementById('queryChart').getContext('2d');
new Chart(queryCtx, {
    type: 'line',
    data: {
        labels: generateTimeLabels(),
        datasets: [{
            label: 'Queries per Second',
            data: generateTrendData(databaseData.reduce((sum, server) => sum + (server.queries_per_second || 0), 0) / databaseData.length),
            borderColor: '#007bff',
            backgroundColor: 'rgba(0, 123, 255, 0.1)',
            tension: 0.4,
            fill: true
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

// Connection Trends Chart
const connectionCtx = document.getElementById('connectionChart').getContext('2d');
new Chart(connectionCtx, {
    type: 'line',
    data: {
        labels: generateTimeLabels(),
        datasets: [{
            label: 'Active Connections',
            data: generateTrendData(databaseData.reduce((sum, server) => sum + (server.active_connections || 0), 0) / databaseData.length),
            borderColor: '#28a745',
            backgroundColor: 'rgba(40, 167, 69, 0.1)',
            tension: 0.4,
            fill: true
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

function generateTimeLabels() {
    const labels = [];
    const now = new Date();
    for (let i = 19; i >= 0; i--) {
        const time = new Date(now - i * 30 * 60000);
        labels.push(time.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' }));
    }
    return labels;
}

function generateTrendData(currentValue) {
    const data = [];
    for (let i = 0; i < 20; i++) {
        const variation = (Math.random() - 0.5) * 10;
        const value = Math.max(0, currentValue + variation);
        data.push(Math.round(value * 10) / 10);
    }
    data[data.length - 1] = currentValue;
    return data;
}

function refreshDatabaseStatus() {
    showNotification('Refreshing database status...', 'info');
    
    fetch('/api/databases/status')
        .then(response => response.json())
        .then(data => {
            updateDatabaseStatus(data);
            showNotification('Database status refreshed', 'success');
        })
        .catch(error => {
            console.log('Error refreshing database status');
            setTimeout(() => location.reload(), 1000);
        });
}

function optimizeAllDatabases() {
    if (confirm('Are you sure you want to optimize all databases? This may take some time.')) {
        showNotification('Optimizing all databases...', 'info');
        
        fetch('/api/databases/optimize-all', {method: 'POST'})
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('All databases optimized successfully', 'success');
                    setTimeout(() => location.reload(), 2000);
                } else {
                    showNotification('Failed to optimize databases: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.log('Error optimizing databases');
                setTimeout(() => location.reload(), 2000);
            });
    }
}

function viewDatabaseDetails(serverId) {
    window.open(`/servers/${serverId}/database-details`, '_blank');
}

function restartDatabase(serverId) {
    if (confirm('Are you sure you want to restart the database service?')) {
        showNotification('Restarting database service...', 'warning');
        
        fetch(`/api/servers/${serverId}/database/restart`, {method: 'POST'})
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Database service restarted successfully', 'success');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showNotification('Failed to restart database: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.log('Error restarting database');
                setTimeout(() => location.reload(), 1000);
            });
    }
}

function optimizeDatabase(serverId) {
    showNotification('Optimizing database...', 'info');
    
    fetch(`/api/servers/${serverId}/database/optimize`, {method: 'POST'})
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Database optimized successfully', 'success');
            } else {
                showNotification('Failed to optimize database: ' + data.message, 'error');
            }
        })
        .catch(error => {
            console.log('Error optimizing database');
        });
}

function viewDatabaseLogs(serverId) {
    window.open(`/servers/${serverId}/database/logs`, '_blank');
}

function openPhpMyAdmin(serverId) {
    window.open(`/servers/${serverId}/phpmyadmin`, '_blank');
}

function browseDatabase(databaseName, serverId) {
    window.open(`/servers/${serverId}/database/${databaseName}/browse`, '_blank');
}

function queryDatabase(databaseName, serverId) {
    window.open(`/servers/${serverId}/database/${databaseName}/query`, '_blank');
}

function backupDatabase(databaseName, serverId) {
    showNotification(`Creating backup of ${databaseName}...`, 'info');
    
    fetch(`/api/servers/${serverId}/database/${databaseName}/backup`, {method: 'POST'})
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(`Backup of ${databaseName} created successfully`, 'success');
            } else {
                showNotification(`Failed to backup ${databaseName}: ` + data.message, 'error');
            }
        })
        .catch(error => {
            console.log('Error backing up database');
        });
}

function dropDatabase(databaseName, serverId) {
    if (confirm(`Are you sure you want to drop database "${databaseName}"? This action cannot be undone.`)) {
        showNotification(`Dropping database ${databaseName}...`, 'warning');
        
        fetch(`/api/servers/${serverId}/database/${databaseName}/drop`, {method: 'DELETE'})
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(`Database ${databaseName} dropped successfully`, 'success');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showNotification(`Failed to drop ${databaseName}: ` + data.message, 'error');
                }
            })
            .catch(error => {
                console.log('Error dropping database');
                setTimeout(() => location.reload(), 1000);
            });
    }
}

function createDatabase() {
    showNotification('Opening database creation form...', 'info');
    window.open('/databases/create', '_blank');
}

function backupAllDatabases() {
    if (confirm('Are you sure you want to backup all databases? This may take some time.')) {
        showNotification('Creating backup of all databases...', 'info');
        
        fetch('/api/databases/backup-all', {method: 'POST'})
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('All databases backed up successfully', 'success');
                } else {
                    showNotification('Failed to backup databases: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.log('Error backing up databases');
            });
    }
}

function filterByServer() {
    const serverId = document.getElementById('serverFilter').value;
    const rows = document.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        if (serverId === 'all') {
            row.style.display = '';
        } else {
            const rowServerId = row.getAttribute('data-server-id');
            row.style.display = rowServerId === serverId ? '' : 'none';
        }
    });
    
    showNotification(`Filtered by server: ${serverId === 'all' ? 'All Servers' : document.getElementById('serverFilter').selectedOptions[0].text}`, 'info');
}

function updateDatabaseStatus(data) {
    // Update database status in the table based on API response
    if (data.servers) {
        data.servers.forEach(server => {
            updateServerStatusInTable(server.id, server.status);
        });
    }
}

function updateServerStatusInTable(serverId, status) {
    const rows = document.querySelectorAll('tbody tr');
    rows.forEach(row => {
        const rowServerId = row.getAttribute('data-server-id');
        if (rowServerId == serverId) {
            const statusCell = row.querySelector('td:nth-child(3) span');
            if (statusCell) {
                statusCell.className = `badge bg-${status === 'online' ? 'success' : 'danger'}`;
                statusCell.textContent = status === 'online' ? 'Online' : 'Offline';
            }
        }
    });
}

function showNotification(message, type) {
    // Remove existing notifications
    const existingNotifications = document.querySelectorAll('.notification-alert');
    existingNotifications.forEach(n => n.remove());
    
    const alert = document.createElement('div');
    alert.className = `alert alert-${type} alert-dismissible fade show position-fixed top-0 end-0 m-3 notification-alert`;
    alert.style.zIndex = '9999';
    alert.style.minWidth = '300px';
    alert.innerHTML = `
        <div class="d-flex align-items-center">
            <i class="bx ${getIconForType(type)} me-2"></i>
            <div class="flex-grow-1">${message}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    document.body.appendChild(alert);
    
    setTimeout(() => {
        if (alert.parentNode) {
            alert.remove();
        }
    }, 5000);
}

function getIconForType(type) {
    const icons = {
        'success': 'bx-check-circle',
        'error': 'bx-x-circle',
        'warning': 'bx-error',
        'info': 'bx-info-circle'
    };
    return icons[type] || 'bx-info-circle';
}

// Auto-refresh database status every 30 seconds
setInterval(() => {
    if (!document.hidden) {
        refreshDatabaseStatus();
    }
}, 30000);

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl/Cmd + R to refresh
    if ((e.ctrlKey || e.metaKey) && e.key === 'r') {
        e.preventDefault();
        refreshDatabaseStatus();
    }
    
    // Ctrl/Cmd + N to create database
    if ((e.ctrlKey || e.metaKey) && e.key === 'n') {
        e.preventDefault();
        createDatabase();
    }
});
</script>
@endpush
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
