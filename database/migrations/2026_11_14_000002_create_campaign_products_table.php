<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('campaign_products')) {
            Schema::create('campaign_products', function (Blueprint $table) {
                $table->foreignId('campaign_id')->constrained()->cascadeOnDelete();
                $table->foreignId('product_id')->constrained()->cascadeOnDelete();
                $table->primary(['campaign_id', 'product_id']);
            });
        }

        if (Schema::hasColumn('campaigns', 'product_id')) {
            DB::table('campaigns')
                ->whereNotNull('product_id')
                ->orderBy('id')
                ->get(['id', 'product_id'])
                ->each(function ($campaign) {
                    DB::table('campaign_products')->insertOrIgnore([
                        'campaign_id' => $campaign->id,
                        'product_id' => $campaign->product_id,
                    ]);
                });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('campaign_products') && Schema::hasColumn('campaigns', 'product_id')) {
            DB::table('campaign_products')
                ->select('campaign_id', DB::raw('MIN(product_id) as product_id'))
                ->groupBy('campaign_id')
                ->get()
                ->each(function ($campaignProduct) {
                    DB::table('campaigns')
                        ->where('id', $campaignProduct->campaign_id)
                        ->update(['product_id' => $campaignProduct->product_id]);
                });
        }

        Schema::dropIfExists('campaign_products');
    }
};
