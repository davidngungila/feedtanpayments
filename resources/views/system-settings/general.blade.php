@extends('layouts.app')

@section('title', 'General Settings - FeedTan Pay')

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Page Header -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-6">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div class="mb-3 mb-md-0">
                                <h4 class="fw-bold mb-2">
                                    <i class="bx bx-cog me-2 text-primary"></i>
                                    General Settings
                                </h4>
                                <p class="text-muted mb-0">Manage system-wide configuration parameters and preferences</p>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-primary" onclick="addSetting()">
                                    <i class="bx bx-plus me-2"></i>Add Setting
                                </button>
                                <button type="button" class="btn btn-outline-secondary" onclick="refreshSettings()">
                                    <i class="bx bx-refresh me-2"></i>Refresh
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alerts -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bx bx-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bx bx-error-circle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Statistics Cards -->
        <div class="row mb-6">
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-primary bg-opacity-10 rounded-circle me-3" style="width: 48px; height: 48px;">
                                <i class="bx bx-cog text-primary fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Settings</h6>
                                <h4 class="mb-0">{{ $settings->count() }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-success bg-opacity-10 rounded-circle me-3" style="width: 48px; height: 48px;">
                                <i class="bx bx-check-shield text-success fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Public Settings</h6>
                                <h4 class="mb-0">{{ $settings->where('is_public', true)->count() }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-warning bg-opacity-10 rounded-circle me-3" style="width: 48px; height: 48px;">
                                <i class="bx bx-lock text-warning fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Private Settings</h6>
                                <h4 class="mb-0">{{ $settings->where('is_public', false)->count() }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-info bg-opacity-10 rounded-circle me-3" style="width: 48px; height: 48px;">
                                <i class="bx bx-category text-info fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Data Types</h6>
                                <h4 class="mb-0">{{ $settings->pluck('setting_type')->unique()->count() }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Settings Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0">
                                <i class="bx bx-list-ul me-2"></i>
                                System Configuration
                            </h5>
                            <small class="text-muted">Manage all system settings and parameters</small>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="bx bx-filter me-1"></i>Filter
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="javascript:void(0)" onclick="filterSettings('all')">All Settings</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0)" onclick="filterSettings('public')">Public Only</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0)" onclick="filterSettings('private')">Private Only</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="javascript:void(0)" onclick="filterSettings('text')">Text Type</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0)" onclick="filterSettings('number')">Number Type</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0)" onclick="filterSettings('boolean')">Boolean Type</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0)" onclick="filterSettings('json')">JSON Type</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="settingsTable">
                                <thead>
                                    <tr>
                                        <th>
                                            <i class="bx bx-key me-1"></i>
                                            Setting Key
                                        </th>
                                        <th>
                                            <i class="bx bx-data me-1"></i>
                                            Value
                                        </th>
                                        <th>
                                            <i class="bx bx-tag me-1"></i>
                                            Type
                                        </th>
                                        <th>
                                            <i class="bx bx-info-circle me-1"></i>
                                            Description
                                        </th>
                                        <th>
                                            <i class="bx bx-shield me-1"></i>
                                            Public
                                        </th>
                                        <th>
                                            <i class="bx bx-cog me-1"></i>
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($settings as $setting)
                                        <tr data-type="{{ $setting->setting_type }}" data-public="{{ $setting->is_public ? 'public' : 'private' }}">
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar bg-primary bg-opacity-10 rounded-circle me-2" style="width: 32px; height: 32px;">
                                                        <i class="bx bx-key text-primary"></i>
                                                    </div>
                                                    <code class="text-primary">{{ $setting->setting_key }}</code>
                                                </div>
                                            </td>
                                            <td>
                                                @if ($setting->setting_type === 'boolean')
                                                    <span class="badge bg-{{ $setting->setting_value === 'true' ? 'success' : 'danger' }} px-3 py-2">
                                                        <i class="bx bx-{{ $setting->setting_value === 'true' ? 'check' : 'x' }} me-1"></i>
                                                        {{ $setting->setting_value === 'true' ? 'Enabled' : 'Disabled' }}
                                                    </span>
                                                @elseif ($setting->setting_type === 'json')
                                                    <code class="bg-light p-1 rounded">{{ Str::limit($setting->setting_value, 50) }}</code>
                                                @else
                                                    <span class="fw-medium">{{ Str::limit($setting->setting_value, 30) }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-info px-3 py-2">
                                                    <i class="bx bx-tag me-1"></i>
                                                    {{ $setting->setting_type }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="text-muted">{{ $setting->description ?? 'No description available' }}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $setting->is_public ? 'success' : 'secondary' }} px-3 py-2">
                                                    <i class="bx bx-{{ $setting->is_public ? 'world' : 'lock' }} me-1"></i>
                                                    {{ $setting->is_public ? 'Public' : 'Private' }}
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
                                                                <i class="bx bx-trash me-2 text-danger"></i>Delete
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-8">
                                                <div class="mb-4">
                                                    <i class="bx bx-inbox bx-lg text-muted"></i>
                                                </div>
                                                <h5 class="text-muted mb-2">No Settings Found</h5>
                                                <p class="text-muted mb-4">Get started by creating your first system setting.</p>
                                                <button type="button" class="btn btn-primary" onclick="addSetting()">
                                                    <i class="bx bx-plus me-2"></i>Create First Setting
                                                </button>
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="settingModalLabel">
                    <i class="bx bx-cog me-2"></i>Add Setting
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="settingForm" action="{{ route('system-settings.general.store') }}" method="POST">
                @csrf
                <input type="hidden" id="settingId" name="setting_id" value="">
                <input type="hidden" id="settingMethod" name="_method" value="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="settingKey" class="form-label">
                                    <i class="bx bx-key me-1"></i>Setting Key
                                </label>
                                <input type="text" class="form-control" id="settingKey" name="setting_key" required placeholder="e.g., app_name, max_users">
                                <small class="text-muted">Unique identifier for the setting</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="settingType" class="form-label">
                                    <i class="bx bx-tag me-1"></i>Setting Type
                                </label>
                                <select class="form-select" id="settingType" name="setting_type" required onchange="updateValueField()">
                                    <option value="text">Text</option>
                                    <option value="number">Number</option>
                                    <option value="boolean">Boolean</option>
                                    <option value="json">JSON</option>
                                </select>
                                <small class="text-muted">Data type of the setting value</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="settingValue" class="form-label">
                                    <i class="bx bx-data me-1"></i>Setting Value
                                </label>
                                <input type="text" class="form-control" id="settingValue" name="setting_value" required placeholder="Enter setting value">
                                <small class="text-muted">The actual value for this setting</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="settingGroup" class="form-label">
                                    <i class="bx bx-folder me-1"></i>Setting Group
                                </label>
                                <select class="form-select" id="settingGroup" name="setting_group" required>
                                    <option value="general">General</option>
                                    <option value="system">System</option>
                                    <option value="application">Application</option>
                                    <option value="security">Security</option>
                                    <option value="performance">Performance</option>
                                </select>
                                <small class="text-muted">Category for organizing settings</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="isPublic" class="form-label">
                                    <i class="bx bx-shield me-1"></i>Visibility
                                </label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" id="isPublic" name="is_public">
                                    <label class="form-check-label" for="isPublic">
                                        Make this setting public (accessible to API)
                                    </label>
                                </div>
                                <small class="text-muted">Public settings can be accessed via API endpoints</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="settingDescription" class="form-label">
                                    <i class="bx bx-info-circle me-1"></i>Description
                                </label>
                                <textarea class="form-control" id="settingDescription" name="description" rows="3" placeholder="Describe what this setting does..."></textarea>
                                <small class="text-muted">Detailed description of the setting's purpose</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x me-2"></i>Cancel
                    </button>
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="viewSettingModalLabel">
                    <i class="bx bx-eye me-2"></i>Setting Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="settingDetails"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x me-2"></i>Close
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteSettingModal" tabindex="-1" aria-labelledby="deleteSettingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteSettingModalLabel">
                    <i class="bx bx-trash me-2"></i>Delete Setting
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this setting? This action cannot be undone.</p>
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
    document.getElementById('settingModalLabel').textContent = 'Add Setting';
    document.getElementById('settingForm').reset();
    document.getElementById('settingId').value = '';
    document.getElementById('settingMethod').value = 'POST';
    document.getElementById('settingForm').action = '{{ route("system-settings.general.store") }}';
    
    const modal = new bootstrap.Modal(document.getElementById('settingModal'));
    modal.show();
}

