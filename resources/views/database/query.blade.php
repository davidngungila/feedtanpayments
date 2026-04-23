@extends('layouts.app')

@section('title', 'Database Query')
@section('description', 'Execute SQL queries on database')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">Database Query</h5>
                    <p class="card-subtitle">Execute SQL queries on {{ $database['name'] }}</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-success" onclick="saveQuery()">
                        <i class="bx bx-save me-1"></i> Save Query
                    </button>
                    <button class="btn btn-outline-primary" onclick="exportResults()">
                        <i class="bx bx-download me-1"></i> Export Results
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- Query Editor -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">SQL Query Editor</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="sqlQuery" class="form-label">SQL Query</label>
                                    <textarea class="form-control" id="sqlQuery" rows="8" placeholder="Enter your SQL query here...">SELECT * FROM users WHERE status = 'active' LIMIT 10;</textarea>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-outline-secondary btn-sm" onclick="formatQuery()">
                                            <i class="bx bx-code me-1"></i> Format
                                        </button>
                                        <button class="btn btn-outline-secondary btn-sm" onclick="clearQuery()">
                                            <i class="bx bx-reset me-1"></i> Clear
                                        </button>
                                        <button class="btn btn-outline-secondary btn-sm" onclick="loadTemplate()">
                                            <i class="bx bx-file me-1"></i> Load Template
                                        </button>
                                    </div>
                                    <div>
                                        <button class="btn btn-primary" onclick="executeQuery()">
                                            <i class="bx bx-play me-1"></i> Execute Query
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Query Results -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Query Results</h6>
                                <div class="d-flex gap-2">
                                    <span class="badge bg-info">10 rows returned</span>
                                    <span class="badge bg-success">0.023s</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm table-striped">
                                        <thead>
                                            <tr>
                                                <th>id</th>
                                                <th>name</th>
                                                <th>email</th>
                                                <th>status</th>
                                                <th>created_at</th>
                                                <th>updated_at</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>John Doe</td>
                                                <td>john@example.com</td>
                                                <td><span class="badge bg-success">active</span></td>
                                                <td>2024-11-15 10:30:00</td>
                                                <td>2024-12-22 14:30:00</td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>Jane Smith</td>
                                                <td>jane@example.com</td>
                                                <td><span class="badge bg-success">active</span></td>
                                                <td>2024-11-20 14:15:00</td>
                                                <td>2024-12-21 09:45:00</td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>Bob Johnson</td>
                                                <td>bob@example.com</td>
                                                <td><span class="badge bg-success">active</span></td>
                                                <td>2024-11-25 16:20:00</td>
                                                <td>2024-12-20 11:30:00</td>
                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td>Alice Brown</td>
                                                <td>alice@example.com</td>
                                                <td><span class="badge bg-success">active</span></td>
                                                <td>2024-11-30 09:10:00</td>
                                                <td>2024-12-19 15:20:00</td>
                                            </tr>
                                            <tr>
                                                <td>5</td>
                                                <td>Charlie Wilson</td>
                                                <td>charlie@example.com</td>
                                                <td><span class="badge bg-success">active</span></td>
                                                <td>2024-12-05 13:45:00</td>
                                                <td>2024-12-18 08:15:00</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Database Information -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Database Info</h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm">
                                    <tbody>
                                        <tr>
                                            <td><strong>Name:</strong></td>
                                            <td>{{ $database['name'] }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Type:</strong></td>
                                            <td>{{ $database['type'] }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Version:</strong></td>
                                            <td>{{ $database['version'] }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Server:</strong></td>
                                            <td>{{ $database['server'] }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Available Tables</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Table Name</th>
                                                <th>Rows</th>
                                                <th>Size</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($tables as $table)
                                            <tr>
                                                <td><code>{{ $table['name'] }}</code></td>
                                                <td>{{ number_format($table['rows']) }}</td>
                                                <td>{{ $table['size'] }}</td>
                                                <td>
                                                    <button class="btn btn-outline-primary btn-sm" onclick="describeTable('{{ $table['name'] }}')">
                                                        <i class="bx bx-info-circle"></i> Describe
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Query History -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Recent Queries</h6>
                                <button class="btn btn-outline-info btn-sm" onclick="clearHistory()">
                                    <i class="bx bx-trash me-1"></i> Clear History
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Query</th>
                                                <th>Time</th>
                                                <th>Duration</th>
                                                <th>Rows</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($recentQueries as $query)
                                            <tr>
                                                <td class="text-truncate" style="max-width: 300px;">
                                                    <code>{{ $query['query'] }}</code>
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($query['time'])->format('H:i:s') }}</td>
                                                <td>{{ $query['duration'] }}</td>
                                                <td>{{ $query['rows'] }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $query['status'] == 'success' ? 'success' : 'danger' }}">
                                                        {{ $query['status'] }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <button class="btn btn-outline-primary btn-sm" onclick="rerunQuery('{{ $query['query'] }}')">
                                                        <i class="bx bx-refresh"></i> Rerun
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
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
<script>
function executeQuery() {
    const query = document.getElementById('sqlQuery').value;
    
    if (!query.trim()) {
        showNotification('Please enter a SQL query', 'warning');
        return;
    }
    
    showNotification('Executing query...', 'info');
    
    // Simulate query execution
    setTimeout(() => {
        showNotification('Query executed successfully', 'success');
    }, 1000);
}

function formatQuery() {
    const query = document.getElementById('sqlQuery').value;
    // Simple SQL formatting (in real implementation, use a proper SQL formatter)
    const formatted = query
        .replace(/\s+/g, ' ')
        .replace(/SELECT/gi, '\nSELECT')
        .replace(/FROM/gi, '\nFROM')
        .replace(/WHERE/gi, '\nWHERE')
        .replace(/ORDER BY/gi, '\nORDER BY')
        .replace(/GROUP BY/gi, '\nGROUP BY')
        .replace(/LIMIT/gi, '\nLIMIT')
        .trim();
    
    document.getElementById('sqlQuery').value = formatted;
    showNotification('Query formatted', 'info');
}

function clearQuery() {
    document.getElementById('sqlQuery').value = '';
    showNotification('Query cleared', 'info');
}

function loadTemplate() {
    showNotification('Loading query template...', 'info');
}

function saveQuery() {
    const query = document.getElementById('sqlQuery').value;
    
    if (!query.trim()) {
        showNotification('Please enter a query to save', 'warning');
        return;
    }
    
    showNotification('Query saved successfully', 'success');
}

function exportResults() {
    showNotification('Exporting query results...', 'info');
}

function describeTable(tableName) {
    const query = `DESCRIBE ${tableName};`;
    document.getElementById('sqlQuery').value = query;
    showNotification(`Table structure for ${tableName} loaded`, 'info');
}

function rerunQuery(query) {
    document.getElementById('sqlQuery').value = query;
    executeQuery();
}

function clearHistory() {
    if (confirm('Are you sure you want to clear query history?')) {
        showNotification('Query history cleared', 'warning');
    }
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
