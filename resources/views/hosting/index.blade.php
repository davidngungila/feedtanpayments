@extends('layouts.app')

@section('title', 'Website Hosting')
@section('description', 'Manage all hosted websites and their configurations')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">Website Hosting</h5>
                    <p class="card-subtitle">Manage all hosted websites and their configurations</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('hosting.create') }}" class="btn btn-primary">
                        <i class="bx bx-plus me-1"></i> Add Website
                    </a>
                    <button class="btn btn-outline-success" onclick="syncWebsites()">
                        <i class="bx bx-sync me-1"></i> Sync All
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- Hosting Statistics -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-primary bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-globe text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Websites</h6>
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
                                <h6 class="mb-0">Suspended</h6>
                                <h4 class="mb-0 text-warning">1</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-info bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-user text-info"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Visitors</h6>
                                <h4 class="mb-0 text-info">11,464</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Websites Table -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Website</th>
                                <th>Server</th>
                                <th>Status</th>
                                <th>Disk Usage</th>
                                <th>Bandwidth</th>
                                <th>Visitors</th>
                                <th>SSL</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($websites as $website)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar bg-primary bg-opacity-10 rounded-circle me-2" style="width: 32px; height: 32px;">
                                            <i class="bx bx-globe text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $website['domain'] }}</h6>
                                            <small class="text-muted">Created {{ \Carbon\Carbon::parse($website['created_at'])->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $website['server'] }}</td>
                                <td>
                                    @switch($website['status'])
                                        @case('active')
                                            <span class="badge bg-success">Active</span>
                                            @break
                                        @case('suspended')
                                            <span class="badge bg-warning">Suspended</span>
                                            @break
                                        @case('disabled')
                                            <span class="badge bg-danger">Disabled</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary">{{ $website['status'] }}</span>
                                    @endswitch
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress me-2" style="width: 60px; height: 6px;">
                                            <div class="progress-bar bg-info" style="width: {{ ($website['disk_usage'] / 10) * 100 }}%"></div>
                                        </div>
                                        <small>{{ $website['disk_usage'] }} GB</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress me-2" style="width: 60px; height: 6px;">
                                            <div class="progress-bar bg-warning" style="width: {{ ($website['bandwidth'] / 100) * 100 }}%"></div>
                                        </div>
                                        <small>{{ $website['bandwidth'] }} GB</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-label-primary">{{ number_format($website['visitors']) }}</span>
                                </td>
                                <td>
                                    @switch($website['ssl_status'])
                                        @case('active')
                                            <span class="badge bg-success">Active</span>
                                            @break
                                        @case('expired')
                                            <span class="badge bg-danger">Expired</span>
                                            @break
                                        @case('none')
                                            <span class="badge bg-secondary">None</span>
                                            @break
                                        @default
                                            <span class="badge bg-warning">{{ $website['ssl_status'] }}</span>
                                    @endswitch
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a href="{{ route('hosting.show', $website['id']) }}" class="dropdown-item">
                                                <i class="bx bx-eye me-2"></i> View Details
                                            </a>
                                            <a href="{{ route('hosting.edit', $website['id']) }}" class="dropdown-item">
                                                <i class="bx bx-edit me-2"></i> Edit
                                            </a>
                                            <a href="{{ route('hosting.analytics', $website['id']) }}" class="dropdown-item">
                                                <i class="bx bx-bar-chart me-2"></i> Analytics
                                            </a>
                                            <a href="{{ route('hosting.files', $website['id']) }}" class="dropdown-item">
                                                <i class="bx bx-folder me-2"></i> File Manager
                                            </a>
                                            <a href="{{ route('hosting.databases', $website['id']) }}" class="dropdown-item">
                                                <i class="bx bx-data me-2"></i> Databases
                                            </a>
                                            <a href="{{ route('hosting.emails', $website['id']) }}" class="dropdown-item">
                                                <i class="bx bx-envelope me-2"></i> Email Accounts
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item text-success">
                                                <i class="bx bx-play me-2"></i> Enable
                                            </a>
                                            <a href="#" class="dropdown-item text-warning">
                                                <i class="bx bx-pause me-2"></i> Suspend
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
function syncWebsites() {
    const button = event.target;
    button.disabled = true;
    button.innerHTML = '<i class="bx bx-loader-alt bx-spin me-1"></i> Syncing...';
    
    setTimeout(() => {
        button.disabled = false;
        button.innerHTML = '<i class="bx bx-sync me-1"></i> Sync All';
        showNotification('Websites synchronized successfully', 'success');
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
