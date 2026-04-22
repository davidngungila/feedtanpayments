@extends('layouts.app')

@section('title', 'Payout History - FeedTan Pay')
@section('description', 'FeedTan Pay - View and manage your payout transactions')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Payout History</h5>
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
                                        <i class="bx bx-money-withdraw text-primary"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Total Paid Out</h6>
                                        <h4 class="mb-0 text-primary">$45,678.90</h4>
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
                                        <h6 class="mb-0">Completed</h6>
                                        <h4 class="mb-0 text-success">89</h4>
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
                                        <h6 class="mb-0">Processing</h6>
                                        <h4 class="mb-0 text-warning">12</h4>
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
                                        <h6 class="mb-0">Scheduled</h6>
                                        <h4 class="mb-0 text-info">5</h4>
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
                            <input type="text" class="form-control" placeholder="Search payouts..." id="searchInput">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="d-flex gap-2">
                            <select class="form-select" id="statusFilter">
                                <option value="">All Status</option>
                                <option value="completed">Completed</option>
                                <option value="processing">Processing</option>
                                <option value="scheduled">Scheduled</option>
                                <option value="failed">Failed</option>
                            </select>
                            <select class="form-select" id="methodFilter">
                                <option value="">All Methods</option>
                                <option value="bank">Bank Transfer</option>
                                <option value="paypal">PayPal</option>
                                <option value="venmo">Venmo</option>
                                <option value="cashapp">Cash App</option>
                                <option value="check">Check</option>
                            </select>
                            <input type="date" class="form-control" id="dateFrom" placeholder="From">
                            <input type="date" class="form-control" id="dateTo" placeholder="To">
                        </div>
                    </div>
                </div>

                <!-- Payouts Table -->
                <div class="table-responsive">
                    <table class="table table-hover" id="payoutsTable">
                        <thead>
                            <tr>
                                <th>Payout ID</th>
                                <th>Recipient</th>
                                <th>Amount</th>
                                <th>Method</th>
                                <th>Status</th>
                                <th>Processing Date</th>
                                <th>Completed Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <span class="text-muted">#PAYOUT001</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar me-2">
                                            <img src="{{ asset('assets/img/avatars/6.png') }}" alt="Avatar" class="rounded-circle">
                                        </div>
                                        <div>
                                            <h6 class="mb-0">Alex Thompson</h6>
                                            <small class="text-muted">alex.t@email.com</small>
                                        </div>
                                    </div>
                                </td>
                                <td><strong>$2,500.00</strong></td>
                                <td>
                                    <span class="badge bg-label-primary">Bank Transfer</span>
                                </td>
                                <td>
                                    <span class="badge bg-success">Completed</span>
                                </td>
                                <td>Dec 15, 2024 09:00 AM</td>
                                <td>Dec 17, 2024 02:30 PM</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#" onclick="viewDetails('PAYOUT001')">
                                                <i class="bx bx-eye me-2"></i>View Details
                                            </a></li>
                                            <li><a class="dropdown-item" href="#" onclick="downloadReceipt('PAYOUT001')">
                                                <i class="bx bx-download me-2"></i>Download Receipt
                                            </a></li>
                                            <li><a class="dropdown-item" href="#" onclick="payAgain('PAYOUT001')">
                                                <i class="bx bx-redo me-2"></i>Pay Again
                                            </a></li>
                                            <li><a class="dropdown-item" href="#" onclick="trackPayout('PAYOUT001')">
                                                <i class="bx bx-map me-2"></i>Track
                                            </a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="text-muted">#PAYOUT002</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar me-2">
                                            <img src="{{ asset('assets/img/avatars/7.png') }}" alt="Avatar" class="rounded-circle">
                                        </div>
                                        <div>
                                            <h6 class="mb-0">Emily Davis</h6>
                                            <small class="text-muted">emily.d@email.com</small>
                                        </div>
                                    </div>
                                </td>
                                <td><strong>$1,250.00</strong></td>
                                <td>
                                    <span class="badge bg-label-info">PayPal</span>
                                </td>
                                <td>
                                    <span class="badge bg-warning">Processing</span>
                                </td>
                                <td>Dec 15, 2024 11:45 AM</td>
                                <td>-</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#" onclick="viewDetails('PAYOUT002')">
                                                <i class="bx bx-eye me-2"></i>View Details
                                            </a></li>
                                            <li><a class="dropdown-item" href="#" onclick="downloadReceipt('PAYOUT002')">
                                                <i class="bx bx-download me-2"></i>Download Receipt
                                            </a></li>
                                            <li><a class="dropdown-item" href="#" onclick="payAgain('PAYOUT002')">
                                                <i class="bx bx-redo me-2"></i>Pay Again
                                            </a></li>
                                            <li><a class="dropdown-item text-danger" href="#" onclick="cancelPayout('PAYOUT002')">
                                                <i class="bx bx-x me-2"></i>Cancel Payout
                                            </a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="text-muted">#PAYOUT003</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar me-2">
                                            <img src="{{ asset('assets/img/avatars/8.png') }}" alt="Avatar" class="rounded-circle">
                                        </div>
                                        <div>
                                            <h6 class="mb-0">Robert Wilson</h6>
                                            <small class="text-muted">robert.w@email.com</small>
                                        </div>
                                    </div>
                                </td>
                                <td><strong>$875.50</strong></td>
                                <td>
                                    <span class="badge bg-label-success">Venmo</span>
                                </td>
                                <td>
                                    <span class="badge bg-info">Scheduled</span>
                                </td>
                                <td>Dec 18, 2024 10:00 AM</td>
                                <td>-</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#" onclick="viewDetails('PAYOUT003')">
                                                <i class="bx bx-eye me-2"></i>View Details
                                            </a></li>
                                            <li><a class="dropdown-item" href="#" onclick="downloadReceipt('PAYOUT003')">
                                                <i class="bx bx-download me-2"></i>Download Receipt
                                            </a></li>
                                            <li><a class="dropdown-item" href="#" onclick="payAgain('PAYOUT003')">
                                                <i class="bx bx-redo me-2"></i>Pay Again
                                            </a></li>
                                            <li><a class="dropdown-item text-warning" href="#" onclick="processNow('PAYOUT003')">
                                                <i class="bx bx-time-five me-2"></i>Process Now
                                            </a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="text-muted">#PAYOUT004</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar me-2">
                                            <img src="{{ asset('assets/img/avatars/9.png') }}" alt="Avatar" class="rounded-circle">
                                        </div>
                                        <div>
                                            <h6 class="mb-0">Lisa Anderson</h6>
                                            <small class="text-muted">lisa.a@email.com</small>
                                        </div>
                                    </div>
                                </td>
                                <td><strong>$450.00</strong></td>
                                <td>
                                    <span class="badge bg-label-secondary">Check</span>
                                </td>
                                <td>
                                    <span class="badge bg-success">Completed</span>
                                </td>
                                <td><span class="transaction-date" data-date="2024-12-15 15:45">Dec 15, 2024 03:45 PM</span></td>
                                <td>Dec 16, 2024 11:45 AM</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#" onclick="viewDetails('PAYOUT004')">
                                                <i class="bx bx-eye me-2"></i>View Details
                                            </a></li>
                                            <li><a class="dropdown-item" href="#" onclick="downloadReceipt('PAYOUT004')">
                                                <i class="bx bx-download me-2"></i>Download Receipt
                                            </a></li>
                                            <li><a class="dropdown-item" href="#" onclick="payAgain('PAYOUT004')">
                                                <i class="bx bx-redo me-2"></i>Pay Again
                                            </a></li>
                                            <li><a class="dropdown-item" href="#" onclick="trackShipping('PAYOUT004')">
                                                <i class="bx bx-package me-2"></i>Track Shipping
                                            </a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="text-muted">#PAYOUT005</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar me-2">
                                            <img src="{{ asset('assets/img/avatars/10.png') }}" alt="Avatar" class="rounded-circle">
                                        </div>
                                        <div>
                                            <h6 class="mb-0">James Miller</h6>
                                            <small class="text-muted">james.m@email.com</small>
                                        </div>
                                    </div>
                                </td>
                                <td><strong>$3,200.00</strong></td>
                                <td>
                                    <span class="badge bg-label-warning">Cash App</span>
                                </td>
                                <td>
                                    <span class="badge bg-danger">Failed</span>
                                </td>
                                <td>Dec 13, 2024 02:30 PM</td>
                                <td>-</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#" onclick="viewDetails('PAYOUT005')">
                                                <i class="bx bx-eye me-2"></i>View Details
                                            </a></li>
                                            <li><a class="dropdown-item" href="#" onclick="downloadReceipt('PAYOUT005')">
                                                <i class="bx bx-download me-2"></i>Download Receipt
                                            </a></li>
                                            <li><a class="dropdown-item" href="#" onclick="payAgain('PAYOUT005')">
                                                <i class="bx bx-redo me-2"></i>Pay Again
                                            </a></li>
                                            <li><a class="dropdown-item text-danger" href="#" onclick="reportIssue('PAYOUT005')">
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

