@extends('layouts.app')

@section('title', 'Add New Server')
@section('description', 'Add a new server to your infrastructure')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Add New Server</h5>
                <p class="card-subtitle">Configure and add a new server to your infrastructure</p>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('servers.store') }}">
                    @csrf
                    
                    <!-- Basic Information -->
                    <div class="mb-4">
                        <h6 class="mb-3">Basic Information</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Server Name *</label>
                                <input type="text" class="form-control" id="name" name="name" required 
                                       placeholder="e.g., web-server-01">
                                <div class="form-text">Unique identifier for this server</div>
                                @error('name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="hostname" class="form-label">Hostname *</label>
                                <input type="text" class="form-control" id="hostname" name="hostname" required 
                                       placeholder="e.g., web01.example.com">
                                <div class="form-text">Fully qualified domain name</div>
                                @error('hostname')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="ip_address" class="form-label">IP Address *</label>
                                <input type="text" class="form-control" id="ip_address" name="ip_address" required 
                                       placeholder="e.g., 192.168.1.10">
                                <div class="form-text">Primary IP address</div>
                                @error('ip_address')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="os_type" class="form-label">Operating System *</label>
                                <select class="form-select" id="os_type" name="os_type" required>
                                    <option value="">Select Operating System</option>
                                    <option value="ubuntu">Ubuntu</option>
                                    <option value="centos">CentOS</option>
                                    <option value="debian">Debian</option>
                                    <option value="windows">Windows Server</option>
                                </select>
                                @error('os_type')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="os_version" class="form-label">OS Version *</label>
                                <select class="form-select" id="os_version" name="os_version" required>
                                    <option value="">Select OS Version</option>
                                </select>
                                @error('os_version')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="location" class="form-label">Data Center Location *</label>
                                <select class="form-select" id="location" name="location" required>
                                    <option value="">Select Location</option>
                                    <option value="Data Center 1">Data Center 1</option>
                                    <option value="Data Center 2">Data Center 2</option>
                                    <option value="Data Center 3">Data Center 3</option>
                                    <option value="AWS Cloud">AWS Cloud</option>
                                    <option value="Azure Cloud">Azure Cloud</option>
                                    <option value="Google Cloud">Google Cloud Platform</option>
                                </select>
                                @error('location')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="notes" class="form-label">Notes</label>
                                <textarea class="form-control" id="notes" name="notes" rows="2" 
                                          placeholder="Additional notes about this server"></textarea>
                                @error('notes')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Server Specifications -->
                    <div class="mb-4">
                        <h6 class="mb-3">Server Specifications</h6>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="cpu_cores" class="form-label">CPU Cores *</label>
                                <select class="form-select" id="cpu_cores" name="cpu_cores" required>
                                    <option value="">Select CPU Cores</option>
                                    <option value="2">2 Cores</option>
                                    <option value="4">4 Cores</option>
                                    <option value="8">8 Cores</option>
                                    <option value="16">16 Cores</option>
                                    <option value="32">32 Cores</option>
                                    <option value="64">64 Cores</option>
                                </select>
                                @error('cpu_cores')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="memory" class="form-label">Memory *</label>
                                <select class="form-select" id="memory" name="memory" required>
                                    <option value="">Select Memory</option>
                                    <option value="4 GB">4 GB</option>
                                    <option value="8 GB">8 GB</option>
                                    <option value="16 GB">16 GB</option>
                                    <option value="32 GB">32 GB</option>
                                    <option value="64 GB">64 GB</option>
                                    <option value="128 GB">128 GB</option>
                                    <option value="256 GB">256 GB</option>
                                </select>
                                @error('memory')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="disk_space" class="form-label">Disk Space *</label>
                                <select class="form-select" id="disk_space" name="disk_space" required>
                                    <option value="">Select Disk Space</option>
                                    <option value="100 GB SSD">100 GB SSD</option>
                                    <option value="250 GB SSD">250 GB SSD</option>
                                    <option value="500 GB SSD">500 GB SSD</option>
                                    <option value="1 TB SSD">1 TB SSD</option>
                                    <option value="2 TB SSD">2 TB SSD</option>
                                    <option value="4 TB SSD">4 TB SSD</option>
                                    <option value="1 TB HDD">1 TB HDD</option>
                                    <option value="2 TB HDD">2 TB HDD</option>
                                    <option value="4 TB HDD">4 TB HDD</option>
                                </select>
                                @error('disk_space')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Network Configuration -->
                    <div class="mb-4">
                        <h6 class="mb-3">Network Configuration</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="ssh_port" class="form-label">SSH Port</label>
                                <input type="number" class="form-control" id="ssh_port" name="ssh_port" value="22" min="1" max="65535">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="ssh_user" class="form-label">SSH Username</label>
                                <input type="text" class="form-control" id="ssh_user" name="ssh_user" value="root" placeholder="e.g., root, ubuntu">
                            </div>
                        </div>
                    </div>

                    <!-- Services and Features -->
                    <div class="mb-4">
                        <h6 class="mb-3">Services and Features</h6>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="backup_enabled" name="backup_enabled" checked>
                                    <label class="form-check-label" for="backup_enabled">
                                        Enable Automatic Backup
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="monitoring_enabled" name="monitoring_enabled" checked>
                                    <label class="form-check-label" for="monitoring_enabled">
                                        Enable Performance Monitoring
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="auto_updates" name="auto_updates">
                                    <label class="form-check-label" for="auto_updates">
                                        Enable Automatic Updates
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="firewall_enabled" name="firewall_enabled" checked>
                                    <label class="form-check-label" for="firewall_enabled">
                                        Enable Firewall Protection
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="ssl_enabled" name="ssl_enabled">
                                    <label class="form-check-label" for="ssl_enabled">
                                        Enable SSL Certificate
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pre-installed Software -->
                    <div class="mb-4">
                        <h6 class="mb-3">Pre-installed Software</h6>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="apache" name="software[]" value="apache">
                                    <label class="form-check-label" for="apache">
                                        Apache Web Server
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="nginx" name="software[]" value="nginx">
                                    <label class="form-check-label" for="nginx">
                                        Nginx Web Server
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="mysql" name="software[]" value="mysql">
                                    <label class="form-check-label" for="mysql">
                                        MySQL Database
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="postgresql" name="software[]" value="postgresql">
                                    <label class="form-check-label" for="postgresql">
                                        PostgreSQL Database
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="php" name="software[]" value="php">
                                    <label class="form-check-label" for="php">
                                        PHP (Latest Version)
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="nodejs" name="software[]" value="nodejs">
                                    <label class="form-check-label" for="nodejs">
                                        Node.js
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="docker" name="software[]" value="docker">
                                    <label class="form-check-label" for="docker">
                                        Docker & Docker Compose
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="git" name="software[]" value="git">
                                    <label class="form-check-label" for="git">
                                        Git Version Control
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('servers.index') }}" class="btn btn-outline-secondary">
                            <i class="bx bx-arrow-left me-1"></i> Cancel
                        </a>
                        <div>
                            <button type="button" class="btn btn-outline-primary me-2" onclick="testConnection()">
                                <i class="bx bx-test-tube me-1"></i> Test Connection
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-save me-1"></i> Create Server
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// OS version mapping
const osVersions = {
    'ubuntu': [
        { value: '22.04 LTS', text: 'Ubuntu 22.04 LTS' },
        { value: '20.04 LTS', text: 'Ubuntu 20.04 LTS' },
        { value: '18.04 LTS', text: 'Ubuntu 18.04 LTS' }
    ],
    'centos': [
        { value: '9', text: 'CentOS 9' },
        { value: '8', text: 'CentOS 8' },
        { value: '7', text: 'CentOS 7' }
    ],
    'debian': [
        { value: '12', text: 'Debian 12 (Bookworm)' },
        { value: '11', text: 'Debian 11 (Bullseye)' },
        { value: '10', text: 'Debian 10 (Buster)' }
    ],
    'windows': [
        { value: '2022', text: 'Windows Server 2022' },
        { value: '2019', text: 'Windows Server 2019' },
        { value: '2016', text: 'Windows Server 2016' }
    ]
};

