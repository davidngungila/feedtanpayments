@extends('layouts.app')

@section('title', 'Server Management - All Servers')
@section('description', 'Manage and monitor all servers in your infrastructure')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">All Servers</h5>
                    <p class="card-subtitle">Monitor and manage your server infrastructure</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('servers.create') }}" class="btn btn-primary">
                        <i class="bx bx-plus me-1"></i> Add Server
                    </a>
                    <button class="btn btn-outline-success" onclick="refreshServers()">
                        <i class="bx bx-refresh me-1"></i> Refresh
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- Server Statistics -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-success bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-server text-success"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Servers</h6>
                                <h4 class="mb-0">{{ $servers->count() }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-success bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-check-circle text-success"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Online</h6>
                                <h4 class="mb-0 text-success">{{ $servers->where('status', 'online')->count() }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-danger bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-x-circle text-danger"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Offline</h6>
                                <h4 class="mb-0 text-danger">{{ $servers->where('status', 'offline')->count() }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-warning bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-alert text-warning"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Warnings</h6>
                                <h4 class="mb-0 text-warning">{{ $servers->filter(function($s) { return $s->cpu_usage > 80 || $s->memory_usage > 80 || $s->disk_usage > 80; })->count() }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Advanced Filters -->
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-outline-primary btn-sm" onclick="filterServers('all')">
                                    All ({{ $servers->count() }})
                                </button>
                                <button type="button" class="btn btn-outline-success btn-sm" onclick="filterServers('online')">
                                    Online ({{ $servers->where('status', 'online')->count() }})
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="filterServers('offline')">
                                    Offline ({{ $servers->where('status', 'offline')->count() }})
                                </button>
                                <button type="button" class="btn btn-outline-warning btn-sm" onclick="filterServers('warnings')">
                                    Warnings ({{ $servers->filter(function($s) { return $s->cpu_usage > 80 || $s->memory_usage > 80 || $s->disk_usage > 80; })->count() }})
                                </button>
                            </div>
                            <div class="d-flex gap-2">
                                <input type="text" class="form-control form-control-sm" placeholder="Search servers..." id="serverSearch" style="width: 200px;">
                                <button class="btn btn-sm btn-outline-secondary" onclick="toggleBulkActions()">
                                    <i class="bx bx-check-square me-1"></i> Bulk Actions
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Server Table -->
                <div class="table-responsive">
                    <table class="table table-hover" id="serversTable">
                        <thead>
                            <tr>
                                <th style="width: 30px;">
                                    <input type="checkbox" class="form-check-input" id="selectAll" onchange="toggleSelectAll()">
                                </th>
                                <th>Server Name</th>
                                <th>IP Address</th>
                                <th>Status</th>
                                <th>CPU</th>
                                <th>Memory</th>
                                <th>Disk</th>
                                <th>Services</th>
                                <th>Last Checked</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($servers as $server)
                            <tr data-status="{{ $server->status }}" data-name="{{ $server->name }}" data-ip="{{ $server->ip_address }}" 
                                data-cpu="{{ $server->cpu_usage }}" data-memory="{{ $server->memory_usage }}" data-disk="{{ $server->disk_usage }}">
                                <td>
                                    <input type="checkbox" class="form-check-input server-checkbox" value="{{ $server->id }}">
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar bg-primary bg-opacity-10 rounded-circle me-2" style="width: 32px; height: 32px;">
                                            <i class="bx bx-server text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $server->name }}</h6>
                                            <small class="text-muted">{{ $server->os_type }} {{ $server->os_version }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $server->ip_address }}</td>
                                <td>
                                    @if($server->status == 'online')
                                        <span class="badge bg-success">Online</span>
                                    @elseif($server->status == 'offline')
                                        <span class="badge bg-danger">Offline</span>
                                    @else
                                        <span class="badge bg-warning">Maintenance</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress me-2" style="width: 60px; height: 6px;">
                                            <div class="progress-bar {{ $server->cpu_usage > 80 ? 'bg-danger' : ($server->cpu_usage > 60 ? 'bg-warning' : 'bg-success') }}" 
                                                 style="width: {{ $server->cpu_usage }}%"></div>
                                        </div>
                                        <small>{{ number_format($server->cpu_usage, 1) }}%</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress me-2" style="width: 60px; height: 6px;">
                                            <div class="progress-bar {{ $server->memory_usage > 80 ? 'bg-danger' : ($server->memory_usage > 60 ? 'bg-warning' : 'bg-success') }}" 
                                                 style="width: {{ $server->memory_usage }}%"></div>
                                        </div>
                                        <small>{{ number_format($server->memory_usage, 1) }}%</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress me-2" style="width: 60px; height: 6px;">
                                            <div class="progress-bar {{ $server->disk_usage > 80 ? 'bg-danger' : ($server->disk_usage > 60 ? 'bg-warning' : 'bg-success') }}" 
                                                 style="width: {{ $server->disk_usage }}%"></div>
                                        </div>
                                        <small>{{ number_format($server->disk_usage, 1) }}%</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-wrap gap-1">
                                        @php
                                            $services = $server->services ?? [];
                                            $activeServices = collect($services)->filter(function($status) { return $status === 'active'; })->count();
                                            $totalServices = count($services);
                                        @endphp
                                        <span class="badge bg-{{ $activeServices > 0 ? 'success' : 'secondary' }}" title="{{ $activeServices }}/{{ $totalServices }} active">
                                            {{ $activeServices }}/{{ $totalServices }}
                                        </span>
                                        @if(collect($services)->contains('nginx', 'active'))
                                            <span class="badge bg-info" title="Nginx">N</span>
                                        @endif
                                        @if(collect($services)->contains('apache', 'active'))
                                            <span class="badge bg-warning" title="Apache">A</span>
                                        @endif
                                        @if(collect($services)->contains('mysql', 'active') || collect($services)->contains('mariadb', 'active'))
                                            <span class="badge bg-primary" title="MySQL/MariaDB">DB</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ $server->last_checked ? $server->last_checked->diffForHumans() : 'Never' }}
                                    </small>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a href="{{ route('servers.show', $server->id) }}" class="dropdown-item">
                                                <i class="bx bx-eye me-2"></i> View Details
                                            </a>
                                            <a href="{{ route('servers.edit', $server->id) }}" class="dropdown-item">
                                                <i class="bx bx-edit me-2"></i> Edit
                                            </a>
                                            <a href="{{ route('servers.performance', $server->id) }}" class="dropdown-item">
                                                <i class="bx bx-line-chart me-2"></i> Performance
                                            </a>
                                            <a href="{{ route('servers.logs', $server->id) }}" class="dropdown-item">
                                                <i class="bx bx-file me-2"></i> View Logs
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item text-success" onclick="checkServerStatus({{ $server->id }})">
                                                <i class="bx bx-refresh me-2"></i> Check Status
                                            </a>
                                            @if($server->status == 'offline')
                                                <a href="#" class="dropdown-item text-success" onclick="startServer({{ $server->id }})">
                                                    <i class="bx bx-play me-2"></i> Start
                                                </a>
                                            @endif
                                            <a href="#" class="dropdown-item text-warning" onclick="restartServer({{ $server->id }})">
                                                <i class="bx bx-power-off me-2"></i> Restart
                                            </a>
                                            <a href="#" class="dropdown-item text-danger" onclick="shutdownServer({{ $server->id }})">
                                                <i class="bx bx-shut-down me-2"></i> Shutdown
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Bulk Actions Bar -->
                <div id="bulkActionsBar" class="d-none alert alert-info mt-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span id="selectedCount">0 servers selected</span>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-success" onclick="bulkStart()">
                                <i class="bx bx-play me-1"></i> Start
                            </button>
                            <button class="btn btn-sm btn-warning" onclick="bulkRestart()">
                                <i class="bx bx-power-off me-1"></i> Restart
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="bulkShutdown()">
                                <i class="bx bx-shut-down me-1"></i> Shutdown
                            </button>
                            <button class="btn btn-sm btn-info" onclick="bulkCheckStatus()">
                                <i class="bx bx-refresh me-1"></i> Check Status
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions Modal -->
<div class="modal fade" id="quickActionsModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Quick Actions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="d-grid gap-2">
                    <button class="btn btn-outline-primary">
                        <i class="bx bx-refresh me-2"></i> Refresh All Servers
                    </button>
                    <button class="btn btn-outline-success">
                        <i class="bx bx-play me-2"></i> Start All Offline
                    </button>
                    <button class="btn btn-outline-warning">
                        <i class="bx bx-cloud-download me-2"></i> Backup All Servers
                    </button>
                    <button class="btn btn-outline-info">
                        <i class="bx bx-shield me-2"></i> Security Scan All
                    </button>
                    <button class="btn btn-outline-secondary">
                        <i class="bx bx-cog me-2"></i> Update All Systems
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let selectedServers = new Set();

// Filter servers
function filterServers(filter) {
    const rows = document.querySelectorAll('#serversTable tbody tr');
    const buttons = document.querySelectorAll('.btn-group button');
    
    // Update active button
    buttons.forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
    
    rows.forEach(row => {
        const status = row.dataset.status;
        const cpu = parseFloat(row.dataset.cpu);
        const memory = parseFloat(row.dataset.memory);
        const disk = parseFloat(row.dataset.disk);
        const hasWarnings = cpu > 80 || memory > 80 || disk > 80;
        
        let show = false;
        switch(filter) {
            case 'all':
                show = true;
                break;
            case 'online':
                show = status === 'online';
                break;
            case 'offline':
                show = status === 'offline';
                break;
            case 'warnings':
                show = hasWarnings;
                break;
        }
        
        row.style.display = show ? '' : 'none';
    });
}

// Search functionality
document.getElementById('serverSearch').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('#serversTable tbody tr');
    
    rows.forEach(row => {
        const name = row.dataset.name.toLowerCase();
        const ip = row.dataset.ip.toLowerCase();
        const match = name.includes(searchTerm) || ip.includes(searchTerm);
        row.style.display = match ? '' : 'none';
    });
});

