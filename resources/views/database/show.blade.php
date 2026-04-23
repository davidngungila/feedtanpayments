@extends('layouts.app')

@section('title', 'Database Details')
@section('description', 'View database details and information')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">Database Details</h5>
                    <p class="card-subtitle">View database details and information</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary" onclick="editDatabase()">
                        <i class="bx bx-edit me-1"></i> Edit
                    </button>
                    <button class="btn btn-outline-success" onclick="backupDatabase()">
                        <i class="bx bx-cloud-download me-1"></i> Backup
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- Database Information -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Database Information</h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm">
                                    <tbody>
                                        <tr>
                                            <td><strong>Name:</strong></td>
                                            <td>{{ $database['name'] }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Type:</strong></td>
                                            <td>{{ $database['type'] }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Version:</strong></td>
                                            <td>{{ $database['version'] }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Server:</strong></td>
                                            <td>{{ $database['server'] }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Size:</strong></td>
                                            <td>{{ $database['size'] }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Tables:</strong></td>
                                            <td>{{ $database['tables'] }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Collation:</strong></td>
                                            <td>{{ $database['collation'] }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Created:</strong></td>
                                            <td>{{ $database['created'] }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Database Statistics</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="text-center">
                                            <h4 class="text-primary">{{ $database['tables'] }}</h4>
                                            <p class="text-muted">Tables</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="text-center">
                                            <h4 class="text-success">{{ $database['size'] }}</h4>
                                            <p class="text-muted">Size</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="text-center">
                                            <h4 class="text-info">{{ $database['rows'] }}</h4>
                                            <p class="text-muted">Total Rows</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="text-center">
                                            <h4 class="text-warning">{{ $database['indexes'] }}</h4>
                                            <p class="text-muted">Indexes</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Quick Actions</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="d-grid">
                                            <button class="btn btn-outline-primary" onclick="openQuery()">
                                                <i class="bx bx-terminal me-1"></i> Query
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="d-grid">
                                            <button class="btn btn-outline-info" onclick="viewTables()">
                                                <i class="bx bx-table me-1"></i> Tables
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="d-grid">
                                            <button class="btn btn-outline-success" onclick="optimizeDatabase()">
                                                <i class="bx bx-wrench me-1"></i> Optimize
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="d-grid">
                                            <button class="btn btn-outline-warning" onclick="repairDatabase()">
                                                <i class="bx bx-tools me-1"></i> Repair
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="d-grid">
                                            <button class="btn btn-outline-secondary" onclick="analyzeDatabase()">
                                                <i class="bx bx-bar-chart me-1"></i> Analyze
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="d-grid">
                                            <button class="btn btn-outline-danger" onclick="truncateDatabase()">
                                                <i class="bx bx-trash me-1"></i> Truncate
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Recent Activity</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Activity</th>
                                                <th>User</th>
                                                <th>Time</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Database backup created</td>
                                                <td>admin</td>
                                                <td>2024-12-22 14:30:00</td>
                                                <td><span class="badge bg-success">Success</span></td>
                                            </tr>
                                            <tr>
                                                <td>Database optimized</td>
                                                <td>admin</td>
                                                <td>2024-12-22 13:15:00</td>
                                                <td><span class="badge bg-success">Success</span></td>
                                            </tr>
                                            <tr>
                                                <td>Query executed</td>
                                                <td>webuser</td>
                                                <td>2024-12-22 12:45:00</td>
                                                <td><span class="badge bg-success">Success</span></td>
                                            </tr>
                                            <tr>
                                                <td>Table created</td>
                                                <td>admin</td>
                                                <td>2024-12-22 11:30:00</td>
                                                <td><span class="badge bg-success">Success</span></td>
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
</div>
@endsection

@push('scripts')
<script>
function editDatabase() {
    showNotification('Opening database edit form...', 'info');
}

function backupDatabase() {
    if (confirm('Are you sure you want to create a backup of this database?')) {
        showNotification('Creating database backup...', 'info');
    }
}

function openQuery() {
    showNotification('Opening query interface...', 'info');
}

function viewTables() {
    showNotification('Loading database tables...', 'info');
}

function optimizeDatabase() {
    if (confirm('Are you sure you want to optimize this database?')) {
        showNotification('Optimizing database...', 'info');
    }
}

function repairDatabase() {
    if (confirm('Are you sure you want to repair this database?')) {
        showNotification('Repairing database...', 'warning');
    }
}

function analyzeDatabase() {
    if (confirm('Are you sure you want to analyze this database?')) {
        showNotification('Analyzing database...', 'info');
    }
}

function truncateDatabase() {
    if (confirm('Are you sure you want to truncate this database? This will delete all data!')) {
        if (confirm('This action cannot be undone. Are you absolutely sure?')) {
            showNotification('Truncating database...', 'danger');
        }
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
