@extends('layouts.app')

@section('title', 'Account Statement - FeedTan Pay')
@section('description', 'FeedTan Pay - Download and view account statements')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Account Statements</h5>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary btn-sm" onclick="downloadAllStatements()">
                        <i class="bx bx-download me-1"></i>Download All
                    </button>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#emailModal">
                        <i class="bx bx-envelope me-1"></i>Email Statements
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- Period Selection -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label class="form-label">Select Period</label>
                        <select class="form-select" id="periodSelect" onchange="filterStatements()">
                            <option value="all">All Statements</option>
                            <option value="current">Current Month</option>
                            <option value="last30">Last 30 Days</option>
                            <option value="last90">Last 90 Days</option>
                            <option value="ytd">Year to Date</option>
                            <option value="custom">Custom Range</option>
                        </select>
                    </div>
                    <div class="col-md-4" id="customRange" style="display: none;">
                        <label class="form-label">Custom Range</label>
                        <div class="d-flex gap-2">
                            <input type="date" class="form-control" id="dateFrom">
                            <input type="date" class="form-control" id="dateTo">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Account</label>
                        <select class="form-select" id="accountSelect" onchange="filterStatements()">
                            <option value="all">All Accounts</option>
                            <option value="primary">Primary Account</option>
                            <option value="savings">Savings Account</option>
                        </select>
                    </div>
                </div>

                <!-- Statements List -->
                <div class="table-responsive">
                    <table class="table table-hover" id="statementsTable">
                        <thead>
                            <tr>
                                <th>Period</th>
                                <th>Account</th>
                                <th>Opening Balance</th>
                                <th>Closing Balance</th>
                                <th>Transactions</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div>
                                        <h6 class="mb-0">December 2024</h6>
                                        <small class="text-muted">Dec 1 - Dec 15, 2024</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-label-primary">Primary Account</span>
                                </td>
                                <td>$3,234.75</td>
                                <td><strong>$8,234.75</strong></td>
                                <td>47</td>
                                <td>
                                    <span class="badge bg-success">Available</span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-sm btn-outline-primary" onclick="viewStatement('2024-12-primary')">
                                            <i class="bx bx-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-success" onclick="downloadStatement('2024-12-primary')">
                                            <i class="bx bx-download"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-info" onclick="emailStatement('2024-12-primary')">
                                            <i class="bx bx-envelope"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div>
                                        <h6 class="mb-0">November 2024</h6>
                                        <small class="text-muted">Nov 1 - Nov 30, 2024</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-label-primary">Primary Account</span>
                                </td>
                                <td>$2,890.25</td>
                                <td><strong>$3,234.75</strong></td>
                                <td>62</td>
                                <td>
                                    <span class="badge bg-success">Available</span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-sm btn-outline-primary" onclick="viewStatement('2024-11-primary')">
                                            <i class="bx bx-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-success" onclick="downloadStatement('2024-11-primary')">
                                            <i class="bx bx-download"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-info" onclick="emailStatement('2024-11-primary')">
                                            <i class="bx bx-envelope"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div>
                                        <h6 class="mb-0">October 2024</h6>
                                        <small class="text-muted">Oct 1 - Oct 31, 2024</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-label-primary">Primary Account</span>
                                </td>
                                <td>$2,456.80</td>
                                <td><strong>$2,890.25</strong></td>
                                <td>58</td>
                                <td>
                                    <span class="badge bg-success">Available</span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-sm btn-outline-primary" onclick="viewStatement('2024-10-primary')">
                                            <i class="bx bx-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-success" onclick="downloadStatement('2024-10-primary')">
                                            <i class="bx bx-download"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-info" onclick="emailStatement('2024-10-primary')">
                                            <i class="bx bx-envelope"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div>
                                        <h6 class="mb-0">December 2024</h6>
                                        <small class="text-muted">Dec 1 - Dec 15, 2024</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-label-success">Savings Account</span>
                                </td>
                                <td>$3,890.25</td>
                                <td><strong>$4,223.75</strong></td>
                                <td>12</td>
                                <td>
                                    <span class="badge bg-success">Available</span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-sm btn-outline-primary" onclick="viewStatement('2024-12-savings')">
                                            <i class="bx bx-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-success" onclick="downloadStatement('2024-12-savings')">
                                            <i class="bx bx-download"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-info" onclick="emailStatement('2024-12-savings')">
                                            <i class="bx bx-envelope"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div>
                                        <h6 class="mb-0">November 2024</h6>
                                        <small class="text-muted">Nov 1 - Nov 30, 2024</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-label-success">Savings Account</span>
                                </td>
                                <td>$3,546.80</td>
                                <td><strong>$3,890.25</strong></td>
                                <td>8</td>
                                <td>
                                    <span class="badge bg-success">Available</span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-sm btn-outline-primary" onclick="viewStatement('2024-11-savings')">
                                            <i class="bx bx-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-success" onclick="downloadStatement('2024-11-savings')">
                                            <i class="bx bx-download"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-info" onclick="emailStatement('2024-11-savings')">
                                            <i class="bx bx-envelope"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div>
                                        <h6 class="mb-0">October 2024</h6>
                                        <small class="text-muted">Oct 1 - Oct 31, 2024</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-label-success">Savings Account</span>
                                </td>
                                <td>$3,234.75</td>
                                <td><strong>$3,546.80</strong></td>
                                <td>10</td>
                                <td>
                                    <span class="badge bg-success">Available</span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-sm btn-outline-primary" onclick="viewStatement('2024-10-savings')">
                                            <i class="bx bx-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-success" onclick="downloadStatement('2024-10-savings')">
                                            <i class="bx bx-download"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-info" onclick="emailStatement('2024-10-savings')">
                                            <i class="bx bx-envelope"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <nav aria-label="Page navigation" class="mt-4">
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

