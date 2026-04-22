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
        Schema::create('email_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('messaging_service_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('message_id', 100)->unique(); // API message ID
            $table->string('from_name', 100);
            $table->string('from_email', 255);
            $table->string('to_email', 255);
            $table->string('to_name', 100)->nullable();
            $table->string('subject', 255);
            $table->longText('body_html');
            $table->longText('body_text')->nullable();
            $table->json('attachments')->nullable(); // Store attachment info
            $table->json('cc')->nullable();
            $table->json('bcc')->nullable();
            $table->json('reply_to')->nullable();
            
            // Status tracking
            $table->integer('status_group_id')->nullable();
            $table->string('status_group_name', 50)->nullable();
            $table->integer('status_id')->nullable();
            $table->string('status_name', 100)->nullable();
            $table->text('status_description')->nullable();
            
            // Delivery tracking
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('opened_at')->nullable();
            $table->timestamp('clicked_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->timestamp('bounced_at')->nullable();
            $table->timestamp('complained_at')->nullable();
            
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
            $table->index(['to_email', 'status_group_id']);
            $table->index(['sent_at']);
            $table->index(['message_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_messages');
    }
};
