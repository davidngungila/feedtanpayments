@extends('layouts.app')

@section('title', 'Audit Trail - FeedTan Pay')

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Page Header -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-6">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div class="mb-3 mb-md-0">
                                <h4 class="fw-bold mb-2">
                                    <i class="bx bx-history me-2 text-primary"></i>
                                    Audit Trail
                                </h4>
                                <p class="text-muted mb-0">Track every action, change history, and system activity</p>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-outline-success" onclick="exportAuditLogs()">
                                    <i class="bx bx-download me-2"></i>Export Logs
                                </button>
                                <button type="button" class="btn btn-outline-secondary" onclick="refreshAuditLogs()">
                                    <i class="bx bx-refresh me-2"></i>Refresh
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Overview -->
        <div class="row mb-6">
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-primary bg-opacity-10 rounded-circle me-3" style="width: 48px; height: 48px;">
                                <i class="bx bx-user text-primary fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Users</h6>
                                <h4 class="mb-0">247</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-success bg-opacity-10 rounded-circle me-3" style="width: 48px; height: 48px;">
                                <i class="bx bx-edit text-success fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Changes Today</h6>
                                <h4 class="mb-0">1,842</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-warning bg-opacity-10 rounded-circle me-3" style="width: 48px; height: 48px;">
                                <i class="bx bx-shield text-warning fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Security Events</h6>
                                <h4 class="mb-0">23</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-info bg-opacity-10 rounded-circle me-3" style="width: 48px; height: 48px;">
                                <i class="bx bx-time text-info fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Last Activity</h6>
                                <h4 class="mb-0">2 min</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="dateRange" class="form-label">Date Range</label>
                                    <select class="form-select" id="dateRange">
                                        <option value="today">Today</option>
                                        <option value="yesterday">Yesterday</option>
                                        <option value="week" selected>Last 7 Days</option>
                                        <option value="month">Last 30 Days</option>
                                        <option value="custom">Custom Range</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="actionType" class="form-label">Action Type</label>
                                    <select class="form-select" id="actionType">
                                        <option value="all" selected>All Actions</option>
                                        <option value="create">Create</option>
                                        <option value="update">Update</option>
                                        <option value="delete">Delete</option>
                                        <option value="login">Login</option>
                                        <option value="logout">Logout</option>
                                        <option value="access">Access Denied</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="userFilter" class="form-label">User</label>
                                    <input type="text" class="form-control" id="userFilter" placeholder="Search user...">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="moduleFilter" class="form-label">Module</label>
                                    <select class="form-select" id="moduleFilter">
                                        <option value="all" selected>All Modules</option>
                                        <option value="users">Users</option>
                                        <option value="payments">Payments</option>
                                        <option value="loans">Loans</option>
                                        <option value="savings">Savings</option>
                                        <option value="members">Members</option>
                                        <option value="system">System</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="button" class="btn btn-primary" onclick="applyFilters()">
                                    <i class="bx bx-filter me-2"></i>Apply Filters
                                </button>
                                <button type="button" class="btn btn-outline-secondary" onclick="clearFilters()">
                                    <i class="bx bx-x me-2"></i>Clear Filters
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Audit Logs Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0">
                                <i class="bx bx-list-ul me-2"></i>
                                Audit Logs
                            </h5>
                            <small class="text-muted">Showing 1,842 records</small>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="clearOldLogs()">
                                <i class="bx bx-trash me-1"></i>Clear Old Logs
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="auditTable">
                                <thead>
                                    <tr>
                                        <th>
                                            <i class="bx bx-time me-1"></i>
                                            Timestamp
                                        </th>
                                        <th>
                                            <i class="bx bx-user me-1"></i>
                                            User
                                        </th>
                                        <th>
                                            <i class="bx bx-cog me-1"></i>
                                            Action
                                        </th>
                                        <th>
                                            <i class="bx bx-file me-1"></i>
                                            Module
                                        </th>
                                        <th>
                                            <i class="bx bx-info-circle me-1"></i>
                                            Details
                                        </th>
                                        <th>
                                            <i class="bx bx-map me-1"></i>
                                            IP Address
                                        </th>
                                        <th>
                                            <i class="bx bx-desktop me-1"></i>
                                            Device
                                        </th>
                                        <th>
                                            <i class="bx bx-cog me-1"></i>
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <small>2024-12-22 14:35:22</small>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar bg-primary bg-opacity-10 rounded-circle me-2" style="width: 32px; height: 32px;">
                                                    <i class="bx bx-user text-primary"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold">John Doe</div>
                                                    <small class="text-muted">Admin</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">Update</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">Users</span>
                                        </td>
                                        <td>
                                            <small>Updated user profile for Jane Smith</small>
                                        </td>
                                        <td>
                                            <code>192.168.1.100</code>
                                        </td>
                                        <td>
                                            <small>Chrome / Windows</small>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="viewAuditDetail(1)">
                                                <i class="bx bx-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <small>2024-12-22 14:32:15</small>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar bg-success bg-opacity-10 rounded-circle me-2" style="width: 32px; height: 32px;">
                                                    <i class="bx bx-user text-success"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold">Jane Smith</div>
                                                    <small class="text-muted">Staff</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">Create</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning">Payments</span>
                                        </td>
                                        <td>
                                            <small>Created new payment: TZS 50,000 to M-Pesa</small>
                                        </td>
                                        <td>
                                            <code>192.168.1.105</code>
                                        </td>
                                        <td>
                                            <small>Firefox / macOS</small>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="viewAuditDetail(2)">
                                                <i class="bx bx-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <small>2024-12-22 14:28:45</small>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar bg-warning bg-opacity-10 rounded-circle me-2" style="width: 32px; height: 32px;">
                                                    <i class="bx bx-user text-warning"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold">Mike Johnson</div>
                                                    <small class="text-muted">Staff</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-danger">Delete</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">Loans</span>
                                        </td>
                                        <td>
                                            <small>Deleted loan application #LN-2024-0042</small>
                                        </td>
                                        <td>
                                            <code>192.168.1.110</code>
                                        </td>
                                        <td>
                                            <small>Safari / iPhone</small>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="viewAuditDetail(3)">
                                                <i class="bx bx-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <small>2024-12-22 14:25:10</small>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar bg-info bg-opacity-10 rounded-circle me-2" style="width: 32px; height: 32px;">
                                                    <i class="bx bx-user text-info"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold">Sarah Williams</div>
                                                    <small class="text-muted">Member</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">Login</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">System</span>
                                        </td>
                                        <td>
                                            <small>User login successful</small>
                                        </td>
                                        <td>
                                            <code>41.202.123.45</code>
                                        </td>
                                        <td>
                                            <small>Chrome / Android</small>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="viewAuditDetail(4)">
                                                <i class="bx bx-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <small>2024-12-22 14:22:33</small>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar bg-danger bg-opacity-10 rounded-circle me-2" style="width: 32px; height: 32px;">
                                                    <i class="bx bx-user text-danger"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold">Unknown User</div>
                                                    <small class="text-muted">Guest</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning">Access Denied</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-danger">Security</span>
                                        </td>
                                        <td>
                                            <small>Failed login attempt - Invalid credentials</small>
                                        </td>
                                        <td>
                                            <code>203.45.67.89</code>
                                        </td>
                                        <td>
                                            <small>Unknown / Linux</small>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="viewAuditDetail(5)">
                                                <i class="bx bx-eye"></i>
                                            </button>
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

