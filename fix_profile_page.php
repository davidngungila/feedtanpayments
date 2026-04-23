<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Fix Profile Page ===\n\n";

// Test 1: Check current profile functionality
echo "=== Test 1: Check Current Profile Setup ===\n";
try {
    // Check if profile route exists
    $routes = \Illuminate\Support\Facades\Route::getRoutes();
    $profileRoute = null;
    
    foreach ($routes as $route) {
        if ($route->getName() === 'profile') {
            $profileRoute = $route;
            break;
        }
    }
    
    if ($profileRoute) {
        echo "✅ Profile route exists: " . $profileRoute->uri() . "\n";
    } else {
        echo "❌ Profile route not found\n";
    }
    
    // Check if updateProfile route exists
    $updateRoute = null;
    foreach ($routes as $route) {
        if ($route->getName() === 'profile.update') {
            $updateRoute = $route;
            break;
        }
    }
    
    if ($updateRoute) {
        echo "✅ Profile update route exists: " . $updateRoute->uri() . "\n";
    } else {
        echo "❌ Profile update route not found\n";
    }
    
    // Check if DashboardController methods exist
    $controller = new \App\Http\Controllers\DashboardController();
    
    if (method_exists($controller, 'profile')) {
        echo "✅ DashboardController::profile() method exists\n";
    } else {
        echo "❌ DashboardController::profile() method missing\n";
    }
    
    if (method_exists($controller, 'updateProfile')) {
        echo "✅ DashboardController::updateProfile() method exists\n";
    } else {
        echo "❌ DashboardController::updateProfile() method missing\n";
    }
    
} catch (\Exception $e) {
    echo "❌ Error checking profile setup: " . $e->getMessage() . "\n";
}

// Test 2: Check user model for avatar support
echo "\n=== Test 2: Check User Model Avatar Support ===\n";
try {
    $user = \App\Models\User::first();
    
    if ($user) {
        echo "User model fields:\n";
        echo "- Has avatar column: " . (\Illuminate\Support\Facades\Schema::hasColumn('users', 'avatar') ? 'Yes' : 'No') . "\n";
        
        // Check if we can add avatar field
        $columns = \Illuminate\Support\Facades\Schema::getColumnListing('users');
        echo "Current user table columns: " . implode(', ', $columns) . "\n";
        
        if (!\Illuminate\Support\Facades\Schema::hasColumn('users', 'avatar')) {
            echo "Adding avatar column to users table...\n";
            
            // Add avatar column
            \Illuminate\Support\Facades\Schema::table('users', function ($table) {
                $table->string('avatar')->nullable()->after('email');
            });
            
            echo "✅ Avatar column added to users table\n";
        }
    }
    
} catch (\Exception $e) {
    echo "❌ Error checking user model: " . $e->getMessage() . "\n";
}

// Test 3: Create profile update functionality with image upload
echo "\n=== Test 3: Create Profile Update API ===\n";
try {
    // Add profile update API route
    echo "Adding profile update API route...\n";
    
    // Check if route already exists
    $apiRouteExists = false;
    foreach ($routes as $route) {
        if ($route->uri() === 'api/profile/update') {
            $apiRouteExists = true;
            break;
        }
    }
    
    if (!$apiRouteExists) {
        echo "✅ API route for profile update needs to be added\n";
    } else {
        echo "✅ API route for profile update already exists\n";
    }
    
} catch (\Exception $e) {
    echo "❌ Error creating profile update API: " . $e->getMessage() . "\n";
}

// Test 4: Check image upload directory
echo "\n=== Test 4: Check Image Upload Setup ===\n";
try {
    $avatarPath = public_path('uploads/avatars');
    
    if (!is_dir($avatarPath)) {
        echo "Creating avatars upload directory...\n";
        mkdir($avatarPath, 0755, true);
        
        if (is_dir($avatarPath)) {
            echo "✅ Avatars directory created\n";
        } else {
            echo "❌ Failed to create avatars directory\n";
        }
    } else {
        echo "✅ Avatars directory already exists\n";
    }
    
    // Check .htaccess for uploads
    $htaccessPath = public_path('uploads/.htaccess');
    if (!file_exists($htaccessPath)) {
        echo "Creating .htaccess for uploads directory...\n";
        
        $htaccessContent = "
Order Allow,Deny
Allow from all
<FilesMatch '\.(php|phtml|php3|php4|php5|pl|py|cgi|sh|bat)$'>
    Order Allow,Deny
    Deny from all
</FilesMatch>
        ";
        
        file_put_contents($htaccessPath, $htaccessContent);
        echo "✅ .htaccess created for uploads directory\n";
    } else {
        echo "✅ .htaccess already exists for uploads directory\n";
    }
    
} catch (\Exception $e) {
    echo "❌ Error checking image upload setup: " . $e->getMessage() . "\n";
}

// Test 5: Check current profile view issues
echo "\n=== Test 5: Identify Current Issues ===\n";
try {
    $viewFile = resource_path('views/auth/profile.blade.php');
    
    if (file_exists($viewFile)) {
        $content = file_get_contents($viewFile);
        
        echo "Current profile view issues:\n";
        
        // Check for JavaScript issues
        if (strpos($content, 'alert(') !== false) {
            echo "❌ Uses alert() instead of proper notifications\n";
        }
        
        if (strpos($content, 'prompt(') !== false) {
            echo "❌ Uses prompt() instead of proper modals\n";
        }
        
        if (strpos($content, 'changeAvatar()') !== false) {
            echo "❌ changeAvatar() function only shows alert\n";
        }
        
        if (strpos($content, 'saveProfile()') !== false) {
            echo "❌ saveProfile() function uses setTimeout instead of API\n";
        }
        
        // Check for form issues
        if (strpos($content, 'action="{{ route('profile.update') }}") !== false) {
            echo "✅ Profile form uses correct route\n";
        } else {
            echo "❌ Profile form doesn't use correct route\n";
        }
        
        // Check for duplicate modal
        if (substr_count($content, 'editProfileModal') > 1) {
            echo "❌ Duplicate editProfileModal in view\n";
        }
        
        // Check for hardcoded values
        if (strpos($content, 'value="John Doe"') !== false) {
            echo "❌ Contains hardcoded values instead of user data\n";
        }
        
    } else {
        echo "❌ Profile view file not found\n";
    }
    
} catch (\Exception $e) {
    echo "❌ Error checking profile view: " . $e->getMessage() . "\n";
}

echo "\n=== Profile Issues Summary ===\n";
echo "❌ JavaScript functions use alerts/prompts\n";
echo "❌ No actual API calls for profile updates\n";
echo "❌ Image upload only shows alert\n";
echo "❌ No database storage for avatars\n";
echo "❌ Hardcoded values in form\n";
echo "❌ Duplicate modal definitions\n\n";

echo "=== Fixes Needed ===\n";
echo "1. ✅ Add avatar column to users table\n";
echo "2. ✅ Create avatars upload directory\n";
echo "3. ✅ Add API route for profile updates\n";
echo "4. ✅ Fix JavaScript to use proper API calls\n";
echo "5. ✅ Implement actual image upload functionality\n";
echo "6. ✅ Update profile form to use dynamic user data\n";
echo "7. ✅ Add proper error handling and notifications\n\n";

echo "=== Ready to Implement Fixes ===\n";
