<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    /**
     * Display a listing of clients.
     */
    public function index()
    {
        $clients = Client::with(['creator', 'updater'])
            ->orderBy('name')
            ->paginate(20);
        
        return view('clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new client.
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created client in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email',
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'status' => 'required|in:active,inactive,suspended',
            'balance' => 'required|numeric|min:0',
            'credit_limit' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $client = Client::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'company' => $request->company,
            'address' => $request->address,
            'city' => $request->city,
            'country' => $request->country,
            'status' => $request->status,
            'balance' => $request->balance,
            'credit_limit' => $request->credit_limit,
            'notes' => $request->notes,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Client created successfully!',
            'client' => $client
        ]);
    }

    /**
     * Display the specified client.
     */
    public function show(Client $client)
    {
        $client->load(['creator', 'updater', 'transactions', 'loans']);
        return view('clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified client.
     */
    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    /**
     * Update the specified client in storage.
     */
    public function update(Request $request, Client $client)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email,' . $client->id,
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'status' => 'required|in:active,inactive,suspended',
            'balance' => 'required|numeric|min:0',
            'credit_limit' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $client->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'company' => $request->company,
            'address' => $request->address,
            'city' => $request->city,
            'country' => $request->country,
            'status' => $request->status,
            'balance' => $request->balance,
            'credit_limit' => $request->credit_limit,
            'notes' => $request->notes,
            'updated_by' => Auth::id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Client updated successfully!',
            'client' => $client->fresh()
        ]);
    }

    /**
     * Remove the specified client from storage.
     */
    public function destroy(Client $client)
    {
        // Check if client has transactions or loans
        if ($client->transactions()->count() > 0 || $client->loans()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete client with existing transactions or loans.'
            ], 422);
        }

        $client->delete();

        return response()->json([
            'success' => true,
            'message' => 'Client deleted successfully!'
        ]);
    }

    /**
     * Get clients for dropdown (API endpoint for client switching).
     */
    public function getClientsForDropdown()
    {
        $clients = Client::active()
            ->select('id', 'name', 'email', 'company', 'balance', 'credit_limit')
            ->orderBy('name')
            ->get();

        return response()->json([
            'success' => true,
            'clients' => $clients
        ]);
    }

    /**
     * Switch to a specific client (set session).
     */
    public function switchClient(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_id' => 'required|exists:clients,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $client = Client::find($request->client_id);

        // Store selected client in session
        session(['selected_client_id' => $client->id, 'selected_client_name' => $client->name]);

        return response()->json([
            'success' => true,
            'message' => "Switched to client: {$client->name}",
            'client' => $client
        ]);
    }

    /**
     * Get current selected client.
     */
    public function getCurrentClient()
    {
        $clientId = session('selected_client_id');
        
        if (!$clientId) {
            return response()->json([
                'success' => false,
                'message' => 'No client selected'
            ]);
        }

        $client = Client::find($clientId);

        if (!$client) {
            // Clear session if client doesn't exist
            session()->forget(['selected_client_id', 'selected_client_name']);
            
            return response()->json([
                'success' => false,
                'message' => 'Selected client not found'
            ]);
        }

        return response()->json([
            'success' => true,
            'client' => $client
        ]);
    }

    /**
     * Clear selected client session.
     */
    public function clearClient()
    {
        session()->forget(['selected_client_id', 'selected_client_name']);

        return response()->json([
            'success' => true,
            'message' => 'Client selection cleared'
        ]);
    }

    /**
     * Search clients (API endpoint for autocomplete).
     */
    public function searchClients(Request $request)
    {
        $query = $request->get('q', '');
        $limit = $request->get('limit', 10);

        $clients = Client::active()
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('email', 'like', "%{$query}%")
                  ->orWhere('company', 'like', "%{$query}%")
                  ->orWhere('phone', 'like', "%{$query}%");
            })
            ->select('id', 'name', 'email', 'company', 'balance', 'credit_limit')
            ->orderBy('name')
            ->limit($limit)
            ->get();

        return response()->json([
            'success' => true,
            'clients' => $clients
        ]);
    }

    public function clientPackages()
    {
        $packages = [
            [
                'id' => 1,
                'name' => 'Starter',
                'price' => 9.99,
                'disk_space' => '10 GB',
                'bandwidth' => '100 GB',
                'domains' => 1,
                'email_accounts' => 5,
                'databases' => 1,
                'features' => ['SSL Certificate', 'Daily Backups', 'Email Support'],
                'active_clients' => 45
            ],
            [
                'id' => 2,
                'name' => 'Professional',
                'price' => 19.99,
                'disk_space' => '50 GB',
                'bandwidth' => '500 GB',
                'domains' => 5,
                'email_accounts' => 25,
                'databases' => 5,
                'features' => ['SSL Certificate', 'Daily Backups', 'Priority Support', 'SSH Access'],
                'active_clients' => 78
            ],
            [
                'id' => 3,
                'name' => 'Business',
                'price' => 49.99,
                'disk_space' => '200 GB',
                'bandwidth' => '2 TB',
                'domains' => 20,
                'email_accounts' => 100,
                'databases' => 20,
                'features' => ['SSL Certificate', 'Daily Backups', 'Priority Support', 'SSH Access', 'Dedicated IP'],
                'active_clients' => 32
            ],
            [
                'id' => 4,
                'name' => 'Enterprise',
                'price' => 99.99,
                'disk_space' => '500 GB',
                'bandwidth' => '5 TB',
                'domains' => 50,
                'email_accounts' => 500,
                'databases' => 50,
                'features' => ['SSL Certificate', 'Daily Backups', 'Priority Support', 'SSH Access', 'Dedicated IP', 'Phone Support'],
                'active_clients' => 15
            ]
        ];

        return view('clients.packages', compact('packages'));
    }

    public function resourceLimits()
    {
        $clients = [
            [
                'id' => 1,
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'package' => 'Professional',
                'disk_used' => '15.2 GB',
                'disk_limit' => '50 GB',
                'bandwidth_used' => '125 GB',
                'bandwidth_limit' => '500 GB',
                'domains_used' => 3,
                'domains_limit' => 5,
                'email_used' => 12,
                'email_limit' => 25,
                'status' => 'active'
            ],
            [
                'id' => 2,
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'package' => 'Starter',
                'disk_used' => '8.5 GB',
                'disk_limit' => '10 GB',
                'bandwidth_used' => '85 GB',
                'bandwidth_limit' => '100 GB',
                'domains_used' => 1,
                'domains_limit' => 1,
                'email_used' => 4,
                'email_limit' => 5,
                'status' => 'warning'
            ],
            [
                'id' => 3,
                'name' => 'Bob Johnson',
                'email' => 'bob@example.com',
                'package' => 'Business',
                'disk_used' => '180 GB',
                'disk_limit' => '200 GB',
                'bandwidth_used' => '1.8 TB',
                'bandwidth_limit' => '2 TB',
                'domains_used' => 15,
                'domains_limit' => 20,
                'email_used' => 85,
                'email_limit' => 100,
                'status' => 'active'
            ]
        ];

        return view('clients.resource-limits', compact('clients'));
    }

    public function diskSpace()
    {
        $clients = [
            [
                'id' => 1,
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'disk_used' => 15.2,
                'disk_limit' => 50,
                'usage_percent' => 30.4,
                'status' => 'normal',
                'last_backup' => '2024-12-22 03:00:00',
                'large_files' => [
                    ['name' => 'backup_2024_12_20.sql', 'size' => '2.3 GB'],
                    ['name' => 'videos.zip', 'size' => '1.8 GB'],
                    ['name' => 'images.tar.gz', 'size' => '1.2 GB']
                ]
            ],
            [
                'id' => 2,
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'disk_used' => 8.5,
                'disk_limit' => 10,
                'usage_percent' => 85.0,
                'status' => 'warning',
                'last_backup' => '2024-12-22 03:00:00',
                'large_files' => [
                    ['name' => 'site_backup.zip', 'size' => '3.2 GB'],
                    ['name' => 'media_files.zip', 'size' => '2.1 GB']
                ]
            ],
            [
                'id' => 3,
                'name' => 'Bob Johnson',
                'email' => 'bob@example.com',
                'disk_used' => 180,
                'disk_limit' => 200,
                'usage_percent' => 90.0,
                'status' => 'critical',
                'last_backup' => '2024-12-21 03:00:00',
                'large_files' => [
                    ['name' => 'database_dumps.sql', 'size' => '15.3 GB'],
                    ['name' => 'log_files.tar.gz', 'size' => '8.7 GB'],
                    ['name' => 'user_uploads.zip', 'size' => '6.2 GB']
                ]
            ]
        ];

        return view('clients.disk-space', compact('clients'));
    }

    public function bandwidth()
    {
        $clients = [
            [
                'id' => 1,
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'bandwidth_used' => 125,
                'bandwidth_limit' => 500,
                'usage_percent' => 25.0,
                'status' => 'normal',
                'daily_usage' => [
                    ['date' => '2024-12-22', 'usage' => '2.1 GB'],
                    ['date' => '2024-12-21', 'usage' => '1.8 GB'],
                    ['date' => '2024-12-20', 'usage' => '2.3 GB'],
                    ['date' => '2024-12-19', 'usage' => '1.9 GB'],
                    ['date' => '2024-12-18', 'usage' => '2.2 GB']
                ]
            ],
            [
                'id' => 2,
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'bandwidth_used' => 85,
                'bandwidth_limit' => 100,
                'usage_percent' => 85.0,
                'status' => 'warning',
                'daily_usage' => [
                    ['date' => '2024-12-22', 'usage' => '1.8 GB'],
                    ['date' => '2024-12-21', 'usage' => '1.6 GB'],
                    ['date' => '2024-12-20', 'usage' => '1.9 GB'],
                    ['date' => '2024-12-19', 'usage' => '1.7 GB'],
                    ['date' => '2024-12-18', 'usage' => '1.8 GB']
                ]
            ],
            [
                'id' => 3,
                'name' => 'Bob Johnson',
                'email' => 'bob@example.com',
                'bandwidth_used' => 1800,
                'bandwidth_limit' => 2048,
                'usage_percent' => 87.9,
                'status' => 'warning',
                'daily_usage' => [
                    ['date' => '2024-12-22', 'usage' => '45 GB'],
                    ['date' => '2024-12-21', 'usage' => '42 GB'],
                    ['date' => '2024-12-20', 'usage' => '48 GB'],
                    ['date' => '2024-12-19', 'usage' => '38 GB'],
                    ['date' => '2024-12-18', 'usage' => '44 GB']
                ]
            ]
        ];

        return view('clients.bandwidth', compact('clients'));
    }

    public function domainsLimit()
    {
        $clients = [
            [
                'id' => 1,
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'domains_used' => 3,
                'domains_limit' => 5,
                'status' => 'normal',
                'domains' => [
                    ['name' => 'example.com', 'status' => 'active', 'created' => '2024-11-15'],
                    ['name' => 'mydomain.net', 'status' => 'active', 'created' => '2024-11-20'],
                    ['name' => 'test.org', 'status' => 'active', 'created' => '2024-11-25']
                ]
            ],
            [
                'id' => 2,
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'domains_used' => 1,
                'domains_limit' => 1,
                'status' => 'normal',
                'domains' => [
                    ['name' => 'jane-site.com', 'status' => 'active', 'created' => '2024-10-10']
                ]
            ],
            [
                'id' => 3,
                'name' => 'Bob Johnson',
                'email' => 'bob@example.com',
                'domains_used' => 18,
                'domains_limit' => 20,
                'status' => 'warning',
                'domains' => [
                    ['name' => 'business1.com', 'status' => 'active', 'created' => '2024-09-15'],
                    ['name' => 'business2.net', 'status' => 'active', 'created' => '2024-09-20'],
                    ['name' => 'business3.org', 'status' => 'suspended', 'created' => '2024-09-25'],
                    ['name' => 'business4.co', 'status' => 'active', 'created' => '2024-10-01']
                ]
            ]
        ];

        return view('clients.domains-limit', compact('clients'));
    }

    public function clientLoginAccess()
    {
        $clients = [
            [
                'id' => 1,
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'username' => 'johndoe',
                'status' => 'active',
                'last_login' => '2024-12-22 14:30:00',
                'login_attempts' => 0,
                'failed_attempts' => 0,
                'session_timeout' => 30,
                'ip_whitelist' => ['192.168.1.0/24', '10.0.0.0/24'],
                'permissions' => ['dashboard', 'domains', 'email', 'database'],
                'created' => '2024-11-15'
            ],
            [
                'id' => 2,
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'username' => 'janesmith',
                'status' => 'suspended',
                'last_login' => '2024-12-20 09:15:00',
                'login_attempts' => 3,
                'failed_attempts' => 5,
                'session_timeout' => 15,
                'ip_whitelist' => ['192.168.1.100'],
                'permissions' => ['dashboard', 'domains'],
                'created' => '2024-10-10'
            ],
            [
                'id' => 3,
                'name' => 'Bob Johnson',
                'email' => 'bob@example.com',
                'username' => 'bobjohnson',
                'status' => 'active',
                'last_login' => '2024-12-22 13:45:00',
                'login_attempts' => 0,
                'failed_attempts' => 0,
                'session_timeout' => 60,
                'ip_whitelist' => ['0.0.0.0/0'],
                'permissions' => ['dashboard', 'domains', 'email', 'database', 'filemanager'],
                'created' => '2024-09-15'
            ]
        ];

        $loginLogs = [
            [
                'client_name' => 'John Doe',
                'username' => 'johndoe',
                'ip' => '192.168.1.100',
                'time' => '2024-12-22 14:30:00',
                'status' => 'success'
            ],
            [
                'client_name' => 'Jane Smith',
                'username' => 'janesmith',
                'ip' => '192.168.1.101',
                'time' => '2024-12-22 14:25:00',
                'status' => 'failed'
            ],
            [
                'client_name' => 'Bob Johnson',
                'username' => 'bobjohnson',
                'ip' => '192.168.1.102',
                'time' => '2024-12-22 14:20:00',
                'status' => 'success'
            ],
            [
                'client_name' => 'Jane Smith',
                'username' => 'janesmith',
                'ip' => '192.168.1.103',
                'time' => '2024-12-22 14:15:00',
                'status' => 'failed'
            ]
        ];

        return view('clients.login-access', compact('clients', 'loginLogs'));
    }
}
