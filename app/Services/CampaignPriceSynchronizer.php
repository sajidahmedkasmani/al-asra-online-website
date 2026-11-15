<?php

namespace App\Services;

use App\Models\Campaign;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class CampaignPriceSynchronizer
{
    public function sync(): int
    {
        return DB::transaction(function (): int {
            $changed = Product::query()
                ->whereNotNull('discount_price')
                ->update(['discount_price' => null]);

            $basePrice = 'CASE WHEN price > 0 THEN price ELSE price_paisa / 100.0 END';

            foreach (Campaign::effectiveAt(now())->with('products:id')->get() as $campaign) {
                $query = Product::query()
                    ->where('is_active', true)
                    ->whereNull('discount_price');

                match ($campaign->type) {
                    'category' => $query->where('category_id', $campaign->category_id),
                    'product' => $query->whereIn('id', $campaign->products->modelKeys()),
                    'price_range' => $this->applyPriceRange($query, $basePrice, $campaign),
                    default => null,
                };

                $value = number_format((float) $campaign->discount_value, 2, '.', '');
                $discountedPrice = $campaign->discount_type === 'percentage'
                    ? "({$basePrice} * (1 - {$value} / 100))"
                    : "({$basePrice} - {$value})";

                $query->update([
                    'discount_price' => DB::raw(
                        "ROUND(CASE WHEN {$discountedPrice} < 0 THEN 0 ELSE {$discountedPrice} END, 2)"
                    ),
                ]);
            }

            return $changed;
        });
    }

    private function applyPriceRange(Builder $query, string $basePrice, Campaign $campaign): void
    {
        if ($campaign->price_min !== null) {
            $query->whereRaw(
                "{$basePrice} >= CAST(? AS DECIMAL(12,2))",
                [$campaign->price_min]
            );
        }

        if ($campaign->price_max !== null) {
            $query->whereRaw(
                "{$basePrice} <= CAST(? AS DECIMAL(12,2))",
                [$campaign->price_max]
            );
        }
    }
}