<!-- Payout Details Modal -->
<div class="modal fade" id="payoutDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Payout Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="mb-2">Payout Information</h6>
                        <div class="mb-3">
                            <label class="form-label">Payout ID</label>
                            <input type="text" class="form-control" id="payoutModalId" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Date & Time</label>
                            <input type="text" class="form-control" id="payoutModalDateTime" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <span class="badge bg-success" id="payoutModalStatus">Completed</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="mb-2">Amount Details</h6>
                        <div class="mb-3">
                            <label class="form-label">Payout Amount</label>
                            <input type="text" class="form-control" id="payoutModalAmount" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Processing Fee</label>
                            <input type="text" class="form-control" id="payoutModalFee" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Net Amount</label>
                            <input type="text" class="form-control" id="payoutModalNet" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Payout Method</label>
                            <input type="text" class="form-control" id="payoutModalMethod" readonly>
                        </div>
                    </div>
                </div>
                
                <div class="mb-4">
                    <h6 class="mb-2">Recipient Information</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" id="payoutModalRecipientName" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="text" class="form-control" id="payoutModalRecipientEmail" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" class="form-control" id="payoutModalRecipientPhone" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Account Details</label>
                                <input type="text" class="form-control" id="payoutModalRecipientAccount" readonly>
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
                                <input type="text" class="form-control" id="payoutModalReference" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" id="payoutModalDescription" rows="3" readonly></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Processing Time</label>
                                <input type="text" class="form-control" id="payoutModalProcessingTime" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Notes</label>
                                <textarea class="form-control" id="payoutModalNotes" rows="2" readonly></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="downloadPayoutReceipt()">Download Receipt</button>
                <button type="button" class="btn btn-success" onclick="requestPayoutAgain()">Request Again</button>
            </div>
        </div>
    </div>
