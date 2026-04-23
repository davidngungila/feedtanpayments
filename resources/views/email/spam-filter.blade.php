@extends('layouts.app')

@section('title', 'Spam Filter')
@section('description', 'Manage spam filter settings and protection')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">Spam Filter</h5>
                    <p class="card-subtitle">Manage spam filter settings and protection</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-success" onclick="trainFilter()">
                        <i class="bx bx-graduation me-1"></i> Train Filter
                    </button>
                    <button class="btn btn-outline-primary" onclick="updateRules()">
                        <i class="bx bx-refresh me-1"></i> Update Rules
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- Spam Filter Statistics -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-primary bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-shield text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Status</h6>
                                <h4 class="mb-0 text-success">Active</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-warning bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-x-circle text-warning"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Blocked Today</h6>
                                <h4 class="mb-0 text-warning">{{ $spamSettings['blocked_today'] }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-info bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-list-check text-info"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Quarantine</h6>
                                <h4 class="mb-0 text-info">{{ $spamSettings['quarantine_count'] }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-success bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-check-circle text-success"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Whitelist</h6>
                                <h4 class="mb-0 text-success">{{ $spamSettings['whitelist_count'] }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Spam Filter Configuration -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Filter Settings</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="enableSpamFilter" {{ $spamSettings['enabled'] ? 'checked' : '' }}>
                                    <label class="form-check-label" for="enableSpamFilter">
                                        Enable Spam Filter
                                    </label>
                                </div>
                                <div class="mb-3">
                                    <label for="spamLevel" class="form-label">Spam Sensitivity Level</label>
                                    <select class="form-select" id="spamLevel">
                                        <option value="low" {{ $spamSettings['spam_level'] == 'low' ? 'selected' : '' }}>Low</option>
                                        <option value="medium" {{ $spamSettings['spam_level'] == 'medium' ? 'selected' : '' }}>Medium</option>
                                        <option value="high" {{ $spamSettings['spam_level'] == 'high' ? 'selected' : '' }}>High</option>
                                        <option value="aggressive" {{ $spamSettings['spam_level'] == 'aggressive' ? 'selected' : '' }}>Aggressive</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="spamAction" class="form-label">Spam Action</label>
                                    <select class="form-select" id="spamAction">
                                        <option value="move_to_folder" {{ $spamSettings['action'] == 'move_to_folder' ? 'selected' : '' }}>Move to Spam Folder</option>
                                        <option value="delete" {{ $spamSettings['action'] == 'delete' ? 'selected' : '' }}>Delete Immediately</option>
                                        <option value="quarantine" {{ $spamSettings['action'] == 'quarantine' ? 'selected' : '' }}>Quarantine</option>
                                        <option value="tag_subject" {{ $spamSettings['action'] == 'tag_subject' ? 'selected' : '' }}>Tag Subject</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="spamFolder" class="form-label">Spam Folder</label>
                                    <input type="text" class="form-control" id="spamFolder" value="{{ $spamSettings['spam_folder'] }}">
                                </div>
                                <button class="btn btn-primary" onclick="saveSpamSettings()">
                                    <i class="bx bx-save me-1"></i> Save Settings
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Spam Statistics</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="spamChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Blacklist Management -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Blacklist</h6>
                                <button class="btn btn-outline-success btn-sm" onclick="addToBlacklist()">
                                    <i class="bx bx-plus me-1"></i> Add
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Email/Domain</th>
                                                <th>Type</th>
                                                <th>Added</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><code>spam@spam.com</code></td>
                                                <td><span class="badge bg-danger">Email</span></td>
                                                <td>2024-11-15</td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-danger" onclick="removeFromBlacklist('spam@spam.com')">
                                                        <i class="bx bx-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><code>spamdomain.com</code></td>
                                                <td><span class="badge bg-warning">Domain</span></td>
                                                <td>2024-11-20</td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-danger" onclick="removeFromBlacklist('spamdomain.com')">
                                                        <i class="bx bx-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><code>fake@fake.com</code></td>
                                                <td><span class="badge bg-danger">Email</span></td>
                                                <td>2024-11-25</td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-danger" onclick="removeFromBlacklist('fake@fake.com')">
                                                        <i class="bx bx-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-2">
                                    <small class="text-muted">Total: {{ $spamSettings['blacklist_count'] }} entries</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Whitelist</h6>
                                <button class="btn btn-outline-success btn-sm" onclick="addToWhitelist()">
                                    <i class="bx bx-plus me-1"></i> Add
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Email/Domain</th>
                                                <th>Type</th>
                                                <th>Added</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><code>trusted@trusted.com</code></td>
                                                <td><span class="badge bg-success">Email</span></td>
                                                <td>2024-11-10</td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-danger" onclick="removeFromWhitelist('trusted@trusted.com')">
                                                        <i class="bx bx-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><code>trusteddomain.com</code></td>
                                                <td><span class="badge bg-info">Domain</span></td>
                                                <td>2024-11-12</td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-danger" onclick="removeFromWhitelist('trusteddomain.com')">
                                                        <i class="bx bx-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><code>partner@partner.com</code></td>
                                                <td><span class="badge bg-success">Email</span></td>
                                                <td>2024-11-18</td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-danger" onclick="removeFromWhitelist('partner@partner.com')">
                                                        <i class="bx bx-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-2">
                                    <small class="text-muted">Total: {{ $spamSettings['whitelist_count'] }} entries</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quarantine Management -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Quarantine</h6>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-outline-success btn-sm" onclick="releaseSelected()">
                                        <i class="bx bx-check me-1"></i> Release Selected
                                    </button>
                                    <button class="btn btn-outline-danger btn-sm" onclick="deleteSelected()">
                                        <i class="bx bx-trash me-1"></i> Delete Selected
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" id="selectAll" onchange="toggleSelectAll()"></th>
                                                <th>From</th>
                                                <th>Subject</th>
                                                <th>Score</th>
                                                <th>Date</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><input type="checkbox" class="row-select"></td>
                                                <td><code>spam@spam.com</code></td>
                                                <td class="text-truncate" style="max-width: 200px;">Suspicious Offer</td>
                                                <td><span class="badge bg-danger">9.8</span></td>
                                                <td>2024-12-22 14:30</td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-success" onclick="releaseEmail('1')">
                                                        <i class="bx bx-check"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-info" onclick="viewEmail('1')">
                                                        <i class="bx bx-eye"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-danger" onclick="deleteEmail('1')">
                                                        <i class="bx bx-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" class="row-select"></td>
                                                <td><code>fake@fake.com</code></td>
                                                <td class="text-truncate" style="max-width: 200px;">You Won Prize</td>
                                                <td><span class="badge bg-danger">9.5</span></td>
                                                <td>2024-12-22 13:45</td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-success" onclick="releaseEmail('2')">
                                                        <i class="bx bx-check"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-info" onclick="viewEmail('2')">
                                                        <i class="bx bx-eye"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-danger" onclick="deleteEmail('2')">
                                                        <i class="bx bx-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-2">
                                    <small class="text-muted">Showing 2 of {{ $spamSettings['quarantine_count'] }} quarantined emails</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter Rules -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Custom Filter Rules</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Rule Name</th>
                                                <th>Condition</th>
                                                <th>Action</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><strong>Block Viagra</strong></td>
                                                <td>Subject contains "viagra"</td>
                                                <td><span class="badge bg-danger">Block</span></td>
                                                <td><span class="badge bg-success">Active</span></td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-warning" onclick="editRule('1')">
                                                        <i class="bx bx-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-danger" onclick="deleteRule('1')">
                                                        <i class="bx bx-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Block Lottery</strong></td>
                                                <td>Subject contains "lottery"</td>
                                                <td><span class="badge bg-danger">Block</span></td>
                                                <td><span class="badge bg-success">Active</span></td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-warning" onclick="editRule('2')">
                                                        <i class="bx bx-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-danger" onclick="deleteRule('2')">
                                                        <i class="bx bx-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-2">
                                    <button class="btn btn-outline-primary" onclick="addRule()">
                                        <i class="bx bx-plus me-1"></i> Add Rule
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Spam Statistics Chart
const spamCtx = document.getElementById('spamChart').getContext('2d');
new Chart(spamCtx, {
    type: 'line',
    data: {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        datasets: [{
            label: 'Spam Blocked',
            data: [45, 52, 38, 65, 59, 42, 35],
            borderColor: '#dc3545',
            backgroundColor: 'rgba(220, 53, 69, 0.1)',
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

function trainFilter() {
    showNotification('Training spam filter with new data...', 'info');
}

function updateRules() {
    showNotification('Updating spam filter rules...', 'info');
}

function saveSpamSettings() {
    showNotification('Spam filter settings saved successfully', 'success');
}

function addToBlacklist() {
    showNotification('Add to blacklist dialog opened', 'info');
}

function removeFromBlacklist(email) {
    if (confirm(`Are you sure you want to remove ${email} from blacklist?`)) {
        showNotification(`Removed ${email} from blacklist`, 'warning');
    }
}

function addToWhitelist() {
    showNotification('Add to whitelist dialog opened', 'info');
}

function removeFromWhitelist(email) {
    if (confirm(`Are you sure you want to remove ${email} from whitelist?`)) {
        showNotification(`Removed ${email} from whitelist`, 'warning');
    }
}

function toggleSelectAll() {
    const checkboxes = document.querySelectorAll('.row-select');
    const selectAll = document.getElementById('selectAll');
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAll.checked;
    });
}

function releaseSelected() {
    const selected = document.querySelectorAll('.row-select:checked');
    if (selected.length === 0) {
        showNotification('No emails selected', 'warning');
        return;
    }
    
    if (confirm(`Are you sure you want to release ${selected.length} selected emails?`)) {
        showNotification(`Released ${selected.length} emails from quarantine`, 'success');
    }
}

function deleteSelected() {
    const selected = document.querySelectorAll('.row-select:checked');
    if (selected.length === 0) {
        showNotification('No emails selected', 'warning');
        return;
    }
    
    if (confirm(`Are you sure you want to delete ${selected.length} selected emails?`)) {
        showNotification(`Deleted ${selected.length} emails from quarantine`, 'danger');
    }
}

function releaseEmail(id) {
    if (confirm('Are you sure you want to release this email?')) {
        showNotification('Email released from quarantine', 'success');
    }
}

function viewEmail(id) {
    showNotification('Viewing email content...', 'info');
}

function deleteEmail(id) {
    if (confirm('Are you sure you want to delete this email?')) {
        showNotification('Email deleted from quarantine', 'danger');
    }
}

function addRule() {
    showNotification('Add filter rule dialog opened', 'info');
}

function editRule(id) {
    showNotification(`Editing filter rule ${id}...`, 'info');
}

function deleteRule(id) {
    if (confirm('Are you sure you want to delete this rule?')) {
        showNotification('Filter rule deleted', 'danger');
    }
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
