@extends('layouts.app')

@section('title', 'Create Database')
@section('description', 'Create new database')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Create Database</h5>
                <p class="card-subtitle">Create a new database for your applications</p>
            </div>
            <div class="card-body">
                <form>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="databaseName" class="form-label">Database Name</label>
                                <input type="text" class="form-control" id="databaseName" placeholder="Enter database name" required>
                                <small class="text-muted">Database name must be unique and contain only letters, numbers, and underscores</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="databaseType" class="form-label">Database Type</label>
                                <select class="form-select" id="databaseType" required>
                                    <option value="">Select Database Type</option>
                                    @foreach($databaseTypes as $name => $value)
                                    <option value="{{ $value }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="collation" class="form-label">Collation</label>
                                <select class="form-select" id="collation" required>
                                    <option value="">Select Collation</option>
                                    @foreach($collations as $collation)
                                    <option value="{{ $collation }}">{{ $collation }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="characterSet" class="form-label">Character Set</label>
                                <select class="form-select" id="characterSet" required>
                                    <option value="utf8mb4" selected>utf8mb4</option>
                                    <option value="utf8">utf8</option>
                                    <option value="latin1">latin1</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="server" class="form-label">Database Server</label>
                                <select class="form-select" id="server" required>
                                    <option value="">Select Server</option>
                                    <option value="db-server-01" selected>db-server-01 (Primary)</option>
                                    <option value="db-server-02">db-server-02 (Secondary)</option>
                                    <option value="db-server-03">db-server-03 (Backup)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="owner" class="form-label">Database Owner</label>
                                <select class="form-select" id="owner" required>
                                    <option value="">Select Owner</option>
                                    <option value="admin">admin</option>
                                    <option value="webuser">webuser</option>
                                    <option value="backup_user">backup_user</option>
                                    <option value="readonly">readonly</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Additional Options</label>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="createUser" checked>
                                            <label class="form-check-label" for="createUser">
                                                Create User
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="grantPrivileges" checked>
                                            <label class="form-check-label" for="grantPrivileges">
                                                Grant Privileges
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="createBackup" checked>
                                            <label class="form-check-label" for="createBackup">
                                                Create Backup
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="enableLogging" checked>
                                            <label class="form-check-label" for="enableLogging">
                                                Enable Logging
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="userOptions" style="display: none;">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" placeholder="Enter username">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" placeholder="Enter password">
                                <button type="button" class="btn btn-outline-secondary btn-sm mt-2" onclick="generatePassword()">
                                    <i class="bx bx-refresh me-1"></i> Generate Password
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="privilegeOptions" style="display: none;">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">User Privileges</label>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="selectAll" checked>
                                            <label class="form-check-label" for="selectAll">
                                                Select All
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="select" checked>
                                            <label class="form-check-label" for="select">
                                                SELECT
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="insert" checked>
                                            <label class="form-check-label" for="insert">
                                                INSERT
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="update" checked>
                                            <label class="form-check-label" for="update">
                                                UPDATE
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="delete" checked>
                                            <label class="form-check-label" for="delete">
                                                DELETE
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="drop">
                                            <label class="form-check-label" for="drop">
                                                DROP
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-outline-secondary" onclick="resetForm()">
                                    <i class="bx bx-reset me-1"></i> Reset
                                </button>
                                <div>
                                    <button type="button" class="btn btn-outline-primary me-2" onclick="testConnection()">
                                        <i class="bx bx-test-tube me-1"></i> Test Connection
                                    </button>
                                    <button type="submit" class="btn btn-primary" onclick="createDatabase()">
                                        <i class="bx bx-plus me-1"></i> Create Database
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Database Preview -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Database Configuration Preview</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Database Name:</strong> <span id="previewName">-</span></p>
                                        <p><strong>Type:</strong> <span id="previewType">-</span></p>
                                        <p><strong>Server:</strong> <span id="previewServer">-</span></p>
                                        <p><strong>Owner:</strong> <span id="previewOwner">-</span></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Collation:</strong> <span id="previewCollation">-</span></p>
                                        <p><strong>Character Set:</strong> <span id="previewCharset">-</span></p>
                                        <p><strong>User:</strong> <span id="previewUser">-</span></p>
                                        <p><strong>Privileges:</strong> <span id="previewPrivileges">-</span></p>
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
function generatePassword() {
    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*';
    let password = '';
    for (let i = 0; i < 12; i++) {
        password += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    document.getElementById('password').value = password;
}

function resetForm() {
    document.getElementById('databaseName').value = '';
    document.getElementById('databaseType').value = '';
    document.getElementById('collation').value = '';
    document.getElementById('characterSet').value = 'utf8mb4';
    document.getElementById('server').value = '';
    document.getElementById('owner').value = '';
    document.getElementById('createUser').checked = true;
    document.getElementById('grantPrivileges').checked = true;
    document.getElementById('createBackup').checked = true;
    document.getElementById('enableLogging').checked = true;
    document.getElementById('username').value = '';
    document.getElementById('password').value = '';
    updatePreview();
}

function testConnection() {
    const server = document.getElementById('server').value;
    
    if (!server) {
        showNotification('Please select a database server', 'warning');
        return;
    }
    
    showNotification('Testing database connection...', 'info');
}

function createDatabase() {
    const dbName = document.getElementById('databaseName').value;
    const dbType = document.getElementById('databaseType').value;
    
    if (!dbName || !dbType) {
        showNotification('Please fill in all required fields', 'warning');
        return;
    }
    
    showNotification('Creating database...', 'info');
}

function updatePreview() {
    const dbName = document.getElementById('databaseName').value;
    const dbType = document.getElementById('databaseType').value;
    const server = document.getElementById('server').value;
    const owner = document.getElementById('owner').value;
    const collation = document.getElementById('collation').value;
    const charset = document.getElementById('characterSet').value;
    const username = document.getElementById('username').value;
    
    document.getElementById('previewName').textContent = dbName || '-';
    document.getElementById('previewType').textContent = dbType ? dbType.charAt(0).toUpperCase() + dbType.slice(1) : '-';
    document.getElementById('previewServer').textContent = server || '-';
    document.getElementById('previewOwner').textContent = owner || '-';
    document.getElementById('previewCollation').textContent = collation || '-';
    document.getElementById('previewCharset').textContent = charset || '-';
    document.getElementById('previewUser').textContent = username || '-';
    
    const privileges = [];
    if (document.getElementById('select').checked) privileges.push('SELECT');
    if (document.getElementById('insert').checked) privileges.push('INSERT');
    if (document.getElementById('update').checked) privileges.push('UPDATE');
    if (document.getElementById('delete').checked) privileges.push('DELETE');
    if (document.getElementById('drop').checked) privileges.push('DROP');
    
    document.getElementById('previewPrivileges').textContent = privileges.join(', ') || '-';
}

// Event listeners
document.getElementById('databaseName').addEventListener('input', updatePreview);
document.getElementById('databaseType').addEventListener('change', updatePreview);
document.getElementById('server').addEventListener('change', updatePreview);
document.getElementById('owner').addEventListener('change', updatePreview);
document.getElementById('collation').addEventListener('change', updatePreview);
document.getElementById('characterSet').addEventListener('change', updatePreview);
document.getElementById('username').addEventListener('input', updatePreview);

document.getElementById('createUser').addEventListener('change', function() {
    document.getElementById('userOptions').style.display = this.checked ? 'block' : 'none';
    updatePreview();
});

document.getElementById('grantPrivileges').addEventListener('change', function() {
    document.getElementById('privilegeOptions').style.display = this.checked ? 'block' : 'none';
    updatePreview();
});

document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = ['select', 'insert', 'update', 'delete', 'drop'];
    checkboxes.forEach(id => {
        document.getElementById(id).checked = this.checked;
    });
    updatePreview();
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
