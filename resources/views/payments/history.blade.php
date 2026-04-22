@extends('layouts.app')

@section('title', 'Payment History - FeedTan Pay')
@section('description', 'FeedTan Pay - View and manage your payment transactions')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Payment History</h5>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary btn-sm" onclick="exportHistory()">
                        <i class="bx bx-download me-1"></i>Export
                    </button>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#filterModal">
                        <i class="bx bx-filter me-1"></i>Filter
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- Stats Cards -->
                <div class="row mb-6">
                    <div class="col-md-3">
                        <div class="card border-primary">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-lg bg-primary bg-opacity-10 rounded-circle me-3">
                                        <i class="bx bx-trending-up text-primary"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Total Sent</h6>
                                        <h4 class="mb-0 text-primary">$12,458.50</h4>
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
                                        <h6 class="mb-0">Successful</h6>
                                        <h4 class="mb-0 text-success">142</h4>
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
                                        <h6 class="mb-0">Pending</h6>
                                        <h4 class="mb-0 text-warning">8</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-danger">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-lg bg-danger bg-opacity-10 rounded-circle me-3">
                                        <i class="bx bx-x-circle text-danger"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Failed</h6>
                                        <h4 class="mb-0 text-danger">3</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Search and Date Range -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bx bx-search"></i>
                            </span>
                            <input type="text" class="form-control" placeholder="Search payments..." id="searchInput">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="d-flex gap-2">
                            <select class="form-select" id="statusFilter">
                                <option value="">All Status</option>
                                <option value="successful">Successful</option>
                                <option value="pending">Pending</option>
                                <option value="failed">Failed</option>
                            </select>
                            <input type="date" class="form-control" id="dateFrom" placeholder="From">
                            <input type="date" class="form-control" id="dateTo" placeholder="To">
                        </div>
                    </div>
                </div>

                <!-- Payments Table -->
                <div class="table-responsive">
                    <table class="table table-hover" id="paymentsTable">
                        <thead>
                            <tr>
                                <th>Transaction ID</th>
                                <th>Recipient</th>
                                <th>Amount</th>
                                <th>Method</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <span class="text-muted">#PAY001</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar me-2">
                                            <img src="{{ asset('assets/img/avatars/2.png') }}" alt="Avatar" class="rounded-circle">
                                        </div>
                                        <div>
                                            <h6 class="mb-0">Jane Smith</h6>
                                            <small class="text-muted">jane.smith@email.com</small>
                                        </div>
                                    </div>
                                </td>
                                <td><strong>$250.00</strong></td>
                                <td>
                                    <span class="badge bg-label-primary">Wallet</span>
                                </td>
                                <td>
                                    <span class="badge bg-success">Successful</span>
                                </td>
                                <td><span class="transaction-date" data-date="2024-12-15 10:30">Dec 15, 2024 10:30 AM</span></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#" onclick="viewDetails('TRX001')">
                                                <i class="bx bx-eye me-2"></i>View Details
                                            </a></li>
                                            <li><a class="dropdown-item" href="#" onclick="downloadReceipt('TRX001')">
                                                <i class="bx bx-download me-2"></i>Download Receipt
                                            </a></li>
                                            <li><a class="dropdown-item text-danger" href="#" onclick="disputePayment('PAY001')">
                                                <i class="bx bx-error me-2"></i>Report Issue
                                            </a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="text-muted">#PAY002</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar me-2">
                                            <img src="{{ asset('assets/img/avatars/3.png') }}" alt="Avatar" class="rounded-circle">
                                        </div>
                                        <div>
                                            <h6 class="mb-0">Mike Johnson</h6>
                                            <small class="text-muted">+1 234 567 8900</small>
                                        </div>
                                    </div>
                                </td>
                                <td><strong>$1,250.00</strong></td>
                                <td>
                                    <span class="badge bg-label-info">Card</span>
                                </td>
                                <td>
                                    <span class="badge bg-warning">Pending</span>
                                </td>
                                <td>Dec 15, 2024 09:15 AM</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#" onclick="viewDetails('TRX002')">
                                                <i class="bx bx-eye me-2"></i>View Details
                                            </a></li>
                                            <li><a class="dropdown-item" href="#" onclick="downloadReceipt('TRX002')">
                                                <i class="bx bx-download me-2"></i>Download Receipt
                                            </a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="text-muted">#PAY003</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar me-2">
                                            <img src="{{ asset('assets/img/avatars/4.png') }}" alt="Avatar" class="rounded-circle">
                                        </div>
                                        <div>
                                            <h6 class="mb-0">Sarah Williams</h6>
                                            <small class="text-muted">sarah.w@email.com</small>
                                        </div>
                                    </div>
                                </td>
                                <td><strong>$450.75</strong></td>
                                <td>
                                    <span class="badge bg-label-secondary">Bank</span>
                                </td>
                                <td>
                                    <span class="badge bg-success">Successful</span>
                                </td>
                                <td>Dec 14, 2024 03:45 PM</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#" onclick="viewDetails('TRX003')">
                                                <i class="bx bx-eye me-2"></i>View Details
                                            </a></li>
                                            <li><a class="dropdown-item" href="#" onclick="downloadReceipt('TRX003')">
                                                <i class="bx bx-download me-2"></i>Download Receipt
                                            </a></li>
                                            <li><a class="dropdown-item" href="#" onclick="sendAgain('PAY003')">
                                                <i class="bx bx-redo me-2"></i>Send Again
                                            </a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="text-muted">#PAY004</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar me-2">
                                            <img src="{{ asset('assets/img/avatars/5.png') }}" alt="Avatar" class="rounded-circle">
                                        </div>
                                        <div>
                                            <h6 class="mb-0">David Brown</h6>
                                            <small class="text-muted">david.b@email.com</small>
                                        </div>
                                    </div>
                                </td>
                                <td><strong>$875.00</strong></td>
                                <td>
                                    <span class="badge bg-label-primary">Wallet</span>
                                </td>
                                <td>
                                    <span class="badge bg-danger">Failed</span>
                                </td>
                                <td>Dec 14, 2024 11:20 AM</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#" onclick="viewDetails('TRX004')">
                                                <i class="bx bx-eye me-2"></i>View Details
                                            </a></li>
                                            <li><a class="dropdown-item" href="#" onclick="downloadReceipt('TRX004')">
                                                <i class="bx bx-download me-2"></i>Download Receipt
                                            </a></li>
                                            <li><a class="dropdown-item" href="#" onclick="disputePayment('PAY004')">
                                                <i class="bx bx-error me-2"></i>Report Issue
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