</div>

<!-- Download Receipt Modal -->
<div class="modal fade" id="downloadPayoutReceiptModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Download Payout Receipt</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-4">
                    <h6 class="mb-3">Choose Receipt Format</h6>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="payoutReceiptFormat" id="payoutPdfFormat" value="pdf" checked>
                        <label class="form-check-label" for="payoutPdfFormat">
                            <i class="bx bx-file me-2"></i>PDF Document
                        </label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="payoutReceiptFormat" id="payoutExcelFormat" value="excel">
                        <label class="form-check-label" for="payoutExcelFormat">
                            <i class="bx bx-table me-2"></i>Excel Spreadsheet
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payoutReceiptFormat" id="payoutCsvFormat" value="csv">
                        <label class="form-check-label" for="payoutCsvFormat">
                            <i class="bx bx-file me-2"></i>CSV File
                        </label>
                    </div>
                </div>
                
                <div class="mb-4">
                    <h6 class="mb-3">Email Options</h6>
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="payoutReceiptEmail" value="john.doe@example.com">
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="payoutIncludeDetails" checked>
                        <label class="form-check-label" for="payoutIncludeDetails">
                            Include full payout details
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="confirmDownloadPayoutReceipt()">Download</button>
            </div>
        </div>
    </div>
</div>

