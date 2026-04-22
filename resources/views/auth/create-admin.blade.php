@extends('layouts.app')

@section('title', 'Create Admin User - FeedTan Pay')

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">Create Admin User</h4>
        
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Add New User</h5>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form action="{{ route('system-settings.create-admin') }}" method="POST">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
                                       id="password_confirmation" name="password_confirmation" required>
                                @error('password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="role" class="form-label">User Role</label>
                                <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                                    <option value="">Select Role</option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff</option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="send_welcome" name="send_welcome" checked>
                                    <label class="form-check-label" for="send_welcome">
                                        Send welcome email to user
                                    </label>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bx bx-user-plus me-2"></i>Create User
                                </button>
                                <a href="{{ route('system-settings.user') }}" class="btn btn-secondary">
                                    <i class="bx bx-arrow-back me-2"></i>Back to Users
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Role Permissions</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <h6 class="text-primary">Admin Role</h6>
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="bx bx-check-circle text-success me-2"></i>Full system access</li>
                                <li class="mb-2"><i class="bx bx-check-circle text-success me-2"></i>Manage users</li>
                                <li class="mb-2"><i class="bx bx-check-circle text-success me-2"></i>System settings</li>
                                <li class="mb-2"><i class="bx bx-check-circle text-success me-2"></i>View all reports</li>
                                <li class="mb-2"><i class="bx bx-check-circle text-success me-2"></i>Payment management</li>
                            </ul>
                        </div>

                        <div class="mb-4">
                            <h6 class="text-info">Staff Role</h6>
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="bx bx-check-circle text-success me-2"></i>Dashboard access</li>
                                <li class="mb-2"><i class="bx bx-check-circle text-success me-2"></i>Process payments</li>
                                <li class="mb-2"><i class="bx bx-check-circle text-success me-2"></i>View reports</li>
                                <li class="mb-2"><i class="bx bx-x-circle text-danger me-2"></i>System settings</li>
                                <li class="mb-2"><i class="bx bx-x-circle text-danger me-2"></i>User management</li>
                            </ul>
                        </div>

                        <div class="alert alert-info">
                            <i class="bx bx-info-circle me-2"></i>
                            <strong>Note:</strong> Admin users have full access to all system features including user management and system settings.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
