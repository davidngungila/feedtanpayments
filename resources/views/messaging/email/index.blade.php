@extends('layouts.app')

@section('title', 'Email Messaging - FeedTan Pay')
@section('description', 'Send and manage Email messages with API V2 integration')

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
                                    <i class="bx bx-envelope me-2 text-primary"></i>
                                    Email Messaging
                                </h4>
                                <p class="text-muted mb-0">Send and manage Email messages with API V2 integration</p>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('messaging.dashboard') }}" class="btn btn-outline-secondary">
                                    <i class="bx bx-arrow-back me-2"></i>Dashboard
                                </a>
                                <button type="button" class="btn btn-outline-success" onclick="refreshEmailMessages()">
                                    <i class="bx bx-refresh me-2"></i>Refresh
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Send Email Form -->
        <div class="row mb-6">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-send me-2"></i>
                            Send Email Message
                        </h5>
                    </div>
                    <div class="card-body">
                        <form id="emailForm">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="email_service_id" class="form-label">Messaging Service</label>
                                    <select class="form-select" id="email_service_id" required>
                                        <option value="">Select Service</option>
                                        @foreach($services as $service)
                                            <option value="{{ $service->id }}" @if($service->test_mode)data-test="true"@endif>
                                                {{ $service->name }} @if($service->test_mode)<span class="badge bg-warning ms-2">TEST</span>@endif
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email_from_name" class="form-label">From Name</label>
                                    <input type="text" class="form-control" id="email_from_name" value="FeedTan Pay" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="email_to" class="form-label">Recipient Email(s)</label>
                                    <input type="text" class="form-control" id="email_to" placeholder="user@example.com or user1@example.com,user2@example.com" required>
                                    <small class="text-muted">For multiple recipients, separate with commas</small>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email_to_name" class="form-label">Recipient Name(s)</label>
                                    <input type="text" class="form-control" id="email_to_name" placeholder="John Doe or John Doe,Jane Smith">
                                    <small class="text-muted">Optional, for multiple recipients separate with commas</small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="email_template_id" class="form-label">Template (Optional)</label>
                                    <select class="form-select" id="email_template_id">
                                        <option value="">Select Template</option>
                                        @foreach($templates as $template)
                                            <option value="{{ $template->id }}" data-subject="{{ $template->subject }}" data-content="{{ $template->content }}">
                                                {{ $template->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email_cc" class="form-label">CC (Optional)</label>
                                    <input type="text" class="form-control" id="email_cc" placeholder="cc@example.com">
                                    <small class="text-muted">Multiple addresses separated by commas</small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="email_bcc" class="form-label">BCC (Optional)</label>
                                    <input type="text" class="form-control" id="email_bcc" placeholder="bcc@example.com">
                                    <small class="text-muted">Multiple addresses separated by commas</small>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email_reply_to" class="form-label">Reply To (Optional)</label>
                                    <input type="text" class="form-control" id="email_reply_to" placeholder="reply@example.com">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="email_subject" class="form-label">Subject</label>
                                <input type="text" class="form-control" id="email_subject" placeholder="Email subject" required>
                            </div>
                            <div class="mb-3">
                                <label for="email_message" class="form-label">Message (HTML)</label>
                                <textarea class="form-control" id="email_message" rows="8" placeholder="Enter your message (HTML supported)..." required></textarea>
                                <small class="text-muted">
                                    <span id="char_count_email">0</span> characters | 
                                    <button type="button" class="btn btn-sm btn-outline-primary ms-2" onclick="toggleEmailEditor()">
                                        <i class="bx bx-code me-1"></i>Toggle Editor
                                    </button>
                                </small>
                            </div>
                            <div class="mb-3" id="email_attachments" style="display: none;">
                                <label class="form-label">Attachments</label>
                                <div class="border rounded p-3 bg-light">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="bx bx-paperclip me-2"></i>
                                        <span>Attachment functionality will be implemented in backend</span>
                                    </div>
                                    <small class="text-muted">Maximum 10MB per attachment, 5 attachments total</small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="email_test_mode">
                                        <label class="form-check-label" for="email_test_mode">
                                            Test Mode (No charges)
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="email_schedule_later">
                                        <label class="form-check-label" for="email_schedule_later">
                                            Schedule for later
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="email_track_opens">
                                        <label class="form-check-label" for="email_track_opens">
                                            Track opens and clicks
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="email_schedule_row" style="display: none;">
                                <div class="col-md-6 mb-3">
                                    <label for="email_schedule_time" class="form-label">Schedule Time</label>
                                    <input type="datetime-local" class="form-control" id="email_schedule_time">
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-success">
                                    <i class="bx bx-send me-2"></i>Send Email
                                </button>
                                <button type="button" class="btn btn-outline-primary" onclick="previewEmail()">
                                    <i class="bx bx-eye me-2"></i>Preview
                                </button>
                                <button type="button" class="btn btn-outline-secondary" onclick="clearEmailForm()">
                                    <i class="bx bx-x me-2"></i>Clear
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Email Messages Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0">
                                <i class="bx bx-list-ul me-2"></i>
                                Email Messages
                            </h5>
                            <small class="text-muted">Message history and delivery status</small>
                        </div>
                        <div class="d-flex gap-2">
                            <input type="text" class="form-control form-control-sm" id="searchEmail" placeholder="Search messages..." style="width: 200px;">
                            <select class="form-select form-select-sm" id="filterEmailStatus" style="width: 150px;">
                                <option value="">All Status</option>
                                <option value="PENDING">Pending</option>
                                <option value="DELIVERY">Delivered</option>
                                <option value="FAILED">Failed</option>
                                <option value="REJECTED">Rejected</option>
                                <option value="BOUNCED">Bounced</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="emailTable">
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
                                            <i class="bx bx-text me-1"></i>
                                            Subject
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
                                            <i class="bx bx-envelope-open me-1"></i>
                                            Opened
                                        </th>
                                        <th>
                                            <i class="bx bx-time me-1"></i>
                                            Sent
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
                                                    <strong>{{ $message->getFullRecipient() }}</strong>
                                                    @if($message->user)
                                                        <br><small class="text-muted">by {{ $message->user->name }}</small>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    {{ Str::limit($message->subject, 40) }}
                                                    @if($message->hasAttachments())
                                                        <br><small class="text-muted"><i class="bx bx-paperclip"></i> {{ $message->getAttachmentCount() }} attachment(s)</small>
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
                                                @if($message->isOpened())
                                                    <span class="badge bg-success">Yes</span>
                                                    <br><small class="text-muted">{{ $message->opened_at->diffForHumans() }}</small>
                                                @else
                                                    <span class="badge bg-secondary">No</span>
                                                @endif
                                            </td>
                                            <td>
                                                <small>{{ $message->sent_at ? $message->sent_at->format('M j, Y H:i') : '-' }}</small>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                        <i class="bx bx-dots-horizontal-rounded"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="viewEmailMessage({{ $message->id }})"><i class="bx bx-eye me-2"></i>View Details</a></li>
                                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="viewEmailContent({{ $message->id }})"><i class="bx bx-file me-2"></i>View Content</a></li>
                                                        @if($message->isFailed())
                                                            <li><a class="dropdown-item" href="javascript:void(0)" onclick="retryEmail({{ $message->id }})"><i class="bx bx-refresh me-2"></i>Retry</a></li>
                                                        @endif
                                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="exportEmail({{ $message->id }})"><i class="bx bx-download me-2"></i>Export</a></li>
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

<!-- Email Details Modal -->
<div class="modal fade" id="emailDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="bx bx-envelope me-2"></i>
                    Email Message Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="emailDetailsContent"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Email Content Modal -->
<div class="modal fade" id="emailContentModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">
                    <i class="bx bx-file me-2"></i>
                    Email Content
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="emailContentBody"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Email Preview Modal -->
<div class="modal fade" id="emailPreviewModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="bx bx-eye me-2"></i>
                    Email Preview
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <iframe id="emailPreviewFrame" style="width: 100%; height: 500px; border: none;"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Template selection
document.getElementById('email_template_id').addEventListener('change', function() {
    const option = this.options[this.selectedIndex];
    if (option.value) {
        document.getElementById('email_subject').value = option.dataset.subject;
        document.getElementById('email_message').value = option.dataset.content;
        updateCharCountEmail();
    }
});

// Character counter
document.getElementById('email_message').addEventListener('input', updateCharCountEmail);

function updateCharCountEmail() {
    const message = document.getElementById('email_message').value;
    const charCount = message.length;
    
    document.getElementById('char_count_email').textContent = charCount;
}

// Schedule toggle
document.getElementById('email_schedule_later').addEventListener('change', function() {
    const scheduleRow = document.getElementById('email_schedule_row');
    scheduleRow.style.display = this.checked ? 'block' : 'none';
    
    if (this.checked) {
        // Set minimum datetime to now
        const now = new Date();
        now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
        document.getElementById('email_schedule_time').min = now.toISOString().slice(0, 16);
    }
});

// Form submission
document.getElementById('emailForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = {
        service_id: document.getElementById('email_service_id').value,
        to_email: document.getElementById('email_to').value,
        to_name: document.getElementById('email_to_name').value || null,
        from_name: document.getElementById('email_from_name').value,
        subject: document.getElementById('email_subject').value,
        body_html: document.getElementById('email_message').value,
        body_text: document.getElementById('email_message').value.replace(/<[^>]*>/g, ''),
        template_id: document.getElementById('email_template_id').value || null,
        cc: document.getElementById('email_cc').value || null,
        bcc: document.getElementById('email_bcc').value || null,
        reply_to: document.getElementById('email_reply_to').value || null,
        is_test: document.getElementById('email_test_mode').checked,
        schedule_time: document.getElementById('email_schedule_later').checked ? document.getElementById('email_schedule_time').value : null
    };
    
    sendEmail(formData);
});