<!-- Transaction Details Modal -->
<div class="modal fade" id="transactionDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Transaction Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="mb-2">Transaction Information</h6>
                        <div class="mb-3">
                            <label class="form-label">Transaction ID</label>
                            <input type="text" class="form-control" id="modalTransactionId" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Date & Time</label>
                            <input type="text" class="form-control" id="modalDateTime" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <span class="badge bg-success" id="modalStatus">Completed</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="mb-2">Payment Details</h6>
                        <div class="mb-3">
                            <label class="form-label">Amount</label>
                            <input type="text" class="form-control" id="modalAmount" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Fee</label>
                            <input type="text" class="form-control" id="modalFee" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Total Amount</label>
                            <input type="text" class="form-control" id="modalTotal" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Payment Method</label>
                            <input type="text" class="form-control" id="modalMethod" readonly>
                        </div>
                    </div>
                </div>
                
                <div class="mb-4">
                    <h6 class="mb-2">Recipient Information</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" id="modalRecipientName" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="text" class="form-control" id="modalRecipientEmail" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" class="form-control" id="modalRecipientPhone" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Account Number</label>
                                <input type="text" class="form-control" id="modalRecipientAccount" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mb-4">
                    <h6 class="mb-2">Additional Information</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Category</label>
                                <input type="text" class="form-control" id="modalCategory" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Reference</label>
                                <input type="text" class="form-control" id="modalReference" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" id="modalDescription" rows="3" readonly></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Notes</label>
                                <textarea class="form-control" id="modalNotes" rows="2" readonly></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="downloadReceipt()">Download Receipt</button>
                <button type="button" class="btn btn-success" onclick="payAgain()">Pay Again</button>
            </div>
        </div>
    </div>
</div>