<!-- Filter Modal -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Filter Payouts</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-4">
                    <label class="form-label">Status</label>
                    <select class="form-select" id="modalStatusFilter">
                        <option value="">All Status</option>
                        <option value="completed">Completed</option>
                        <option value="processing">Processing</option>
                        <option value="scheduled">Scheduled</option>
                        <option value="failed">Failed</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="form-label">Payout Method</label>
                    <select class="form-select" id="modalMethodFilter">
                        <option value="">All Methods</option>
                        <option value="bank">Bank Transfer</option>
                        <option value="paypal">PayPal</option>
                        <option value="venmo">Venmo</option>
                        <option value="cashapp">Cash App</option>
                        <option value="check">Check</option>
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
    const methodFilter = document.getElementById('methodFilter');
    const dateFrom = document.getElementById('dateFrom');
    const dateTo = document.getElementById('dateTo');
    
    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const status = statusFilter.value;
        const method = methodFilter.value;
        const fromDate = dateFrom.value;
        const toDate = dateTo.value;
        
        const rows = document.querySelectorAll('#payoutsTable tbody tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            const statusBadge = row.querySelector('.badge');
            const rowStatus = statusBadge ? statusBadge.textContent.toLowerCase() : '';
            const methodBadge = row.cells[3].textContent.toLowerCase();
            const processingDate = row.cells[5].textContent;
            
            let showRow = true;
            
            // Search filter
            if (searchTerm && !text.includes(searchTerm)) {
                showRow = false;
            }
            
            // Status filter
            if (status && !rowStatus.includes(status.toLowerCase())) {
                showRow = false;
            }
            
            // Method filter
            if (method && !methodBadge.includes(method.toLowerCase())) {
                showRow = false;
            }
            
            // Date filter (simplified)
            if (fromDate && processingDate < fromDate) {
                showRow = false;
            }
            
            row.style.display = showRow ? '' : 'none';
        });
    }
    
    searchInput.addEventListener('input', filterTable);
    statusFilter.addEventListener('change', filterTable);
    methodFilter.addEventListener('change', filterTable);
    dateFrom.addEventListener('change', filterTable);
    dateTo.addEventListener('change', filterTable);
});

// Sample payout data
const payouts = [
    {
        id: 'PAYOUT001',
        date: 'Dec 15, 2024',
        description: 'Monthly Salary Withdrawal',
        amount: 3500.00,
        fee: 35.00,
        net: 3465.00,
        status: 'Completed',
        method: 'Bank Transfer',
        recipient: {
            name: 'John Doe',
            email: 'john.doe@example.com',
            phone: '+1 (555) 123-4567',
            account: '****5678'
        },
        reference: 'PAYOUT-2024-001',
        processingTime: '2 hours',
        notes: 'Monthly salary withdrawal to personal account'
    },
    {
        id: 'PAYOUT002',
        date: 'Dec 14, 2024',
        description: 'Freelance Payment',
        amount: 1200.00,
        fee: 12.00,
        net: 1188.00,
        status: 'Processing',
        method: 'PayPal',
        recipient: {
            name: 'Jane Smith',
            email: 'jane.smith@freelance.com',
            phone: '+1 (555) 987-6543',
            account: 'jane.smith@paypal.com'
        },
        reference: 'PAYOUT-2024-002',
        processingTime: '24 hours',
        notes: 'Freelance project payment'
    }
];

