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
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="ip_address" class="form-label">IP Address *</label>
                                <input type="text" class="form-control" id="ip_address" name="ip_address" required 
                                       placeholder="e.g., 192.168.1.10">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="type" class="form-label">Server Type *</label>
                                <select class="form-select" id="type" name="type" required>
                                    <option value="">Select Server Type</option>
                                    <option value="web">Web Server</option>
                                    <option value="application">Application Server</option>
                                    <option value="database">Database Server</option>
                                    <option value="mail">Mail Server</option>
                                    <option value="backup">Backup Server</option>
                                    <option value="test">Test Server</option>
                                    <option value="development">Development Server</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="os" class="form-label">Operating System *</label>
                                <select class="form-select" id="os" name="os" required>
                                    <option value="">Select Operating System</option>
                                    <option value="ubuntu-22.04">Ubuntu 22.04 LTS</option>
                                    <option value="ubuntu-20.04">Ubuntu 20.04 LTS</option>
                                    <option value="centos-8">CentOS 8</option>
                                    <option value="centos-7">CentOS 7</option>
                                    <option value="debian-11">Debian 11</option>
                                    <option value="debian-10">Debian 10</option>
                                    <option value="windows-2019">Windows Server 2019</option>
                                    <option value="windows-2022">Windows Server 2022</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="location" class="form-label">Data Center Location *</label>
                                <select class="form-select" id="location" name="location" required>
                                    <option value="">Select Location</option>
                                    <option value="dc1">Data Center 1</option>
                                    <option value="dc2">Data Center 2</option>
                                    <option value="dc3">Data Center 3</option>
                                    <option value="cloud-aws">AWS Cloud</option>
                                    <option value="cloud-azure">Azure Cloud</option>
                                    <option value="cloud-gcp">Google Cloud Platform</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="1" 
                                          placeholder="Brief description of the server purpose"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Server Specifications -->
                    <div class="mb-4">
                        <h6 class="mb-3">Server Specifications</h6>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="cpu" class="form-label">CPU Cores *</label>
                                <select class="form-select" id="cpu" name="cpu" required>
                                    <option value="">Select CPU Cores</option>
                                    <option value="2">2 Cores</option>
                                    <option value="4">4 Cores</option>
                                    <option value="8">8 Cores</option>
                                    <option value="16">16 Cores</option>
                                    <option value="32">32 Cores</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="memory" class="form-label">Memory (GB) *</label>
                                <select class="form-select" id="memory" name="memory" required>
                                    <option value="">Select Memory</option>
                                    <option value="4">4 GB</option>
                                    <option value="8">8 GB</option>
                                    <option value="16">16 GB</option>
                                    <option value="32">32 GB</option>
                                    <option value="64">64 GB</option>
                                    <option value="128">128 GB</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="storage" class="form-label">Storage (GB) *</label>
                                <select class="form-select" id="storage" name="storage" required>
                                    <option value="">Select Storage</option>
                                    <option value="100">100 GB SSD</option>
                                    <option value="250">250 GB SSD</option>
                                    <option value="500">500 GB SSD</option>
                                    <option value="1000">1 TB SSD</option>
                                    <option value="2000">2 TB SSD</option>
                                    <option value="1000-hdd">1 TB HDD</option>
                                    <option value="2000-hdd">2 TB HDD</option>
                                </select>
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
function testConnection() {
    const button = event.target;
    button.disabled = true;
    button.innerHTML = '<i class="bx bx-loader-alt bx-spin me-1"></i> Testing...';
    
    // Simulate connection test
    setTimeout(() => {
        button.disabled = false;
        button.innerHTML = '<i class="bx bx-test-tube me-1"></i> Test Connection';
        
        // Show success notification
        showNotification('Connection test successful!', 'success');
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
