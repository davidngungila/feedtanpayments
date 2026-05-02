<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class ClientControllerNew extends Controller
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
}
