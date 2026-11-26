<?php

namespace App\Modules\Inventory\Models;

use App\Modules\Catalog\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** One row for every stock change: + for restock/restore, - for sales. */
class StockMovement extends Model
{
    protected $fillable = ['product_id', 'order_id', 'user_id', 'change', 'reason'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
