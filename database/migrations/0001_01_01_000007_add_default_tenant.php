<?php

declare(strict_types = 1);

use App\Models\Tenant;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Tenant::create([
            'name' => 'Laravel Starter',
            'title' => 'Laravel Starter',
            'logo' => 'https://placehold.co/160x80?text=Laravel+Starter&font=roboto',
            'is_fallback' => true,
            'is_active' => true,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
