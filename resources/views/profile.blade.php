@extends('layouts.app')

@section('title', 'User Profile')
@section('description', 'Manage your user profile and personal information')

@section('content')
<div class="row">
    <div class="col-xl-4 col-lg-4 col-md-5 order-1 order-md-0 mb-4">
        <!-- User Card -->
        <div class="card h-100">
            <div class="card-body">
                <div class="user-avatar-section">
                    <div class="d-flex align-items-center flex-column">
                        <div class="avatar avatar-xl">
                            <img src="{{ asset('assets/img/avatars/1.png') }}" alt="User Avatar" class="rounded-circle">
                        </div>
                        <div class="user-info text-center mt-3">
                            <h4 class="mb-2">{{ Auth::user()->name ?? 'Admin User' }}</h4>
                            <p class="mb-0">System Administrator</p>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-center flex-wrap gap-2 mb-4 pt-2">
                    <button type="button" class="btn btn-sm btn-outline-primary">Upload Photo</button>
                    <button type="button" class="btn btn-sm btn-outline-danger">Remove</button>
                </div>

                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <div class="d-flex align-items-center">
                        <i class="bx bx-user me-2"></i>
                        <span class="align-middle">Username</span>
                    </div>
                    <span class="text-muted">{{ Auth::user()->name ?? 'admin' }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <div class="d-flex align-items-center">
                        <i class="bx bx-envelope me-2"></i>
                        <span class="align-middle">Email</span>
                    </div>
                    <span class="text-muted">{{ Auth::user()->email ?? 'admin@example.com' }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <div class="d-flex align-items-center">
                        <i class="bx bx-shield me-2"></i>
                        <span class="align-middle">Role</span>
                    </div>
                    <span class="badge bg-label-primary">Administrator</span>
                </div>
                <div class="d-flex justify-content-between align-items-center py-2">
                    <div class="d-flex align-items-center">
                        <i class="bx bx-calendar me-2"></i>
                        <span class="align-middle">Joined</span>
                    </div>
                    <span class="text-muted">Jan 1, 2024</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-8 col-lg-8 col-md-7 order-0 order-md-1 mb-4">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between">
                <div class="card-title mb-0">
                    <h5 class="mb-0">Profile Information</h5>
                    <small class="text-muted">Update your account details</small>
                </div>
                <button type="button" class="btn btn-primary">Save Changes</button>
            </div>
            <div class="card-body">
                <form>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="firstName" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="firstName" value="{{ Auth::user()->name ?? 'Admin' }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="lastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="lastName" value="User">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" value="{{ Auth::user()->email ?? 'admin@example.com' }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="phone" value="+1 234 567 8900">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" value="123 Main St, City, State 12345">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="language" class="form-label">Language</label>
                            <select class="form-select" id="language">
                                <option>English</option>
                                <option>Spanish</option>
                                <option>French</option>
                                <option>German</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="timezone" class="form-label">Timezone</label>
                            <select class="form-select" id="timezone">
                                <option>UTC-05:00 Eastern Time</option>
                                <option>UTC-06:00 Central Time</option>
                                <option>UTC-07:00 Mountain Time</option>
                                <option>UTC-08:00 Pacific Time</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
