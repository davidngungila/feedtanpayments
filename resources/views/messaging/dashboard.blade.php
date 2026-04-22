@extends('layouts.app')

@section('title', 'Messaging Dashboard - FeedTan Pay')
@section('description', 'Manage SMS and Email messaging services')

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
                                    <i class="bx bx-message-square-dots me-2 text-primary"></i>
                                    Messaging Dashboard
                                </h4>
                                <p class="text-muted mb-0">Manage SMS and Email messaging services with API V2 integration</p>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('messaging.services') }}" class="btn btn-outline-primary">
                                    <i class="bx bx-cog me-2"></i>Manage Services
                                </a>
                                <button type="button" class="btn btn-outline-success" onclick="refreshDashboard()">
                                    <i class="bx bx-refresh me-2"></i>Refresh
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Messaging Statistics -->
        <div class="row mb-6">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-primary bg-opacity-10 rounded-circle me-3" style="width: 48px; height: 48px;">
                                <i class="bx bx-mobile-alt text-primary fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total SMS</h6>
                                <h4 class="mb-0">{{ number_format($stats['total_sms']) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-success bg-opacity-10 rounded-circle me-3" style="width: 48px; height: 48px;">
                                <i class="bx bx-check-circle text-success fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Delivered SMS</h6>
                                <h4 class="mb-0">{{ number_format($stats['delivered_sms']) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-info bg-opacity-10 rounded-circle me-3" style="width: 48px; height: 48px;">
                                <i class="bx bx-envelope text-info fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Emails</h6>
                                <h4 class="mb-0">{{ number_format($stats['total_emails']) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-warning bg-opacity-10 rounded-circle me-3" style="width: 48px; height: 48px;">
                                <i class="bx bx-envelope-open text-warning fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Opened Emails</h6>
                                <h4 class="mb-0">{{ number_format($stats['opened_emails']) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row mb-6">
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0">
                                <i class="bx bx-mobile-alt me-2"></i>
                                Send SMS
                            </h5>
                            <small class="text-muted">Quick SMS messaging</small>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="quickSmsForm">
                            <div class="mb-3">
                                <label for="smsService" class="form-label">Service</label>
                                <select class="form-select" id="smsService" required>
                                    <option value="">Select Service</option>
                                    @foreach($smsServices as $service)
                                        <option value="{{ $service->id }}">{{ $service->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="smsTo" class="form-label">Recipient Phone</label>
                                <input type="text" class="form-control" id="smsTo" placeholder="255712345678" required>
                            </div>
                            <div class="mb-3">
                                <label for="smsMessage" class="form-label">Message</label>
                                <textarea class="form-control" id="smsMessage" rows="3" placeholder="Enter your message..." required maxlength="1600"></textarea>
                                <small class="text-muted"><span id="smsCharCount">0</span>/1600 characters</small>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="smsTestMode">
                                <label class="form-check-label" for="smsTestMode">
                                    Test Mode (No charges)
                                </label>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-send me-2"></i>Send SMS
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0">
                                <i class="bx bx-envelope me-2"></i>
                                Send Email
                            </h5>
                            <small class="text-muted">Quick Email messaging</small>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="quickEmailForm">
                            <div class="mb-3">
                                <label for="emailService" class="form-label">Service</label>
                                <select class="form-select" id="emailService" required>
                                    <option value="">Select Service</option>
                                    @foreach($emailServices as $service)
                                        <option value="{{ $service->id }}">{{ $service->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="emailTo" class="form-label">Recipient Email</label>
                                <input type="email" class="form-control" id="emailTo" placeholder="user@example.com" required>
                            </div>
                            <div class="mb-3">
                                <label for="emailSubject" class="form-label">Subject</label>
                                <input type="text" class="form-control" id="emailSubject" placeholder="Email subject" required>
                            </div>
                            <div class="mb-3">
                                <label for="emailMessage" class="form-label">Message</label>
                                <textarea class="form-control" id="emailMessage" rows="3" placeholder="Enter your message..." required></textarea>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="emailTestMode">
                                <label class="form-check-label" for="emailTestMode">
                                    Test Mode (No charges)
                                </label>
                            </div>
                            <button type="submit" class="btn btn-success">
                                <i class="bx bx-send me-2"></i>Send Email
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Messages -->
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0">
                                <i class="bx bx-mobile-alt me-2"></i>
                                Recent SMS Messages
                            </h5>
                            <small class="text-muted">Latest SMS activity</small>
                        </div>
                        <a href="{{ route('messaging.sms') }}" class="btn btn-sm btn-outline-primary">
                            View All
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>To</th>
                                        <th>Message</th>
                                        <th>Status</th>
                                        <th>Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentSms as $sms)
                                        <tr>
                                            <td>
                                                <small>{{ $sms->to }}</small>
                                            </td>
                                            <td>
                                                <small>{{ Str::limit($sms->message, 30) }}</small>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $sms->getStatusBadgeColor() }}">
                                                    {{ $sms->status_name }}
                                                </span>
                                            </td>
                                            <td>
                                                <small>{{ $sms->created_at->diffForHumans() }}</small>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0">
                                <i class="bx bx-envelope me-2"></i>
                                Recent Email Messages
                            </h5>
                            <small class="text-muted">Latest Email activity</small>
                        </div>
                        <a href="{{ route('messaging.email') }}" class="btn btn-sm btn-outline-primary">
                            View All
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>To</th>
                                        <th>Subject</th>
                                        <th>Status</th>
                                        <th>Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentEmails as $email)
                                        <tr>
                                            <td>
                                                <small>{{ $email->to_email }}</small>
                                            </td>
                                            <td>
                                                <small>{{ Str::limit($email->subject, 30) }}</small>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $email->getStatusBadgeColor() }}">
                                                    {{ $email->status_name }}
                                                </span>
                                            </td>
                                            <td>
                                                <small>{{ $email->created_at->diffForHumans() }}</small>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SMS Result Modal -->
<div class="modal fade" id="smsResultModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="bx bx-mobile-alt me-2"></i>
                    SMS Result
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="smsResultContent"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Email Result Modal -->
<div class="modal fade" id="emailResultModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="bx bx-envelope me-2"></i>
                    Email Result
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="emailResultContent"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// SMS character counter
document.getElementById('smsMessage').addEventListener('input', function() {
    const charCount = this.value.length;
    document.getElementById('smsCharCount').textContent = charCount;
    
    if (charCount > 160) {
        document.getElementById('smsCharCount').classList.add('text-danger');
    } else {
        document.getElementById('smsCharCount').classList.remove('text-danger');
    }
});

// Quick SMS form submission
document.getElementById('quickSmsForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = {
        service_id: document.getElementById('smsService').value,
        to: document.getElementById('smsTo').value,
        message: document.getElementById('smsMessage').value,
        is_test: document.getElementById('smsTestMode').checked
    };
    
    if (!formData.service_id) {
        showNotification('Please select a messaging service', 'warning');
        return;
    }
    
    sendSms(formData);
});

// Quick Email form submission
document.getElementById('quickEmailForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = {
        service_id: document.getElementById('emailService').value,
        to_email: document.getElementById('emailTo').value,
        subject: document.getElementById('emailSubject').value,
        body_html: document.getElementById('emailMessage').value,
        body_text: document.getElementById('emailMessage').value.replace(/<[^>]*>/g, ''),
        is_test: document.getElementById('emailTestMode').checked
    };
    
    if (!formData.service_id) {
        showNotification('Please select a messaging service', 'warning');
        return;
    }
    
    sendEmail(formData);
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
            document.getElementById('quickSmsForm').reset();
            document.getElementById('smsCharCount').textContent = '0';
            showSmsResult(data.data);
        } else {
            showNotification('Failed to send SMS: ' + data.message, 'error');
        }
    })
    .catch(error => {
        showNotification('Error sending SMS: ' + error.message, 'error');
    });
}

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
            document.getElementById('quickEmailForm').reset();
            showEmailResult(data.data);
        } else {
            showNotification('Failed to send Email: ' + data.message, 'error');
        }
    })
    .catch(error => {
        showNotification('Error sending Email: ' + error.message, 'error');
    });
}

