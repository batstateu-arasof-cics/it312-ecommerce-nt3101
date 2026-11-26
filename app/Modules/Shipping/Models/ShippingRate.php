<?php

namespace App\Modules\Shipping\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingRate extends Model
{
    protected $fillable = ['province', 'region', 'fee'];

    protected $casts = ['fee' => 'decimal:2'];
}
