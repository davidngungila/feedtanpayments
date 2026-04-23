@extends('layouts.app')

@section('title', 'Website Analytics')
@section('description', 'View website analytics and performance metrics')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">Website Analytics</h5>
                    <p class="card-subtitle">View website analytics and performance metrics</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-success" onclick="refreshAnalytics()">
                        <i class="bx bx-refresh me-1"></i> Refresh
                    </button>
                    <button class="btn btn-outline-primary" onclick="exportAnalytics()">
                        <i class="bx bx-download me-1"></i> Export
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- Analytics Overview -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-primary bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-user text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Visitors Today</h6>
                                <h4 class="mb-0">45</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-success bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-file text-success"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Pageviews Today</h6>
                                <h4 class="mb-0 text-success">234</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-warning bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-exit text-warning"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Bounce Rate</h6>
                                <h4 class="mb-0 text-warning">32.5%</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-info bg-opacity-10 rounded-circle me-3" style="width: 40px; height: 40px;">
                                <i class="bx bx-time text-info"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Avg Session</h6>
                                <h4 class="mb-0 text-info">2:45</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Traffic Charts -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Visitor Traffic</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="visitorChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Pageview Trends</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="pageviewChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Top Pages -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Top Pages</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Page</th>
                                                <th>Views</th>
                                                <th>%</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><code>/</code></td>
                                                <td>89</td>
                                                <td>38.0%</td>
                                            </tr>
                                            <tr>
                                                <td><code>/about</code></td>
                                                <td>45</td>
                                                <td>19.2%</td>
                                            </tr>
                                            <tr>
                                                <td><code>/services</code></td>
                                                <td>38</td>
                                                <td>16.2%</td>
                                            </tr>
                                            <tr>
                                                <td><code>/contact</code></td>
                                                <td>28</td>
                                                <td>12.0%</td>
                                            </tr>
                                            <tr>
                                                <td><code>/blog</code></td>
                                                <td>23</td>
                                                <td>9.8%</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Traffic Sources</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="sourceChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Geographic Distribution -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Geographic Distribution</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <canvas id="geoChart" height="300"></canvas>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="table-responsive">
                                            <table class="table table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Country</th>
                                                        <th>Visitors</th>
                                                        <th>%</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>🇺🇸 United States</td>
                                                        <td>23</td>
                                                        <td>51.1%</td>
                                                    </tr>
                                                    <tr>
                                                        <td>🇬🇧 United Kingdom</td>
                                                        <td>8</td>
                                                        <td>17.8%</td>
                                                    </tr>
                                                    <tr>
                                                        <td>🇨🇦 Canada</td>
                                                        <td>6</td>
                                                        <td>13.3%</td>
                                                    </tr>
                                                    <tr>
                                                        <td>🇦🇺 Australia</td>
                                                        <td>5</td>
                                                        <td>11.1%</td>
                                                    </tr>
                                                    <tr>
                                                        <td>🇩🇪 Germany</td>
                                                        <td>3</td>
                                                        <td>6.7%</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Device Statistics -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Device Statistics</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="deviceChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Browser Statistics</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="browserChart" height="200"></canvas>
                            </div>
                        </div>
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
// Visitor Traffic Chart
const visitorCtx = document.getElementById('visitorChart').getContext('2d');
new Chart(visitorCtx, {
    type: 'line',
    data: {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        datasets: [{
            label: 'Visitors',
            data: [32, 45, 38, 52, 48, 42, 45],
            borderColor: '#28a745',
            backgroundColor: 'rgba(40, 167, 69, 0.1)',
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        }
    }
});

// Pageview Trends Chart
const pageviewCtx = document.getElementById('pageviewChart').getContext('2d');
new Chart(pageviewCtx, {
    type: 'line',
    data: {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        datasets: [{
            label: 'Pageviews',
            data: [189, 234, 198, 267, 245, 212, 234],
            borderColor: '#007bff',
            backgroundColor: 'rgba(0, 123, 255, 0.1)',
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        }
    }
});

// Traffic Sources Chart
const sourceCtx = document.getElementById('sourceChart').getContext('2d');
new Chart(sourceCtx, {
    type: 'doughnut',
    data: {
        labels: ['Direct', 'Search', 'Social', 'Referral'],
        datasets: [{
            data: [35, 40, 15, 10],
            backgroundColor: ['#28a745', '#007bff', '#ffc107', '#dc3545']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

// Geographic Distribution Chart
const geoCtx = document.getElementById('geoChart').getContext('2d');
new Chart(geoCtx, {
    type: 'bar',
    data: {
        labels: ['US', 'UK', 'CA', 'AU', 'DE'],
        datasets: [{
            label: 'Visitors',
            data: [23, 8, 6, 5, 3],
            backgroundColor: '#28a745'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        }
    }
});

// Device Statistics Chart
const deviceCtx = document.getElementById('deviceChart').getContext('2d');
new Chart(deviceCtx, {
    type: 'doughnut',
    data: {
        labels: ['Desktop', 'Mobile', 'Tablet'],
        datasets: [{
            data: [55, 35, 10],
            backgroundColor: ['#007bff', '#28a745', '#ffc107']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

// Browser Statistics Chart
const browserCtx = document.getElementById('browserChart').getContext('2d');
new Chart(browserCtx, {
    type: 'doughnut',
    data: {
        labels: ['Chrome', 'Firefox', 'Safari', 'Edge'],
        datasets: [{
            data: [45, 25, 20, 10],
            backgroundColor: ['#dc3545', '#ffc107', '#28a745', '#007bff']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

function refreshAnalytics() {
    showNotification('Analytics data refreshed', 'success');
}

function exportAnalytics() {
    showNotification('Analytics export initiated', 'info');
}

function showNotification(message, type) {
    const alert = document.createElement('div');
    alert.className = `alert alert-${type} alert-dismissible fade show position-fixed top-0 end-0 m-3`;
    alert.style.zIndex = '9999';
    alert.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    document.body.appendChild(alert);
    
    setTimeout(() => {
        alert.remove();
    }, 3000);
}
</script>
@endpush