<!-- Statement Preview Modal -->
<div class="modal fade" id="statementModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Statement Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="statementContent">
                    <!-- Statement content will be loaded here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="downloadCurrentStatement()">
                    <i class="bx bx-download me-2"></i>Download PDF
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Email Modal -->
<div class="modal fade" id="emailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Email Statements</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-4">
                    <label class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="emailAddress" placeholder="Enter email address">
                </div>
                <div class="mb-4">
                    <label class="form-label">Select Statements</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="selectAll" onchange="toggleAllStatements()">
                        <label class="form-check-label" for="selectAll">
                            Select All Statements
                        </label>
                    </div>
                    <div class="mt-2">
                        <div class="form-check">
                            <input class="form-check-input statement-checkbox" type="checkbox" value="2024-12-primary" checked>
                            <label class="form-check-label">December 2024 - Primary Account</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input statement-checkbox" type="checkbox" value="2024-11-primary">
                            <label class="form-check-label">November 2024 - Primary Account</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input statement-checkbox" type="checkbox" value="2024-10-primary">
                            <label class="form-check-label">October 2024 - Primary Account</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input statement-checkbox" type="checkbox" value="2024-12-savings" checked>
                            <label class="form-check-label">December 2024 - Savings Account</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input statement-checkbox" type="checkbox" value="2024-11-savings">
                            <label class="form-check-label">November 2024 - Savings Account</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input statement-checkbox" type="checkbox" value="2024-10-savings">
                            <label class="form-check-label">October 2024 - Savings Account</label>
                        </div>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label">Message (Optional)</label>
                    <textarea class="form-control" id="emailMessage" rows="3" placeholder="Add a message to the email"></textarea>
                </div>
                <div class="mb-4">
                    <label class="form-label">Format</label>
                    <div class="btn-group" role="group">
                        <input type="radio" class="btn-check" name="format" id="pdf" value="pdf" checked>
                        <label class="btn btn-outline-primary" for="pdf">PDF</label>
                        
                        <input type="radio" class="btn-check" name="format" id="excel" value="excel">
                        <label class="btn btn-outline-primary" for="excel">Excel</label>
                        
                        <input type="radio" class="btn-check" name="format" id="csv" value="csv">
                        <label class="btn btn-outline-primary" for="csv">CSV</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="sendEmail()">
                    <i class="bx bx-send me-2"></i>Send Email
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const periodSelect = document.getElementById('periodSelect');
    const customRange = document.getElementById('customRange');
    
    periodSelect.addEventListener('change', function() {
        if (this.value === 'custom') {
            customRange.style.display = 'block';
        } else {
            customRange.style.display = 'none';
        }
    });
});