<!-- Audit Detail Modal -->
<div class="modal fade" id="auditDetailModal" tabindex="-1" aria-labelledby="auditDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="auditDetailModalLabel">
                    <i class="bx bx-eye me-2"></i>
                    Audit Log Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="auditDetails"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x me-2"></i>Close
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function refreshAuditLogs() {
    showNotification('Refreshing audit logs...', 'info');
    setTimeout(() => {
        location.reload();
    }, 1000);
}

function exportAuditLogs() {
    const logs = [
        {
            timestamp: '2024-12-22 14:35:22',
            user: 'John Doe',
            action: 'Update',
            module: 'Users',
            details: 'Updated user profile for Jane Smith',
            ip: '192.168.1.100',
            device: 'Chrome / Windows'
        }
    ];
    
    const dataStr = JSON.stringify(logs, null, 2);
    const dataUri = 'data:application/json;charset=utf-8,'+ encodeURIComponent(dataStr);
    
    const exportFileDefaultName = `audit-logs-${new Date().toISOString().split('T')[0]}.json`;
    
    const linkElement = document.createElement('a');
    linkElement.setAttribute('href', dataUri);
    linkElement.setAttribute('download', exportFileDefaultName);
    linkElement.click();
    
    showNotification('Audit logs exported successfully!', 'success');
}

