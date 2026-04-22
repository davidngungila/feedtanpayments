@extends('layouts.app')

@section('title', 'Create Bill - FeedTan Pay')
@section('description', 'FeedTan Pay - Add new bills to your payment schedule')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Create New Bill</h5>
            </div>
            <div class="card-body">
                <form id="billForm" method="POST" onsubmit="return false">
                    @csrf
                    <div class="row g-6">
                        <div class="col-md-12">
                            <label for="billName" class="form-label">Bill Name *</label>
                            <input
                                type="text"
                                class="form-control"
                                id="billName"
                                name="billName"
                                placeholder="e.g., Electricity Bill, Monthly Rent"
                                required />
                        </div>
                        <div class="col-md-6">
                            <label for="provider" class="form-label">Service Provider *</label>
                            <input
                                type="text"
                                class="form-control"
                                id="provider"
                                name="provider"
                                placeholder="e.g., Con Edison, Property Management"
                                required />
                        </div>
                        <div class="col-md-6">
                            <label for="category" class="form-label">Category *</label>
                            <select class="form-select" id="category" name="category" required>
                                <option value="">Select category</option>
                                <option value="utilities">Utilities</option>
                                <option value="rent">Rent</option>
                                <option value="insurance">Insurance</option>
                                <option value="subscription">Subscription</option>
                                <option value="loan">Loan</option>
                                <option value="credit-card">Credit Card</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="amount" class="form-label">Amount ($) *</label>
                            <input
                                type="number"
                                class="form-control"
                                id="amount"
                                name="amount"
                                placeholder="0.00"
                                step="0.01"
                                min="0.01"
                                required />
                        </div>
                        <div class="col-md-6">
                            <label for="dueDate" class="form-label">Due Date *</label>
                            <input
                                type="date"
                                class="form-control"
                                id="dueDate"
                                name="dueDate"
                                required />
                        </div>
                        <div class="col-md-6">
                            <label for="frequency" class="form-label">Frequency</label>
                            <select class="form-select" id="frequency" name="frequency">
                                <option value="once">One-time</option>
                                <option value="weekly">Weekly</option>
                                <option value="biweekly">Bi-weekly</option>
                                <option value="monthly">Monthly</option>
                                <option value="quarterly">Quarterly</option>
                                <option value="yearly">Yearly</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="reminderDays" class="form-label">Reminder (days before due)</label>
                            <select class="form-select" id="reminderDays" name="reminderDays">
                                <option value="0">No reminder</option>
                                <option value="1">1 day</option>
                                <option value="3" selected>3 days</option>
                                <option value="7">1 week</option>
                                <option value="14">2 weeks</option>
                                <option value="30">1 month</option>
                            </select>
                        </div>
                        
                        <!-- Payment Method Details -->
                        <div class="col-md-12">
                            <h6 class="mb-3">Payment Method</h6>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label for="paymentMethod" class="form-label">Default Payment Method</label>
                                    <select class="form-select" id="paymentMethod" name="paymentMethod">
                                        <option value="">Select payment method</option>
                                        <option value="wallet">Wallet Balance</option>
                                        <option value="card">Credit/Debit Card</option>
                                        <option value="bank">Bank Transfer</option>
                                        <option value="paypal">PayPal</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="accountNumber" class="form-label">Account Number (Optional)</label>
                                    <input type="text" class="form-control" id="accountNumber" name="accountNumber" placeholder="Account or reference number">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Auto-pay Settings -->
                        <div class="col-md-12">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="autoPay" name="autoPay">
                                <label class="form-check-label" for="autoPay">
                                    Enable automatic payments
                                </label>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="earlyPay" name="earlyPay">
                                <label class="form-check-label" for="earlyPay">
                                    Pay early when possible (if auto-pay is enabled)
                                </label>
                            </div>
                        </div>
                        
                        <!-- Additional Information -->
                        <div class="col-md-12">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea
                                class="form-control"
                                id="notes"
                                name="notes"
                                rows="3"
                                placeholder="Add any additional notes about this bill"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="website" class="form-label">Website URL (Optional)</label>
                            <input
                                type="url"
                                class="form-control"
                                id="website"
                                name="website"
                                placeholder="https://example.com/bill-pay" />
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Phone Number (Optional)</label>
                            <input
                                type="tel"
                                class="form-control"
                                id="phone"
                                name="phone"
                                placeholder="+1 234 567 8900" />
                        </div>
                        
                        <!-- Attachments -->
                        <div class="col-md-12">
                            <label class="form-label">Attachments</label>
                            <div class="border rounded p-4 text-center" id="dropZone">
                                <i class="bx bx-cloud-upload text-primary" style="font-size: 2rem;"></i>
                                <p class="mb-2">Drag and drop files here or click to browse</p>
                                <button type="button" class="btn btn-outline-primary btn-sm">Choose Files</button>
                                <input type="file" id="fileInput" multiple style="display: none;" accept=".pdf,.jpg,.jpeg,.png">
                                <div id="fileList" class="mt-3"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <button type="submit" class="btn btn-primary me-3">
                            <i class="bx bx-plus me-2"></i>Create Bill
                        </button>
                        <button type="button" class="btn btn-outline-secondary" onclick="saveDraft()">Save Draft</button>
                        <a href="{{ route('billpay.all') }}" class="btn btn-outline-danger ms-2">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Bill Preview</h5>
            </div>
            <div class="card-body">
                <div id="billPreview">
                    <div class="text-center text-muted py-8">
                        <i class="bx bx-file" style="font-size: 3rem;"></i>
                        <p class="mt-3">Fill in the form to see bill preview</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card mt-6">
            <div class="card-header">
                <h5 class="card-title mb-0">Quick Tips</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <i class="bx bx-info-circle me-2"></i>
                    <small>Set up reminders to avoid late fees and maintain good credit.</small>
                </div>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <i class="bx bx-check-circle text-success me-2"></i>
                        <small>Enable auto-pay for recurring bills</small>
                    </li>
                    <li class="mb-2">
                        <i class="bx bx-check-circle text-success me-2"></i>
                        <small>Set reminders 3-7 days before due date</small>
                    </li>
                    <li class="mb-2">
                        <i class="bx bx-check-circle text-success me-2"></i>
                        <small>Keep bill statements for tax purposes</small>
                    </li>
                    <li class="mb-2">
                        <i class="bx bx-check-circle text-success me-2"></i>
                        <small>Review bills regularly for errors</small>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="card mt-6">
            <div class="card-header">
                <h5 class="card-title mb-0">Recent Bills</h5>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="avatar me-3">
                        <div class="avatar bg-danger bg-opacity-10 rounded-circle">
                            <i class="bx bx-bolt text-danger"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-0">Electricity Bill</h6>
                        <small class="text-muted">$145.50 - Due Dec 10</small>
                    </div>
                    <span class="badge bg-danger">Overdue</span>
                </div>
                <div class="d-flex align-items-center mb-3">
                    <div class="avatar me-3">
                        <div class="avatar bg-warning bg-opacity-10 rounded-circle">
                            <i class="bx bx-home text-warning"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-0">Monthly Rent</h6>
                        <small class="text-muted">$1,200.00 - Due Dec 20</small>
                    </div>
                    <span class="badge bg-warning">Due Soon</span>
                </div>
                <div class="d-flex align-items-center">
                    <div class="avatar me-3">
                        <div class="avatar bg-success bg-opacity-10 rounded-circle">
                            <i class="bx bx-shield text-success"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-0">Car Insurance</h6>
                        <small class="text-muted">$285.00 - Due Jan 5</small>
                    </div>
                    <span class="badge bg-info">Upcoming</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const billForm = document.getElementById('billForm');
    const billNameInput = document.getElementById('billName');
    const providerInput = document.getElementById('provider');
    const categorySelect = document.getElementById('category');
    const amountInput = document.getElementById('amount');
    const dueDateInput = document.getElementById('dueDate');
    const frequencySelect = document.getElementById('frequency');
    const autoPayCheckbox = document.getElementById('autoPay');
    
    // File upload handling
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('fileInput');
    const fileList = document.getElementById('fileList');
    
    dropZone.addEventListener('click', () => fileInput.click());
    
    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.classList.add('bg-light');
    });
    
    dropZone.addEventListener('dragleave', () => {
        dropZone.classList.remove('bg-light');
    });
    
    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('bg-light');
        handleFiles(e.dataTransfer.files);
    });
    
    fileInput.addEventListener('change', (e) => {
        handleFiles(e.target.files);
    });
    
    function handleFiles(files) {
        fileList.innerHTML = '';
        Array.from(files).forEach(file => {
            const fileItem = document.createElement('div');
            fileItem.className = 'd-flex align-items-center justify-content-between mb-2';
            fileItem.innerHTML = `
                <small><i class="bx bx-file me-2"></i>${file.name}</small>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="this.parentElement.remove()">
                    <i class="bx bx-x"></i>
                </button>
            `;
            fileList.appendChild(fileItem);
        });
    }
    
    // Update preview
    function updatePreview() {
        const billName = billNameInput.value;
        const provider = providerInput.value;
        const category = categorySelect.value;
        const amount = amountInput.value;
        const dueDate = dueDateInput.value;
        const frequency = frequencySelect.value;
        const autoPay = autoPayCheckbox.checked;
        
        if (!billName && !provider && !amount && !dueDate) {
            document.getElementById('billPreview').innerHTML = `
                <div class="text-center text-muted py-8">
                    <i class="bx bx-file" style="font-size: 3rem;"></i>
                    <p class="mt-3">Fill in the form to see bill preview</p>
                </div>
            `;
            return;
        }
        
        const categoryColors = {
            'utilities': 'primary',
            'rent': 'info',
            'insurance': 'secondary',
            'subscription': 'warning',
            'loan': 'danger',
            'credit-card': 'success',
            'other': 'dark'
        };
        
        const categoryColor = categoryColors[category] || 'secondary';
        
        document.getElementById('billPreview').innerHTML = `
            <div class="d-flex align-items-start mb-3">
                <div class="avatar me-3">
                    <div class="avatar bg-${categoryColor} bg-opacity-10 rounded-circle">
                        <i class="bx bx-file text-${categoryColor}"></i>
                    </div>
                </div>
                <div class="flex-grow-1">
                    <h6 class="mb-1">${billName || 'Bill Name'}</h6>
                    <small class="text-muted">${provider || 'Provider'}</small>
                </div>
            </div>
            <div class="mb-3">
                <span class="badge bg-label-${categoryColor}">${category || 'Category'}</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span>Amount:</span>
                <strong>$${amount || '0.00'}</strong>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span>Due Date:</span>
                <span>${dueDate ? new Date(dueDate).toLocaleDateString() : 'Not set'}</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span>Frequency:</span>
                <span>${frequency.charAt(0).toUpperCase() + frequency.slice(1)}</span>
            </div>
            <div class="d-flex justify-content-between">
                <span>Auto-pay:</span>
                <span>${autoPay ? '<i class="bx bx-check-circle text-success"></i> Enabled' : '<i class="bx bx-x-circle text-muted"></i> Disabled'}</span>
            </div>
        `;
    }
    
    billNameInput.addEventListener('input', updatePreview);
    providerInput.addEventListener('input', updatePreview);
    categorySelect.addEventListener('change', updatePreview);
    amountInput.addEventListener('input', updatePreview);
    dueDateInput.addEventListener('change', updatePreview);
    frequencySelect.addEventListener('change', updatePreview);
    autoPayCheckbox.addEventListener('change', updatePreview);
    
    // Form submission
    billForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Basic validation
        const billName = billNameInput.value;
        const provider = providerInput.value;
        const category = categorySelect.value;
        const amount = parseFloat(amountInput.value);
        const dueDate = dueDateInput.value;
        
        if (!billName || !provider || !category || !amount || !dueDate) {
            alert('Please fill in all required fields');
            return;
        }
        
        if (amount < 0.01) {
            alert('Amount must be at least $0.01');
            return;
        }
        
        // Show loading state
        const submitBtn = billForm.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin me-2"></i>Creating Bill...';
        
        // Simulate API call
        setTimeout(() => {
            alert('Bill created successfully!');
            billForm.reset();
            updatePreview();
            fileList.innerHTML = '';
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="bx bx-plus me-2"></i>Create Bill';
            
            // Redirect to bills list
            window.location.href = '{{ route("billpay.all") }}';
        }, 2000);
    });
});

function saveDraft() {
    alert('Bill draft saved! You can continue editing later.');
}
</script>
@endpush
