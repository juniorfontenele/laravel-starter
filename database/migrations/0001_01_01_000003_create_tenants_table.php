<?php

declare(strict_types = 1);

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
        Schema::create('tenants', function (Blueprint $table) {
            $table->defaultCharset();
            $table->id();
            $table->string('name');
            $table->string('title');
            $table->longText('logo')->nullable();
            $table->boolean('is_fallback')->default(false)->index();
            $table->boolean('is_active')->default(true)->index();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamps();
        });

        Schema::create('tenant_hosts', function (Blueprint $table) {
            $table->defaultCharset();
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants');
            $table->string('host')->unique();
            $table->boolean('is_active')->default(true)->index();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamps();
        });

        Schema::create('user_tenant', function (Blueprint $table) {
            $table->defaultCharset();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('tenant_id')->constrained('tenants');
            $table->timestamps();

            $table->unique(['user_id', 'tenant_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_tenant');
        Schema::dropIfExists('tenant_hosts');
        Schema::dropIfExists('tenants');
    }
};
