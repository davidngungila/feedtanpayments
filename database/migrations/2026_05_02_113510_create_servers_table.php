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
        Schema::create('servers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('hostname');
            $table->string('ip_address');
            $table->enum('status', ['online', 'offline', 'maintenance'])->default('offline');
            $table->string('os_type')->nullable(); // ubuntu, centos, debian
            $table->string('os_version')->nullable();
            $table->string('cpu_cores')->nullable();
            $table->string('memory')->nullable();
            $table->string('disk_space')->nullable();
            $table->string('location')->nullable();
            $table->json('services')->nullable(); // nginx, apache, mysql, php-fpm, etc.
            $table->decimal('cpu_usage', 5, 2)->default(0);
            $table->decimal('memory_usage', 5, 2)->default(0);
            $table->decimal('disk_usage', 5, 2)->default(0);
            $table->timestamp('last_checked')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servers');
    }
};