function viewDetails(payoutId) {
    const payout = payouts.find(p => p.id === payoutId);
    if (payout) {
        // Populate modal with payout data
        document.getElementById('payoutModalId').value = payout.id;
        document.getElementById('payoutModalDateTime').value = payout.date + ' at 3:45 PM';
        document.getElementById('payoutModalStatus').textContent = payout.status;
        document.getElementById('payoutModalStatus').className = payout.status === 'Completed' ? 'badge bg-success' : 'badge bg-warning';
        document.getElementById('payoutModalAmount').value = '$' + payout.amount.toFixed(2);
        document.getElementById('payoutModalFee').value = '$' + payout.fee.toFixed(2);
        document.getElementById('payoutModalNet').value = '$' + payout.net.toFixed(2);
        document.getElementById('payoutModalMethod').textContent = payout.method;
        document.getElementById('payoutModalRecipientName').value = payout.recipient.name;
        document.getElementById('payoutModalRecipientEmail').value = payout.recipient.email;
        document.getElementById('payoutModalRecipientPhone').value = payout.recipient.phone;
        document.getElementById('payoutModalRecipientAccount').value = payout.recipient.account;
        document.getElementById('payoutModalReference').value = payout.reference;
        document.getElementById('payoutModalDescription').value = payout.description;
        document.getElementById('payoutModalProcessingTime').value = payout.processingTime;
        document.getElementById('payoutModalNotes').value = payout.notes;
        
        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('payoutDetailsModal'));
        modal.show();
    }
}

function downloadReceipt(payoutId) {
    const payout = payouts.find(p => p.id === payoutId);
    if (payout) {
        // Set current payout for download modal
        document.getElementById('payoutReceiptEmail').value = 'john.doe@example.com';
        
        // Show download receipt modal
        const modal = new bootstrap.Modal(document.getElementById('downloadPayoutReceiptModal'));
        modal.show();
    }
}

function confirmDownloadPayoutReceipt() {
    const format = document.querySelector('input[name="payoutReceiptFormat"]:checked').value;
    const email = document.getElementById('payoutReceiptEmail').value;
    const includeDetails = document.getElementById('payoutIncludeDetails').checked;
    
    alert(`Downloading payout receipt in ${format.toUpperCase()} format to ${email}${includeDetails ? ' with full details' : ''}...`);
    
    // Close modal
    const modal = bootstrap.Modal.getInstance(document.getElementById('downloadPayoutReceiptModal'));
    modal.hide();
}

function requestPayoutAgain(payoutId) {
    const payout = payouts.find(p => p.id === payoutId);
    if (payout) {
        alert(`Initiating new payout to ${payout.recipient.name} (${payout.recipient.email})...`);
        
        // Close details modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('payoutDetailsModal'));
        modal.hide();
        
        // Redirect to payout page
        window.location.href = '/payouts/initiate';
    }
}

function payAgain(payoutId) {
    requestPayoutAgain(payoutId);
}

function trackPayout(payoutId) {
    alert('Tracking payout: ' + payoutId);
}

function cancelPayout(payoutId) {
    if (confirm('Are you sure you want to cancel this payout?')) {
        alert('Payout cancelled: ' + payoutId);
    }
}

function editPayout(payoutId) {
    alert('Editing payout: ' + payoutId);
}

function processNow(payoutId) {
    if (confirm('Process this payout now? Additional fees may apply.')) {
        alert('Payout processing: ' + payoutId);
    }
}

function trackShipping(payoutId) {
    alert('Tracking check shipping: ' + payoutId);
}

function retryPayout(payoutId) {
    alert('Retrying payout: ' + payoutId);
}

function reportIssue(payoutId) {
    alert('Opening issue report for payout: ' + payoutId);
}

function exportHistory() {
    alert('Exporting payout history...');
}

function applyFilters() {
    const modal = bootstrap.Modal.getInstance(document.getElementById('filterModal'));
    modal.hide();
    
    // Apply filters to main table
    const status = document.getElementById('modalStatusFilter').value;
    const method = document.getElementById('modalMethodFilter').value;
    
    document.getElementById('statusFilter').value = status;
    document.getElementById('methodFilter').value = method;
    
    // Trigger filter
    document.getElementById('statusFilter').dispatchEvent(new Event('change'));
}
</script>
@endpush