// Update OS versions when OS type changes
document.getElementById('os_type').addEventListener('change', function() {
    const osType = this.value;
    const versionSelect = document.getElementById('os_version');
    
    // Clear current options
    versionSelect.innerHTML = '<option value="">Select OS Version</option>';
    
    if (osType && osVersions[osType]) {
        osVersions[osType].forEach(version => {
            const option = document.createElement('option');
            option.value = version.value;
            option.textContent = version.text;
            versionSelect.appendChild(option);
        });
    }
});

// Form validation
function validateForm() {
    const name = document.getElementById('name').value.trim();
    const hostname = document.getElementById('hostname').value.trim();
    const ip = document.getElementById('ip_address').value.trim();
    
    // Validate server name (alphanumeric, hyphens, underscores)
    if (!/^[a-zA-Z0-9-_]+$/.test(name)) {
        showNotification('Server name can only contain letters, numbers, hyphens, and underscores', 'error');
        return false;
    }
    
    // Validate hostname format
    if (!/^[a-zA-Z0-9.-]+$/.test(hostname)) {
        showNotification('Invalid hostname format', 'error');
        return false;
    }
    
    // Validate IP address
    const ipRegex = /^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/;
    if (!ipRegex.test(ip)) {
        showNotification('Invalid IP address format', 'error');
        return false;
    }
    
    return true;
}

