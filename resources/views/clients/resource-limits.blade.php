@extends('layouts.app')

@section('title', 'Resource Limits')
@section('description', 'Monitor and manage client resource limits')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">Resource Limits</h5>
                    <p class="card-subtitle">Monitor and manage client resource limits</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-success" onclick="addLimits()">
                        <i class="bx bx-plus me-1"></i> Add Limits
                    </button>
                    <button class="btn btn-outline-primary" onclick="exportLimits()">
                        <i class="bx bx-download me-1"></i> Export
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- Resource Statistics -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-primary bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-user text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Clients</h6>
                                <h4 class="mb-0">{{ count($clients) }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-success bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-check-circle text-success"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Normal Usage</h6>
                                <h4 class="mb-0 text-success">{{ collect($clients)->where('status', 'active')->count() }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-warning bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-error text-warning"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Warning Usage</h6>
                                <h4 class="mb-0 text-warning">{{ collect($clients)->where('status', 'warning')->count() }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-danger bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-error-circle text-danger"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Critical Usage</h6>
                                <h4 class="mb-0 text-danger">{{ collect($clients)->where('status', 'critical')->count() }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Resource Limits Table -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Client</th>
                                <th>Package</th>
                                <th>Disk Space</th>
                                <th>Bandwidth</th>
                                <th>Domains</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clients as $client)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar bg-primary bg-opacity-10 rounded-circle me-2" style="width: 32px; height: 32px;">
                                            <i class="bx bx-user text-primary"></i>
                                        </div>
                                        <div>
                                            <strong>{{ $client['name'] }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $client['email'] }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge bg-info">{{ $client['package'] }}</span></td>
                                <td>
                                    <div class="mb-1">
                                        <small>{{ $client['disk_used'] }} / {{ $client['disk_limit'] }}</small>
                                    </div>
                                    <div class="progress" style="height: 6px;">
                                        @php
                                            $diskPercent = (floatval(str_replace(' GB', '', $client['disk_used'])) / floatval(str_replace(' GB', '', $client['disk_limit']))) * 100;
                                        @endphp
                                        <div class="progress-bar bg-{{ $diskPercent > 80 ? 'danger' : ($diskPercent > 60 ? 'warning' : 'success') }}" 
                                             style="width: {{ min($diskPercent, 100) }}%"></div>
                                    </div>
                                </td>
                                <td>
                                    <div class="mb-1">
                                        <small>{{ $client['bandwidth_used'] }} / {{ $client['bandwidth_limit'] }}</small>
                                    </div>
                                    <div class="progress" style="height: 6px;">
                                        @php
                                            $bandwidthPercent = (floatval(str_replace([' GB', ' TB'], ['', '1024'], $client['bandwidth_used'])) / floatval(str_replace([' GB', 'TB'], ['', '1024'], $client['bandwidth_limit']))) * 100;
                                        @endphp
                                        <div class="progress-bar bg-{{ $bandwidthPercent > 80 ? 'danger' : ($bandwidthPercent > 60 ? 'warning' : 'success') }}" 
                                             style="width: {{ min($bandwidthPercent, 100) }}%"></div>
                                    </div>
                                </td>
                                <td>
                                    <div class="mb-1">
                                        <small>{{ $client['domains_used'] }} / {{ $client['domains_limit'] }}</small>
                                    </div>
                                    <div class="progress" style="height: 6px;">
                                        @php
                                            $domainsPercent = ($client['domains_used'] / $client['domains_limit']) * 100;
                                        @endphp
                                        <div class="progress-bar bg-{{ $domainsPercent > 80 ? 'danger' : ($domainsPercent > 60 ? 'warning' : 'success') }}" 
                                             style="width: {{ min($domainsPercent, 100) }}%"></div>
                                    </div>
                                </td>
                                <td>
                                    <div class="mb-1">
                                        <small>{{ $client['email_used'] }} / {{ $client['email_limit'] }}</small>
                                    </div>
                                    <div class="progress" style="height: 6px;">
                                        @php
                                            $emailPercent = ($client['email_used'] / $client['email_limit']) * 100;
                                        @endphp
                                        <div class="progress-bar bg-{{ $emailPercent > 80 ? 'danger' : ($emailPercent > 60 ? 'warning' : 'success') }}" 
                                             style="width: {{ min($emailPercent, 100) }}%"></div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $client['status'] == 'active' ? 'success' : ($client['status'] == 'warning' ? 'warning' : 'danger') }}">
                                        {{ $client['status'] }}
                                    </span>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a href="#" class="dropdown-item" onclick="viewDetails({{ $client['id'] }})">
                                                <i class="bx bx-eye me-2"></i> View Details
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="adjustLimits({{ $client['id'] }})">
                                                <i class="bx bx-adjust me-2"></i> Adjust Limits
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="upgradePackage({{ $client['id'] }})">
                                                <i class="bx bx-upgrade me-2"></i> Upgrade Package
                                            </a>
                                            <a href="#" class="dropdown-item" onclick="sendWarning({{ $client['id'] }})">
                                                <i class="bx bx-bell me-2"></i> Send Warning
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item text-warning" onclick="suspendClient({{ $client['id'] }})">
                                                <i class="bx bx-pause me-2"></i> Suspend
                                            </a>
                                            <a href="#" class="dropdown-item text-danger" onclick="terminateClient({{ $client['id'] }})">
                                                <i class="bx bx-x-circle me-2"></i> Terminate
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Resource Usage Charts -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Disk Space Usage Distribution</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="diskChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Bandwidth Usage Distribution</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="bandwidthChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Resource Limit Settings -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Resource Limit Settings</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="mb-3">Warning Thresholds</h6>
                                        <div class="mb-3">
                                            <label for="diskWarning" class="form-label">Disk Space Warning (%)</label>
                                            <input type="number" class="form-control" id="diskWarning" value="80" min="50" max="95">
                                        </div>
                                        <div class="mb-3">
                                            <label for="bandwidthWarning" class="form-label">Bandwidth Warning (%)</label>
                                            <input type="number" class="form-control" id="bandwidthWarning" value="80" min="50" max="95">
                                        </div>
                                        <div class="mb-3">
                                            <label for="domainsWarning" class="form-label">Domains Warning (%)</label>
                                            <input type="number" class="form-control" id="domainsWarning" value="80" min="50" max="95">
                                        </div>
                                        <div class="mb-3">
                                            <label for="emailWarning" class="form-label">Email Warning (%)</label>
                                            <input type="number" class="form-control" id="emailWarning" value="80" min="50" max="95">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="mb-3">Notification Settings</h6>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="emailNotifications" checked>
                                            <label class="form-check-label" for="emailNotifications">
                                                Send email notifications to clients
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="adminNotifications" checked>
                                            <label class="form-check-label" for="adminNotifications">
                                                Send notifications to administrators
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="autoSuspend" checked>
                                            <label class="form-check-label" for="autoSuspend">
                                                Auto-suspend on limit exceeded
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="dailyReports" checked>
                                            <label class="form-check-label" for="dailyReports">
                                                Send daily usage reports
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-primary" onclick="saveResourceSettings()">
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Disk Space Usage Chart
const diskCtx = document.getElementById('diskChart').getContext('2d');
new Chart(diskCtx, {
    type: 'doughnut',
    data: {
        labels: ['John Doe', 'Jane Smith', 'Bob Johnson'],
        datasets: [{
            data: [15.2, 8.5, 180],
            backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

// Bandwidth Usage Chart
const bandwidthCtx = document.getElementById('bandwidthChart').getContext('2d');
new Chart(bandwidthCtx, {
    type: 'doughnut',
    data: {
        labels: ['John Doe', 'Jane Smith', 'Bob Johnson'],
        datasets: [{
            data: [125, 85, 1800],
            backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

function addLimits() {
    showNotification('Add resource limits dialog opened', 'info');
}

function exportLimits() {
    showNotification('Exporting resource limits...', 'info');
}

function viewDetails(id) {
    // Find client data and show detailed resource information
    const clientData = findClientResourceData(id);
    if (clientData) {
        const details = `
            Client: ${clientData.name}
            Email: ${clientData.email}
            Package: ${clientData.package}
            Status: ${clientData.status}
            
            Resource Usage:
            Disk: ${clientData.disk_used} / ${clientData.disk_limit}
            Bandwidth: ${clientData.bandwidth_used} / ${clientData.bandwidth_limit}
            Domains: ${clientData.domains_used} / ${clientData.domains_limit}
            Email: ${clientData.email_used} / ${clientData.email_limit}
            CPU: ${clientData.cpu_usage}
            Memory: ${clientData.memory_usage}
            Email Accounts: ${clientData.email_accounts}
            Databases: ${clientData.databases}
        `;
        showNotification(`Resource Details:\\n${details}`, 'info');
    } else {
        showNotification('Client data not found', 'error');
    }
}

function adjustLimits(id) {
    const clientData = findClientResourceData(id);
    if (clientData) {
        // Create a simple prompt interface for adjusting limits
        const newDiskLimit = prompt(`Current disk limit: ${clientData.disk_limit}\\nEnter new disk limit (in GB):`, clientData.disk_limit.replace(' GB', ''));
        const newBandwidthLimit = prompt(`Current bandwidth limit: ${clientData.bandwidth_limit}\\nEnter new bandwidth limit (in GB):`, clientData.bandwidth_limit.replace(' GB', ''));
        const newDomainsLimit = prompt(`Current domains limit: ${clientData.domains_limit}\\nEnter new domains limit:`, clientData.domains_limit);
        const newEmailLimit = prompt(`Current email limit: ${clientData.email_limit}\\nEnter new email limit:`, clientData.email_limit);
        
        if (newDiskLimit && newBandwidthLimit && newDomainsLimit && newEmailLimit) {
            showNotification(`Resource limits updated for client ${id}:\\nDisk: ${newDiskLimit} GB\\nBandwidth: ${newBandwidthLimit} GB\\nDomains: ${newDomainsLimit}\\nEmail: ${newEmailLimit}`, 'success');
            // In a real application, this would make an API call to update the database
        } else {
            showNotification('Please provide valid values for all limits', 'error');
        }
    } else {
        showNotification('Client data not found', 'error');
    }
}

function upgradePackage(id) {
    const clientData = findClientResourceData(id);
    if (clientData) {
        const currentPackage = clientData.package;
        const packages = ['Starter', 'Professional', 'Enterprise'];
        const currentIndex = packages.indexOf(currentPackage);
        
        if (currentIndex < packages.length - 1) {
            const newPackage = packages[currentIndex + 1];
            const packagePrices = { 'Starter': '$9.99', 'Professional': '$29.99', 'Enterprise': '$99.99' };
            
            if (confirm(`Upgrade from ${currentPackage} (${packagePrices[currentPackage]}) to ${newPackage} (${packagePrices[newPackage]})?\\nThis will change the monthly billing.`)) {
                showNotification(`Package upgraded from ${currentPackage} to ${newPackage} for client ${id}`, 'success');
                // In a real application, this would make an API call to update the package
            }
        } else {
            showNotification(`Client ${id} already has the highest package (${currentPackage})`, 'warning');
        }
    } else {
        showNotification('Client data not found', 'error');
    }
}

function sendWarning(id) {
    const clientData = findClientResourceData(id);
    if (clientData) {
        const warningTypes = [
            'Disk space usage warning',
            'Bandwidth limit approaching',
            'Domain limit exceeded',
            'Email account quota warning',
            'Resource usage notification',
            'Account suspension warning'
        ];
        
        const selectedWarning = prompt(`Select warning type for ${clientData.name}:\\n\\n1. ${warningTypes[0]}\\n2. ${warningTypes[1]}\\n3. ${warningTypes[2]}\\n4. ${warningTypes[3]}\\n5. ${warningTypes[4]}\\n6. ${warningTypes[5]}\\n\\nEnter number (1-6):`);
        
        if (selectedWarning && selectedWarning >= 1 && selectedWarning <= 6) {
            const warningType = warningTypes[selectedWarning - 1];
            const customMessage = prompt(`Custom message (optional):`, `Your ${warningType.toLowerCase()} requires immediate attention.`);
            
            showNotification(`Warning sent to ${clientData.name}: ${warningType}\\nMessage: ${customMessage}`, 'success');
            // In a real application, this would send an email/notification to the client
        } else if (selectedWarning !== null) {
            showNotification('Please select a valid warning type (1-6)', 'error');
        }
    } else {
        showNotification('Client data not found', 'error');
    }
}

function suspendClient(id) {
    const clientData = findClientResourceData(id);
    if (clientData) {
        const suspensionReasons = [
            'Non-payment',
            'Resource abuse',
            'Terms of service violation',
            'Security concerns',
            'Exceeded resource limits',
            'Other'
        ];
        
        const reason = prompt(`Suspend ${clientData.name}?\\n\\nReason for suspension:\\n1. ${suspensionReasons[0]}\\n2. ${suspensionReasons[1]}\\n3. ${suspensionReasons[2]}\\n4. ${suspensionReasons[3]}\\n5. ${suspensionReasons[4]}\\n6. ${suspensionReasons[5]}\\n\\nEnter number (1-6):`);
        
        if (reason && reason >= 1 && reason <= 6) {
            const suspensionReason = suspensionReasons[reason - 1];
            const notes = prompt(`Additional notes (optional):`);
            
            if (confirm(`Are you sure you want to suspend ${clientData.name} for "${suspensionReason}"?\\nThis will disable all services.`)) {
                showNotification(`Client ${id} suspended\\nReason: ${suspensionReason}\\nNotes: ${notes || 'None'}`, 'warning');
                // In a real application, this would make an API call to suspend the client
            }
        } else if (reason !== null) {
            showNotification('Please select a valid reason (1-6)', 'error');
        }
    } else {
        showNotification('Client data not found', 'error');
    }
}

function terminateClient(id) {
    const clientData = findClientResourceData(id);
    if (clientData) {
        const terminationReasons = [
            'Request by client',
            'Non-payment',
            'Terms of service violation',
            'Security breach',
            'Account abandonment',
            'Other'
        ];
        
        const reason = prompt(`TERMINATE ${clientData.name.toUpperCase()}?\\n\\n⚠️  THIS ACTION CANNOT BE UNDONE ⚠️\\n\\nAll data will be permanently deleted.\\n\\nReason for termination:\\n1. ${terminationReasons[0]}\\n2. ${terminationReasons[1]}\\n3. ${terminationReasons[2]}\\n4. ${terminationReasons[3]}\\n5. ${terminationReasons[4]}\\n6. ${terminationReasons[5]}\\n\\nEnter number (1-6):`);
        
        if (reason && reason >= 1 && reason <= 6) {
            const terminationReason = terminationReasons[reason - 1];
            const confirmation = prompt(`Type "TERMINATE" to confirm deletion of all data for ${clientData.name}:`);
            
            if (confirmation === 'TERMINATE') {
                showNotification(`🚨 CLIENT ${id} TERMINATED 🚨\\nClient: ${clientData.name}\\nReason: ${terminationReason}\\nAll data has been permanently deleted.`, 'danger');
                // In a real application, this would make an API call to terminate and delete all client data
            } else if (confirmation !== null) {
                showNotification('Termination cancelled - confirmation did not match "TERMINATE"', 'error');
            }
        } else if (reason !== null) {
            showNotification('Please select a valid reason (1-6)', 'error');
        }
    } else {
        showNotification('Client data not found', 'error');
    }
}

// Helper function to find client resource data
function findClientResourceData(id) {
    // This would typically come from the client data passed to the view
    // For now, we'll return a mock object with realistic data
    const packages = ['Starter', 'Professional', 'Enterprise'];
    const package = packages[Math.floor(Math.random() * packages.length)];
    
    return {
        id: id,
        name: `Client ${id}`,
        email: `client${id}@example.com`,
        package: package,
        status: 'active',
        disk_used: (Math.random() * 50).toFixed(1) + ' GB',
        disk_limit: (Math.random() * 50 + 50).toFixed(1) + ' GB',
        bandwidth_used: (Math.random() * 200).toFixed(1) + ' GB',
        bandwidth_limit: (Math.random() * 300 + 200).toFixed(1) + ' GB',
        domains_used: Math.floor(Math.random() * 10) + 1,
        domains_limit: Math.floor(Math.random() * 20) + 10,
        email_used: Math.floor(Math.random() * 25) + 1,
        email_limit: Math.floor(Math.random() * 50) + 25,
        cpu_usage: Math.floor(Math.random() * 80) + 10 + '%',
        memory_usage: Math.floor(Math.random() * 70) + 20 + '%',
        email_accounts: Math.floor(Math.random() * 50) + 5,
        databases: Math.floor(Math.random() * 10) + 1
    };
}

function saveResourceSettings() {
    showNotification('Resource limit settings saved successfully', 'success');
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
