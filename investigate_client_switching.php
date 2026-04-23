<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Investigate Client Switching List ===\n\n";

// Test 1: Check database tables for client-related tables
echo "=== Test 1: Check Database Tables ===\n";
try {
    $tables = \Illuminate\Support\Facades\Schema::getTableListing();
    
    echo "Available tables:\n";
    foreach ($tables as $table) {
        if (strpos($table, 'client') !== false || strpos($table, 'member') !== false || strpos($table, 'customer') !== false) {
            echo "✅ Found relevant table: {$table}\n";
        }
    }
    
    // Check if there's a clients table
    if (\Illuminate\Support\Facades\Schema::hasTable('clients')) {
        echo "✅ Clients table exists\n";
        
        // Check table structure
        $columns = \Illuminate\Support\Facades\Schema::getColumnListing('clients');
        echo "Clients table columns: " . implode(', ', $columns) . "\n";
        
        // Check if there's any data
        $clientCount = \Illuminate\Support\Facades\DB::table('clients')->count();
        echo "Number of clients: {$clientCount}\n";
        
        if ($clientCount > 0) {
            $clients = \Illuminate\Support\Facades\DB::table('clients')->limit(5)->get();
            echo "Sample clients:\n";
            foreach ($clients as $client) {
                echo "- ID: {$client->id}, Name: " . ($client->name ?? 'N/A') . "\n";
            }
        }
    } else {
        echo "❌ No clients table found\n";
    }
    
    // Check if there's a members table
    if (\Illuminate\Support\Facades\Schema::hasTable('members')) {
        echo "✅ Members table exists\n";
        
        $columns = \Illuminate\Support\Facades\Schema::getColumnListing('members');
        echo "Members table columns: " . implode(', ', $columns) . "\n";
        
        $memberCount = \Illuminate\Support\Facades\DB::table('members')->count();
        echo "Number of members: {$memberCount}\n";
    } else {
        echo "❌ No members table found\n";
    }
    
} catch (\Exception $e) {
    echo "❌ Error checking database tables: " . $e->getMessage() . "\n";
}

// Test 2: Check for client-related models
echo "\n=== Test 2: Check for Client Models ===\n";
try {
    $modelPath = app_path('Models');
    $modelFiles = glob($modelPath . '/*.php');
    
    echo "Available models:\n";
    foreach ($modelFiles as $file) {
        $modelName = basename($file, '.php');
        if (strpos($modelName, 'Client') !== false || strpos($modelName, 'Member') !== false || strpos($modelName, 'Customer') !== false) {
            echo "✅ Found relevant model: {$modelName}\n";
        }
    }
    
} catch (\Exception $e) {
    echo "❌ Error checking models: " . $e->getMessage() . "\n";
}

// Test 3: Check routes for client switching
echo "\n=== Test 3: Check Routes for Client Switching ===\n";
try {
    $routes = \Illuminate\Support\Facades\Route::getRoutes();
    
    echo "Searching for client-related routes...\n";
    foreach ($routes as $route) {
        $uri = $route->uri();
        $name = $route->getName();
        
        if (strpos($uri, 'client') !== false || strpos($uri, 'member') !== false || strpos($uri, 'customer') !== false) {
            echo "✅ Found route: {$uri} (Name: {$name})\n";
        }
    }
    
} catch (\Exception $e) {
    echo "❌ Error checking routes: " . $e->getMessage() . "\n";
}

// Test 4: Check views for client switching functionality
echo "\n=== Test 4: Check Views for Client Switching ===\n";
try {
    $viewPath = resource_path('views');
    $viewFiles = [];
    
    // Recursive search for view files
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($viewPath));
    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'blade.php') {
            $viewFiles[] = $file->getPathname();
        }
    }
    
    echo "Searching for client switching in views...\n";
    foreach ($viewFiles as $file) {
        $content = file_get_contents($file);
        
        if (strpos($content, 'client') !== false && strpos($content, 'switch') !== false) {
            echo "✅ Found client switching in: " . str_replace($viewPath, '', $file) . "\n";
        }
        
        if (strpos($content, 'member') !== false && strpos($content, 'select') !== false) {
            echo "✅ Found member selection in: " . str_replace($viewPath, '', $file) . "\n";
        }
        
        if (strpos($content, 'dropdown') !== false && (strpos($content, 'client') !== false || strpos($content, 'member') !== false)) {
            echo "✅ Found client/member dropdown in: " . str_replace($viewPath, '', $file) . "\n";
        }
    }
    
} catch (\Exception $e) {
    echo "❌ Error checking views: " . $e->getMessage() . "\n";
}

// Test 5: Check if there's any JavaScript for client switching
echo "\n=== Test 5: Check JavaScript for Client Switching ===\n";
try {
    $jsPath = public_path('assets/js');
    $jsFiles = [];
    
    if (is_dir($jsPath)) {
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($jsPath));
        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'js') {
                $jsFiles[] = $file->getPathname();
            }
        }
    }
    
    echo "Searching for client switching in JavaScript files...\n";
    foreach ($jsFiles as $file) {
        $content = file_get_contents($file);
        
        if (strpos($content, 'client') !== false && strpos($content, 'switch') !== false) {
            echo "✅ Found client switching in: " . str_replace($jsPath, '', $file) . "\n";
        }
        
        if (strpos($content, 'member') !== false && strpos($content, 'select') !== false) {
            echo "✅ Found member selection in: " . str_replace($jsPath, '', $file) . "\n";
        }
    }
    
} catch (\Exception $e) {
    echo "❌ Error checking JavaScript files: " . $e->getMessage() . "\n";
}

// Test 6: Check if this might be a new feature request
echo "\n=== Test 6: Analysis and Recommendations ===\n";
try {
    echo "Based on the investigation:\n\n";
    
    // Check if we have users table with role-based switching
    if (\Illuminate\Support\Facades\Schema::hasTable('users')) {
        $userCount = \Illuminate\Support\Facades\DB::table('users')->count();
        echo "✅ Users table exists with {$userCount} users\n";
        
        // Check if users have roles that could be used for switching
        $roles = \Illuminate\Support\Facades\DB::table('users')->distinct()->pluck('role');
        echo "Available user roles: " . implode(', ', $roles->toArray()) . "\n";
    }
    
    echo "\nPossible interpretations of 'client switching list':\n";
    echo "1. Switching between different clients/members in a dropdown\n";
    echo "2. Switching between user accounts/roles\n";
    echo "3. Switching between different organizations/companies\n";
    echo "4. A new feature that needs to be implemented\n\n";
    
    echo "Recommendations:\n";
    echo "1. If this is for member switching, implement a member selection dropdown\n";
    echo "2. If this is for client management, create a clients table and management system\n";
    echo "3. If this is for user switching, implement a role-based switching mechanism\n";
    echo "4. If this is a new feature, create the necessary database tables and UI components\n\n";
    
} catch (\Exception $e) {
    echo "❌ Error in analysis: " . $e->getMessage() . "\n";
}

echo "=== Investigation Complete ===\n";
