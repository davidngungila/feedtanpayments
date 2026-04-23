@extends('layouts.app')

@section('title', 'Clients - FeedTan Pay')

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0">Client Management</h4>
            <a href="{{ route('clients.create') }}" class="btn btn-primary">
                <i class="bx bx-plus me-2"></i>Add New Client
            </a>
        </div>
        
        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-label-primary rounded-circle me-3">
                                <i class="bx bx-user"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0">Total Clients</h6>
                                <h3 class="mb-0">{{ $clients->total() }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-label-success rounded-circle me-3">
                                <i class="bx bx-check-circle"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0">Active Clients</h6>
                                <h3 class="mb-0">0</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-label-warning rounded-circle me-3">
                                <i class="bx bx-dollar"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0">Total Balance</h6>
                                <h3 class="mb-0">TZS 0</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-label-info rounded-circle me-3">
                                <i class="bx bx-trending-up"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0">Credit Limit</h6>
                                <h3 class="mb-0">TZS 0</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Clients Table -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">All Clients</h5>
            </div>
            <div class="card-body">
                @if($clients->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Company</th>
                                    <th>Status</th>
                                    <th>Balance</th>
                                    <th>Credit Limit</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($clients as $client)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar bg-label-primary rounded-circle me-2">
                                                <i class="bx bx-user"></i>
                                            </div>
                                            <div>
                                                <div class="fw-semibold">{{ $client->name }}</div>
                                                @if($client->company)
                                                    <small class="text-muted">{{ $client->company }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $client->email }}</td>
                                    <td>{{ $client->phone ?? '-' }}</td>
                                    <td>{{ $client->company ?? '-' }}</td>
                                    <td>{!! $client->status_badge !!}</td>
                                    <td>{{ $client->formatted_balance }}</td>
                                    <td>{{ $client->formatted_credit_limit }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-horizontal-rounded"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('clients.show', $client) }}">
                                                        <i class="bx bx-eye me-2"></i>View Details
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('clients.edit', $client) }}">
                                                        <i class="bx bx-edit me-2"></i>Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li>
                                                    <a class="dropdown-item text-danger" href="javascript:void(0)" onclick="deleteClient({{ $client->id }})">
                                                        <i class="bx bx-trash me-2"></i>Delete
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                           Showing {{ $clients->firstItem() }} to {{ $clients->lastItem() }} of {{ $clients->total() }} results
                        </div>
                        {{ $clients->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bx bx-user-x" style="font-size: 3rem; color: #6c757d;"></i>
                        <h5 class="mt-3">No clients found</h5>
                        <p class="text-muted">Get started by adding your first client.</p>
                        <a href="{{ route('clients.create') }}" class="btn btn-primary">
                            <i class="bx bx-plus me-2"></i>Add Your First Client
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function deleteClient(clientId) {
    if (confirm('Are you sure you want to delete this client? This action cannot be undone.')) {
        fetch(`/clients/${clientId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                showNotification(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error deleting client:', error);
            showNotification('Error deleting client', 'error');
        });
    }
}

function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        if (notification.parentNode) {
            notification.parentNode.removeChild(notification);
        }
    }, 5000);
}
</script>
@endpush
