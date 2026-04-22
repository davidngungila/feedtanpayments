@extends('layouts.app')

@section('title', 'All Bills - FeedTan Pay')
@section('description', 'FeedTan Pay - Manage and track your bills and payments')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">All Bills</h5>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary btn-sm" onclick="exportBills()">
                        <i class="bx bx-download me-1"></i>Export
                    </button>
                    <a href="{{ route('billpay.create') }}" class="btn btn-primary btn-sm">
                        <i class="bx bx-plus me-1"></i>Create Bill
                    </a>
                </div>
            </div>
            <div class="card-body">
                <!-- Stats Cards -->
                <div class="row mb-6">
                    <div class="col-md-3">
                        <div class="card border-danger">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-lg bg-danger bg-opacity-10 rounded-circle me-3">
                                        <i class="bx bx-error text-danger"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Overdue</h6>
                                        <h4 class="mb-0 text-danger">3</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-warning">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-lg bg-warning bg-opacity-10 rounded-circle me-3">
                                        <i class="bx bx-time-five text-warning"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Due Soon</h6>
                                        <h4 class="mb-0 text-warning">8</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-info">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-lg bg-info bg-opacity-10 rounded-circle me-3">
                                        <i class="bx bx-calendar text-info"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Upcoming</h6>
                                        <h4 class="mb-0 text-info">15</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-success">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-lg bg-success bg-opacity-10 rounded-circle me-3">
                                        <i class="bx bx-check-circle text-success"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Paid</h6>
                                        <h4 class="mb-0 text-success">42</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Search and Filters -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bx bx-search"></i>
                            </span>
                            <input type="text" class="form-control" placeholder="Search bills..." id="searchInput">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="d-flex gap-2">
                            <select class="form-select" id="statusFilter">
                                <option value="">All Status</option>
                                <option value="overdue">Overdue</option>
                                <option value="due-soon">Due Soon</option>
                                <option value="upcoming">Upcoming</option>
                                <option value="paid">Paid</option>
                            </select>
                            <select class="form-select" id="categoryFilter">
                                <option value="">All Categories</option>
                                <option value="utilities">Utilities</option>
                                <option value="rent">Rent</option>
                                <option value="insurance">Insurance</option>
                                <option value="subscription">Subscription</option>
                                <option value="other">Other</option>
                            </select>
                            <input type="month" class="form-control" id="monthFilter" placeholder="Month">
                        </div>
                    </div>
                </div>

                <!-- Bills Table -->
                <div class="table-responsive">
                    <table class="table table-hover" id="billsTable">
                        <thead>
                            <tr>
                                <th>Bill Name</th>
                                <th>Category</th>
                                <th>Amount</th>
                                <th>Due Date</th>
                                <th>Status</th>
                                <th>Auto-Pay</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar me-2">
                                            <div class="avatar bg-danger bg-opacity-10 rounded-circle">
                                                <i class="bx bx-bolt text-danger"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">Electricity Bill</h6>
                                            <small class="text-muted">Con Edison</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-label-primary">Utilities</span>
                                </td>
                                <td><strong>$145.50</strong></td>
                                <td>
                                    <div class="text-danger fw-bold">Dec 10, 2024</div>
                                    <small class="text-muted">5 days overdue</small>
                                </td>
                                <td>
                                    <span class="badge bg-danger">Overdue</span>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="autopay1" checked>
                                        <label class="form-check-label" for="autopay1"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="javascript:void(0)" onclick="payBill('BILL001')">
                                                <i class="bx bx-dollar me-2"></i>Pay Now
                                            </a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0)" onclick="viewDetails('BILL001')">
                                                <i class="bx bx-eye me-2"></i>View Details
                                            </a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0)" onclick="editBill('BILL001')">
                                                <i class="bx bx-edit me-2"></i>Edit Bill
                                            </a></li>
                                            <li><a class="dropdown-item text-danger" href="javascript:void(0)" onclick="deleteBill('BILL001')">
                                                <i class="bx bx-trash me-2"></i>Delete Bill
                                            </a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar me-2">
                                            <div class="avatar bg-warning bg-opacity-10 rounded-circle">
                                                <i class="bx bx-home text-warning"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">Monthly Rent</h6>
                                            <small class="text-muted">Property Management</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-label-info">Rent</span>
                                </td>
                                <td><strong>$1,200.00</strong></td>
                                <td>
                                    <span class="bill-date" data-date="2024-12-20">Dec 20, 2024</span>
                                    <small class="text-muted">5 days from now</small>
                                </td>
                                <td>
                                    <span class="badge bg-warning">Due Soon</span>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="autopay2" checked>
                                        <label class="form-check-label" for="autopay2"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="javascript:void(0)" onclick="payBill('BILL002')">
                                                <i class="bx bx-dollar me-2"></i>Pay Now
                                            </a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0)" onclick="viewDetails('BILL002')">
                                                <i class="bx bx-eye me-2"></i>View Details
                                            </a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0)" onclick="editBill('BILL002')">
                                                <i class="bx bx-edit me-2"></i>Edit Bill
                                            </a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0)" onclick="schedulePayment('BILL002')">
                                                <i class="bx bx-calendar me-2"></i>Schedule Payment
                                            </a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar me-2">
                                            <div class="avatar bg-success bg-opacity-10 rounded-circle">
                                                <i class="bx bx-shield text-success"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">Car Insurance</h6>
                                            <small class="text-muted">State Farm</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-label-secondary">Insurance</span>
                                </td>
                                <td><strong>$285.00</strong></td>
                                <td>
                                    <div class="text-info">Jan 5, 2025</div>
                                    <small class="text-muted">21 days from now</small>
                                </td>
                                <td>
                                    <span class="badge bg-info">Upcoming</span>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="autopay3">
                                        <label class="form-check-label" for="autopay3"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="javascript:void(0)" onclick="payBill('BILL003')">
                                                <i class="bx bx-dollar me-2"></i>Pay Now
                                            </a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0)" onclick="viewDetails('BILL003')">
                                                <i class="bx bx-eye me-2"></i>View Details
                                            </a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0)" onclick="editBill('BILL003')">
                                                <i class="bx bx-edit me-2"></i>Edit Bill
                                            </a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0)" onclick="downloadReceipt('BILL003')">
                                                <i class="bx bx-download me-2"></i>Download Receipt
                                            </a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar me-2">
                                            <div class="avatar bg-primary bg-opacity-10 rounded-circle">
                                                <i class="bx bx-wifi text-primary"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">Internet Service</h6>
                                            <small class="text-muted">Comcast</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-label-primary">Utilities</span>
                                </td>
                                <td><strong>$79.99</strong></td>
                                <td>
                                    <div class="text-success">Dec 1, 2024</div>
                                    <small class="text-muted">Paid on Nov 30, 2024</small>
                                </td>
                                <td>
                                    <span class="badge bg-success">Paid</span>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="autopay4" checked>
                                        <label class="form-check-label" for="autopay4"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="javascript:void(0)" onclick="viewDetails('BILL004')">
                                                <i class="bx bx-eye me-2"></i>View Details
                                            </a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0)" onclick="downloadReceipt('BILL004')">
                                                <i class="bx bx-download me-2"></i>Download Receipt
                                            </a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0)" onclick="editBill('BILL004')">
                                                <i class="bx bx-edit me-2"></i>Edit Bill
                                            </a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0)" onclick="duplicateBill('BILL004')">
                                                <i class="bx bx-copy me-2"></i>Duplicate Bill
                                            </a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar me-2">
                                            <div class="avatar bg-secondary bg-opacity-10 rounded-circle">
                                                <i class="bx bx-play-circle text-secondary"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">Netflix Premium</h6>
                                            <small class="text-muted">Netflix</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-label-warning">Subscription</span>
                                </td>
                                <td><strong>$19.99</strong></td>
                                <td>
                                    <div class="text-info">Dec 25, 2024</div>
                                    <small class="text-muted">10 days from now</small>
                                </td>
                                <td>
                                    <span class="badge bg-info">Upcoming</span>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="autopay5" checked>
                                        <label class="form-check-label" for="autopay5"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="javascript:void(0)" onclick="payBill('BILL005')">
                                                <i class="bx bx-dollar me-2"></i>Pay Now
                                            </a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0)" onclick="viewDetails('BILL005')">
                                                <i class="bx bx-eye me-2"></i>View Details
                                            </a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0)" onclick="editBill('BILL005')">
                                                <i class="bx bx-edit me-2"></i>Edit Bill
                                            </a></li>
                                            <li><a class="dropdown-item text-warning" href="javascript:void(0)" onclick="cancelSubscription('BILL005')">
                                                <i class="bx bx-x me-2"></i>Cancel Subscription
                                            </a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1">Previous</a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- Bill Details Modal -->
