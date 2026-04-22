@extends('layouts.app')

@section('title', 'Payment Settings - FeedTan Pay')

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0">Payment Settings</h4>
            <div>
                <button type="button" class="btn btn-primary" onclick="addSetting()">
                    <i class="bx bx-plus me-2"></i>Add Setting
                </button>
                <button type="button" class="btn btn-outline-secondary" onclick="refreshSettings()">
                    <i class="bx bx-refresh me-2"></i>Refresh
                </button>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <!-- Settings Table -->
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Payment Configuration</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Setting Key</th>
                                        <th>Value</th>
                                        <th>Type</th>
                                        <th>Description</th>
                                        <th>Public</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($settings as $setting)
                                        <tr>
                                            <td>
                                                <code>{{ $setting->setting_key }}</code>
                                            </td>
                                            <td>
                                                @if ($setting->setting_type === 'boolean')
                                                    <span class="badge bg-{{ $setting->setting_value === 'true' ? 'success' : 'danger' }}">
                                                        {{ $setting->setting_value === 'true' ? 'Enabled' : 'Disabled' }}
                                                    </span>
                                                @elseif ($setting->setting_type === 'json')
                                                    <code>{{ Str::limit($setting->setting_value, 50) }}</code>
                                                @else
                                                    {{ Str::limit($setting->setting_value, 30) }}
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ $setting->setting_type }}</span>
                                            </td>
                                            <td>{{ $setting->description ?? 'N/A' }}</td>
                                            <td>
                                                <span class="badge bg-{{ $setting->is_public ? 'success' : 'secondary' }}">
                                                    {{ $setting->is_public ? 'Yes' : 'No' }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                        <i class="bx bx-dots-horizontal-rounded"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="viewSetting({{ $setting->id }})">
                                                                <i class="bx bx-eye me-2"></i>View Details
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="editSetting({{ $setting->id }})">
                                                                <i class="bx bx-edit me-2"></i>Edit
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="deleteSetting({{ $setting->id }})">
                                                                <i class="bx bx-trash me-2"></i>Delete
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4">
                                                <i class="bx bx-inbox bx-lg text-muted"></i>
                                                <p class="text-muted mb-0">No payment settings found. Click "Add Setting" to create your first setting.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit Setting Modal -->
<div class="modal fade" id="settingModal" tabindex="-1" aria-labelledby="settingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="settingModalLabel">Add Payment Setting</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="settingForm" action="{{ route('system-settings.payment.store') }}" method="POST">
                @csrf
                <input type="hidden" id="settingId" name="setting_id" value="">
                <input type="hidden" id="settingMethod" name="_method" value="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="settingKey" class="form-label">Setting Key</label>
                        <input type="text" class="form-control" id="settingKey" name="setting_key" required>
                    </div>
                    <div class="mb-3">
                        <label for="settingValue" class="form-label">Setting Value</label>
                        <input type="text" class="form-control" id="settingValue" name="setting_value" required>
                    </div>
                    <div class="mb-3">
                        <label for="settingType" class="form-label">Setting Type</label>
                        <select class="form-select" id="settingType" name="setting_type" required>
                            <option value="text">Text</option>
                            <option value="number">Number</option>
                            <option value="boolean">Boolean</option>
                            <option value="json">JSON</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="settingGroup" class="form-label">Setting Group</label>
                        <select class="form-select" id="settingGroup" name="setting_group" required>
                            <option value="payment">Payment</option>
                            <option value="gateway">Payment Gateway</option>
                            <option value="currency">Currency</option>
                            <option value="fees">Fees</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="settingDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="settingDescription" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="isPublic" name="is_public">
                            <label class="form-check-label" for="isPublic">Public Setting</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-save me-2"></i>Save Setting
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Setting Modal -->
<div class="modal fade" id="viewSettingModal" tabindex="-1" aria-labelledby="viewSettingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewSettingModalLabel">Payment Setting Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="settingDetails"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteSettingModal" tabindex="-1" aria-labelledby="deleteSettingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteSettingModalLabel">Delete Payment Setting</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this payment setting? This action cannot be undone.</p>
                <div id="deleteSettingName" class="fw-bold"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                    <i class="bx bx-trash me-2"></i>Delete
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let currentDeleteId = null;

function addSetting() {
    document.getElementById('settingModalLabel').textContent = 'Add Payment Setting';
    document.getElementById('settingForm').reset();
    document.getElementById('settingId').value = '';
    document.getElementById('settingMethod').value = 'POST';
    document.getElementById('settingForm').action = '{{ route("system-settings.payment.store") }}';
    
    const modal = new bootstrap.Modal(document.getElementById('settingModal'));
    modal.show();
}

function editSetting(id) {
    document.getElementById('settingModalLabel').textContent = 'Edit Payment Setting';
    document.getElementById('settingId').value = id;
    document.getElementById('settingMethod').value = 'PUT';
    document.getElementById('settingForm').action = `/system-settings/payment/${id}`;
    
    // Fetch setting data
    fetch(`/api/payment-settings/${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('settingKey').value = data.setting_key;
            document.getElementById('settingValue').value = data.setting_value;
            document.getElementById('settingType').value = data.setting_type;
            document.getElementById('settingGroup').value = data.setting_group;
            document.getElementById('settingDescription').value = data.description || '';
            document.getElementById('isPublic').checked = data.is_public;
            
            const modal = new bootstrap.Modal(document.getElementById('settingModal'));
            modal.show();
        });
}

function viewSetting(id) {
    fetch(`/api/payment-settings/${id}`)
        .then(response => response.json())
        .then(data => {
            const details = `
                <div class="row">
                    <div class="col-md-6">
                        <strong>Setting Key:</strong><br>
                        <code>${data.setting_key}</code>
                    </div>
                    <div class="col-md-6">
                        <strong>Setting Value:</strong><br>
                        ${data.setting_value}
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <strong>Type:</strong> ${data.setting_type}
                    </div>
                    <div class="col-md-6">
                        <strong>Group:</strong> ${data.setting_group}
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <strong>Description:</strong><br>
                        ${data.description || 'N/A'}
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <strong>Public:</strong> ${data.is_public ? 'Yes' : 'No'}
                    </div>
                    <div class="col-md-6">
                        <strong>Created:</strong> ${new Date(data.created_at).toLocaleString()}
                    </div>
                </div>
            `;
            
            document.getElementById('settingDetails').innerHTML = details;
            const modal = new bootstrap.Modal(document.getElementById('viewSettingModal'));
            modal.show();
        });
}

function deleteSetting(id) {
    currentDeleteId = id;
    fetch(`/api/payment-settings/${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('deleteSettingName').textContent = data.setting_key;
            const modal = new bootstrap.Modal(document.getElementById('deleteSettingModal'));
            modal.show();
        });
}

function confirmDelete() {
    if (currentDeleteId) {
        fetch(`/api/payment-settings/${currentDeleteId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error deleting setting: ' + data.message);
            }
        });
    }
}

function refreshSettings() {
    location.reload();
}
</script>
@endpush
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
