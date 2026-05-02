@extends('layouts.app')

@section('title', 'Client Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Client Details</h1>
                <div>
                    <a href="{{ route('clients.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Clients
                    </a>
                    <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>Edit Client
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Client Information</h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="avatar avatar-lg bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center">
                            {{ substr($client->name, 0, 2) }}
                        </div>
                    </div>
                    
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Name:</strong></td>
                            <td>{{ $client->name }}</td>
                        </tr>
                        <tr>
                            <td><strong>Email:</strong></td>
                            <td>{{ $client->email }}</td>
                        </tr>
                        <tr>
                            <td><strong>Phone:</strong></td>
                            <td>{{ $client->phone ?: 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Company:</strong></td>
                            <td>{{ $client->company ?: 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Status:</strong></td>
                            <td>
                                <span class="badge bg-{{ $client->status === 'active' ? 'success' : ($client->status === 'suspended' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($client->status) }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Financial Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Balance:</strong></td>
                            <td class="${{ $client->balance > 0 ? 'text-success' : 'text-danger' }}">
                                ${{ number_format($client->balance, 2) }}
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Credit Limit:</strong></td>
                            <td>${{ number_format($client->credit_limit, 2) }}</td>
                        </tr>
                        <tr>
                            <td><strong>Available Credit:</strong></td>
                            <td class="text-info">
                                ${{ number_format($client->credit_limit - $client->balance, 2) }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Address Information</h5>
                </div>
                <div class="card-body">
                    @if($client->address || $client->city || $client->country)
                        <table class="table table-borderless">
                            @if($client->address)
                            <tr>
                                <td><strong>Address:</strong></td>
                                <td>{{ $client->address }}</td>
                            </tr>
                            @endif
                            @if($client->city)
                            <tr>
                                <td><strong>City:</strong></td>
                                <td>{{ $client->city }}</td>
                            </tr>
                            @endif
                            @if($client->country)
                            <tr>
                                <td><strong>Country:</strong></td>
                                <td>{{ $client->country }}</td>
                            </tr>
                            @endif
                        </table>
                    @else
                        <p class="text-muted">No address information available</p>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('clients.packages') }}" class="btn btn-outline-primary w-100">
                                <i class="fas fa-box me-2"></i>View Packages
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('clients.resource-limits') }}" class="btn btn-outline-info w-100">
                                <i class="fas fa-chart-line me-2"></i>Resource Limits
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('clients.disk-space') }}" class="btn btn-outline-warning w-100">
                                <i class="fas fa-hdd me-2"></i>Disk Space
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('clients.bandwidth') }}" class="btn btn-outline-success w-100">
                                <i class="fas fa-network-wired me-2"></i>Bandwidth
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('clients.domains-limit') }}" class="btn btn-outline-secondary w-100">
                                <i class="fas fa-globe me-2"></i>Domains
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('clients.login-access') }}" class="btn btn-outline-dark w-100">
                                <i class="fas fa-key me-2"></i>Login Access
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            @if($client->notes)
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Notes</h5>
                </div>
                <div class="card-body">
                    <p>{{ $client->notes }}</p>
                </div>
            </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Activity Log</h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-primary"></div>
                            <div class="timeline-content">
                                <h6>Client Created</h6>
                                <p class="text-muted small">{{ $client->created_at->format('M j, Y g:i A') }}</p>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-marker bg-info"></div>
                            <div class="timeline-content">
                                <h6>Last Updated</h6>
                                <p class="text-muted small">{{ $client->updated_at->format('M j, Y g:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.avatar {
    width: 80px;
    height: 80px;
    font-size: 2rem;
    font-weight: bold;
}

.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    padding-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -30px;
    top: 0;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid #fff;
}

.timeline-content {
    padding-left: 15px;
}
</style>
@endpush
