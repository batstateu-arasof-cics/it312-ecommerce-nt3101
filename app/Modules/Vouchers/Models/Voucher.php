<?php

namespace App\Modules\Vouchers\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = [
        'code', 'type', 'value', 'min_spend', 'usage_limit', 'used_count', 'expires_at', 'is_active',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'min_spend' => 'decimal:2',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];
}
