@extends('layouts.app')

@section('title', 'SMS Messaging - FeedTan Pay')
@section('description', 'Send and manage SMS messages with API V2 integration')

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
                                    <i class="bx bx-mobile-alt me-2 text-primary"></i>
                                    SMS Messaging
                                </h4>
                                <p class="text-muted mb-0">Send and manage SMS messages with API V2 integration</p>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('messaging.dashboard') }}" class="btn btn-outline-secondary">
                                    <i class="bx bx-arrow-back me-2"></i>Dashboard
                                </a>
                                <button type="button" class="btn btn-outline-success" onclick="refreshSmsMessages()">
                                    <i class="bx bx-refresh me-2"></i>Refresh
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Send SMS Form -->
        <div class="row mb-6">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-send me-2"></i>
                            Send SMS Message
                        </h5>
                    </div>
                    <div class="card-body">
                        <form id="smsForm">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="service_id" class="form-label">Messaging Service</label>
                                    <select class="form-select" id="service_id" required>
                                        <option value="">Select Service</option>
                                        @foreach($services as $service)
                                            <option value="{{ $service->id }}" data-cost="{{ $service->cost_per_message }}" data-currency="{{ $service->currency }}">
                                                {{ $service->name }} @if($service->test_mode)<span class="badge bg-warning ms-2">TEST</span>@endif
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="sms_to" class="form-label">Recipient Phone Number(s)</label>
                                    <input type="text" class="form-control" id="sms_to" placeholder="255712345678 or 255712345678,255722345678" required>
                                    <small class="text-muted">For multiple recipients, separate with commas</small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="template_id" class="form-label">Template (Optional)</label>
                                    <select class="form-select" id="template_id">
                                        <option value="">Select Template</option>
                                        @foreach($templates as $template)
                                            <option value="{{ $template->id }}" data-content="{{ $template->content }}">
                                                {{ $template->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="sender_id" class="form-label">Sender ID (Optional)</label>
                                    <input type="text" class="form-control" id="sender_id" placeholder="FeedTanPay" maxlength="11">
                                    <small class="text-muted">Leave empty to use default sender ID</small>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="sms_message" class="form-label">Message</label>
                                <textarea class="form-control" id="sms_message" rows="4" placeholder="Enter your message..." required maxlength="1600"></textarea>
                                <div class="d-flex justify-content-between mt-1">
                                    <small class="text-muted">
                                        <span id="char_count">0</span>/1600 characters | 
                                        <span id="sms_count">1</span> SMS(s) | 
                                        Cost: <span id="total_cost">0.0000</span> <span id="currency">TZS</span>
                                    </small>
                                    <small class="text-muted" id="delivery_estimate"></small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="test_mode">
                                        <label class="form-check-label" for="test_mode">
                                            Test Mode (No charges, dummy response)
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="schedule_later">
                                        <label class="form-check-label" for="schedule_later">
                                            Schedule for later
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="schedule_row" style="display: none;">
                                <div class="col-md-6 mb-3">
                                    <label for="schedule_time" class="form-label">Schedule Time</label>
                                    <input type="datetime-local" class="form-control" id="schedule_time">
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bx bx-send me-2"></i>Send SMS
                                </button>
                                <button type="button" class="btn btn-outline-secondary" onclick="clearForm()">
                                    <i class="bx bx-x me-2"></i>Clear
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- SMS Messages Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0">
                                <i class="bx bx-list-ul me-2"></i>
                                SMS Messages
                            </h5>
                            <small class="text-muted">Message history and delivery status</small>
                        </div>
                        <div class="d-flex gap-2">
                            <input type="text" class="form-control form-control-sm" id="searchSms" placeholder="Search messages..." style="width: 200px;">
                            <select class="form-select form-select-sm" id="filterStatus" style="width: 150px;">
                                <option value="">All Status</option>
                                <option value="PENDING">Pending</option>
                                <option value="DELIVERY">Delivered</option>
                                <option value="FAILED">Failed</option>
                                <option value="REJECTED">Rejected</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="smsTable">
                                <thead>
                                    <tr>
                                        <th>
                                            <i class="bx bx-hash me-1"></i>
                                            ID
                                        </th>
                                        <th>
                                            <i class="bx bx-user me-1"></i>
                                            Recipient
                                        </th>
                                        <th>
                                            <i class="bx bx-message me-1"></i>
                                            Message
                                        </th>
                                        <th>
                                            <i class="bx bx-cog me-1"></i>
                                            Service
                                        </th>
                                        <th>
                                            <i class="bx bx-check-circle me-1"></i>
                                            Status
                                        </th>
                                        <th>
                                            <i class="bx bx-time me-1"></i>
                                            Sent
                                        </th>
                                        <th>
                                            <i class="bx bx-dollar me-1"></i>
                                            Cost
                                        </th>
                                        <th>
                                            <i class="bx bx-cog me-1"></i>
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($messages as $message)
                                        <tr>
                                            <td>
                                                <small class="text-muted">#{{ $message->id }}</small>
                                            </td>
                                            <td>
                                                <div>
                                                    <strong>{{ $message->getFormattedRecipient() }}</strong>
                                                    @if($message->user)
                                                        <br><small class="text-muted">by {{ $message->user->name }}</small>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    {{ Str::limit($message->message, 50) }}
                                                    @if(strlen($message->message) > 50)
                                                        <br><small class="text-muted">{{ $message->sms_count }} SMS(s)</small>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ $message->messagingService->name }}</span>
                                                @if($message->is_test)
                                                    <span class="badge bg-warning ms-1">TEST</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $message->getStatusBadgeColor() }}">
                                                    {{ $message->status_name }}
                                                </span>
                                            </td>
                                            <td>
                                                <small>{{ $message->sent_at ? $message->sent_at->format('M j, Y H:i') : '-' }}</small>
                                            </td>
                                            <td>
                                                <small>{{ $message->currency }} {{ number_format($message->price, 4) }}</small>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                        <i class="bx bx-dots-horizontal-rounded"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="viewSmsMessage({{ $message->id }})"><i class="bx bx-eye me-2"></i>View Details</a></li>
                                                        @if($message->isFailed())
                                                            <li><a class="dropdown-item" href="javascript:void(0)" onclick="retrySms({{ $message->id }})"><i class="bx bx-refresh me-2"></i>Retry</a></li>
                                                        @endif
                                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="exportSms({{ $message->id }})"><i class="bx bx-download me-2"></i>Export</a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div>
                                <small class="text-muted">Showing {{ $messages->firstItem() }} to {{ $messages->lastItem() }} of {{ $messages->total() }} messages</small>
                            </div>
                            <div>
                                {{ $messages->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SMS Details Modal -->
<div class="modal fade" id="smsDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="bx bx-mobile-alt me-2"></i>
                    SMS Message Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="smsDetailsContent"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let currentCost = 0;
let currentCurrency = 'TZS';

// Service selection change
document.getElementById('service_id').addEventListener('change', function() {
    const option = this.options[this.selectedIndex];
    currentCost = parseFloat(option.dataset.cost) || 0;
    currentCurrency = option.dataset.currency || 'TZS';
    updateCostCalculation();
});

// Template selection
document.getElementById('template_id').addEventListener('change', function() {
    const option = this.options[this.selectedIndex];
    if (option.value) {
        document.getElementById('sms_message').value = option.dataset.content;
        updateCharCount();
    }
});

// Character counter and cost calculation
document.getElementById('sms_message').addEventListener('input', updateCharCount);
document.getElementById('sms_to').addEventListener('input', updateCostCalculation);

function updateCharCount() {
    const message = document.getElementById('sms_message').value;
    const charCount = message.length;
    const smsCount = Math.ceil(charCount / 160);
    
    document.getElementById('char_count').textContent = charCount;
    document.getElementById('sms_count').textContent = smsCount;
    
    if (charCount > 1600) {
        document.getElementById('char_count').classList.add('text-danger');
    } else {
        document.getElementById('char_count').classList.remove('text-danger');
    }
    
    updateCostCalculation();
}

function updateCostCalculation() {
    const message = document.getElementById('sms_message').value;
    const smsCount = Math.ceil(message.length / 160);
    const recipients = document.getElementById('sms_to').value.split(',').filter(r => r.trim()).length;
    const totalCost = currentCost * smsCount * recipients;
    
    document.getElementById('total_cost').textContent = totalCost.toFixed(4);
    document.getElementById('currency').textContent = currentCurrency;
    
    // Update delivery estimate
    if (recipients > 0) {
        document.getElementById('delivery_estimate').textContent = `Estimated delivery to ${recipients} recipient(s)`;
    } else {
        document.getElementById('delivery_estimate').textContent = '';
    }
}

// Schedule toggle
document.getElementById('schedule_later').addEventListener('change', function() {
    const scheduleRow = document.getElementById('schedule_row');
    scheduleRow.style.display = this.checked ? 'block' : 'none';
    
    if (this.checked) {
        // Set minimum datetime to now
        const now = new Date();
        now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
        document.getElementById('schedule_time').min = now.toISOString().slice(0, 16);
    }
});

// Form submission
document.getElementById('smsForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = {
        service_id: document.getElementById('service_id').value,
        to: document.getElementById('sms_to').value,
        message: document.getElementById('sms_message').value,
        template_id: document.getElementById('template_id').value || null,
        sender_id: document.getElementById('sender_id').value || null,
        is_test: document.getElementById('test_mode').checked,
        schedule_time: document.getElementById('schedule_later').checked ? document.getElementById('schedule_time').value : null
    };
    
    sendSms(formData);
});

