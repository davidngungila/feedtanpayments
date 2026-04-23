<!-- Client Switcher Component -->
<div class="client-switcher">
    <div class="dropdown">
        <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="clientSwitcherDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bx bx-user me-1"></i>
            <span id="selectedClientName">Select Client</span>
        </button>
        <ul class="dropdown-menu" aria-labelledby="clientSwitcherDropdown" style="min-width: 300px;">
            <li class="dropdown-header">
                <div class="d-flex justify-content-between align-items-center">
                    <span>Switch Client</span>
                    <button type="button" class="btn btn-xs btn-outline-secondary" onclick="clearClientSelection()">
                        <i class="bx bx-x"></i>
                    </button>
                </div>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <div class="px-3 py-2">
                    <input type="text" class="form-control form-control-sm" id="clientSearchInput" placeholder="Search clients...">
                </div>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li id="clientListContainer">
                <div class="px-3 py-2 text-center">
                    <div class="spinner-border spinner-border-sm" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <small class="text-muted">Loading clients...</small>
                </div>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <a class="dropdown-item" href="{{ route('clients.create') }}">
                    <i class="bx bx-plus-circle me-2"></i>Add New Client
                </a>
            </li>
        </ul>
    </div>
</div>

@push('styles')
<style>
.client-switcher {
    position: relative;
}

.client-switcher .dropdown-menu {
    max-height: 400px;
    overflow-y: auto;
}

.client-item {
    cursor: pointer;
    transition: background-color 0.2s;
}

.client-item:hover {
    background-color: #f8f9fa;
}

.client-item.active {
    background-color: #e3f2fd;
    color: #1976d2;
}

.client-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.client-details {
    flex: 1;
}

.client-name {
    font-weight: 600;
    color: #333;
    margin-bottom: 2px;
}

.client-email {
    font-size: 0.875rem;
    color: #666;
    margin-bottom: 2px;
}

.client-company {
    font-size: 0.75rem;
    color: #888;
}

.client-balance {
    text-align: right;
    font-size: 0.875rem;
    font-weight: 500;
}

.client-balance.positive {
    color: #28a745;
}

.client-balance.negative {
    color: #dc3545;
}

.client-status {
    display: inline-block;
    padding: 2px 6px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 500;
}

.client-status.active {
    background-color: #d4edda;
    color: #155724;
}

.client-status.inactive {
    background-color: #f8f9fa;
    color: #6c757d;
}

.client-status.suspended {
    background-color: #f8d7da;
    color: #721c24;
}

.no-clients {
    text-align: center;
    padding: 20px;
    color: #6c757d;
}

.search-highlight {
    background-color: #fff3cd;
    padding: 1px 2px;
    border-radius: 2px;
}
</style>
@endpush

@push('scripts')
<script>
// Client Switcher JavaScript
let currentClient = null;
let allClients = [];
let searchTimeout = null;

document.addEventListener('DOMContentLoaded', function() {
    loadClients();
    loadCurrentClient();
    
    // Setup search functionality
    const searchInput = document.getElementById('clientSearchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                searchClients(e.target.value);
            }, 300);
        });
    }
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.client-switcher')) {
            const dropdown = document.querySelector('.client-switcher .dropdown-menu');
            if (dropdown && dropdown.classList.contains('show')) {
                bootstrap.Dropdown.getInstance(document.getElementById('clientSwitcherDropdown'))?.hide();
            }
        }
    });
});

function loadClients() {
    fetch('/api/clients/dropdown')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                allClients = data.clients;
                renderClientList(allClients);
            } else {
                console.error('Error loading clients:', data.message);
                showClientListError();
            }
        })
        .catch(error => {
            console.error('Error loading clients:', error);
            showClientListError();
        });
}

function loadCurrentClient() {
    fetch('/api/clients/current')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                currentClient = data.client;
                updateSelectedClientDisplay(currentClient);
            } else {
                updateSelectedClientDisplay(null);
            }
        })
        .catch(error => {
            console.error('Error loading current client:', error);
            updateSelectedClientDisplay(null);
        });
}

