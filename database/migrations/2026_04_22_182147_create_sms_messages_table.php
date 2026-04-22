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
        Schema::create('sms_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('messaging_service_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('message_id', 100)->unique(); // API message ID
            $table->string('from', 100); // Sender ID
            $table->string('to', 20); // Recipient number
            $table->text('message');
            $table->string('message_type', 20)->default('TEXT'); // TEXT, UNICODE, BINARY
            $table->integer('sms_count')->default(1);
            $table->decimal('price', 10, 4)->default(0);
            $table->string('currency', 3)->default('TZS');
            
            // Status tracking based on API V2
            $table->integer('status_group_id')->nullable();
            $table->string('status_group_name', 50)->nullable();
            $table->integer('status_id')->nullable();
            $table->string('status_name', 100)->nullable();
            $table->text('status_description')->nullable();
            
            // Delivery tracking
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            
            // Additional fields
            $table->string('schedule_time', 50)->nullable();
            $table->json('custom_data')->nullable();
            $table->text('error_message')->nullable();
            $table->integer('retry_count')->default(0);
            $table->timestamp('last_retry_at')->nullable();
            $table->boolean('is_test')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['messaging_service_id', 'status_group_id']);
            $table->index(['to', 'status_group_id']);
            $table->index(['sent_at']);
            $table->index(['message_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_messages');
    }
};