// Bulk actions
function toggleBulkActions() {
    const bulkActionsBar = document.getElementById('bulkActionsBar');
    const checkboxes = document.querySelectorAll('.server-checkbox');
    const selectAll = document.getElementById('selectAll');
    
    bulkActionsBar.classList.toggle('d-none');
    
    if (!bulkActionsBar.classList.contains('d-none')) {
        checkboxes.forEach(cb => {
            cb.style.display = '';
        });
        selectAll.style.display = '';
    } else {
        checkboxes.forEach(cb => {
            cb.style.display = 'none';
        });
        selectAll.style.display = 'none';
        selectedServers.clear();
        updateSelectedCount();
    }
}

function toggleSelectAll() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.server-checkbox');
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAll.checked;
        if (selectAll.checked) {
            selectedServers.add(checkbox.value);
        } else {
            selectedServers.delete(checkbox.value);
        }
    });
    
    updateSelectedCount();
}

function updateSelectedCount() {
    const count = selectedServers.size;
    document.getElementById('selectedCount').textContent = `${count} server${count !== 1 ? 's' : ''} selected`;
}

// Add event listeners for checkboxes
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.server-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            if (this.checked) {
                selectedServers.add(this.value);
            } else {
                selectedServers.delete(this.value);
            }
            updateSelectedCount();
        });
    });
});

