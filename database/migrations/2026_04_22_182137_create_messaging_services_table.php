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
        Schema::create('messaging_services', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('type', 50); // SMS, EMAIL, WHATSAPP, MOBILE
            $table->string('provider', 100); // messaging-service.co.tz, etc.
            $table->string('base_url', 255);
            $table->string('api_version', 20)->default('v2');
            $table->text('api_key')->nullable();
            $table->text('bearer_token')->nullable();
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->string('sender_id', 100)->nullable();
            $table->json('config')->nullable(); // Additional configuration
            $table->boolean('is_active')->default(true);
            $table->boolean('test_mode')->default(false);
            $table->integer('rate_limit_per_hour')->default(100);
            $table->decimal('cost_per_message', 10, 4)->default(0);
            $table->string('currency', 3)->default('TZS');
            $table->text('webhook_url')->nullable();
            $table->json('webhook_events')->nullable();
            $table->timestamp('last_sync_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['type', 'is_active']);
            $table->index(['provider', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messaging_services');
    }
};
