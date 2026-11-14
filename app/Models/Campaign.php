<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Campaign extends Model
{
    protected $fillable = [
        'name',
        'type',
        'discount_type',
        'discount_value',
        'category_id',
        'price_min',
        'price_max',
        'starts_at',
        'ends_at',
        'is_active',
    ];

    protected $casts = [
        'discount_value' => 'decimal:2',
        'price_min' => 'decimal:2',
        'price_max' => 'decimal:2',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'campaign_products');
    }

    public function scopeEffectiveAt(Builder $query, $time): Builder
    {
        return $query->where('is_active', true)
            ->where('starts_at', '<=', $time)
            ->where(function (Builder $query) use ($time) {
                $query->whereNull('ends_at')->orWhere('ends_at', '>', $time);
            })
            ->orderByDesc('starts_at')
            ->orderByDesc('id');
    }
}