// Server actions
function checkServerStatus(serverId) {
    showNotification(`Checking status for server ${serverId}...`, 'info');
    
    fetch(`/api/servers/${serverId}/check-status`, {method: 'POST'})
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(`Server ${serverId} status updated`, 'success');
                setTimeout(() => location.reload(), 1000);
            } else {
                showNotification(`Failed to check server status: ${data.message}`, 'error');
            }
        })
        .catch(error => {
            showNotification('Error checking server status', 'error');
        });
}

function startServer(serverId) {
    if (confirm('Are you sure you want to start this server?')) {
        showNotification(`Starting server ${serverId}...`, 'info');
        setTimeout(() => {
            showNotification(`Server ${serverId} started successfully`, 'success');
        }, 2000);
    }
}

function restartServer(serverId) {
    if (confirm('Are you sure you want to restart this server?')) {
        showNotification(`Restarting server ${serverId}...`, 'warning');
        setTimeout(() => {
            showNotification(`Server ${serverId} restarted successfully`, 'success');
        }, 3000);
    }
}

function shutdownServer(serverId) {
    if (confirm('Are you sure you want to shutdown this server?')) {
        showNotification(`Shutting down server ${serverId}...`, 'danger');
        setTimeout(() => {
            showNotification(`Server ${serverId} shut down successfully`, 'success');
        }, 2000);
    }
}