function sendSms(formData) {
    showNotification('Sending SMS...', 'info');
    
    fetch('{{ route("messaging.sms.send") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('SMS sent successfully!', 'success');
            clearForm();
            setTimeout(() => location.reload(), 1500);
        } else {
            showNotification('Failed to send SMS: ' + data.message, 'error');
        }
    })
    .catch(error => {
        showNotification('Error sending SMS: ' + error.message, 'error');
    });
}

function viewSmsMessage(messageId) {
    fetch(`/api/sms-messages/${messageId}`)
        .then(response => response.json())
        .then(data => {
            const content = `
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Message ID</label>
                            <div class="fw-bold">${data.message_id}</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Recipient</label>
                            <div>${data.getFormattedRecipient()}</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Sender ID</label>
                            <div>${data.from}</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Service</label>
                            <div>${data.messagingService?.name || 'N/A'}</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <div><span class="badge bg-${data.getStatusBadgeColor()}">${data.status_name}</span></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Message</label>
                            <div class="bg-light p-2 rounded" style="max-height: 150px; overflow-y: auto;">${data.message}</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">SMS Count</label>
                            <div>${data.sms_count} message(s)</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Cost</label>
                            <div>${data.currency} ${data.price.toFixed(4)}</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Created</label>
                            <div>${new Date(data.created_at).toLocaleString()}</div>
                        </div>
                        @if(data.sent_at)
                        <div class="mb-3">
                            <label class="form-label">Sent</label>
                            <div>${new Date(data.sent_at).toLocaleString()}</div>
                        </div>
                        @endif
                    </div>
                </div>
                @if(data.error_message)
                <div class="mb-3">
                    <label class="form-label">Error Message</label>
                    <div class="text-danger">${data.error_message}</div>
                </div>
                @endif
            `;
            
            document.getElementById('smsDetailsContent').innerHTML = content;
            new bootstrap.Modal(document.getElementById('smsDetailsModal')).show();
        })
        .catch(error => {
            showNotification('Error loading message details', 'error');
        });
}

