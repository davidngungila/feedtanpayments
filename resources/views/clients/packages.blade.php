@extends('layouts.app')

@section('title', 'Client Packages')
@section('description', 'Manage client packages and pricing')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">Client Packages</h5>
                    <p class="card-subtitle">Manage client packages and pricing plans</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-success" onclick="addPackage()">
                        <i class="bx bx-plus me-1"></i> Add Package
                    </button>
                    <button class="btn btn-outline-primary" onclick="exportPackages()">
                        <i class="bx bx-download me-1"></i> Export
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- Package Statistics -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-primary bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-package text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Packages</h6>
                                <h4 class="mb-0">{{ count($packages) }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-success bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-user text-success"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Clients</h6>
                                <h4 class="mb-0 text-success">{{ collect($packages)->sum('active_clients') }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-info bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-dollar text-info"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Avg Revenue</h6>
                                <h4 class="mb-0 text-info">${{ number_format(collect($packages)->avg('price'), 2) }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-warning bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-trending-up text-warning"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Monthly Revenue</h6>
                                <h4 class="mb-0 text-warning">${{ number_format(collect($packages)->sum(function($p) { return $p['price'] * $p['active_clients']; }), 2) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Package Cards -->
                <div class="row">
                    @foreach($packages as $package)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">{{ $package['name'] }}</h5>
                                    <div class="badge bg-white text-dark">${{ number_format($package['price'], 2) }}/mo</div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <div class="text-center">
                                            <h6 class="text-primary">{{ $package['disk_space'] }}</h6>
                                            <small class="text-muted">Disk Space</small>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-center">
                                            <h6 class="text-info">{{ $package['bandwidth'] }}</h6>
                                            <small class="text-muted">Bandwidth</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <div class="text-center">
                                            <h6 class="text-success">{{ $package['domains'] }}</h6>
                                            <small class="text-muted">Domains</small>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-center">
                                            <h6 class="text-warning">{{ $package['email_accounts'] }}</h6>
                                            <small class="text-muted">Email Accounts</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <h6 class="mb-2">Features:</h6>
                                    <ul class="list-unstyled">
                                        @foreach($package['features'] as $feature)
                                        <li class="mb-1">
                                            <i class="bx bx-check text-success me-1"></i>
                                            <small>{{ $feature }}</small>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <small class="text-muted">{{ $package['active_clients'] }} active clients</small>
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a href="#" class="dropdown-item" onclick="editPackage({{ $package['id'] }})">
                                                <i class="bx bx-edit me-2"></i> Edit Package
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="viewClients({{ $package['id'] }})">
                                                <i class="bx bx-user me-2"></i> View Clients
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="duplicatePackage({{ $package['id'] }})">
                                                <i class="bx bx-copy me-2"></i> Duplicate
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item text-danger" onclick="deletePackage({{ $package['id'] }})">
                                                <i class="bx bx-trash me-2"></i> Delete
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Package Comparison -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Package Comparison</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Features</th>
                                                @foreach($packages as $package)
                                                <th class="text-center">{{ $package['name'] }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><strong>Price</strong></td>
                                                @foreach($packages as $package)
                                                <td class="text-center">${{ number_format($package['price'], 2) }}/mo</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td><strong>Disk Space</strong></td>
                                                @foreach($packages as $package)
                                                <td class="text-center">{{ $package['disk_space'] }}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td><strong>Bandwidth</strong></td>
                                                @foreach($packages as $package)
                                                <td class="text-center">{{ $package['bandwidth'] }}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td><strong>Domains</strong></td>
                                                @foreach($packages as $package)
                                                <td class="text-center">{{ $package['domains'] }}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td><strong>Email Accounts</strong></td>
                                                @foreach($packages as $package)
                                                <td class="text-center">{{ $package['email_accounts'] }}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td><strong>Databases</strong></td>
                                                @foreach($packages as $package)
                                                <td class="text-center">{{ $package['databases'] }}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td><strong>Active Clients</strong></td>
                                                @foreach($packages as $package)
                                                <td class="text-center">{{ $package['active_clients'] }}</td>
                                                @endforeach
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Package Settings -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Package Settings</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="mb-3">General Settings</h6>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="autoUpgrade" checked>
                                            <label class="form-check-label" for="autoUpgrade">
                                                Allow automatic upgrades
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="packageNotifications" checked>
                                            <label class="form-check-label" for="packageNotifications">
                                                Send package notifications
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="trialPeriod" checked>
                                            <label class="form-check-label" for="trialPeriod">
                                                Enable trial period (7 days)
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="discountCodes" checked>
                                            <label class="form-check-label" for="discountCodes">
                                                Allow discount codes
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="mb-3">Billing Settings</h6>
                                        <div class="mb-3">
                                            <label for="billingCycle" class="form-label">Default Billing Cycle</label>
                                            <select class="form-select" id="billingCycle">
                                                <option value="monthly" selected>Monthly</option>
                                                <option value="quarterly">Quarterly</option>
                                                <option value="semiannual">Semi-Annual</option>
                                                <option value="annual">Annual</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="gracePeriod" class="form-label">Grace Period (days)</label>
                                            <input type="number" class="form-control" id="gracePeriod" value="7" min="1" max="30">
                                        </div>
                                        <div class="mb-3">
                                            <label for="lateFee" class="form-label">Late Fee (%)</label>
                                            <input type="number" class="form-control" id="lateFee" value="10" min="0" max="50">
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-primary" onclick="savePackageSettings()">
                                        <i class="bx bx-save me-1"></i> Save Settings
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
@endsection

@push('scripts')
<script>
function addPackage() {
    showNotification('Add package dialog opened', 'info');
}

function editPackage(id) {
    showNotification(`Editing package ${id}...`, 'info');
}

function viewClients(id) {
    showNotification(`Viewing clients for package ${id}...`, 'info');
}

function duplicatePackage(id) {
    if (confirm('Are you sure you want to duplicate this package?')) {
        showNotification(`Duplicating package ${id}...`, 'info');
    }
}

function deletePackage(id) {
    if (confirm('Are you sure you want to delete this package?')) {
        showNotification(`Package ${id} deleted`, 'danger');
    }
}

function exportPackages() {
    showNotification('Exporting packages...', 'info');
}

function savePackageSettings() {
    showNotification('Package settings saved successfully', 'success');
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
