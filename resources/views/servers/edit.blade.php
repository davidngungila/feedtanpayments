@extends('layouts.app')

@section('title', 'Edit Server - ' . $server['name'])
@section('description', 'Edit server configuration and settings')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Edit Server</h5>
                <p class="card-subtitle">Update server configuration and settings</p>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('servers.update', $server['id']) }}">
                    @csrf
                    @method('PUT')
                    
                    <!-- Basic Information -->
                    <div class="mb-4">
                        <h6 class="mb-3">Basic Information</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Server Name *</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $server['name'] }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="ip_address" class="form-label">IP Address *</label>
                                <input type="text" class="form-control" id="ip_address" name="ip_address" value="{{ $server['ip_address'] }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="type" class="form-label">Server Type *</label>
                                <select class="form-select" id="type" name="type" required>
                                    <option value="web" {{ $server['type'] == 'Web Server' ? 'selected' : '' }}>Web Server</option>
                                    <option value="application" {{ $server['type'] == 'Application Server' ? 'selected' : '' }}>Application Server</option>
                                    <option value="database" {{ $server['type'] == 'Database Server' ? 'selected' : '' }}>Database Server</option>
                                    <option value="mail" {{ $server['type'] == 'Mail Server' ? 'selected' : '' }}>Mail Server</option>
                                    <option value="backup" {{ $server['type'] == 'Backup Server' ? 'selected' : '' }}>Backup Server</option>
                                    <option value="test" {{ $server['type'] == 'Test Server' ? 'selected' : '' }}>Test Server</option>
                                    <option value="development" {{ $server['type'] == 'Development Server' ? 'selected' : '' }}>Development Server</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="os" class="form-label">Operating System *</label>
                                <select class="form-select" id="os" name="os" required>
                                    <option value="ubuntu-22.04" {{ $server['os'] == 'Ubuntu 22.04 LTS' ? 'selected' : '' }}>Ubuntu 22.04 LTS</option>
                                    <option value="ubuntu-20.04" {{ $server['os'] == 'Ubuntu 20.04 LTS' ? 'selected' : '' }}>Ubuntu 20.04 LTS</option>
                                    <option value="centos-8" {{ $server['os'] == 'CentOS 8' ? 'selected' : '' }}>CentOS 8</option>
                                    <option value="centos-7" {{ $server['os'] == 'CentOS 7' ? 'selected' : '' }}>CentOS 7</option>
                                    <option value="debian-11" {{ $server['os'] == 'Debian 11' ? 'selected' : '' }}>Debian 11</option>
                                    <option value="debian-10" {{ $server['os'] == 'Debian 10' ? 'selected' : '' }}>Debian 10</option>
                                    <option value="windows-2019" {{ $server['os'] == 'Windows Server 2019' ? 'selected' : '' }}>Windows Server 2019</option>
                                    <option value="windows-2022" {{ $server['os'] == 'Windows Server 2022' ? 'selected' : '' }}>Windows Server 2022</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="location" class="form-label">Data Center Location *</label>
                                <select class="form-select" id="location" name="location" required>
                                    <option value="dc1" {{ $server['location'] == 'Data Center 1' ? 'selected' : '' }}>Data Center 1</option>
                                    <option value="dc2" {{ $server['location'] == 'Data Center 2' ? 'selected' : '' }}>Data Center 2</option>
                                    <option value="dc3" {{ $server['location'] == 'Data Center 3' ? 'selected' : '' }}>Data Center 3</option>
                                    <option value="cloud-aws" {{ $server['location'] == 'AWS Cloud' ? 'selected' : '' }}>AWS Cloud</option>
                                    <option value="cloud-azure" {{ $server['location'] == 'Azure Cloud' ? 'selected' : '' }}>Azure Cloud</option>
                                    <option value="cloud-gcp" {{ $server['location'] == 'Google Cloud Platform' ? 'selected' : '' }}>Google Cloud Platform</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="1">{{ $server['description'] ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Server Features -->
                    <div class="mb-4">
                        <h6 class="mb-3">Server Features</h6>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="backup_enabled" name="backup_enabled" {{ $server['backup_enabled'] ?? false ? 'checked' : '' }}>
                                    <label class="form-check-label" for="backup_enabled">
                                        Enable Automatic Backup
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="monitoring_enabled" name="monitoring_enabled" {{ $server['monitoring_enabled'] ?? false ? 'checked' : '' }}>
                                    <label class="form-check-label" for="monitoring_enabled">
                                        Enable Performance Monitoring
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="auto_updates" name="auto_updates" {{ $server['auto_updates'] ?? false ? 'checked' : '' }}>
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
                                    <input class="form-check-input" type="checkbox" id="ssl_enabled" name="ssl_enabled" checked>
                                    <label class="form-check-label" for="ssl_enabled">
                                        Enable SSL Certificate
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('servers.show', $server['id']) }}" class="btn btn-outline-secondary">
                            <i class="bx bx-arrow-left me-1"></i> Cancel
                        </a>
                        <div>
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-save me-1"></i> Update Server
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
