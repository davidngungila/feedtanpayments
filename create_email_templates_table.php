<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Creating Email Templates Database Table ===\n\n";

// Test 1: Check if table already exists
echo "=== Test 1: Check Existing Table ===\n";
try {
    if (\Illuminate\Support\Facades\Schema::hasTable('email_templates')) {
        echo "✅ email_templates table already exists\n";
        
        // Show table structure
        $columns = \Illuminate\Support\Facades\Schema::getColumnListing('email_templates');
        echo "Current columns:\n";
        foreach ($columns as $column) {
            echo "- {$column}\n";
        }
    } else {
        echo "❌ email_templates table does not exist\n";
    }
    
} catch (\Exception $e) {
    echo "❌ Error checking table: " . $e->getMessage() . "\n";
}

// Test 2: Create the table if it doesn't exist
echo "\n=== Test 2: Create Email Templates Table ===\n";
try {
    if (!\Illuminate\Support\Facades\Schema::hasTable('email_templates')) {
        \Illuminate\Support\Facades\Schema::create('email_templates', function ($table) {
            $table->id();
            $table->string('name');
            $table->string('type')->default('email'); // email, sms, etc.
            $table->string('category')->default('general'); // welcome, loan, balance, etc.
            $table->text('subject')->nullable();
            $table->longText('html_content');
            $table->text('text_content')->nullable();
            $table->json('variables')->nullable(); // Template variables definition
            $table->boolean('is_active')->default(true);
            $table->boolean('is_default')->default(false);
            $table->integer('usage_count')->default(0);
            $table->timestamp('last_used_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            
            // Indexes
            $table->index(['type', 'category']);
            $table->index('is_active');
            $table->index('is_default');
        });
        
        echo "✅ email_templates table created successfully\n";
    } else {
        echo "✅ Table already exists, skipping creation\n";
    }
    
} catch (\Exception $e) {
    echo "❌ Error creating table: " . $e->getMessage() . "\n";
}

// Test 3: Create EmailTemplate model
echo "\n=== Test 3: Create EmailTemplate Model ===\n";
try {
    $modelPath = app_path('Models/EmailTemplate.php');
    
    if (!file_exists($modelPath)) {
        $modelContent = '<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        \'name\',
        \'type\',
        \'category\',
        \'subject\',
        \'html_content\',
        \'text_content\',
        \'variables\',
        \'is_active\',
        \'is_default\',
        \'usage_count\',
        \'last_used_at\',
        \'created_by\'
    ];

    protected $casts = [
        \'variables\' => \'array\',
        \'is_active\' => \'boolean\',
        \'is_default\' => \'boolean\',
        \'last_used_at\' => \'datetime\'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, \'created_by\');
    }

    public function incrementUsage()
    {
        $this->increment(\'usage_count\');
        $this->update([\'last_used_at\' => now()]);
    }

    public function processTemplate(array $data = [])
    {
        $htmlContent = $this->html_content;
        $textContent = $this->text_content;
        $subject = $this->subject;

        // Replace variables in HTML content
        foreach ($data as $key => $value) {
            $htmlContent = str_replace(\'{\' . $key . \'}\', $value, $htmlContent);
            if ($textContent) {
                $textContent = str_replace(\'{\' . $key . \'}\', $value, $textContent);
            }
            if ($subject) {
                $subject = str_replace(\'{\' . $key . \'}\', $value, $subject);
            }
        }

        return [
            \'html\' => $htmlContent,
            \'text\' => $textContent,
            \'subject\' => $subject
        ];
    }

    public function scopeActive($query)
    {
        return $query->where(\'is_active\', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where(\'category\', $category);
    }

    public function scopeDefault($query)
    {
        return $query->where(\'is_default\', true);
    }
}';
        
        file_put_contents($modelPath, $modelContent);
        echo "✅ EmailTemplate model created\n";
    } else {
        echo "✅ EmailTemplate model already exists\n";
    }
    
} catch (\Exception $e) {
    echo "❌ Error creating model: " . $e->getMessage() . "\n";
}

echo "\n=== Database Setup Complete ===\n";
echo "✅ Database table and model are ready for email templates\n";
echo "Next: Insert the HTML templates into the database\n";