function applyFilters() {
    const dateRange = document.getElementById('dateRange').value;
    const actionType = document.getElementById('actionType').value;
    const userFilter = document.getElementById('userFilter').value;
    const moduleFilter = document.getElementById('moduleFilter').value;
    
    showNotification('Applying filters...', 'info');
    
    // Simulate filtering
    setTimeout(() => {
        showNotification('Filters applied successfully!', 'success');
    }, 1000);
}

function clearFilters() {
    document.getElementById('dateRange').value = 'week';
    document.getElementById('actionType').value = 'all';
    document.getElementById('userFilter').value = '';
    document.getElementById('moduleFilter').value = 'all';
    
    showNotification('Filters cleared!', 'info');
}

function clearOldLogs() {
    if (confirm('Are you sure you want to clear audit logs older than 90 days? This action cannot be undone.')) {
        showNotification('Clearing old logs...', 'info');
        setTimeout(() => {
            showNotification('Old logs cleared successfully!', 'success');
        }, 2000);
    }
}

function viewAuditDetail(id) {
    const auditData = {
        1: {
            timestamp: '2024-12-22 14:35:22',
            user: 'John Doe',
            role: 'Admin',
            action: 'Update',
            module: 'Users',
            details: 'Updated user profile for Jane Smith',
            ip: '192.168.1.100',
            device: 'Chrome / Windows',
            userAgent: 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
            changes: {
                before: {
                    name: 'Jane Smith',
                    email: 'jane.smith@example.com',
                    phone: '+255 712 345 678'
                },
                after: {
                    name: 'Jane Smith',
                    email: 'jane.smith@newdomain.com',
                    phone: '+255 712 345 679'
                }
            }
        }
    };
    
    const data = auditData[id] || auditData[1];
    
    const details = `
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label text-muted">Timestamp</label>
                    <div class="fw-bold">${data.timestamp}</div>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted">User</label>
                    <div class="fw-bold">${data.user} (${data.role})</div>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted">Action</label>
                    <div><span class="badge bg-success">${data.action}</span></div>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted">Module</label>
                    <div><span class="badge bg-info">${data.module}</span></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label text-muted">IP Address</label>
                    <div><code>${data.ip}</code></div>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted">Device</label>
                    <div>${data.device}</div>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted">User Agent</label>
                    <div><small class="text-muted">${data.userAgent}</small></div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <div class="mb-3">
                    <label class="form-label text-muted">Details</label>
                    <div class="bg-light p-2 rounded">${data.details}</div>
                </div>
                ${data.changes ? `
                <div class="mb-3">
                    <label class="form-label text-muted">Changes</label>
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Before:</h6>
                            <pre class="bg-light p-2 rounded">${JSON.stringify(data.changes.before, null, 2)}</pre>
                        </div>
                        <div class="col-md-6">
                            <h6>After:</h6>
                            <pre class="bg-light p-2 rounded">${JSON.stringify(data.changes.after, null, 2)}</pre>
                        </div>
                    </div>
                </div>
                ` : ''}
            </div>
        </div>
    `;
    
    document.getElementById('auditDetails').innerHTML = details;
    
    const modal = new bootstrap.Modal(document.getElementById('auditDetailModal'));
    modal.show();
}

function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        if (notification.parentNode) {
            notification.parentNode.removeChild(notification);
        }
    }, 5000);
}
</script>
@endpush
@endsection
