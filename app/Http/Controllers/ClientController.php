<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class ClientController extends Controller
{
    /**
     * Display a listing of clients.
     */
    public function index()
    {
        $clients = Client::orderBy('name')->paginate(20);
        
        return view('clients.index', compact('clients'));
    }

    /**
     * Show form for creating a new client.
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
            'created_by' => 'nullable|exists:users,id',
            'updated_by' => 'nullable|exists:users,id',
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
    public function show($id)
    {
        $client = Client::findOrFail($id);
        return view('clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified client.
     */
    public function edit($id)
    {
        $client = Client::findOrFail($id);
        return view('clients.edit', compact('client'));
    }

    /**
     * Update the specified client in storage.
     */
    public function update(Request $request, $id)
    {
        $client = Client::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'status' => 'required|in:active,inactive,suspended',
            'balance' => 'required|numeric|min:0',
            'credit_limit' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
            'updated_by' => 'nullable|exists:users,id',
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
    public function destroy($id)
    {
        $client = Client::findOrFail($id);
        
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
        $clients = Client::where('status', 'active')
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

        $client = Client::findOrFail($request->client_id);
        
        // Store client in session
        session(['current_client_id' => $request->client_id]);

        return response()->json([
            'success' => true,
            'message' => 'Switched to client: ' . $client->name,
            'client' => $client
        ]);
    }

    /**
     * Get current client from session.
     */
    public function getCurrentClient()
    {
        $clientId = session('current_client_id');
        
        if (!$clientId) {
            return response()->json([
                'success' => false,
                'message' => 'No client selected'
            ]);
        }

        $client = Client::findOrFail($clientId);

        return response()->json([
            'success' => true,
            'client' => $client
        ]);
    }

    /**
     * Clear client selection from session.
     */
    public function clearClient()
    {
        session()->forget('current_client_id');

        return response()->json([
            'success' => true,
            'message' => 'Client selection cleared'
        ]);
    }

    /**
     * Search clients (API endpoint).
     */
    public function searchClients(Request $request)
    {
        $search = $request->get('q', '');
        
        if (empty($search)) {
            return response()->json([
                'success' => false,
                'message' => 'Search term is required'
            ]);
        }

        $clients = Client::where('name', 'like', '%' . $search . '%')
            ->orWhere('email', 'like', '%' . $search . '%')
            ->orWhere('company', 'like', '%' . $search . '%')
            ->orderBy('name')
            ->limit(10)
            ->get(['id', 'name', 'email', 'company']);

        return response()->json([
            'success' => true,
            'clients' => $clients
        ]);
    }

    /**
     * Display client packages page.
     */
    public function clientPackages()
    {
        $clients = Client::orderBy('name')->get();
        $packages = [
            [
                'id' => 1,
                'name' => 'Starter',
                'price' => 9.99,
                'features' => ['1 Website', '5 GB Storage', '100 GB Bandwidth', '1 Database', 'Email Support'],
                'clients_count' => $clients->where('credit_limit', '<=', 2000)->count(),
                'active_clients' => $clients->where('credit_limit', '<=', 2000)->where('status', 'active')->count(),
                'disk_space' => '5 GB',
                'bandwidth' => '100 GB',
                'domains' => '1',
                'email_accounts' => '5'
            ],
            [
                'id' => 2,
                'name' => 'Professional',
                'price' => 29.99,
                'features' => ['5 Websites', '25 GB Storage', '500 GB Bandwidth', '5 Databases', 'Priority Support'],
                'clients_count' => $clients->where('credit_limit', '>', 2000)->where('credit_limit', '<=', 8000)->count(),
                'active_clients' => $clients->where('credit_limit', '>', 2000)->where('credit_limit', '<=', 8000)->where('status', 'active')->count(),
                'disk_space' => '25 GB',
                'bandwidth' => '500 GB',
                'domains' => '5',
                'email_accounts' => '25'
            ],
            [
                'id' => 3,
                'name' => 'Enterprise',
                'price' => 99.99,
                'features' => ['Unlimited Websites', '100 GB Storage', '2 TB Bandwidth', 'Unlimited Databases', '24/7 Phone Support'],
                'clients_count' => $clients->where('credit_limit', '>', 8000)->count(),
                'active_clients' => $clients->where('credit_limit', '>', 8000)->where('status', 'active')->count(),
                'disk_space' => '100 GB',
                'bandwidth' => '2 TB',
                'domains' => 'Unlimited',
                'email_accounts' => 'Unlimited'
            ]
        ];

        return view('clients.packages', compact('clients', 'packages'));
    }

    /**
     * Display client resource limits page.
     */
    public function resourceLimits()
    {
        $clients = Client::orderBy('name')->get();
        
        $resourceLimits = [
            'cpu' => ['limit' => '2 Cores', 'usage' => '45%'],
            'memory' => ['limit' => '4 GB', 'usage' => '62%'],
            'storage' => ['limit' => '50 GB', 'usage' => '78%'],
            'bandwidth' => ['limit' => '1 TB', 'usage' => '23%'],
            'email_accounts' => ['limit' => '100', 'usage' => '34'],
            'databases' => ['limit' => '10', 'usage' => '6']
        ];

        // Add client-specific resource data to avoid division by zero
        $clientsWithResources = $clients->map(function ($client) {
            $diskUsed = rand(1, 50) . '.' . rand(0, 9);
            $diskLimit = rand(50, 100) . '.' . rand(0, 9);
            $bandwidthUsed = rand(10, 200) . '.' . rand(0, 9);
            $bandwidthLimit = rand(100, 500) . '.' . rand(0, 9);
            
            $domainsUsed = rand(1, 10);
            $domainsLimit = rand(5, 50);
            // Ensure domains_limit is never zero to prevent division by zero
            $domainsLimit = max($domainsLimit, 1);
            
            $emailUsed = rand(1, 25);
            $emailLimit = rand(10, 100);
            // Ensure email_limit is never zero to prevent division by zero
            $emailLimit = max($emailLimit, 1);
            
            return [
                'id' => $client->id,
                'name' => $client->name,
                'email' => $client->email,
                'status' => $client->status,
                'package' => $client->credit_limit <= 2000 ? 'Starter' : ($client->credit_limit <= 8000 ? 'Professional' : 'Enterprise'),
                'disk_used' => $diskUsed . ' GB',
                'disk_limit' => $diskLimit . ' GB',
                'bandwidth_used' => $bandwidthUsed . ' GB',
                'bandwidth_limit' => $bandwidthLimit . ' GB',
                'domains_used' => $domainsUsed,
                'domains_limit' => $domainsLimit,
                'email_used' => $emailUsed,
                'email_limit' => $emailLimit,
                'cpu_usage' => rand(10, 80) . '%',
                'memory_usage' => rand(20, 90) . '%',
                'email_accounts' => rand(5, 50),
                'databases' => rand(1, 10)
            ];
        });

        return view('clients.resource-limits', [
            'clients' => $clientsWithResources,
            'resourceLimits' => $resourceLimits
        ]);
    }

    /**
     * Display client disk space page.
     */
    public function diskSpace()
    {
        $clients = Client::orderBy('name')->get();
        
        $diskUsage = [
            'total_space' => '500 GB',
            'used_space' => '125.3 GB',
            'free_space' => '374.7 GB',
            'usage_percentage' => 25,
            'clients' => $clients->map(function ($client) {
                // Generate large files array
                $largeFiles = [];
                for ($i = 0; $i < rand(3, 8); $i++) {
                    $largeFiles[] = [
                        'name' => 'file_' . $i . '.' . ['pdf', 'jpg', 'mp4', 'zip'][rand(0, 3)],
                        'size' => rand(10, 500) . ' MB'
                    ];
                }
                
                $diskUsed = rand(1, 50) . '.' . rand(0, 9);
                $diskLimit = rand(50, 100) . '.' . rand(0, 9);
                $usagePercent = ($diskUsed / $diskLimit) * 100;
                
                return [
                    'id' => $client->id,
                    'name' => $client->name,
                    'email' => $client->email,
                    'status' => $client->status,
                    'disk_used' => $diskUsed,
                    'disk_limit' => $diskLimit,
                    'usage_percent' => $usagePercent,
                    'used_space' => $diskUsed . ' GB',
                    'files_count' => rand(100, 5000),
                    'last_backup' => now()->subDays(rand(1, 30))->format('Y-m-d H:i:s'),
                    'large_files' => $largeFiles
                ];
            })
        ];

        return view('clients.disk-space', [
            'clients' => $diskUsage['clients'],
            'diskUsage' => $diskUsage
        ]);
    }

    /**
     * Display client bandwidth page.
     */
    public function bandwidth()
    {
        $clients = Client::orderBy('name')->get();
        
        $bandwidthData = [
            'monthly_limit' => '1 TB',
            'current_usage' => '234.5 GB',
            'remaining' => '765.5 GB',
            'usage_percentage' => 23,
            'daily_average' => '7.8 GB',
            'clients' => $clients->map(function ($client) {
                $bandwidthUsed = rand(10, 200) . '.' . rand(0, 9);
                $bandwidthLimit = rand(100, 500);
                $usagePercent = ($bandwidthUsed / $bandwidthLimit) * 100;
                
                // Generate daily usage data for the last 7 days
                $dailyUsage = [];
                for ($i = 6; $i >= 0; $i--) {
                    $dailyUsage[] = [
                        'date' => now()->subDays($i)->format('Y-m-d'),
                        'usage' => rand(1, 20) . '.' . rand(0, 9) . ' GB'
                    ];
                }
                
                return [
                    'id' => $client->id,
                    'name' => $client->name,
                    'email' => $client->email,
                    'status' => $client->status,
                    'bandwidth_used' => $bandwidthUsed,
                    'bandwidth_limit' => $bandwidthLimit,
                    'usage_percent' => $usagePercent,
                    'peak_day' => now()->subDays(rand(1, 7))->format('Y-m-d'),
                    'daily_usage' => $dailyUsage
                ];
            })
        ];

        return view('clients.bandwidth', [
            'clients' => $bandwidthData['clients'],
            'bandwidthData' => $bandwidthData
        ]);
    }

    /**
     * Display client domains limit page.
     */
    public function domainsLimit()
    {
        $clients = Client::orderBy('name')->get();
        
        $domainsData = [
            'total_domains' => $clients->count() * 3, // Average 3 domains per client
            'active_domains' => $clients->count() * 2,
            'parked_domains' => $clients->count(),
            'subdomains' => $clients->count() * 5,
            'clients' => $clients->map(function ($client) {
                $domainsUsed = rand(1, 10);
                $domainsLimit = rand(5, 50);
                // Ensure domains_limit is never zero to prevent division by zero
                $domainsLimit = max($domainsLimit, 1);
                
                // Generate domains array with status
                $domains = [];
                for ($i = 0; $i < $domainsUsed; $i++) {
                    $status = rand(0, 1) ? 'active' : (rand(0, 1) ? 'suspended' : 'pending');
                    $domains[] = [
                        'id' => $i + 1,
                        'domain' => strtolower(str_replace(' ', '', $client->name)) . ($i > 0 ? $i + 1 : '') . '.com',
                        'status' => $status,
                        'created_at' => now()->subDays(rand(1, 365))->format('Y-m-d'),
                        'expires_at' => now()->addDays(rand(30, 365))->format('Y-m-d')
                    ];
                }
                
                return [
                    'id' => $client->id,
                    'name' => $client->name,
                    'email' => $client->email,
                    'status' => $client->status,
                    'domains_used' => $domainsUsed,
                    'domains_limit' => $domainsLimit,
                    'usage_percentage' => ($domainsUsed / $domainsLimit) * 100,
                    'primary_domain' => strtolower(str_replace(' ', '', $client->name)) . '.com',
                    'domains' => $domains
                ];
            })
        ];

        return view('clients.domains-limit', [
            'clients' => $domainsData['clients'],
            'domainsData' => $domainsData
        ]);
    }

    /**
     * Display client login access page.
     */
    public function clientLoginAccess()
    {
        $clients = Client::orderBy('name')->get();
        
        // Generate login logs
        $loginLogs = [];
        for ($i = 0; $i < 20; $i++) {
            $randomClient = $clients->random();
            $loginLogs[] = [
                'client_name' => $randomClient->name,
                'username' => strtolower(str_replace(' ', '', $randomClient->name)) . '_' . $randomClient->id,
                'ip' => rand(1, 255) . '.' . rand(1, 255) . '.' . rand(1, 255) . '.' . rand(1, 255),
                'time' => now()->subMinutes(rand(1, 1440))->format('Y-m-d H:i:s'),
                'status' => rand(0, 1) ? 'success' : 'failed',
                'details' => rand(0, 1) ? 'Login successful' : 'Invalid password'
            ];
        }

        $loginData = [
            'total_logins_24h' => rand(100, 500),
            'failed_logins_24h' => rand(5, 25),
            'active_sessions' => rand(20, 100),
            'clients' => $clients->map(function ($client) {
                // Generate IP whitelist array
                $ipWhitelist = [];
                for ($i = 0; $i < rand(2, 5); $i++) {
                    $ipWhitelist[] = rand(1, 255) . '.' . rand(1, 255) . '.' . rand(1, 255) . '.' . rand(1, 255);
                }
                
                return [
                    'id' => $client->id,
                    'name' => $client->name,
                    'email' => $client->email,
                    'username' => strtolower(str_replace(' ', '', $client->name)) . '_' . $client->id,
                    'status' => $client->status,
                    'last_login' => now()->subMinutes(rand(1, 1440))->format('Y-m-d H:i:s'),
                    'login_count_24h' => rand(0, 20),
                    'failed_attempts' => rand(0, 5),
                    'ip_address' => rand(1, 255) . '.' . rand(1, 255) . '.' . rand(1, 255) . '.' . rand(1, 255),
                    'session_status' => rand(0, 1) ? 'Active' : 'Inactive',
                    'session_timeout' => rand(15, 120),
                    'ip_whitelist' => $ipWhitelist,
                    'permissions' => ['read', 'write', 'delete', 'manage_users', 'view_reports']
                ];
            })
        ];

        return view('clients.login-access', [
            'clients' => $loginData['clients'],
            'loginData' => $loginData,
            'loginLogs' => $loginLogs
        ]);
    }
}
