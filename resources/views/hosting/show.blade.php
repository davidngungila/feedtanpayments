@extends('layouts.app')

@section('title', 'Website Details - ' . $website['domain'])
@section('description', 'View and manage website details and configuration')

@section('content')
<div class="row">
    <!-- Website Overview -->
    <div class="col-12 mb-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="avatar bg-primary bg-opacity-10 rounded-circle me-3" style="width: 48px; height: 48px;">
                        <i class="bx bx-globe text-primary"></i>
                    </div>
                    <div>
                        <h5 class="card-title mb-0">{{ $website['domain'] }}</h5>
                        <p class="card-subtitle mb-0">{{ $website['server'] }} • Active</p>
                    </div>
                </div>
                <div class="d-flex gap-2 align-items-center">
                    <span class="badge bg-success">Active</span>
                    <a href="{{ route('hosting.edit', $website['id']) }}" class="btn btn-outline-primary btn-sm">
                        <i class="bx bx-edit me-1"></i> Edit
                    </a>
                    <div class="dropdown">
                        <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="dropdown">
                            <i class="bx bx-dots-horizontal-rounded"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="#" class="dropdown-item text-success">
                                <i class="bx bx-play me-2"></i> Enable
                            </a>
                            <a href="#" class="dropdown-item text-warning">
                                <i class="bx bx-pause me-2"></i> Suspend
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
                            <a href="#" class="dropdown-item text-danger">
                                <i class="bx bx-trash me-2"></i> Delete
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <!-- Website Information -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6 class="mb-3">Website Information</h6>
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="text-muted" style="width: 150px;">Domain:</td>
                                        <td><strong>{{ $website['domain'] }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Status:</td>
                                        <td><span class="badge bg-success">Active</span></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Server:</td>
                                        <td>{{ $website['server'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">PHP Version:</td>
                                        <td>{{ $website['php_version'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Database:</td>
                                        <td>{{ $website['database'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Created:</td>
                                        <td>{{ \Carbon\Carbon::parse($website['created_at'])->format('M d, Y') }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h6 class="mb-3">Resource Usage</h6>
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="text-muted" style="width: 150px;">Disk Usage:</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="progress me-2" style="width: 60px; height: 6px;">
                                                    <div class="progress-bar {{ ($website['disk_usage'] / $website['disk_limit']) > 0.8 ? 'bg-danger' : (($website['disk_usage'] / $website['disk_limit']) > 0.6 ? 'bg-warning' : 'bg-success') }}" 
                                                         style="width: {{ ($website['disk_usage'] / $website['disk_limit']) * 100 }}%"></div>
                                                </div>
                                                <small>{{ $website['disk_usage'] }} / {{ $website['disk_limit'] }} GB</small>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Bandwidth:</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="progress me-2" style="width: 60px; height: 6px;">
                                                    <div class="progress-bar {{ ($website['bandwidth'] / $website['bandwidth_limit']) > 0.8 ? 'bg-danger' : (($website['bandwidth'] / $website['bandwidth_limit']) > 0.6 ? 'bg-warning' : 'bg-success') }}" 
                                                         style="width: {{ ($website['bandwidth'] / $website['bandwidth_limit']) * 100 }}%"></div>
                                                </div>
                                                <small>{{ $website['bandwidth'] }} / {{ $website['bandwidth_limit'] }} GB</small>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Visitors:</td>
                                        <td>{{ number_format($website['visitors']) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Email Accounts:</td>
                                        <td>{{ $website['email_accounts'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Subdomains:</td>
                                        <td>{{ $website['subdomains'] }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- Analytics Overview -->
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="mb-3">Analytics Overview</h6>
                                <div class="row text-center">
                                    <div class="col-md-3">
                                        <h4 class="text-primary mb-0">{{ $website['analytics']['visitors_today'] }}</h4>
                                        <small class="text-muted">Visitors Today</small>
                                    </div>
                                    <div class="col-md-3">
                                        <h4 class="text-success mb-0">{{ $website['analytics']['pageviews_today'] }}</h4>
                                        <small class="text-muted">Pageviews Today</small>
                                    </div>
                                    <div class="col-md-3">
                                        <h4 class="text-warning mb-0">{{ $website['analytics']['bounce_rate'] }}%</h4>
                                        <small class="text-muted">Bounce Rate</small>
                                    </div>
                                    <div class="col-md-3">
                                        <h4 class="text-info mb-0">{{ $website['analytics']['avg_session_duration'] }}</h4>
                                        <small class="text-muted">Avg Session</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <!-- Quick Actions -->
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Quick Actions</h6>
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <a href="{{ route('hosting.analytics', $website['id']) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="bx bx-bar-chart me-2"></i> View Analytics
                                    </a>
                                    <a href="{{ route('hosting.files', $website['id']) }}" class="btn btn-outline-info btn-sm">
                                        <i class="bx bx-folder me-2"></i> File Manager
                                    </a>
                                    <a href="{{ route('hosting.databases', $website['id']) }}" class="btn btn-outline-success btn-sm">
                                        <i class="bx bx-data me-2"></i> Manage Databases
                                    </a>
                                    <a href="{{ route('hosting.emails', $website['id']) }}" class="btn btn-outline-warning btn-sm">
                                        <i class="bx bx-envelope me-2"></i> Email Accounts
                                    </a>
                                    <button class="btn btn-outline-danger btn-sm" onclick="backupWebsite()">
                                        <i class="bx bx-cloud-download me-2"></i> Backup Website
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- SSL Status -->
                        <div class="card border-0 shadow-sm mt-3">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">SSL Certificate</h6>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted">Status:</span>
                                    <span class="badge bg-success">Active</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted">Issuer:</span>
                                    <strong>Let's Encrypt</strong>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted">Expires:</span>
                                    <span class="text-warning">{{ \Carbon\Carbon::parse($website['ssl_expiry'])->format('M d, Y') }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">Auto Renew:</span>
                                    <span class="badge bg-success">Enabled</span>
                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-outline-primary btn-sm w-100" onclick="renewSSL()">
                                        <i class="bx bx-refresh me-1"></i> Renew Certificate
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Pages -->
    <div class="col-md-6 mb-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Top Pages</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Page</th>
                                <th>Views</th>
                                <th>%</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($website['analytics']['top_pages'] as $page)
                            <tr>
                                <td><code>{{ $page['page'] }}</code></td>
                                <td>{{ $page['views'] }}</td>
                                <td>
                                    <div class="progress" style="width: 60px; height: 6px;">
                                        <div class="progress-bar bg-primary" style="width: {{ ($page['views'] / $website['analytics']['pageviews_today']) * 100 }}%"></div>
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

    <!-- Recent Visitors -->
    <div class="col-md-6 mb-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Recent Visitors</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>IP Address</th>
                                <th>Page</th>
                                <th>Time</th>
                                <th>Country</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($website['recent_visitors'] as $visitor)
                            <tr>
                                <td><code>{{ $visitor['ip'] }}</code></td>
                                <td><code>{{ $visitor['page'] }}</code></td>
                                <td>{{ $visitor['time'] }}</td>
                                <td>{{ $visitor['country'] }}</td>
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
function backupWebsite() {
    showNotification('Website backup initiated', 'info');
}

function renewSSL() {
    showNotification('SSL certificate renewal initiated', 'info');
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
