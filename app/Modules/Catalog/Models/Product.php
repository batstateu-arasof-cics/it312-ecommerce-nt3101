<?php

namespace App\Modules\Catalog\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Core model. Owner: Catalog team.
 * Only Inventory team changes `stock`, through InventoryServiceInterface.
 */
class Product extends Model
{
    protected $fillable = [
        'category_id', 'name', 'slug', 'description', 'price', 'stock', 'image', 'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function imageUrl(): string
    {
        // TODO (Catalog team): return the uploaded image from storage once image upload is built
        return $this->image ?: 'https://placehold.co/400x300?text='.urlencode($this->name);
    }
}
