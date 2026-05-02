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
        Schema::create('websites', function (Blueprint $table) {
            $table->id();
            $table->string('domain')->unique();
            $table->string('project_name');
            $table->string('path');
            $table->string('php_version', 10)->default('8.2');
            $table->boolean('ssl_enabled')->default(false);
            $table->boolean('database_enabled')->default(false);
            $table->string('database_name')->nullable();
            $table->string('database_username')->nullable();
            $table->string('database_password')->nullable();
            $table->string('linux_username')->nullable();
            $table->enum('status', ['active', 'inactive', 'suspended', 'error'])->default('active');
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable();
            $table->foreignId('updated_by')->nullable();
            $table->timestamps();

            $table->index(['status']);
            $table->index(['domain']);
            $table->index(['created_by']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('websites');
    }
};
