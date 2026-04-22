@extends('layouts.app')

@section('title', 'Connections')
@section('description', 'Manage your connected accounts and services')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card mb-6">
            <div class="card-header">
                <h5 class="card-title mb-0">Connected Accounts</h5>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <h6 class="mb-1">Google Account</h6>
                        <p class="text-muted mb-0">john.doe@gmail.com</p>
                    </div>
                    <button class="btn btn-outline-danger btn-sm">Disconnect</button>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <h6 class="mb-1">Facebook Account</h6>
                        <p class="text-muted mb-0">John Doe</p>
                    </div>
                    <button class="btn btn-outline-danger btn-sm">Disconnect</button>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <h6 class="mb-1">GitHub Account</h6>
                        <p class="text-muted mb-0">@johndoe</p>
                    </div>
                    <button class="btn btn-outline-danger btn-sm">Disconnect</button>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1">Microsoft Account</h6>
                        <p class="text-muted mb-0">john.doe@outlook.com</p>
                    </div>
                    <button class="btn btn-outline-danger btn-sm">Disconnect</button>
                </div>
            </div>
        </div>

        <div class="card mb-6">
            <div class="card-header">
                <h5 class="card-title mb-0">API Integrations</h5>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-4 p-3 border rounded">
                    <div class="d-flex align-items-center">
                        <div class="avatar bg-success bg-opacity-10 rounded-circle me-3">
                            <i class="bx bx-dollar-circle text-success"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">Stripe Payment Gateway</h6>
                            <p class="text-muted mb-0">Process payments via Stripe</p>
                        </div>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="stripe" checked>
                        <label class="form-check-label" for="stripe"></label>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-4 p-3 border rounded">
                    <div class="d-flex align-items-center">
                        <div class="avatar bg-primary bg-opacity-10 rounded-circle me-3">
                            <i class="bx bx-dollar text-primary"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">PayPal Integration</h6>
                            <p class="text-muted mb-0">PayPal payment processing</p>
                        </div>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="paypal">
                        <label class="form-check-label" for="paypal"></label>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between p-3 border rounded">
                    <div class="d-flex align-items-center">
                        <div class="avatar bg-warning bg-opacity-10 rounded-circle me-3">
                            <i class="bx bx-mobile text-warning"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">Mobile Money API</h6>
                            <p class="text-muted mb-0">Mobile money integration</p>
                        </div>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="mobilemoney" checked>
                        <label class="form-check-label" for="mobilemoney"></label>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Connected Devices</h5>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center">
                        <div class="avatar bg-primary bg-opacity-10 rounded-circle me-3">
                            <i class="bx bx-laptop text-primary"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">Chrome on Windows</h6>
                            <p class="text-muted mb-0">192.168.1.100 - Current session</p>
                        </div>
                    </div>
                    <span class="badge bg-success">Current</span>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center">
                        <div class="avatar bg-info bg-opacity-10 rounded-circle me-3">
                            <i class="bx bx-mobile text-info"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">iPhone 13 Pro</h6>
                            <p class="text-muted mb-0">San Francisco, CA - 2 hours ago</p>
                        </div>
                    </div>
                    <button class="btn btn-outline-danger btn-sm">Remove</button>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="avatar bg-warning bg-opacity-10 rounded-circle me-3">
                            <i class="bx bx-tablet text-warning"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">iPad Pro</h6>
                            <p class="text-muted mb-0">Los Angeles, CA - 1 day ago</p>
                        </div>
                    </div>
                    <button class="btn btn-outline-danger btn-sm">Remove</button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card mb-6">
            <div class="card-header">
                <h5 class="card-title mb-0">Connection Stats</h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <h2 class="mb-2">7</h2>
                    <p class="text-muted">Total Connections</p>
                </div>
                <div class="row text-center">
                    <div class="col-4">
                        <h5 class="mb-0 text-success">4</h5>
                        <small class="text-muted">Active</small>
                    </div>
                    <div class="col-4">
                        <h5 class="mb-0 text-warning">2</h5>
                        <small class="text-muted">Pending</small>
                    </div>
                    <div class="col-4">
                        <h5 class="mb-0 text-danger">1</h5>
                        <small class="text-muted">Failed</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-6">
            <div class="card-header">
                <h5 class="card-title mb-0">Security Tips</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info mb-3">
                    <i class="bx bx-info-circle me-2"></i>
                    <strong>Two-Factor Authentication</strong> is enabled on your account
                </div>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <i class="bx bx-check-circle text-success me-2"></i>
                        <span>Review connected devices regularly</span>
                    </li>
                    <li class="mb-2">
                        <i class="bx bx-check-circle text-success me-2"></i>
                        <span>Use strong, unique passwords</span>
                    </li>
                    <li class="mb-2">
                        <i class="bx bx-check-circle text-success me-2"></i>
                        <span>Enable login notifications</span>
                    </li>
                    <li>
                        <i class="bx bx-x-circle text-danger me-2"></i>
                        <span>Revoke unused app permissions</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button class="btn btn-outline-primary">
                        <i class="bx bx-plus me-2"></i>Add New Connection
                    </button>
                    <button class="btn btn-outline-success">
                        <i class="bx bx-refresh me-2"></i>Sync All
                    </button>
                    <button class="btn btn-outline-warning">
                        <i class="bx bx-shield me-2"></i>Security Check
                    </button>
                    <button class="btn btn-outline-danger">
                        <i class="bx bx-x-circle me-2"></i>Disconnect All
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