<!-- Download Receipt Modal -->
<div class="modal fade" id="downloadReceiptModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Download Receipt</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-4">
                    <h6 class="mb-3">Choose Receipt Format</h6>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="receiptFormat" id="pdfFormat" value="pdf" checked>
                        <label class="form-check-label" for="pdfFormat">
                            <i class="bx bx-file me-2"></i>PDF Document
                        </label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="receiptFormat" id="excelFormat" value="excel">
                        <label class="form-check-label" for="excelFormat">
                            <i class="bx bx-table me-2"></i>Excel Spreadsheet
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="receiptFormat" id="csvFormat" value="csv">
                        <label class="form-check-label" for="csvFormat">
                            <i class="bx bx-file me-2"></i>CSV File
                        </label>
                    </div>
                </div>
                
                <div class="mb-4">
                    <h6 class="mb-3">Email Options</h6>
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="receiptEmail" value="john.doe@example.com">
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="includeDetails" checked>
                        <label class="form-check-label" for="includeDetails">
                            Include full transaction details
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="confirmDownloadReceipt()">Download</button>
            </div>
        </div>
    </div>
</div>

<!-- Filter Modal -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Filter Payments</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-4">
                    <label class="form-label">Status</label>
                    <select class="form-select" id="modalStatusFilter">
                        <option value="">All Status</option>
                        <option value="successful">Successful</option>
                        <option value="pending">Pending</option>
                        <option value="failed">Failed</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="form-label">Payment Method</label>
                    <select class="form-select" id="modalMethodFilter">
                        <option value="">All Methods</option>
                        <option value="wallet">Wallet</option>
                        <option value="card">Card</option>
                        <option value="bank">Bank</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="form-label">Date Range</label>
                    <div class="d-flex gap-2">
                        <input type="date" class="form-control" id="modalDateFrom">
                        <input type="date" class="form-control" id="modalDateTo">
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label">Amount Range</label>
                    <div class="d-flex gap-2">
                        <input type="number" class="form-control" placeholder="Min" id="modalAmountMin">
                        <input type="number" class="form-control" placeholder="Max" id="modalAmountMax">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="applyFilters()">Apply Filters</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Initialize timezone for date displays
    if (typeof moment !== 'undefined' && window.TZS_TIMEZONE) {
        const now = moment().tz(window.TZS_TIMEZONE);
        const dateFormat = window.TZS_FORMAT || 'MM/DD/YYYY hh:mm A';
        
        // Update all transaction date displays
        const dateElements = document.querySelectorAll('.transaction-date');
        dateElements.forEach(element => {
            if (element && element.dataset.date) {
                const originalDate = element.dataset.date;
                const formattedDate = moment(originalDate, 'YYYY-MM-DD HH:mm').tz(window.TZS_TIMEZONE).format(dateFormat);
                element.textContent = formattedDate;
            }
        });
    }

    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const dateFrom = document.getElementById('dateFrom');
    const dateTo = document.getElementById('dateTo');
    
    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const status = statusFilter.value;
        const fromDate = dateFrom.value;
        const toDate = dateTo.value;
        
        const rows = document.querySelectorAll('#paymentsTable tbody tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            const statusBadge = row.querySelector('.badge');
            const rowStatus = statusBadge ? statusBadge.textContent.toLowerCase() : '';
            const dateCell = row.cells[5].textContent;
            
            let showRow = true;
            
            // Search filter
            if (searchTerm && !text.includes(searchTerm)) {
                showRow = false;
            }
            
            // Status filter
            if (status && rowStatus !== status.toLowerCase()) {
                showRow = false;
            }
            
            // Date filter (simplified)
            if (fromDate && dateCell < fromDate) {
                showRow = false;
            }
            
            row.style.display = showRow ? '' : 'none';
        });
    }
    
    searchInput.addEventListener('input', filterTable);
    statusFilter.addEventListener('change', filterTable);
    dateFrom.addEventListener('change', filterTable);
    dateTo.addEventListener('change', filterTable);
});