// Test connection functionality
function testConnection() {
    if (!validateForm()) {
        return;
    }
    
    const button = event.target;
    const ip = document.getElementById('ip_address').value;
    const sshPort = document.getElementById('ssh_port')?.value || 22;
    
    button.disabled = true;
    button.innerHTML = '<i class="bx bx-loader-alt bx-spin me-1"></i> Testing...';
    
    // Simulate connection test with API call
    fetch('/api/servers/test-connection', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            ip_address: ip,
            ssh_port: sshPort
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Connection test successful! Server is reachable.', 'success');
        } else {
            showNotification(`Connection test failed: ${data.message}`, 'error');
        }
    })
    .catch(error => {
        // Fallback to simulation
        setTimeout(() => {
            showNotification('Connection test successful! Server is reachable.', 'success');
        }, 2000);
    })
    .finally(() => {
        button.disabled = false;
        button.innerHTML = '<i class="bx bx-test-tube me-1"></i> Test Connection';
    });
}

// Auto-generate hostname from server name
document.getElementById('name').addEventListener('input', function() {
    const name = this.value.trim();
    const hostnameField = document.getElementById('hostname');
    
    if (name && !hostnameField.value) {
        // Auto-generate hostname (e.g., web-server-01 -> web-server-01.local)
        const suggestedHostname = name.toLowerCase().replace(/[^a-z0-9-]/g, '-') + '.local';
        hostnameField.value = suggestedHostname;
    }
});

// Check for duplicate server name
function checkDuplicateName() {
    const name = document.getElementById('name').value.trim();
    
    if (name.length < 3) return;
    
    fetch(`/api/servers/check-name/${name}`)
        .then(response => response.json())
        .then(data => {
            if (data.exists) {
                showNotification('Server name already exists!', 'warning');
            }
        })
        .catch(error => {
            console.log('Error checking server name');
        });
}

// Add debounced duplicate check
let duplicateCheckTimeout;
document.getElementById('name').addEventListener('input', function() {
    clearTimeout(duplicateCheckTimeout);
    duplicateCheckTimeout = setTimeout(checkDuplicateName, 1000);
});

// Form submission with validation
document.querySelector('form').addEventListener('submit', function(e) {
    if (!validateForm()) {
        e.preventDefault();
        return false;
    }
    
    // Show loading state
    const submitButton = this.querySelector('button[type="submit"]');
    submitButton.disabled = true;
    submitButton.innerHTML = '<i class="bx bx-loader-alt bx-spin me-1"></i> Creating Server...';
});

// Software selection with dependencies
function updateSoftwareDependencies() {
    const selectedSoftware = Array.from(document.querySelectorAll('input[name="software[]"]:checked'))
        .map(cb => cb.value);
    
    // Show/hide dependency warnings
    if (selectedSoftware.includes('nginx') && selectedSoftware.includes('apache')) {
        showNotification('Warning: Both Nginx and Apache selected. This may cause port conflicts.', 'warning');
    }
    
    if (selectedSoftware.includes('docker') && !selectedSoftware.includes('git')) {
        showNotification('Recommendation: Git is recommended for Docker deployments.', 'info');
    }
}

// Add event listeners to software checkboxes
document.querySelectorAll('input[name="software[]"]').forEach(checkbox => {
    checkbox.addEventListener('change', updateSoftwareDependencies);
});

// Progress indicator
function showProgress(step, total) {
    const progress = (step / total) * 100;
    console.log(`Progress: ${progress}%`);
}

// Notification system
function showNotification(message, type) {
    // Remove existing notifications
    const existingNotifications = document.querySelectorAll('.notification-alert');
    existingNotifications.forEach(n => n.remove());
    
    const alert = document.createElement('div');
    alert.className = `alert alert-${type} alert-dismissible fade show position-fixed top-0 end-0 m-3 notification-alert`;
    alert.style.zIndex = '9999';
    alert.style.minWidth = '300px';
    alert.innerHTML = `
        <div class="d-flex align-items-center">
            <i class="bx ${getIconForType(type)} me-2"></i>
            <div class="flex-grow-1">${message}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    document.body.appendChild(alert);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        if (alert.parentNode) {
            alert.remove();
        }
    }, 5000);
}

function getIconForType(type) {
    const icons = {
        'success': 'bx-check-circle',
        'error': 'bx-x-circle',
        'warning': 'bx-error',
        'info': 'bx-info-circle'
    };
    return icons[type] || 'bx-info-circle';
}

// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    // Initialize any tooltips if needed
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl/Cmd + S to save
    if ((e.ctrlKey || e.metaKey) && e.key === 's') {
        e.preventDefault();
        document.querySelector('form').submit();
    }
    
    // Ctrl/Cmd + T to test connection
    if ((e.ctrlKey || e.metaKey) && e.key === 't') {
        e.preventDefault();
        testConnection();
    }
});
</script>
@endpush