function editSetting(id) {
    document.getElementById('settingModalLabel').textContent = 'Edit Setting';
    document.getElementById('settingId').value = id;
    document.getElementById('settingMethod').value = 'PUT';
    document.getElementById('settingForm').action = `/system-settings/general/${id}`;
    
    // Fetch setting data
    fetch(`/api/general-settings/${id}`)
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
    fetch(`/api/general-settings/${id}`)
        .then(response => response.json())
        .then(data => {
            const details = `
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">Setting Key</label>
                            <div><code class="bg-light p-2 rounded">${data.setting_key}</code></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted">Setting Value</label>
                            <div class="bg-light p-2 rounded">
                                ${data.setting_type === 'boolean' ? 
                                    `<span class="badge bg-${data.setting_value === 'true' ? 'success' : 'danger'}">${data.setting_value === 'true' ? 'Enabled' : 'Disabled'}</span>` :
                                    data.setting_type === 'json' ? 
                                    `<code>${data.setting_value}</code>` :
                                    `<span class="fw-medium">${data.setting_value}</span>`
                                }
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted">Setting Type</label>
                            <div><span class="badge bg-info">${data.setting_type}</span></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">Setting Group</label>
                            <div><span class="badge bg-primary">${data.setting_group}</span></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted">Visibility</label>
                            <div><span class="badge bg-${data.is_public ? 'success' : 'secondary'}">${data.is_public ? 'Public' : 'Private'}</span></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted">Description</label>
                            <div class="bg-light p-2 rounded">${data.description || 'No description available'}</div>
                        </div>
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
    fetch(`/api/general-settings/${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('deleteSettingName').textContent = `Setting: ${data.setting_key}`;
            
            const modal = new bootstrap.Modal(document.getElementById('deleteSettingModal'));
            modal.show();
        });
}

function confirmDelete() {
    if (currentDeleteId) {
        fetch(`/system-settings/general/${currentDeleteId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error deleting setting: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while deleting the setting.');
        });
    }
}

function refreshSettings() {
    location.reload();
}

function filterSettings(filter) {
    const table = document.getElementById('settingsTable');
    const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    
    for (let row of rows) {
        let showRow = false;
        
        switch(filter) {
            case 'all':
                showRow = true;
                break;
            case 'public':
                showRow = row.getAttribute('data-public') === 'public';
                break;
            case 'private':
                showRow = row.getAttribute('data-public') === 'private';
                break;
            default:
                showRow = row.getAttribute('data-type') === filter;
        }
        
        row.style.display = showRow ? '' : 'none';
    }
}

function updateValueField() {
    const type = document.getElementById('settingType').value;
    const valueField = document.getElementById('settingValue');
    
    // Clear any existing validation
    valueField.removeAttribute('min');
    valueField.removeAttribute('max');
    valueField.removeAttribute('step');
    
    switch(type) {
        case 'number':
            valueField.type = 'number';
            valueField.placeholder = 'Enter a numeric value';
            break;
        case 'boolean':
            valueField.type = 'text';
            valueField.placeholder = 'true or false';
            break;
        case 'json':
            valueField.type = 'text';
            valueField.placeholder = '{"key": "value"}';
            break;
        default:
            valueField.type = 'text';
            valueField.placeholder = 'Enter text value';
    }
}

// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    // Initialize any tooltips if needed
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endpush
@endsection
