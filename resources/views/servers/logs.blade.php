@extends('layouts.app')

@section('title', 'Server Logs')
@section('description', 'View and search server logs')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">Server Logs</h5>
                    <p class="card-subtitle">System logs and event history</p>
                </div>
                <div class="d-flex gap-2">
                    <select class="form-select form-select-sm" style="width: auto;">
                        <option value="all">All Logs</option>
                        <option value="system">System</option>
                        <option value="application">Application</option>
                        <option value="security">Security</option>
                        <option value="backup">Backup</option>
                        <option value="error">Errors Only</option>
                    </select>
                    <select class="form-select form-select-sm" style="width: auto;">
                        <option value="today">Today</option>
                        <option value="yesterday">Yesterday</option>
                        <option value="week">Last 7 Days</option>
                        <option value="month">Last 30 Days</option>
                    </select>
                    <button class="btn btn-outline-primary btn-sm" onclick="refreshLogs()">
                        <i class="bx bx-refresh me-1"></i> Refresh
                    </button>
                    <button class="btn btn-outline-success btn-sm" onclick="downloadLogs()">
                        <i class="bx bx-download me-1"></i> Download
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- Log Statistics -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-info bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-info-circle text-info"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Info Logs</h6>
                                <h4 class="mb-0 text-info">156</h4>
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
                                <h4 class="mb-0 text-warning">24</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-danger bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-error text-danger"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Errors</h6>
                                <h4 class="mb-0 text-danger">8</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-success bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-check-circle text-success"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Success</h6>
                                <h4 class="mb-0 text-success">92</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Search and Filter -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bx bx-search"></i>
                            </span>
                            <input type="text" class="form-control" placeholder="Search logs..." id="searchInput">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-secondary btn-sm" onclick="clearFilters()">
                                <i class="bx bx-x me-1"></i> Clear Filters
                            </button>
                            <button class="btn btn-outline-warning btn-sm" onclick="exportLogs()">
                                <i class="bx bx-file-export me-1"></i> Export
                            </button>
                            <button class="btn btn-outline-danger btn-sm" onclick="clearLogs()">
                                <i class="bx bx-trash me-1"></i> Clear Logs
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Logs Table -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Timestamp</th>
                                <th>Level</th>
                                <th>Source</th>
                                <th>Message</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($logs as $log)
                            <tr class="log-row" data-level="{{ $log['level'] }}" data-source="{{ $log['source'] }}">
                                <td>
                                    <small>{{ $log['timestamp'] }}</small>
                                </td>
                                <td>
                                    @switch($log['level'])
                                        @case('info')
                                            <span class="badge bg-info">Info</span>
                                            @break
                                        @case('warning')
                                            <span class="badge bg-warning">Warning</span>
                                            @break
                                        @case('error')
                                            <span class="badge bg-danger">Error</span>
                                            @break
                                        @case('success')
                                            <span class="badge bg-success">Success</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary">{{ $log['level'] }}</span>
                                    @endswitch
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark">{{ $log['source'] }}</span>
                                </td>
                                <td>
                                    <div class="log-message">
                                        {{ $log['message'] }}
                                    </div>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a href="#" class="dropdown-item" onclick="viewLogDetails('{{ $log['timestamp'] }}')">
                                                <i class="bx bx-eye me-2"></i> View Details
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="copyLog('{{ $log['message'] }}')">
                                                <i class="bx bx-copy me-2"></i> Copy Message
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item text-danger" onclick="deleteLog('{{ $log['timestamp'] }}')">
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

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div>
                        <small class="text-muted">Showing 1 to 10 of 280 entries</small>
                    </div>
                    <nav>
                        <ul class="pagination pagination-sm mb-0">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1">Previous</a>
                            </li>
                            <li class="page-item active">
                                <a class="page-link" href="#">1</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">2</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">3</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Log Details Modal -->
<div class="modal fade" id="logDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Log Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Timestamp:</strong>
                        <p id="logTimestamp">2024-12-22 14:30:00</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Level:</strong>
                        <p id="logLevel"><span class="badge bg-info">Info</span></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Source:</strong>
                        <p id="logSource">backup</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Process ID:</strong>
                        <p id="logPid">1234</p>
                    </div>
                </div>
                <div class="mb-3">
                    <strong>Message:</strong>
                    <pre id="logMessage" class="bg-light p-3 rounded">System backup completed successfully</pre>
                </div>
                <div class="mb-3">
                    <strong>Stack Trace:</strong>
                    <pre id="logStackTrace" class="bg-light p-3 rounded" style="max-height: 200px; overflow-y: auto;">No stack trace available</pre>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="copyFullLog()">
                    <i class="bx bx-copy me-1"></i> Copy Full Log
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function refreshLogs() {
    showNotification('Logs refreshed successfully', 'success');
}

function downloadLogs() {
    showNotification('Log download started', 'info');
}

function exportLogs() {
    showNotification('Log export initiated', 'info');
}

function clearLogs() {
    if (confirm('Are you sure you want to clear all logs? This action cannot be undone.')) {
        showNotification('Logs cleared successfully', 'warning');
    }
}

function clearFilters() {
    document.getElementById('searchInput').value = '';
    showNotification('Filters cleared', 'info');
}

function viewLogDetails(timestamp) {
    // Set modal content
    document.getElementById('logTimestamp').textContent = timestamp;
    // Show modal
    new bootstrap.Modal(document.getElementById('logDetailsModal')).show();
}

function copyLog(message) {
    navigator.clipboard.writeText(message).then(() => {
        showNotification('Log message copied to clipboard', 'success');
    });
}

function copyFullLog() {
    const logContent = document.getElementById('logMessage').textContent;
    navigator.clipboard.writeText(logContent).then(() => {
        showNotification('Full log copied to clipboard', 'success');
    });
}

function deleteLog(timestamp) {
    if (confirm('Are you sure you want to delete this log entry?')) {
        showNotification('Log entry deleted', 'warning');
    }
}

// Search functionality
document.getElementById('searchInput').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const logRows = document.querySelectorAll('.log-row');
    
    logRows.forEach(row => {
        const message = row.querySelector('.log-message').textContent.toLowerCase();
        if (message.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

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
