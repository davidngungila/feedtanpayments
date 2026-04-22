@extends('layouts.app')

@section('title', 'Initiate Payout - FeedTan Pay')
@section('description', 'FeedTan Pay - Request money withdrawal to various payment methods')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Initiate Payout</h5>
            </div>
            <div class="card-body">
                <form id="payoutForm" method="POST" onsubmit="return false">
                    @csrf
                    <div class="row g-6">
                        <div class="col-md-6">
                            <label for="recipient" class="form-label">Recipient Name</label>
                            <input
                                type="text"
                                class="form-control"
                                id="recipient"
                                name="recipient"
                                placeholder="Enter recipient name"
                                required />
                        </div>
                        <div class="col-md-6">
                            <label for="recipientEmail" class="form-label">Recipient Email</label>
                            <input
                                type="email"
                                class="form-control"
                                id="recipientEmail"
                                name="recipientEmail"
                                placeholder="Enter recipient email"
                                required />
                        </div>
                        <div class="col-md-6">
                            <label for="amount" class="form-label">Amount ($)</label>
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
                            <label for="payoutMethod" class="form-label">Payout Method</label>
                            <select class="form-select" id="payoutMethod" name="payoutMethod" required>
                                <option value="">Select payout method</option>
                                <option value="bank">Bank Transfer</option>
                                <option value="paypal">PayPal</option>
                                <option value="venmo">Venmo</option>
                                <option value="cashapp">Cash App</option>
                                <option value="check">Check</option>
                            </select>
                        </div>
                        
                        <!-- Bank Transfer Details -->
                        <div id="bankDetails" class="col-md-12" style="display: none;">
                            <h6 class="mb-3">Bank Transfer Details</h6>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label for="bankName" class="form-label">Bank Name</label>
                                    <input type="text" class="form-control" id="bankName" name="bankName" placeholder="Bank name">
                                </div>
                                <div class="col-md-6">
                                    <label for="accountNumber" class="form-label">Account Number</label>
                                    <input type="text" class="form-control" id="accountNumber" name="accountNumber" placeholder="Account number">
                                </div>
                                <div class="col-md-6">
                                    <label for="routingNumber" class="form-label">Routing Number</label>
                                    <input type="text" class="form-control" id="routingNumber" name="routingNumber" placeholder="Routing number">
                                </div>
                                <div class="col-md-6">
                                    <label for="accountType" class="form-label">Account Type</label>
                                    <select class="form-select" id="accountType" name="accountType">
                                        <option value="checking">Checking</option>
                                        <option value="savings">Savings</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <!-- PayPal Details -->
                        <div id="paypalDetails" class="col-md-12" style="display: none;">
                            <h6 class="mb-3">PayPal Details</h6>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label for="paypalEmail" class="form-label">PayPal Email</label>
                                    <input type="email" class="form-control" id="paypalEmail" name="paypalEmail" placeholder="PayPal email address">
                                </div>
                                <div class="col-md-6">
                                    <label for="paypalPhone" class="form-label">PayPal Phone (Optional)</label>
                                    <input type="tel" class="form-control" id="paypalPhone" name="paypalPhone" placeholder="Phone number">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Venmo Details -->
                        <div id="venmoDetails" class="col-md-12" style="display: none;">
                            <h6 class="mb-3">Venmo Details</h6>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label for="venmoUsername" class="form-label">Venmo Username</label>
                                    <input type="text" class="form-control" id="venmoUsername" name="venmoUsername" placeholder="@username">
                                </div>
                                <div class="col-md-6">
                                    <label for="venmoPhone" class="form-label">Venmo Phone (Optional)</label>
                                    <input type="tel" class="form-control" id="venmoPhone" name="venmoPhone" placeholder="Phone number">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Cash App Details -->
                        <div id="cashappDetails" class="col-md-12" style="display: none;">
                            <h6 class="mb-3">Cash App Details</h6>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label for="cashappTag" class="form-label">Cash App Tag</label>
                                    <input type="text" class="form-control" id="cashappTag" name="cashappTag" placeholder="$cashtag">
                                </div>
                                <div class="col-md-6">
                                    <label for="cashappPhone" class="form-label">Cash App Phone (Optional)</label>
                                    <input type="tel" class="form-control" id="cashappPhone" name="cashappPhone" placeholder="Phone number">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Check Details -->
                        <div id="checkDetails" class="col-md-12" style="display: none;">
                            <h6 class="mb-3">Check Details</h6>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label for="checkAddress" class="form-label">Mailing Address</label>
                                    <textarea class="form-control" id="checkAddress" name="checkAddress" rows="3" placeholder="Street address, city, state, zip"></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="checkMemo" class="form-label">Memo (Optional)</label>
                                    <input type="text" class="form-control" id="checkMemo" name="checkMemo" placeholder="Check memo">
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <label for="description" class="form-label">Description</label>
                            <textarea
                                class="form-control"
                                id="description"
                                name="description"
                                rows="3"
                                placeholder="What's this payout for?"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-select" id="category" name="category">
                                <option value="">Select category</option>
                                <option value="salary">Salary</option>
                                <option value="freelance">Freelance</option>
                                <option value="commission">Commission</option>
                                <option value="refund">Refund</option>
                                <option value="reimbursement">Reimbursement</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="scheduledDate" class="form-label">Schedule Date (Optional)</label>
                            <input type="date" class="form-control" id="scheduledDate" name="scheduledDate">
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" id="saveRecipient">
                            <label class="form-check-label" for="saveRecipient">
                                Save recipient for future payouts
                            </label>
                        </div>
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" id="urgentPayout">
                            <label class="form-check-label" for="urgentPayout">
                                <span class="text-warning">Urgent payout (additional fees may apply)</span>
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary me-3">
                            <i class="bx bx-money-withdraw me-2"></i>Send Payout
                        </button>
                        <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Payout Summary</h5>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Payout Amount:</span>
                        <span id="summaryAmount">$0.00</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Processing Fee:</span>
                        <span id="summaryFee">$0.00</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2" id="urgentFeeRow" style="display: none;">
                        <span>Urgent Fee:</span>
                        <span id="urgentFee">$0.00</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold">
                        <span>Total:</span>
                        <span id="summaryTotal">$0.00</span>
                    </div>
                </div>
                
                <div class="alert alert-info">
                    <i class="bx bx-info-circle me-2"></i>
                    <small>Processing fees vary by payout method. Bank transfers: 1%, PayPal: 2.9% + $0.30, Checks: $5.00</small>
                </div>
                
                <div class="alert alert-warning" id="urgentAlert" style="display: none;">
                    <i class="bx bx-error me-2"></i>
                    <small>Urgent payouts are processed within 1-2 hours instead of 1-3 business days.</small>
                </div>
            </div>
        </div>
        
        <div class="card mt-6">
            <div class="card-header">
                <h5 class="card-title mb-0">Recent Recipients</h5>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="avatar me-3">
                        <img src="{{ asset('assets/img/avatars/6.png') }}" alt="Avatar" class="rounded-circle">
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-0">Alex Thompson</h6>
                        <small class="text-muted">alex.t@email.com</small>
                    </div>
                    <button class="btn btn-sm btn-outline-primary">Pay</button>
                </div>
                <div class="d-flex align-items-center mb-3">
                    <div class="avatar me-3">
                        <img src="{{ asset('assets/img/avatars/7.png') }}" alt="Avatar" class="rounded-circle">
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-0">Emily Davis</h6>
                        <small class="text-muted">emily.d@email.com</small>
                    </div>
                    <button class="btn btn-sm btn-outline-primary">Pay</button>
                </div>
                <div class="d-flex align-items-center">
                    <div class="avatar me-3">
                        <img src="{{ asset('assets/img/avatars/8.png') }}" alt="Avatar" class="rounded-circle">
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-0">Robert Wilson</h6>
                        <small class="text-muted">robert.w@email.com</small>
                    </div>
                    <button class="btn btn-sm btn-outline-primary">Pay</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const payoutForm = document.getElementById('payoutForm');
    const amountInput = document.getElementById('amount');
    const payoutMethodSelect = document.getElementById('payoutMethod');
    const urgentCheckbox = document.getElementById('urgentPayout');
    
    // Method-specific detail sections
    const methodSections = {
        'bank': document.getElementById('bankDetails'),
        'paypal': document.getElementById('paypalDetails'),
        'venmo': document.getElementById('venmoDetails'),
        'cashapp': document.getElementById('cashappDetails'),
        'check': document.getElementById('checkDetails')
    };
    
    function showMethodDetails(method) {
        // Hide all sections
        Object.values(methodSections).forEach(section => {
            if (section) section.style.display = 'none';
        });
        
        // Show selected section
        if (methodSections[method]) {
            methodSections[method].style.display = 'block';
        }
    }
    
    function updateSummary() {
        const amount = parseFloat(amountInput.value) || 0;
        const method = payoutMethodSelect.value;
        const urgent = urgentCheckbox.checked;
        
        let fee = 0;
        let urgentFee = 0;
        
        if (method === 'bank') {
            fee = amount * 0.01; // 1%
        } else if (method === 'paypal') {
            fee = amount * 0.029 + 0.30; // 2.9% + $0.30
        } else if (method === 'check') {
            fee = 5.00; // $5.00
        } else if (method === 'venmo' || method === 'cashapp') {
            fee = amount * 0.015; // 1.5%
        }
        
        if (urgent) {
            urgentFee = amount * 0.02; // 2% urgent fee
        }
        
        document.getElementById('summaryAmount').textContent = '$' + amount.toFixed(2);
        document.getElementById('summaryFee').textContent = '$' + fee.toFixed(2);
        document.getElementById('urgentFee').textContent = '$' + urgentFee.toFixed(2);
        document.getElementById('summaryTotal').textContent = '$' + (amount + fee + urgentFee).toFixed(2);
        
        // Show/hide urgent fee row and alert
        document.getElementById('urgentFeeRow').style.display = urgent ? 'flex' : 'none';
        document.getElementById('urgentAlert').style.display = urgent ? 'block' : 'none';
    }
    
    payoutMethodSelect.addEventListener('change', function() {
        showMethodDetails(this.value);
        updateSummary();
    });
    
    amountInput.addEventListener('input', updateSummary);
    urgentCheckbox.addEventListener('change', updateSummary);
    
    payoutForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Basic validation
        const recipient = document.getElementById('recipient').value;
        const recipientEmail = document.getElementById('recipientEmail').value;
        const amount = parseFloat(amountInput.value);
        const method = payoutMethodSelect.value;
        
        if (!recipient || !recipientEmail || !amount || !method) {
            alert('Please fill in all required fields');
            return;
        }
        
        if (amount < 0.01) {
            alert('Amount must be at least $0.01');
            return;
        }
        
        // Validate method-specific fields
        let methodValid = true;
        if (method === 'bank') {
            const bankName = document.getElementById('bankName').value;
            const accountNumber = document.getElementById('accountNumber').value;
            const routingNumber = document.getElementById('routingNumber').value;
            if (!bankName || !accountNumber || !routingNumber) {
                methodValid = false;
                alert('Please fill in all bank transfer details');
            }
        } else if (method === 'paypal') {
            const paypalEmail = document.getElementById('paypalEmail').value;
            if (!paypalEmail) {
                methodValid = false;
                alert('Please provide PayPal email');
            }
        }
        
        if (!methodValid) return;
        
        // Show loading state
        const submitBtn = payoutForm.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin me-2"></i>Processing...';
        
        // Simulate API call
        setTimeout(() => {
            alert('Payout sent successfully!');
            payoutForm.reset();
            showMethodDetails('');
            updateSummary();
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="bx bx-money-withdraw me-2"></i>Send Payout';
        }, 2000);
    });
});
</script>
@endpush
