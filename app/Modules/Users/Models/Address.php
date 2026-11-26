<?php

namespace App\Modules\Users\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    protected $fillable = [
        'user_id', 'recipient', 'phone', 'street', 'barangay',
        'city', 'province', 'region', 'postal_code', 'is_default',
    ];

    protected $casts = ['is_default' => 'boolean'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** One-line address, copied into orders.shipping_address at checkout. */
    public function fullAddress(): string
    {
        return collect([$this->street, $this->barangay, $this->city, $this->province, $this->postal_code])
            ->filter()
            ->implode(', ');
    }
}