function showSmsResult(data) {
    const content = `
        <div class="mb-3">
            <label class="form-label">Message ID</label>
            <div class="fw-bold">${data.message_id}</div>
        </div>
        <div class="mb-3">
            <label class="form-label">Recipient</label>
            <div>${data.to}</div>
        </div>
        <div class="mb-3">
            <label class="form-label">Status</label>
            <div><span class="badge bg-${data.status_group_name === 'PENDING' ? 'warning' : 'success'}">${data.status_name}</span></div>
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
            <label class="form-label">Sent At</label>
            <div>${new Date().toLocaleString()}</div>
        </div>
    `;
    
    document.getElementById('smsResultContent').innerHTML = content;
    new bootstrap.Modal(document.getElementById('smsResultModal')).show();
}

function showEmailResult(data) {
    const content = `
        <div class="mb-3">
            <label class="form-label">Message ID</label>
            <div class="fw-bold">${data.message_id}</div>
        </div>
        <div class="mb-3">
            <label class="form-label">Recipient</label>
            <div>${data.to_name ? data.to_name + ' <' + data.to_email + '>' : data.to_email}</div>
        </div>
        <div class="mb-3">
            <label class="form-label">Subject</label>
            <div>${data.subject}</div>
        </div>
        <div class="mb-3">
            <label class="form-label">Status</label>
            <div><span class="badge bg-${data.status_group_name === 'PENDING' ? 'warning' : 'success'}">${data.status_name}</span></div>
        </div>
        <div class="mb-3">
            <label class="form-label">Sent At</label>
            <div>${new Date().toLocaleString()}</div>
        </div>
    `;
    
    document.getElementById('emailResultContent').innerHTML = content;
    new bootstrap.Modal(document.getElementById('emailResultModal')).show();
}

function refreshDashboard() {
    showNotification('Refreshing dashboard...', 'info');
    setTimeout(() => {
        location.reload();
    }, 1000);
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
@endsection
