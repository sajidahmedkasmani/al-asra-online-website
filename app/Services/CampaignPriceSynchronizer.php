<?php

namespace App\Services;

use App\Models\Campaign;
use App\Models\Product;
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

            foreach (Campaign::effectiveAt(now())->get() as $campaign) {
                $query = Product::query()
                    ->where('is_active', true)
                    ->whereNull('discount_price');

                match ($campaign->type) {
                    'category' => $query->where('category_id', $campaign->category_id),
                    'product' => $query->whereKey($campaign->product_id),
                    'price_range' => $query->whereRaw(
                        "{$basePrice} BETWEEN CAST(? AS DECIMAL(12,2)) AND CAST(? AS DECIMAL(12,2))",
                        [$campaign->price_min, $campaign->price_max]
                    ),
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
}