function retrySms(messageId) {
    if (confirm('Are you sure you want to retry this SMS?')) {
        showNotification('Retrying SMS...', 'info');
        
        fetch(`/api/sms-messages/${messageId}/retry`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('SMS retry initiated successfully', 'success');
                setTimeout(() => location.reload(), 1500);
            } else {
                showNotification('Failed to retry SMS: ' + data.message, 'error');
            }
        })
        .catch(error => {
            showNotification('Error retrying SMS', 'error');
        });
    }
}

function exportSms(messageId) {
    window.open(`/api/sms-messages/${messageId}/export`, '_blank');
}

function clearForm() {
    document.getElementById('smsForm').reset();
    document.getElementById('char_count').textContent = '0';
    document.getElementById('sms_count').textContent = '1';
    document.getElementById('total_cost').textContent = '0.0000';
    document.getElementById('schedule_row').style.display = 'none';
}

function refreshSmsMessages() {
    showNotification('Refreshing messages...', 'info');
    setTimeout(() => location.reload(), 1000);
}

// Search functionality
document.getElementById('searchSms').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('#smsTable tbody tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});

// Status filter
document.getElementById('filterStatus').addEventListener('change', function() {
    const status = this.value;
    const rows = document.querySelectorAll('#smsTable tbody tr');
    
    rows.forEach(row => {
        if (!status) {
            row.style.display = '';
        } else {
            const statusBadge = row.querySelector('.badge');
            const rowStatus = statusBadge ? statusBadge.textContent : '';
            row.style.display = rowStatus.includes(status) ? '' : 'none';
        }
    });
});

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
@endsection