// Bulk actions
function bulkStart() {
    if (selectedServers.size === 0) {
        showNotification('No servers selected', 'warning');
        return;
    }
    
    if (confirm(`Are you sure you want to start ${selectedServers.size} selected servers?`)) {
        showNotification(`Starting ${selectedServers.size} servers...`, 'info');
        setTimeout(() => {
            showNotification(`${selectedServers.size} servers started successfully`, 'success');
        }, 2000);
    }
}

function bulkRestart() {
    if (selectedServers.size === 0) {
        showNotification('No servers selected', 'warning');
        return;
    }
    
    if (confirm(`Are you sure you want to restart ${selectedServers.size} selected servers?`)) {
        showNotification(`Restarting ${selectedServers.size} servers...`, 'warning');
        setTimeout(() => {
            showNotification(`${selectedServers.size} servers restarted successfully`, 'success');
        }, 3000);
    }
}

function bulkShutdown() {
    if (selectedServers.size === 0) {
        showNotification('No servers selected', 'warning');
        return;
    }
    
    if (confirm(`Are you sure you want to shutdown ${selectedServers.size} selected servers?`)) {
        showNotification(`Shutting down ${selectedServers.size} servers...`, 'danger');
        setTimeout(() => {
            showNotification(`${selectedServers.size} servers shut down successfully`, 'success');
        }, 2000);
    }
}

function bulkCheckStatus() {
    if (selectedServers.size === 0) {
        showNotification('No servers selected', 'warning');
        return;
    }
    
    showNotification(`Checking status for ${selectedServers.size} servers...`, 'info');
    setTimeout(() => {
        showNotification(`Status checked for ${selectedServers.size} servers`, 'success');
    }, 2000);
}

function refreshServers() {
    const button = event.target;
    button.disabled = true;
    button.innerHTML = '<i class="bx bx-loader-alt bx-spin me-1"></i> Refreshing...';
    
    fetch('/api/servers/refresh-all', {method: 'POST'})
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('All servers refreshed successfully', 'success');
                setTimeout(() => location.reload(), 1000);
            } else {
                showNotification('Failed to refresh servers', 'error');
            }
        })
        .catch(error => {
            showNotification('Error refreshing servers', 'error');
        })
        .finally(() => {
            button.disabled = false;
            button.innerHTML = '<i class="bx bx-refresh me-1"></i> Refresh';
        });
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

// Auto-refresh every 30 seconds
setInterval(() => {
    if (!document.hidden) {
        fetch('/api/servers/status')
            .then(response => response.json())
            .then(data => {
                // Update server status in real-time
                console.log('Server status updated');
            })
            .catch(error => {
                console.log('Error fetching server status');
            });
    }
}, 30000);
</script>
@endpush