function sendEmail(formData) {
    showNotification('Sending Email...', 'info');
    
    fetch('{{ route("messaging.email.send") }}', {
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
            showNotification('Email sent successfully!', 'success');
            clearEmailForm();
            setTimeout(() => location.reload(), 1500);
        } else {
            showNotification('Failed to send Email: ' + data.message, 'error');
        }
    })
    .catch(error => {
        showNotification('Error sending Email: ' + error.message, 'error');
    });
}

function viewEmailMessage(messageId) {
    fetch(`/api/email-messages/${messageId}`)
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
                            <label class="form-label">From</label>
                            <div>${data.getFullSender()}</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">To</label>
                            <div>${data.getFullRecipient()}</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Subject</label>
                            <div><strong>${data.subject}</strong></div>
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
                            <label class="form-label">Engagement</label>
                            <div>
                                ${data.isOpened() ? '<span class="badge bg-success">Opened</span> ' + data.opened_at?.diffForHumans() : '<span class="badge bg-secondary">Not opened</span>'}
                                ${data.isClicked() ? '<span class="badge bg-info ms-1">Clicked</span>' : ''}
                                ${data.isBounced() ? '<span class="badge bg-danger ms-1">Bounced</span>' : ''}
                            </div>
                        </div>
                        @if(data.cc)
                        <div class="mb-3">
                            <label class="form-label">CC</label>
                            <div>${data.cc.join(', ')}</div>
                        </div>
                        @endif
                        @if(data.bcc)
                        <div class="mb-3">
                            <label class="form-label">BCC</label>
                            <div>${data.bcc.join(', ')}</div>
                        </div>
                        @endif
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
                        @if(data.opened_at)
                        <div class="mb-3">
                            <label class="form-label">Opened</label>
                            <div>${new Date(data.opened_at).toLocaleString()}</div>
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
                <div class="mb-3">
                    <button type="button" class="btn btn-outline-primary" onclick="viewEmailContent(${messageId})">
                        <i class="bx bx-file me-2"></i>View Full Content
                    </button>
                </div>
            `;
            
            document.getElementById('emailDetailsContent').innerHTML = content;
            new bootstrap.Modal(document.getElementById('emailDetailsModal')).show();
        })
        .catch(error => {
            showNotification('Error loading message details', 'error');
        });
}

function viewEmailContent(messageId) {
    fetch(`/api/email-messages/${messageId}/content`)
        .then(response => response.json())
        .then(data => {
            const content = `
                <div class="mb-3">
                    <h6>Subject: ${data.subject}</h6>
                    <hr>
                    <div style="border: 1px solid #ddd; padding: 20px; background: white;">
                        ${data.body_html}
                    </div>
                </div>
            `;
            
            document.getElementById('emailContentBody').innerHTML = content;
            new bootstrap.Modal(document.getElementById('emailContentModal')).show();
        })
        .catch(error => {
            showNotification('Error loading email content', 'error');
        });
}

function retryEmail(messageId) {
    if (confirm('Are you sure you want to retry this Email?')) {
        showNotification('Retrying Email...', 'info');
        
        fetch(`/api/email-messages/${messageId}/retry`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Email retry initiated successfully', 'success');
                setTimeout(() => location.reload(), 1500);
            } else {
                showNotification('Failed to retry Email: ' + data.message, 'error');
            }
        })
        .catch(error => {
            showNotification('Error retrying Email', 'error');
        });
    }
}

function exportEmail(messageId) {
    window.open(`/api/email-messages/${messageId}/export`, '_blank');
}

function previewEmail() {
    const subject = document.getElementById('email_subject').value;
    const content = document.getElementById('email_message').value;
    
    if (!subject || !content) {
        showNotification('Please fill in subject and message fields', 'warning');
        return;
    }
    
    const previewHtml = `
        <html>
        <head>
            <title>${subject}</title>
            <style>
                body { font-family: Arial, sans-serif; padding: 20px; }
            </style>
        </head>
        <body>
            ${content}
        </body>
        </html>
    `;
    
    document.getElementById('emailPreviewFrame').srcdoc = previewHtml;
    new bootstrap.Modal(document.getElementById('emailPreviewModal')).show();
}

function toggleEmailEditor() {
    // This would integrate with a rich text editor like TinyMCE or CKEditor
    showNotification('Rich text editor integration coming soon', 'info');
}

function clearEmailForm() {
    document.getElementById('emailForm').reset();
    document.getElementById('char_count_email').textContent = '0';
    document.getElementById('email_schedule_row').style.display = 'none';
}

function refreshEmailMessages() {
    showNotification('Refreshing messages...', 'info');
    setTimeout(() => location.reload(), 1000);
}

// Search functionality
document.getElementById('searchEmail').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('#emailTable tbody tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});

// Status filter
document.getElementById('filterEmailStatus').addEventListener('change', function() {
    const status = this.value;
    const rows = document.querySelectorAll('#emailTable tbody tr');
    
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