function filterStatements() {
    const period = document.getElementById('periodSelect').value;
    const account = document.getElementById('accountSelect').value;
    
    const rows = document.querySelectorAll('#statementsTable tbody tr');
    
    rows.forEach(row => {
        let showRow = true;
        
        // Account filter
        if (account !== 'all') {
            const accountBadge = row.cells[1].textContent.toLowerCase();
            if (!accountBadge.includes(account)) {
                showRow = false;
            }
        }
        
        // Period filter (simplified)
        if (period !== 'all') {
            // In a real application, this would filter by actual dates
            console.log('Filtering by period:', period);
        }
        
        row.style.display = showRow ? '' : 'none';
    });
}

function viewStatement(statementId) {
    // Load statement preview
    const statementContent = document.getElementById('statementContent');
    statementContent.innerHTML = `
        <div class="text-center py-8">
            <i class="bx bx-loader-alt bx-spin" style="font-size: 3rem;"></i>
            <p class="mt-3">Loading statement...</p>
        </div>
    `;
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('statementModal'));
    modal.show();
    
    // Simulate loading statement content
    setTimeout(() => {
        statementContent.innerHTML = `
            <div class="statement-preview">
                <div class="text-center mb-4">
                    <h4>Account Statement</h4>
                    <p class="text-muted">${statementId}</p>
                </div>
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6>Account Information</h6>
                        <p><strong>Account Number:</strong> ****1234</p>
                        <p><strong>Account Type:</strong> Primary Account</p>
                        <p><strong>Period:</strong> December 1-15, 2024</p>
                    </div>
                    <div class="col-md-6">
                        <h6>Summary</h6>
                        <p><strong>Opening Balance:</strong> $3,234.75</p>
                        <p><strong>Closing Balance:</strong> $8,234.75</p>
                        <p><strong>Net Change:</strong> +$5,000.00</p>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Debit</th>
                                <th>Credit</th>
                                <th>Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Dec 1, 2024</td>
                                <td>Opening Balance</td>
                                <td>-</td>
                                <td>-</td>
                                <td>$3,234.75</td>
                            </tr>
                            <tr>
                                <td>Dec 15, 2024</td>
                                <td>Salary Deposit</td>
                                <td>-</td>
                                <td>$5,000.00</td>
                                <td>$8,234.75</td>
                            </tr>
                            <tr>
                                <td>Dec 14, 2024</td>
                                <td>Grocery Shopping</td>
                                <td>$245.50</td>
                                <td>-</td>
                                <td>$3,234.75</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        `;
    }, 1000);
}

function downloadStatement(statementId) {
    alert('Downloading statement: ' + statementId);
}

function downloadCurrentStatement() {
    alert('Downloading current statement as PDF...');
}

function emailStatement(statementId) {
    const email = prompt('Enter email address:');
    if (email) {
        alert('Statement ' + statementId + ' will be emailed to: ' + email);
    }
}

function downloadAllStatements() {
    if (confirm('Download all available statements? This may take a moment.')) {
        alert('Downloading all statements...');
    }
}

function sendEmail() {
    const emailAddress = document.getElementById('emailAddress').value;
    const selectedStatements = Array.from(document.querySelectorAll('.statement-checkbox:checked'))
        .map(cb => cb.value);
    
    if (!emailAddress) {
        alert('Please enter an email address');
        return;
    }
    
    if (selectedStatements.length === 0) {
        alert('Please select at least one statement');
        return;
    }
    
    const format = document.querySelector('input[name="format"]:checked').value;
    const message = document.getElementById('emailMessage').value;
    
    alert(`Sending ${selectedStatements.length} statement(s) in ${format.toUpperCase()} format to: ${emailAddress}`);
    
    // Close modal
    const modal = bootstrap.Modal.getInstance(document.getElementById('emailModal'));
    modal.hide();
}

function toggleAllStatements() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.statement-checkbox');
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAll.checked;
    });
}
</script>
@endpush
