<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('messaging_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('type', 20); // SMS, EMAIL, WHATSAPP
            $table->string('category', 50); // TRANSACTIONAL, MARKETING, NOTIFICATION, ALERT
            $table->string('subject', 255)->nullable(); // For emails
            $table->text('content'); // Template content with placeholders
            $table->json('variables')->nullable(); // Available variables for replacement
            $table->json('default_values')->nullable(); // Default values for variables
            $table->boolean('is_active')->default(true);
            $table->boolean('is_system')->default(false); // System templates
            $table->integer('usage_count')->default(0);
            $table->timestamp('last_used_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->text('description')->nullable();
            $table->json('tags')->nullable();
            $table->timestamps();
            
            $table->index(['type', 'category', 'is_active']);
            $table->index(['is_system', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messaging_templates');
    }
};
