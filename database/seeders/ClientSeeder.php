<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\Client;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing clients
        DB::table('clients')->delete();
        DB::table('client_management')->delete();

        $clients = [
            [
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
                'phone' => '+1-555-123-4567',
                'company' => 'Doe Enterprises',
                'address' => '123 Main Street, Apt 4B',
                'city' => 'New York',
                'country' => 'United States',
                'status' => 'active',
                'balance' => 1250.50,
                'credit_limit' => 5000.00,
                'notes' => 'Premium client with full hosting package',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now()->subMonths(3),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane.smith@example.com',
                'phone' => '+1-555-987-6543',
                'company' => 'Smith Consulting',
                'address' => '456 Business Ave, Suite 100',
                'city' => 'Los Angeles',
                'country' => 'United States',
                'status' => 'active',
                'balance' => -250.00,
                'credit_limit' => 2000.00,
                'notes' => 'Small business client with starter package',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now()->subMonths(6),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Bob Johnson',
                'email' => 'bob.johnson@example.com',
                'phone' => '+1-555-456-7890',
                'company' => 'Johnson Tech Solutions',
                'address' => '789 Tech Park, Building 5',
                'city' => 'San Francisco',
                'country' => 'United States',
                'status' => 'suspended',
                'balance' => 5000.00,
                'credit_limit' => 10000.00,
                'notes' => 'Enterprise client with overdue payment',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now()->subYear(1)->subMonth(3)->day(15),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Alice Williams',
                'email' => 'alice.williams@example.com',
                'phone' => '+1-555-234-5678',
                'company' => 'Williams Design Studio',
                'address' => '321 Creative Lane',
                'city' => 'Austin',
                'country' => 'United States',
                'status' => 'active',
                'balance' => 0.00,
                'credit_limit' => 1500.00,
                'notes' => 'Freelance designer with basic package',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now()->subMonths(2),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Charlie Brown',
                'email' => 'charlie.brown@example.com',
                'phone' => '+1-555-345-6789',
                'company' => 'Brown Marketing',
                'address' => '567 Market Street',
                'city' => 'Chicago',
                'country' => 'United States',
                'status' => 'active',
                'balance' => 750.00,
                'credit_limit' => 3000.00,
                'notes' => 'Marketing agency with professional package',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now()->subMonths(4),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Diana Martinez',
                'email' => 'diana.martinez@example.com',
                'phone' => '+1-555-890-1234',
                'company' => 'Martinez E-commerce',
                'address' => '890 Commerce Blvd',
                'city' => 'Miami',
                'country' => 'United States',
                'status' => 'active',
                'balance' => 2500.00,
                'credit_limit' => 8000.00,
                'notes' => 'E-commerce store with enterprise package',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now()->subMonths(5),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Edward Davis',
                'email' => 'edward.davis@example.com',
                'phone' => '+1-555-567-8901',
                'company' => 'Davis Development',
                'address' => '123 Dev Street',
                'city' => 'Seattle',
                'country' => 'United States',
                'status' => 'active',
                'balance' => 0.00,
                'credit_limit' => 2500.00,
                'notes' => 'Development contractor with custom package',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now()->subMonths(1),
                'updated_at' => Carbon::now()
            ]
        ];

        // Insert clients into database
        foreach ($clients as $client) {
            Client::create($client);
        }

        $this->command->info('Client table seeded successfully!');
    }
}
