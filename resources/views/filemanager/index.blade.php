@extends('layouts.app')

@section('title', 'File Manager')
@section('description', 'Manage files and directories')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">File Manager</h5>
                    <p class="card-subtitle">Manage files and directories</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-success" onclick="uploadFile()">
                        <i class="bx bx-upload me-1"></i> Upload
                    </button>
                    <button class="btn btn-outline-primary" onclick="createFolder()">
                        <i class="bx bx-folder-plus me-1"></i> New Folder
                    </button>
                    <button class="btn btn-outline-info" onclick="refreshFiles()">
                        <i class="bx bx-refresh me-1"></i> Refresh
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- File Statistics -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-primary bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-file text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Files</h6>
                                <h4 class="mb-0">{{ $stats['total_files'] }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-success bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-folder text-success"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Directories</h6>
                                <h4 class="mb-0 text-success">{{ $stats['total_directories'] }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-warning bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-hard-drive text-warning"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Size</h6>
                                <h4 class="mb-0 text-warning">{{ $stats['total_size'] }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-info bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-pie-chart text-info"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Disk Usage</h6>
                                <h4 class="mb-0 text-info">{{ $stats['disk_usage'] }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- File Navigation -->
                <div class="row mb-3">
                    <div class="col-md-12">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#" onclick="navigateTo('/')">/</a></li>
                                <li class="breadcrumb-item"><a href="#" onclick="navigateTo('/var')">var</a></li>
                                <li class="breadcrumb-item"><a href="#" onclick="navigateTo('/var/www')">www</a></li>
                                <li class="breadcrumb-item active">{{ $currentPath }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <!-- File List -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Size</th>
                                <th>Modified</th>
                                <th>Permissions</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($files as $file)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bx {{ $file['type'] == 'directory' ? 'bx-folder text-warning' : 'bx-file text-primary' }} me-2"></i>
                                        <strong>{{ $file['name'] }}</strong>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $file['type'] == 'directory' ? 'warning' : 'primary' }}">
                                        {{ $file['type'] }}
                                    </span>
                                </td>
                                <td>{{ $file['size'] }}</td>
                                <td>{{ $file['modified'] }}</td>
                                <td><code>{{ $file['permissions'] }}</code></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            @if($file['type'] == 'directory')
                                            <a href="#" class="dropdown-item" onclick="openDirectory('{{ $file['name'] }}')">
                                                <i class="bx bx-folder-open me-2"></i> Open
                                            </a>
                                            @else
                                            <a href="#" class="dropdown-item" onclick="editFile('{{ $file['name'] }}')">
                                                <i class="bx bx-edit me-2"></i> Edit
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="downloadFile('{{ $file['name'] }}')">
                                                <i class="bx bx-download me-2"></i> Download
                                            </a>
                                            @endif
                                            <a href="#" class="dropdown-item" onclick="copyItem('{{ $file['name'] }}')">
                                                <i class="bx bx-copy me-2"></i> Copy
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="moveItem('{{ $file['name'] }}')">
                                                <i class="bx bx-move me-2"></i> Move
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="renameItem('{{ $file['name'] }}')">
                                                <i class="bx bx-rename me-2"></i> Rename
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item" onclick="changePermissions('{{ $file['name'] }}')">
                                                <i class="bx bx-lock me-2"></i> Change Permissions
                                            </a>
                                            <a href="#" class="dropdown-item text-danger" onclick="deleteItem('{{ $file['name'] }}')">
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

                <!-- Quick Actions -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Quick Actions</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="d-grid">
                                            <button class="btn btn-outline-primary btn-sm" onclick="uploadFile()">
                                                <i class="bx bx-upload me-2"></i> Upload Files
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="d-grid">
                                            <button class="btn btn-outline-success btn-sm" onclick="createFolder()">
                                                <i class="bx bx-folder-plus me-2"></i> New Folder
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="d-grid">
                                            <button class="btn btn-outline-info btn-sm" onclick="createFile()">
                                                <i class="bx bx-file-plus me-2"></i> New File
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="d-grid">
                                            <button class="btn btn-outline-warning btn-sm" onclick="compressFiles()">
                                                <i class="bx bx-archive me-2"></i> Compress
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="d-grid">
                                            <button class="btn btn-outline-secondary btn-sm" onclick="extractFiles()">
                                                <i class="bx bx-archive-out me-2"></i> Extract
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="d-grid">
                                            <button class="btn btn-outline-danger btn-sm" onclick="emptyTrash()">
                                                <i class="bx bx-trash me-2"></i> Empty Trash
                                            </button>
                                        </div>
                                    </div>
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
function uploadFile() {
    showNotification('File upload dialog opened', 'info');
}

function createFolder() {
    showNotification('Create folder dialog opened', 'info');
}

function createFile() {
    showNotification('Create file dialog opened', 'info');
}

function refreshFiles() {
    showNotification('Refreshing file list...', 'info');
}

function navigateTo(path) {
    showNotification(`Navigating to ${path}`, 'info');
}

function openDirectory(name) {
    showNotification(`Opening directory: ${name}`, 'info');
}

function editFile(name) {
    showNotification(`Editing file: ${name}`, 'info');
}

function downloadFile(name) {
    showNotification(`Downloading file: ${name}`, 'info');
}

function copyItem(name) {
    showNotification(`Copying: ${name}`, 'info');
}

function moveItem(name) {
    showNotification(`Moving: ${name}`, 'info');
}

function renameItem(name) {
    showNotification(`Renaming: ${name}`, 'info');
}

function changePermissions(name) {
    showNotification(`Changing permissions for: ${name}`, 'info');
}

function deleteItem(name) {
    if (confirm(`Are you sure you want to delete ${name}?`)) {
        showNotification(`Deleted: ${name}`, 'danger');
    }
}

function compressFiles() {
    showNotification('Compress files dialog opened', 'info');
}

function extractFiles() {
    showNotification('Extract files dialog opened', 'info');
}

function emptyTrash() {
    if (confirm('Are you sure you want to empty trash? This action cannot be undone.')) {
        showNotification('Trash emptied', 'danger');
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
