@extends('layouts.app')

@section('title', 'Balance Report - FeedTan Pay')
@section('description', 'FeedTan Pay - Account balance and transaction history')

@section('content')
<div class="row">
    <!-- Balance Overview -->
    <div class="col-md-12">
        <div class="card mb-6">
            <div class="card-header">
                <h5 class="card-title mb-0">Balance Overview</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="text-center">
                            <h2 class="mb-2 text-primary">$12,458.50</h2>
                            <p class="text-muted">Current Balance</p>
                            <div class="d-flex justify-content-center gap-2">
                                <span class="badge bg-success">
                                    <i class="bx bx-trending-up"></i> +12.5%
                                </span>
                                <small class="text-muted">vs last month</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <canvas id="balanceChart" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Account Details -->
    <div class="col-md-8">
        <!-- Account Cards -->
        <div class="row mb-6">
            <div class="col-md-6">
                <div class="card border-primary">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h6 class="mb-0">Primary Account</h6>
                                <small class="text-muted">****1234</small>
                            </div>
                            <div class="avatar bg-primary bg-opacity-10 rounded-circle">
                                <i class="bx bx-credit-card text-primary"></i>
                            </div>
                        </div>
                        <h4 class="mb-3">$8,234.75</h4>
                        <div class="d-flex justify-content-between mb-2">
                            <small class="text-muted">Available</small>
                            <strong>$8,234.75</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <small class="text-muted">Pending</small>
                            <strong>$0.00</strong>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-success">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h6 class="mb-0">Savings Account</h6>
                                <small class="text-muted">****5678</small>
                            </div>
                            <div class="avatar bg-success bg-opacity-10 rounded-circle">
                                <i class="bx bx-piggy-bank text-success"></i>
                            </div>
                        </div>
                        <h4 class="mb-3">$4,223.75</h4>
                        <div class="d-flex justify-content-between mb-2">
                            <small class="text-muted">Available</small>
                            <strong>$4,223.75</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <small class="text-muted">Interest Rate</small>
                            <strong>2.5% APY</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Balance History -->
        <div class="card mb-6">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Balance History</h5>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-sm btn-outline-primary active" onclick="changePeriod('7d')">7 Days</button>
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="changePeriod('30d')">30 Days</button>
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="changePeriod('90d')">90 Days</button>
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="changePeriod('1y')">1 Year</button>
                </div>
            </div>
            <div class="card-body">
                <canvas id="historyChart" height="300"></canvas>
            </div>
        </div>

        <!-- Transaction List -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Recent Transactions</h5>
                <div class="d-flex gap-2">
                    <select class="form-select form-select-sm" style="width: auto;">
                        <option>All Accounts</option>
                        <option>Primary Account</option>
                        <option>Savings Account</option>
                    </select>
                    <button class="btn btn-sm btn-outline-primary">
                        <i class="bx bx-filter"></i> Filter
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Category</th>
                                <th>Account</th>
                                <th>Amount</th>
                                <th>Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Dec 15, 2024</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar bg-success bg-opacity-10 rounded-circle me-2" style="width: 32px; height: 32px;">
                                            <i class="bx bx-dollar text-success"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">Salary Deposit</h6>
                                            <small class="text-muted">Monthly salary</small>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge bg-label-success">Income</span></td>
                                <td>Primary</td>
                                <td class="text-success">+$5,000.00</td>
                                <td>$8,234.75</td>
                            </tr>
                            <tr>
                                <td>Dec 14, 2024</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar bg-primary bg-opacity-10 rounded-circle me-2" style="width: 32px; height: 32px;">
                                            <i class="bx bx-shopping-bag text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">Walmart</h6>
                                            <small class="text-muted">Grocery shopping</small>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge bg-label-primary">Food</span></td>
                                <td>Primary</td>
                                <td class="text-danger">-$245.50</td>
                                <td>$3,234.75</td>
                            </tr>
                            <tr>
                                <td>Dec 13, 2024</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar bg-warning bg-opacity-10 rounded-circle me-2" style="width: 32px; height: 32px;">
                                            <i class="bx bx-bolt text-warning"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">Con Edison</h6>
                                            <small class="text-muted">Electric bill payment</small>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge bg-label-warning">Utilities</span></td>
                                <td>Primary</td>
                                <td class="text-danger">-$145.50</td>
                                <td>$3,480.25</td>
                            </tr>
                            <tr>
                                <td>Dec 12, 2024</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar bg-success bg-opacity-10 rounded-circle me-2" style="width: 32px; height: 32px;">
                                            <i class="bx bx-laptop text-success"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">Freelance Payment</h6>
                                            <small class="text-muted">Web design project</small>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge bg-label-success">Income</span></td>
                                <td>Primary</td>
                                <td class="text-success">+$1,250.00</td>
                                <td>$3,625.75</td>
                            </tr>
                            <tr>
                                <td>Dec 11, 2024</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar bg-info bg-opacity-10 rounded-circle me-2" style="width: 32px; height: 32px;">
                                            <i class="bx bx-play-circle text-info"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">Netflix</h6>
                                            <small class="text-muted">Monthly subscription</small>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge bg-label-info">Entertainment</span></td>
                                <td>Primary</td>
                                <td class="text-danger">-$19.99</td>
                                <td>$2,375.75</td>
                            </tr>
                            <tr>
                                <td>Dec 10, 2024</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar bg-success bg-opacity-10 rounded-circle me-2" style="width: 32px; height: 32px;">
                                            <i class="bx bx-piggy-bank text-success"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">Transfer to Savings</h6>
                                            <small class="text-muted">Monthly savings</small>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge bg-label-secondary">Transfer</span></td>
                                <td>Primary</td>
                                <td class="text-danger">-$500.00</td>
                                <td>$2,395.74</td>
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

    <!-- Sidebar -->
    <div class="col-md-4">
        <!-- Quick Stats -->
        <div class="card mb-6">
            <div class="card-header">
                <h5 class="card-title mb-0">Quick Stats</h5>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Today's Change</span>
                        <strong class="text-success">+$125.50</strong>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-success" style="width: 75%"></div>
                    </div>
                </div>
                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span>This Week</span>
                        <strong class="text-success">+$1,250.00</strong>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-info" style="width: 60%"></div>
                    </div>
                </div>
                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span>This Month</span>
                        <strong class="text-danger">-$890.25</strong>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-warning" style="width: 35%"></div>
                    </div>
                </div>
                <div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Year to Date</span>
                        <strong class="text-success">+$3,458.50</strong>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-primary" style="width: 85%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Spending Analysis -->
        <div class="card mb-6">
            <div class="card-header">
                <h5 class="card-title mb-0">Spending Analysis</h5>
            </div>
            <div class="card-body">
                <canvas id="spendingChart" height="200"></canvas>
                <div class="mt-4">
                    <div class="d-flex justify-content-between mb-2">
                        <small>Daily Average</small>
                        <strong>$174.49</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <small>Weekly Average</small>
                        <strong>$1,221.43</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <small>Monthly Average</small>
                        <strong>$5,234.75</strong>
                    </div>
                </div>
            </div>
        </div>

        <!-- Budget Status -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Budget Status</h5>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-2">
                        <div>
                            <h6 class="mb-0">Food & Dining</h6>
                            <small class="text-muted">$845.50 / $1,000</small>
                        </div>
                        <span class="badge bg-success">On Track</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-success" style="width: 84.5%"></div>
                    </div>
                </div>
                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-2">
                        <div>
                            <h6 class="mb-0">Entertainment</h6>
                            <small class="text-muted">$320.00 / $300</small>
                        </div>
                        <span class="badge bg-warning">Over Budget</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-warning" style="width: 106.7%"></div>
                    </div>
                </div>
                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-2">
                        <div>
                            <h6 class="mb-0">Transportation</h6>
                            <small class="text-muted">$180.00 / $400</small>
                        </div>
                        <span class="badge bg-success">Good</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-success" style="width: 45%"></div>
                    </div>
                </div>
                <div>
                    <div class="d-flex justify-content-between mb-2">
                        <div>
                            <h6 class="mb-0">Shopping</h6>
                            <small class="text-muted">$245.50 / $500</small>
                        </div>
                        <span class="badge bg-success">On Track</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-success" style="width: 49.1%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Balance Chart
    const balanceCtx = document.getElementById('balanceChart').getContext('2d');
    new Chart(balanceCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Balance',
                data: [8000, 8500, 9200, 8800, 9500, 10200, 11000, 10500, 11200, 11800, 11500, 12458],
                borderColor: '#007bff',
                backgroundColor: 'rgba(0, 123, 255, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: false,
                    ticks: {
                        callback: function(value) {
                            return '$' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });

    // History Chart
    const historyCtx = document.getElementById('historyChart').getContext('2d');
    new Chart(historyCtx, {
        type: 'bar',
        data: {
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
            datasets: [{
                label: 'Income',
                data: [2500, 3200, 2800, 3500],
                backgroundColor: '#28a745'
            }, {
                label: 'Expenses',
                data: [1800, 2100, 1900, 2300],
                backgroundColor: '#dc3545'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '$' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });

    // Spending Chart
    const spendingCtx = document.getElementById('spendingChart').getContext('2d');
    new Chart(spendingCtx, {
        type: 'doughnut',
        data: {
            labels: ['Food', 'Transport', 'Entertainment', 'Shopping', 'Utilities', 'Other'],
            datasets: [{
                data: [845.50, 320, 320, 245.50, 425.75, 198],
                backgroundColor: [
                    '#28a745',
                    '#17a2b8',
                    '#ffc107',
                    '#6c757d',
                    '#fd7e14',
                    '#e83e8c'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });
});

function changePeriod(period) {
    // Update button states
    document.querySelectorAll('.btn-group .btn').forEach(btn => {
        btn.classList.remove('active');
    });
    event.target.classList.add('active');
    
    // In a real application, this would fetch new data based on the period
    console.log('Changing period to:', period);
}
</script>
@endpush
