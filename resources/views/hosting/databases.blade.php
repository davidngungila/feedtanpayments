@extends('layouts.app')

@section('title', 'Website Databases')
@section('description', 'Manage website databases and database users')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">Website Databases</h5>
                    <p class="card-subtitle">Manage website databases and database users</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-success" onclick="createDatabase()">
                        <i class="bx bx-plus me-1"></i> Create Database
                    </button>
                    <button class="btn btn-outline-primary" onclick="createUser()">
                        <i class="bx bx-user-plus me-1"></i> Create User
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
                                <h4 class="mb-0">4</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-success bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-hard-drive text-success"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Size</h6>
                                <h4 class="mb-0 text-success">301.4 MB</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-info bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-table text-info"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Tables</h6>
                                <h4 class="mb-0 text-info">28</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-warning bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-user text-warning"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Database Users</h6>
                                <h4 class="mb-0 text-warning">3</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Database List -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Database Name</th>
                                <th>Size</th>
                                <th>Tables</th>
                                <th>Collation</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-data text-primary me-2"></i>
                                        <strong>example_main</strong>
                                    </div>
                                </td>
                                <td>45.2 MB</td>
                                <td>12</td>
                                <td><span class="badge bg-info">utf8mb4_unicode_ci</span></td>
                                <td>Mar 15, 2022</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a href="#" class="dropdown-item">
                                                <i class="bx bx-table me-2"></i> Browse
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="bx bx-terminal me-2"></i> Query
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="bx bx-cloud-download me-2"></i> Backup
                                            </a>
                                            <a href="#" class="dropdown-item text-warning">
                                                <i class="bx bx-wrench me-2"></i> Optimize
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item text-danger">
                                                <i class="bx bx-trash me-2"></i> Drop
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-data text-primary me-2"></i>
                                        <strong>example_users</strong>
                                    </div>
                                </td>
                                <td>12.8 MB</td>
                                <td>5</td>
                                <td><span class="badge bg-info">utf8mb4_unicode_ci</span></td>
                                <td>Mar 16, 2022</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a href="#" class="dropdown-item">
                                                <i class="bx bx-table me-2"></i> Browse
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="bx bx-terminal me-2"></i> Query
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="bx bx-cloud-download me-2"></i> Backup
                                            </a>
                                            <a href="#" class="dropdown-item text-warning">
                                                <i class="bx bx-wrench me-2"></i> Optimize
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item text-danger">
                                                <i class="bx bx-trash me-2"></i> Drop
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-data text-primary me-2"></i>
                                        <strong>example_logs</strong>
                                    </div>
                                </td>
                                <td>234.5 MB</td>
                                <td>8</td>
                                <td><span class="badge bg-info">utf8mb4_unicode_ci</span></td>
                                <td>Mar 20, 2022</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a href="#" class="dropdown-item">
                                                <i class="bx bx-table me-2"></i> Browse
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="bx bx-terminal me-2"></i> Query
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="bx bx-cloud-download me-2"></i> Backup
                                            </a>
                                            <a href="#" class="dropdown-item text-warning">
                                                <i class="bx bx-wrench me-2"></i> Optimize
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item text-danger">
                                                <i class="bx bx-trash me-2"></i> Drop
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-data text-primary me-2"></i>
                                        <strong>example_cache</strong>
                                    </div>
                                </td>
                                <td>8.9 MB</td>
                                <td>3</td>
                                <td><span class="badge bg-info">utf8mb4_unicode_ci</span></td>
                                <td>Apr 5, 2022</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a href="#" class="dropdown-item">
                                                <i class="bx bx-table me-2"></i> Browse
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="bx bx-terminal me-2"></i> Query
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="bx bx-cloud-download me-2"></i> Backup
                                            </a>
                                            <a href="#" class="dropdown-item text-warning">
                                                <i class="bx bx-wrench me-2"></i> Optimize
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item text-danger">
                                                <i class="bx bx-trash me-2"></i> Drop
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Database Users -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Database Users</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Username</th>
                                                <th>Host</th>
                                                <th>Privileges</th>
                                                <th>Created</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><strong>example_user</strong></td>
                                                <td><code>localhost</code></td>
                                                <td><span class="badge bg-success">ALL PRIVILEGES</span></td>
                                                <td>Mar 15, 2022</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a href="#" class="dropdown-item">
                                                                <i class="bx bx-edit me-2"></i> Edit
                                                            </a>
                                                            <a href="#" class="dropdown-item">
                                                                <i class="bx bx-key me-2"></i> Change Password
                                                            </a>
                                                            <div class="dropdown-divider"></div>
                                                            <a href="#" class="dropdown-item text-danger">
                                                                <i class="bx bx-trash me-2"></i> Delete
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>example_readonly</strong></td>
                                                <td><code>localhost</code></td>
                                                <td><span class="badge bg-info">SELECT</span></td>
                                                <td>Mar 16, 2022</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a href="#" class="dropdown-item">
                                                                <i class="bx bx-edit me-2"></i> Edit
                                                            </a>
                                                            <a href="#" class="dropdown-item">
                                                                <i class="bx bx-key me-2"></i> Change Password
                                                            </a>
                                                            <div class="dropdown-divider"></div>
                                                            <a href="#" class="dropdown-item text-danger">
                                                                <i class="bx bx-trash me-2"></i> Delete
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>example_backup</strong></td>
                                                <td><code>localhost</code></td>
                                                <td><span class="badge bg-warning">SELECT, LOCK TABLES</span></td>
                                                <td>Mar 22, 2022</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a href="#" class="dropdown-item">
                                                                <i class="bx bx-edit me-2"></i> Edit
                                                            </a>
                                                            <a href="#" class="dropdown-item">
                                                                <i class="bx bx-key me-2"></i> Change Password
                                                            </a>
                                                            <div class="dropdown-divider"></div>
                                                            <a href="#" class="dropdown-item text-danger">
                                                                <i class="bx bx-trash me-2"></i> Delete
                                                            </a>
                                                        </div>
                                                    </div>
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
</div>
@endsection

@push('scripts')
<script>
function createDatabase() {
    showNotification('Database creation dialog opened', 'info');
}

function createUser() {
    showNotification('User creation dialog opened', 'info');
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
