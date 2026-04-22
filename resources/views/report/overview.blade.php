@extends('layouts.app')

@section('title', 'Report Overview - FeedTan Pay')
@section('description', 'FeedTan Pay - Financial reports and analytics overview')

@section('content')
<div class="row">
    <!-- Summary Cards -->
    <div class="col-md-12">
        <div class="row mb-6">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="mb-0">Total Balance</h6>
                                <h3 class="mb-0">$12,458.50</h3>
                                <small class="text-success">
                                    <i class="bx bx-trending-up"></i> +12.5% from last month
                                </small>
                            </div>
                            <div class="avatar avatar-lg bg-primary bg-opacity-10 rounded-circle">
                                <i class="bx bx-wallet text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="mb-0">Monthly Income</h6>
                                <h3 class="mb-0">$8,750.00</h3>
                                <small class="text-success">
                                    <i class="bx bx-trending-up"></i> +8.2% from last month
                                </small>
                            </div>
                            <div class="avatar avatar-lg bg-success bg-opacity-10 rounded-circle">
                                <i class="bx bx-trending-up text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="mb-0">Monthly Expenses</h6>
                                <h3 class="mb-0">$5,234.75</h3>
                                <small class="text-danger">
                                    <i class="bx bx-trending-down"></i> +3.1% from last month
                                </small>
                            </div>
                            <div class="avatar avatar-lg bg-danger bg-opacity-10 rounded-circle">
                                <i class="bx bx-trending-down text-danger"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="mb-0">Net Savings</h6>
                                <h3 class="mb-0">$3,515.25</h3>
                                <small class="text-success">
                                    <i class="bx bx-trending-up"></i> +18.7% from last month
                                </small>
                            </div>
                            <div class="avatar avatar-lg bg-info bg-opacity-10 rounded-circle">
                                <i class="bx bx-piggy-bank text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Charts Section -->
    <div class="col-md-8">
        <!-- Revenue Chart -->
        <div class="card mb-6">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Revenue Overview</h5>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-sm btn-outline-primary active" onclick="changeChartPeriod('week')">Week</button>
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="changeChartPeriod('month')">Month</button>
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="changeChartPeriod('year')">Year</button>
                </div>
            </div>
            <div class="card-body">
                <canvas id="revenueChart" height="300"></canvas>
            </div>
        </div>

        <!-- Expense Breakdown -->
        <div class="card mb-6">
            <div class="card-header">
                <h5 class="card-title mb-0">Expense Breakdown</h5>
            </div>
            <div class="card-body">
                <canvas id="expenseChart" height="300"></canvas>
            </div>
        </div>

        <!-- Transaction History -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Recent Transactions</h5>
                <a href="#" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Category</th>
                                <th>Type</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Dec 15, 2024</td>
                                <td>Salary Payment</td>
                                <td><span class="badge bg-label-success">Income</span></td>
                                <td><span class="badge bg-success">Credit</span></td>
                                <td class="text-success">+$5,000.00</td>
                            </tr>
                            <tr>
                                <td>Dec 14, 2024</td>
                                <td>Grocery Shopping</td>
                                <td><span class="badge bg-label-primary">Food</span></td>
                                <td><span class="badge bg-danger">Debit</span></td>
                                <td class="text-danger">-$245.50</td>
                            </tr>
                            <tr>
                                <td>Dec 13, 2024</td>
                                <td>Electric Bill</td>
                                <td><span class="badge bg-label-warning">Utilities</span></td>
                                <td><span class="badge bg-danger">Debit</span></td>
                                <td class="text-danger">-$145.50</td>
                            </tr>
                            <tr>
                                <td>Dec 12, 2024</td>
                                <td>Freelance Project</td>
                                <td><span class="badge bg-label-success">Income</span></td>
                                <td><span class="badge bg-success">Credit</span></td>
                                <td class="text-success">+$1,250.00</td>
                            </tr>
                            <tr>
                                <td>Dec 11, 2024</td>
                                <td>Netflix Subscription</td>
                                <td><span class="badge bg-label-info">Entertainment</span></td>
                                <td><span class="badge bg-danger">Debit</span></td>
                                <td class="text-danger">-$19.99</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
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
                        <span>Transactions Today</span>
                        <strong>12</strong>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-primary" style="width: 60%"></div>
                    </div>
                </div>
                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Pending Payments</span>
                        <strong>3</strong>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-warning" style="width: 25%"></div>
                    </div>
                </div>
                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Overdue Bills</span>
                        <strong>1</strong>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-danger" style="width: 8%"></div>
                    </div>
                </div>
                <div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Savings Goal</span>
                        <strong>78%</strong>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-success" style="width: 78%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Categories -->
        <div class="card mb-6">
            <div class="card-header">
                <h5 class="card-title mb-0">Top Spending Categories</h5>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="d-flex align-items-center">
                        <div class="avatar bg-primary bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                            <i class="bx bx-home text-primary"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">Housing</h6>
                            <small class="text-muted">$1,200.00</small>
                        </div>
                    </div>
                    <span class="text-primary fw-bold">35%</span>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="d-flex align-items-center">
                        <div class="avatar bg-success bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                            <i class="bx bx-restaurant text-success"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">Food & Dining</h6>
                            <small class="text-muted">$845.50</small>
                        </div>
                    </div>
                    <span class="text-success fw-bold">25%</span>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="d-flex align-items-center">
                        <div class="avatar bg-warning bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                            <i class="bx bx-bolt text-warning"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">Utilities</h6>
                            <small class="text-muted">$425.75</small>
                        </div>
                    </div>
                    <span class="text-warning fw-bold">12%</span>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="d-flex align-items-center">
                        <div class="avatar bg-info bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                            <i class="bx bx-car text-info"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">Transportation</h6>
                            <small class="text-muted">$320.00</small>
                        </div>
                    </div>
                    <span class="text-info fw-bold">9%</span>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="avatar bg-secondary bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                            <i class="bx bx-shopping-bag text-secondary"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">Shopping</h6>
                            <small class="text-muted">$245.50</small>
                        </div>
                    </div>
                    <span class="text-secondary fw-bold">7%</span>
                </div>
            </div>
        </div>

        <!-- Upcoming Bills -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Upcoming Bills</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-warning mb-4">
                    <i class="bx bx-error me-2"></i>
                    <small>1 bill overdue - Total $145.50</small>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <h6 class="mb-0">Electricity Bill</h6>
                        <small class="text-muted">Due Dec 10</small>
                    </div>
                    <span class="badge bg-danger">Overdue</span>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <h6 class="mb-0">Monthly Rent</h6>
                        <small class="text-muted">Due Dec 20</small>
                    </div>
                    <span class="badge bg-warning">5 days</span>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-0">Car Insurance</h6>
                        <small class="text-muted">Due Jan 5</small>
                    </div>
                    <span class="badge bg-info">21 days</span>
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
    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'Income',
                data: [1200, 1900, 1500, 2500, 2200, 3000, 2800],
                borderColor: '#28a745',
                backgroundColor: 'rgba(40, 167, 69, 0.1)',
                tension: 0.4
            }, {
                label: 'Expenses',
                data: [800, 1200, 900, 1500, 1300, 1800, 1600],
                borderColor: '#dc3545',
                backgroundColor: 'rgba(220, 53, 69, 0.1)',
                tension: 0.4
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
                            return '$' + value;
                        }
                    }
                }
            }
        }
    });

    // Expense Chart
    const expenseCtx = document.getElementById('expenseChart').getContext('2d');
    const expenseChart = new Chart(expenseCtx, {
        type: 'doughnut',
        data: {
            labels: ['Housing', 'Food & Dining', 'Utilities', 'Transportation', 'Shopping', 'Other'],
            datasets: [{
                data: [1200, 845.50, 425.75, 320, 245.50, 198],
                backgroundColor: [
                    '#007bff',
                    '#28a745',
                    '#ffc107',
                    '#17a2b8',
                    '#6c757d',
                    '#e83e8c'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                }
            }
        }
    });
});

function changeChartPeriod(period) {
    // Update button states
    document.querySelectorAll('.btn-group .btn').forEach(btn => {
        btn.classList.remove('active');
    });
    event.target.classList.add('active');
    
    // In a real application, this would fetch new data based on the period
    console.log('Changing chart period to:', period);
    
    // For demo purposes, just show an alert
    alert('Chart period changed to: ' + period);
}
</script>
@endpush