<div class="modal fade" id="billDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bill Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="mb-2">Bill Information</h6>
                        <div class="mb-3">
                            <label class="form-label">Bill ID</label>
                            <input type="text" class="form-control" id="billModalId" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Bill Name</label>
                            <input type="text" class="form-control" id="billModalName" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Provider</label>
                            <input type="text" class="form-control" id="billModalProvider" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <input type="text" class="form-control" id="billModalCategory" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="mb-2">Amount & Schedule</h6>
                        <div class="mb-3">
                            <label class="form-label">Amount</label>
                            <input type="text" class="form-control" id="billModalAmount" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Due Date</label>
                            <input type="text" class="form-control" id="billModalDueDate" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Frequency</label>
                            <input type="text" class="form-control" id="billModalFrequency" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Auto-Pay</label>
                            <span class="badge bg-success" id="billModalAutopay">Enabled</span>
                        </div>
                    </div>
                </div>
                
                <div class="mb-4">
                    <h6 class="mb-2">Payment Information</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Payment Method</label>
                                <input type="text" class="form-control" id="billModalPaymentMethod" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Account Number</label>
                                <input type="text" class="form-control" id="billModalAccountNumber" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Last Payment Date</label>
                                <input type="text" class="form-control" id="billModalLastPayment" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Next Due Date</label>
                                <input type="text" class="form-control" id="billModalNextDue" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mb-4">
                    <h6 class="mb-2">Additional Information</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Reference</label>
                                <input type="text" class="form-control" id="billModalReference" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" id="billModalDescription" rows="3" readonly></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Notes</label>
                                <textarea class="form-control" id="billModalNotes" rows="3" readonly></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Attachments</label>
                                <div class="d-flex gap-2">
                                    <span class="badge bg-secondary">invoice.pdf</span>
                                    <span class="badge bg-secondary">contract.pdf</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="downloadBillReceipt()">Download Receipt</button>
                <button type="button" class="btn btn-success" onclick="payBillNow()">Pay Now</button>
            </div>
        </div>
    </div>