function renderClientList(clients) {
    const container = document.getElementById('clientListContainer');
    
    if (clients.length === 0) {
        container.innerHTML = `
            <div class="no-clients">
                <i class="bx bx-user-x" style="font-size: 2rem; margin-bottom: 10px;"></i>
                <p>No clients found</p>
                <small>Add your first client to get started</small>
            </div>
        `;
        return;
    }
    
    let html = '';
    clients.forEach(client => {
        const isActive = currentClient && currentClient.id === client.id;
        const balanceClass = client.balance >= 0 ? 'positive' : 'negative';
        const statusClass = client.status || 'active';
        
        html += `
            <li>
                <div class="dropdown-item client-item ${isActive ? 'active' : ''}" onclick="switchToClient(${client.id})">
                    <div class="client-info">
                        <div class="client-details">
                            <div class="client-name">${highlightSearchTerm(client.name)}</div>
                            ${client.email ? `<div class="client-email">${highlightSearchTerm(client.email)}</div>` : ''}
                            ${client.company ? `<div class="client-company">${highlightSearchTerm(client.company)}</div>` : ''}
                        </div>
                        <div class="client-balance ${balanceClass}">
                            TZS ${formatNumber(Math.abs(client.balance))}
                            ${client.balance < 0 ? '<i class="bx bx-down-arrow-alt"></i>' : ''}
                        </div>
                    </div>
                    <div class="mt-1">
                        <span class="client-status ${statusClass}">${client.status || 'Active'}</span>
                    </div>
                </div>
            </li>
        `;
    });
    
    container.innerHTML = html;
}

function switchToClient(clientId) {
    const client = allClients.find(c => c.id === clientId);
    if (!client) return;
    
    const formData = new FormData();
    formData.append('client_id', clientId);
    
    fetch('/api/clients/switch', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            currentClient = data.client;
            updateSelectedClientDisplay(currentClient);
            
            // Update active state in dropdown
            document.querySelectorAll('.client-item').forEach(item => {
                item.classList.remove('active');
            });
            event.target.closest('.client-item').classList.add('active');
            
            // Show success notification
            showNotification(data.message, 'success');
            
            // Close dropdown
            bootstrap.Dropdown.getInstance(document.getElementById('clientSwitcherDropdown'))?.hide();
            
            // Reload page to update client-specific data
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } else {
            showNotification('Error switching client: ' + (data.message || 'Unknown error'), 'error');
        }
    })
    .catch(error => {
        console.error('Error switching client:', error);
        showNotification('Error switching client', 'error');
    });
}

function clearClientSelection() {
    fetch('/api/clients/clear', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            currentClient = null;
            updateSelectedClientDisplay(null);
            
            // Remove active state from all client items
            document.querySelectorAll('.client-item').forEach(item => {
                item.classList.remove('active');
            });
            
            showNotification(data.message, 'info');
            
            // Close dropdown
            bootstrap.Dropdown.getInstance(document.getElementById('clientSwitcherDropdown'))?.hide();
            
            // Reload page to clear client-specific data
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } else {
            showNotification('Error clearing client selection', 'error');
        }
    })
    .catch(error => {
        console.error('Error clearing client selection:', error);
        showNotification('Error clearing client selection', 'error');
    });
}

function updateSelectedClientDisplay(client) {
    const nameElement = document.getElementById('selectedClientName');
    
    if (client) {
        nameElement.textContent = client.name;
        nameElement.title = `${client.name}${client.company ? ' - ' + client.company : ''}`;
    } else {
        nameElement.textContent = 'Select Client';
        nameElement.title = 'Select a client to work with';
    }
}

function searchClients(query) {
    if (!query.trim()) {
        renderClientList(allClients);
        return;
    }
    
    const filteredClients = allClients.filter(client => {
        const searchLower = query.toLowerCase();
        return client.name.toLowerCase().includes(searchLower) ||
               (client.email && client.email.toLowerCase().includes(searchLower)) ||
               (client.company && client.company.toLowerCase().includes(searchLower));
    });
    
    renderClientList(filteredClients);
}

function highlightSearchTerm(text) {
    const searchInput = document.getElementById('clientSearchInput');
    if (!searchInput || !searchInput.value.trim()) return text;
    
    const searchTerm = searchInput.value.trim();
    const regex = new RegExp(`(${searchTerm})`, 'gi');
    return text.replace(regex, '<span class="search-highlight">$1</span>');
}

function formatNumber(num) {
    return num.toLocaleString('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}

function showClientListError() {
    const container = document.getElementById('clientListContainer');
    container.innerHTML = `
        <div class="px-3 py-2 text-center text-danger">
            <i class="bx bx-error" style="font-size: 1.5rem; margin-bottom: 5px;"></i>
            <p class="mb-0">Error loading clients</p>
            <small>Please try again</small>
        </div>
    `;
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