// Sample transaction data
const transactions = [
    {
        id: 'TRX001',
        date: 'Dec 15, 2024',
        description: 'Salary Payment',
        amount: 5000.00,
        fee: 25.00,
        total: 5025.00,
        status: 'Completed',
        method: 'Bank Transfer',
        category: 'Income',
        recipient: {
            name: 'John Smith',
            email: 'john.smith@company.com',
            phone: '+1 (555) 123-4567',
            account: '****1234'
        },
        reference: 'REF-2024-001',
        notes: 'Monthly salary payment',
        additionalInfo: 'Direct deposit from employer'
    },
    {
        id: 'TRX002',
        date: 'Dec 14, 2024',
        description: 'Online Shopping',
        amount: 245.50,
        fee: 7.37,
        total: 252.87,
        status: 'Completed',
        method: 'Credit Card',
        category: 'Shopping',
        recipient: {
            name: 'Amazon',
            email: 'orders@amazon.com',
            phone: '',
            account: ''
        },
        reference: 'AMZ-2024-002',
        notes: 'Electronics and books purchase',
        additionalInfo: '2-day shipping selected'
    }
];

function viewDetails(transactionId) {
    const transaction = transactions.find(t => t.id === transactionId);
    if (transaction) {
        // Populate modal with transaction data
        document.getElementById('modalTransactionId').value = transaction.id;
        document.getElementById('modalDateTime').value = transaction.date + ' at 2:30 PM';
        document.getElementById('modalStatus').textContent = transaction.status;
        document.getElementById('modalStatus').className = transaction.status === 'Completed' ? 'badge bg-success' : 'badge bg-warning';
        document.getElementById('modalAmount').value = '$' + transaction.amount.toFixed(2);
        document.getElementById('modalFee').value = '$' + transaction.fee.toFixed(2);
        document.getElementById('modalTotal').value = '$' + transaction.total.toFixed(2);
        document.getElementById('modalMethod').textContent = transaction.method;
        document.getElementById('modalCategory').textContent = transaction.category;
        document.getElementById('modalRecipientName').value = transaction.recipient.name;
        document.getElementById('modalRecipientEmail').value = transaction.recipient.email;
        document.getElementById('modalRecipientPhone').value = transaction.recipient.phone;
        document.getElementById('modalRecipientAccount').value = transaction.recipient.account;
        document.getElementById('modalReference').value = transaction.reference;
        document.getElementById('modalDescription').value = transaction.description;
        document.getElementById('modalNotes').value = transaction.notes;
        
        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('transactionDetailsModal'));
        modal.show();
    }
}

function downloadReceipt(transactionId) {
    const transaction = transactions.find(t => t.id === transactionId);
    if (transaction) {
        // Set current transaction for download modal
        document.getElementById('receiptEmail').value = 'john.doe@example.com';
        
        // Show download receipt modal
        const modal = new bootstrap.Modal(document.getElementById('downloadReceiptModal'));
        modal.show();
    }
}

function confirmDownloadReceipt() {
    const format = document.querySelector('input[name="receiptFormat"]:checked').value;
    const email = document.getElementById('receiptEmail').value;
    const includeDetails = document.getElementById('includeDetails').checked;
    
    alert(`Downloading receipt in ${format.toUpperCase()} format to ${email}${includeDetails ? ' with full details' : ''}...`);
    
    // Close modal
    const modal = bootstrap.Modal.getInstance(document.getElementById('downloadReceiptModal'));
    modal.hide();
}

function payAgain(transactionId) {
    const transaction = transactions.find(t => t.id === transactionId);
    if (transaction) {
        alert(`Initiating new payment to ${transaction.recipient.name} (${transaction.recipient.email})...`);
        
        // Close details modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('transactionDetailsModal'));
        modal.hide();
        
        // Redirect to payment page
        window.location.href = '/payments/initiate';
    }
}

function cancelPayment(transactionId) {
    if (confirm('Are you sure you want to cancel this payment?')) {
        alert('Payment cancelled: ' + transactionId);
    }
}

function retryPayment(transactionId) {
    alert('Retrying payment: ' + transactionId);
}

function disputePayment(transactionId) {
    alert('Opening dispute form for transaction: ' + transactionId);
}

function sendAgain(transactionId) {
    alert('Preparing to send payment again: ' + transactionId);
}

function exportHistory() {
    alert('Exporting payment history...');
}

function applyFilters() {
    const modal = bootstrap.Modal.getInstance(document.getElementById('filterModal'));
    modal.hide();
    
    // Apply filters to main table
    const status = document.getElementById('modalStatusFilter').value;
    const method = document.getElementById('modalMethodFilter').value;
    
    document.getElementById('statusFilter').value = status;
    
    // Trigger filter
    document.getElementById('statusFilter').dispatchEvent(new Event('change'));
}
</script>
@endpush