</div>

<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Process Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-4">
                    <h6 class="mb-3">Payment Details</h6>
                    <div class="mb-3">
                        <label class="form-label">Bill</label>
                        <input type="text" class="form-control" id="paymentModalBillName" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Amount Due</label>
                        <input type="text" class="form-control" id="paymentModalAmount" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Payment Method</label>
                        <select class="form-select" id="paymentModalMethod">
                            <option value="wallet">Wallet</option>
                            <option value="card">Credit Card</option>
                            <option value="bank">Bank Transfer</option>
                            <option value="paypal">PayPal</option>
                        </select>
                    </div>
                </div>
                
                <div class="mb-4">
                    <h6 class="mb-3">Payment Options</h6>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="paymentModalAutopay" checked>
                            <label class="form-check-label" for="paymentModalAutopay">
                                Enable auto-pay for this bill
                            </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Payment Notes</label>
                        <textarea class="form-control" id="paymentModalNotes" rows="3" placeholder="Add any notes for this payment..."></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="confirmPayment()">Process Payment</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const categoryFilter = document.getElementById('categoryFilter');
    const monthFilter = document.getElementById('monthFilter');
    
    // Initialize timezone for date displays
    if (typeof moment !== 'undefined' && window.TZS_TIMEZONE) {
        const now = moment().tz(window.TZS_TIMEZONE);
        const dateFormat = window.TZS_FORMAT || 'MM/DD/YYYY';
        
        // Update all bill date displays
        const dateElements = document.querySelectorAll('.bill-date');
        dateElements.forEach(element => {
            if (element && element.dataset.date) {
                const originalDate = element.dataset.date;
                const formattedDate = moment(originalDate, 'YYYY-MM-DD').tz(window.TZS_TIMEZONE).format(dateFormat);
                element.textContent = formattedDate;
            }
        });
    }
    
    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const status = statusFilter.value;
        const category = categoryFilter.value;
        const month = monthFilter.value;
        
        const rows = document.querySelectorAll('#billsTable tbody tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            const statusBadge = row.querySelector('.badge');
            const rowStatus = statusBadge ? statusBadge.textContent.toLowerCase() : '';
            const categoryBadge = row.cells[1].textContent.toLowerCase();
            const dueDate = row.cells[3].textContent;
            
            let showRow = true;
            
            // Search filter
            if (searchTerm && !text.includes(searchTerm)) {
                showRow = false;
            }
            
            // Status filter
            if (status && !rowStatus.includes(status.toLowerCase())) {
                showRow = false;
            }
            
            // Category filter
            if (category && !categoryBadge.includes(category.toLowerCase())) {
                showRow = false;
            }
            
            // Month filter (simplified)
            if (month && !dueDate.includes(month)) {
                showRow = false;
            }
            
            row.style.display = showRow ? '' : 'none';
        });
    }
    
    searchInput.addEventListener('input', filterTable);
    statusFilter.addEventListener('change', filterTable);
    categoryFilter.addEventListener('change', filterTable);
    monthFilter.addEventListener('change', filterTable);
});

