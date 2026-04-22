@extends('layouts.app')

@section('title', 'Initiate Payment - FeedTan Pay')
@section('description', 'FeedTan Pay - Send money to recipients with various payment methods')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Initiate Payment</h5>
            </div>
            <div class="card-body">
                <form id="paymentForm" method="POST" onsubmit="return false">
                    @csrf
                    <div class="row g-6">
                        <div class="col-md-6">
                            <label for="recipient" class="form-label">Recipient Email/Phone</label>
                            <input
                                type="text"
                                class="form-control"
                                id="recipient"
                                name="recipient"
                                placeholder="Enter recipient email or phone number"
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
                        <div class="col-md-12">
                            <label for="description" class="form-label">Description</label>
                            <textarea
                                class="form-control"
                                id="description"
                                name="description"
                                rows="3"
                                placeholder="What's this payment for?"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="paymentMethod" class="form-label">Payment Method</label>
                            <select class="form-select" id="paymentMethod" name="paymentMethod" required>
                                <option value="">Select payment method</option>
                                <option value="wallet">Wallet Balance</option>
                                <option value="card">Credit/Debit Card</option>
                                <option value="bank">Bank Transfer</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-select" id="category" name="category">
                                <option value="">Select category</option>
                                <option value="personal">Personal</option>
                                <option value="business">Business</option>
                                <option value="utilities">Utilities</option>
                                <option value="rent">Rent</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" id="saveRecipient">
                            <label class="form-check-label" for="saveRecipient">
                                Save recipient for future payments
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary me-3">
                            <i class="bx bx-send me-2"></i>Send Payment
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
                <h5 class="card-title mb-0">Payment Summary</h5>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Amount:</span>
                        <span id="summaryAmount">$0.00</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Fee:</span>
                        <span id="summaryFee">$0.00</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold">
                        <span>Total:</span>
                        <span id="summaryTotal">$0.00</span>
                    </div>
                </div>
                
                <div class="alert alert-info">
                    <i class="bx bx-info-circle me-2"></i>
                    <small>Processing fees may apply based on payment method and amount.</small>
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
                        <img src="{{ asset('assets/img/avatars/2.png') }}" alt="Avatar" class="rounded-circle">
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-0">Jane Smith</h6>
                        <small class="text-muted">jane.smith@email.com</small>
                    </div>
                    <button class="btn btn-sm btn-outline-primary">Pay</button>
                </div>
                <div class="d-flex align-items-center mb-3">
                    <div class="avatar me-3">
                        <img src="{{ asset('assets/img/avatars/3.png') }}" alt="Avatar" class="rounded-circle">
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-0">Mike Johnson</h6>
                        <small class="text-muted">+1 234 567 8900</small>
                    </div>
                    <button class="btn btn-sm btn-outline-primary">Pay</button>
                </div>
                <div class="d-flex align-items-center">
                    <div class="avatar me-3">
                        <img src="{{ asset('assets/img/avatars/4.png') }}" alt="Avatar" class="rounded-circle">
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-0">Sarah Williams</h6>
                        <small class="text-muted">sarah.w@email.com</small>
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
    const paymentForm = document.getElementById('paymentForm');
    const amountInput = document.getElementById('amount');
    const paymentMethodSelect = document.getElementById('paymentMethod');
    
    function updateSummary() {
        const amount = parseFloat(amountInput.value) || 0;
        const method = paymentMethodSelect.value;
        
        let fee = 0;
        if (method === 'card') {
            fee = amount * 0.029 + 0.30; // 2.9% + $0.30
        } else if (method === 'bank') {
            fee = amount * 0.005; // 0.5%
        }
        
        document.getElementById('summaryAmount').textContent = '$' + amount.toFixed(2);
        document.getElementById('summaryFee').textContent = '$' + fee.toFixed(2);
        document.getElementById('summaryTotal').textContent = '$' + (amount + fee).toFixed(2);
    }
    
    amountInput.addEventListener('input', updateSummary);
    paymentMethodSelect.addEventListener('change', updateSummary);
    
    paymentForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Basic validation
        const recipient = document.getElementById('recipient').value;
        const amount = parseFloat(amountInput.value);
        const method = paymentMethodSelect.value;
        
        if (!recipient || !amount || !method) {
            alert('Please fill in all required fields');
            return;
        }
        
        if (amount < 0.01) {
            alert('Amount must be at least $0.01');
            return;
        }
        
        // Show loading state
        const submitBtn = paymentForm.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin me-2"></i>Processing...';
        
        // Simulate API call
        setTimeout(() => {
            alert('Payment sent successfully!');
            paymentForm.reset();
            updateSummary();
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="bx bx-send me-2"></i>Send Payment';
        }, 2000);
    });
});
</script>
@endpush
