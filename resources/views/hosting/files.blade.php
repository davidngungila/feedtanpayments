@extends('layouts.app')

@section('title', 'File Manager')
@section('description', 'Manage website files and directories')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">File Manager</h5>
                    <p class="card-subtitle">Manage website files and directories</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-success" onclick="uploadFile()">
                        <i class="bx bx-upload me-1"></i> Upload
                    </button>
                    <button class="btn btn-outline-primary" onclick="createFolder()">
                        <i class="bx bx-folder-plus me-1"></i> New Folder
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- File Navigation -->
                <div class="row mb-3">
                    <div class="col-md-12">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">/var/www/example.com/public</li>
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
                                <th>Size</th>
                                <th>Modified</th>
                                <th>Permissions</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-folder text-warning me-2"></i>
                                        <strong>css</strong>
                                    </div>
                                </td>
                                <td>-</td>
                                <td>Dec 22, 2024 12:30:00</td>
                                <td><code>755</code></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a href="#" class="dropdown-item">
                                                <i class="bx bx-folder-open me-2"></i> Open
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="bx bx-edit me-2"></i> Rename
                                            </a>
                                            <a href="#" class="dropdown-item text-danger">
                                                <i class="bx bx-trash me-2"></i> Delete
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-folder text-warning me-2"></i>
                                        <strong>js</strong>
                                    </div>
                                </td>
                                <td>-</td>
                                <td>Dec 22, 2024 12:15:00</td>
                                <td><code>755</code></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a href="#" class="dropdown-item">
                                                <i class="bx bx-folder-open me-2"></i> Open
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="bx bx-edit me-2"></i> Rename
                                            </a>
                                            <a href="#" class="dropdown-item text-danger">
                                                <i class="bx bx-trash me-2"></i> Delete
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-folder text-warning me-2"></i>
                                        <strong>images</strong>
                                    </div>
                                </td>
                                <td>-</td>
                                <td>Dec 22, 2024 11:45:00</td>
                                <td><code>755</code></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a href="#" class="dropdown-item">
                                                <i class="bx bx-folder-open me-2"></i> Open
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="bx bx-edit me-2"></i> Rename
                                            </a>
                                            <a href="#" class="dropdown-item text-danger">
                                                <i class="bx bx-trash me-2"></i> Delete
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-file text-primary me-2"></i>
                                        <strong>index.html</strong>
                                    </div>
                                </td>
                                <td>12.4 KB</td>
                                <td>Dec 22, 2024 14:30:00</td>
                                <td><code>644</code></td>
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
                                                <i class="bx bx-download me-2"></i> Download
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="bx bx-copy me-2"></i> Copy
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="bx bx-move me-2"></i> Move
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
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-file text-primary me-2"></i>
                                        <strong>about.html</strong>
                                    </div>
                                </td>
                                <td>8.7 KB</td>
                                <td>Dec 22, 2024 13:45:00</td>
                                <td><code>644</code></td>
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
                                                <i class="bx bx-download me-2"></i> Download
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="bx bx-copy me-2"></i> Copy
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="bx bx-move me-2"></i> Move
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
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-file text-primary me-2"></i>
                                        <strong>config.php</strong>
                                    </div>
                                </td>
                                <td>2.1 KB</td>
                                <td>Dec 22, 2024 09:15:00</td>
                                <td><code>600</code></td>
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
                                                <i class="bx bx-download me-2"></i> Download
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="bx bx-copy me-2"></i> Copy
                                            </a>
                                            <a href="#" class="dropdown-item">
                                                <i class="bx bx-move me-2"></i> Move
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
@endsection

@push('scripts')
<script>
function uploadFile() {
    showNotification('File upload dialog opened', 'info');
}

function createFolder() {
    showNotification('Create folder dialog opened', 'info');
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
