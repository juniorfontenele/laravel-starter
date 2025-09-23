<?php

declare(strict_types = 1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TenantHost extends Model
{
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
}
