@extends('layouts.app')

@section('title', 'Database Management')
@section('description', 'Manage MySQL and PostgreSQL databases')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">Database Management</h5>
                    <p class="card-subtitle">Manage MySQL and PostgreSQL databases</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('database.create') }}" class="btn btn-primary">
                        <i class="bx bx-plus me-1"></i> Add Database
                    </a>
                    <button class="btn btn-outline-success" onclick="syncDatabases()">
                        <i class="bx bx-sync me-1"></i> Sync All
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- Database Statistics -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-primary bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-data text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Databases</h6>
                                <h4 class="mb-0">5</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-success bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-check-circle text-success"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Active</h6>
                                <h4 class="mb-0 text-success">4</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-warning bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-alert text-warning"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Maintenance</h6>
                                <h4 class="mb-0 text-warning">1</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-info bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-hard-drive text-info"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Size</h6>
                                <h4 class="mb-0 text-info">538.5 MB</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Databases Table -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Database Name</th>
                                <th>Server</th>
                                <th>Type</th>
                                <th>Version</th>
                                <th>Size</th>
                                <th>Tables</th>
                                <th>Users</th>
                                <th>Status</th>
                                <th>Backup</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($databases as $database)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar bg-primary bg-opacity-10 rounded-circle me-2" style="width: 32px; height: 32px;">
                                            <i class="bx bx-data text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $database['name'] }}</h6>
                                            <small class="text-muted">Created {{ \Carbon\Carbon::parse($database['created_at'])->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $database['server'] }}</td>
                                <td>
                                    <span class="badge bg-label-{{ $database['type'] == 'MySQL' ? 'success' : 'info' }}">
                                        {{ $database['type'] }}
                                    </span>
                                </td>
                                <td>{{ $database['version'] }}</td>
                                <td>{{ $database['size'] }}</td>
                                <td>{{ $database['tables'] }}</td>
                                <td>{{ $database['users'] }}</td>
                                <td>
                                    @switch($database['status'])
                                        @case('active')
                                            <span class="badge bg-success">Active</span>
                                            @break
                                        @case('maintenance')
                                            <span class="badge bg-warning">Maintenance</span>
                                            @break
                                        @case('disabled')
                                            <span class="badge bg-danger">Disabled</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary">{{ $database['status'] }}</span>
                                    @endswitch
                                </td>
                                <td>
                                    @if($database['backup_enabled'])
                                        <span class="badge bg-success">Enabled</span>
                                    @else
                                        <span class="badge bg-danger">Disabled</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a href="{{ route('database.show', $database['id']) }}" class="dropdown-item">
                                                <i class="bx bx-eye me-2"></i> View Details
                                            </a>
                                            <a href="{{ route('database.edit', $database['id']) }}" class="dropdown-item">
                                                <i class="bx bx-edit me-2"></i> Edit
                                            </a>
                                            <a href="{{ route('database.query', $database['id']) }}" class="dropdown-item">
                                                <i class="bx bx-terminal me-2"></i> Query
                                            </a>
                                            <a href="{{ route('database.backup', $database['id']) }}" class="dropdown-item">
                                                <i class="bx bx-cloud-download me-2"></i> Backups
                                            </a>
                                            <a href="{{ route('database.users', $database['id']) }}" class="dropdown-item">
                                                <i class="bx bx-user me-2"></i> Users
                                            </a>
                                            <a href="{{ route('database.performance', $database['id']) }}" class="dropdown-item">
                                                <i class="bx bx-line-chart me-2"></i> Performance
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item text-success">
                                                <i class="bx bx-play me-2"></i> Start
                                            </a>
                                            <a href="#" class="dropdown-item text-warning">
                                                <i class="bx bx-pause me-2"></i> Stop
                                            </a>
                                            <a href="#" class="dropdown-item text-info">
                                                <i class="bx bx-refresh me-2"></i> Restart
                                            </a>
                                            <a href="#" class="dropdown-item text-danger">
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
@endsection

@push('scripts')
<script>
function syncDatabases() {
    const button = event.target;
    button.disabled = true;
    button.innerHTML = '<i class="bx bx-loader-alt bx-spin me-1"></i> Syncing...';
    
    setTimeout(() => {
        button.disabled = false;
        button.innerHTML = '<i class="bx bx-sync me-1"></i> Sync All';
        showNotification('Databases synchronized successfully', 'success');
    }, 2000);
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