// Sample bill data
const bills = [
    {
        id: 'BILL001',
        name: 'Monthly Rent',
        provider: 'Property Management Co',
        category: 'Housing',
        amount: 1500.00,
        dueDate: 'Dec 25, 2024',
        frequency: 'Monthly',
        autopay: true,
        paymentMethod: 'Bank Transfer',
        accountNumber: '****1234',
        lastPayment: 'Nov 25, 2024',
        nextDue: 'Dec 25, 2024',
        reference: 'RENT-2024-001',
        description: 'Monthly apartment rent payment',
        notes: 'Due on 25th of each month',
        attachments: ['invoice.pdf', 'lease.pdf']
    },
    {
        id: 'BILL002',
        name: 'Electric Bill',
        provider: 'City Power Company',
        category: 'Utilities',
        amount: 245.50,
        dueDate: 'Dec 20, 2024',
        frequency: 'Monthly',
        autopay: false,
        paymentMethod: 'Credit Card',
        accountNumber: '****5678',
        lastPayment: 'Nov 20, 2024',
        nextDue: 'Dec 20, 2024',
        reference: 'ELEC-2024-002',
        description: 'Monthly electricity consumption',
        notes: 'Higher usage due to cold weather',
        attachments: ['bill.pdf']
    },
    {
        id: 'BILL003',
        name: 'Car Insurance',
        provider: 'SafeDrive Insurance',
        category: 'Insurance',
        amount: 125.00,
        dueDate: 'Dec 28, 2024',
        frequency: 'Monthly',
        autopay: true,
        paymentMethod: 'Wallet',
        accountNumber: '****9876',
        lastPayment: 'Nov 28, 2024',
        nextDue: 'Dec 28, 2024',
        reference: 'INS-2024-003',
        description: 'Comprehensive auto insurance coverage',
        notes: 'Premium includes roadside assistance',
        attachments: ['policy.pdf', 'invoice.pdf']
    }
];

function payBill(billId) {
    const bill = bills.find(b => b.id === billId);
    if (bill) {
        // Populate payment modal with bill data
        document.getElementById('paymentModalBillName').value = bill.name;
        document.getElementById('paymentModalAmount').value = '$' + bill.amount.toFixed(2);
        document.getElementById('paymentModalMethod').value = 'Bank Transfer';
        
        // Show payment modal
        const modal = new bootstrap.Modal(document.getElementById('paymentModal'));
        modal.show();
    }
}

function viewDetails(billId) {
    const bill = bills.find(b => b.id === billId);
    if (bill) {
        // Populate bill details modal
        document.getElementById('billModalId').value = bill.id;
        document.getElementById('billModalName').value = bill.name;
        document.getElementById('billModalProvider').value = bill.provider;
        document.getElementById('billModalCategory').value = bill.category;
        document.getElementById('billModalAmount').value = '$' + bill.amount.toFixed(2);
        document.getElementById('billModalDueDate').value = bill.dueDate;
        document.getElementById('billModalFrequency').value = bill.frequency;
        document.getElementById('billModalAutopay').textContent = bill.autopay ? 'Enabled' : 'Disabled';
        document.getElementById('billModalAutopay').className = bill.autopay ? 'badge bg-success' : 'badge bg-warning';
        document.getElementById('billModalPaymentMethod').value = bill.paymentMethod;
        document.getElementById('billModalAccountNumber').value = bill.accountNumber;
        document.getElementById('billModalLastPayment').value = bill.lastPayment;
        document.getElementById('billModalNextDue').value = bill.nextDue;
        document.getElementById('billModalReference').value = bill.reference;
        document.getElementById('billModalDescription').value = bill.description;
        document.getElementById('billModalNotes').value = bill.notes;
        
        // Show bill details modal
        const modal = new bootstrap.Modal(document.getElementById('billDetailsModal'));
        modal.show();
    }
}

function editBill(billId) {
    const bill = bills.find(b => b.id === billId);
    if (bill) {
        alert('Opening edit form for bill: ' + bill.name);
        // Close details modal if open
        const detailsModal = bootstrap.Modal.getInstance(document.getElementById('billDetailsModal'));
        if (detailsModal) {
            detailsModal.hide();
        }
        // Redirect to edit page
        window.location.href = '/billpay/create?id=' + billId;
    }
}

function schedulePayment(billId) {
    payBill(billId);
        alert('Payment scheduled for ' + date + ' for bill: ' + billId);
    }
}

function downloadReceipt(billId) {
    alert('Downloading receipt for bill: ' + billId);
}

function duplicateBill(billId) {
    alert('Duplicating bill: ' + billId);
}

function cancelSubscription(billId) {
    if (confirm('Are you sure you want to cancel this subscription?')) {
        alert('Subscription cancelled: ' + billId);
    }
}

function exportBills() {
    alert('Exporting bills data...');
}
</script>
@endpush
