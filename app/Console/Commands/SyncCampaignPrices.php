<?php

namespace App\Console\Commands;

use App\Services\CampaignPriceSynchronizer;
use Illuminate\Console\Command;

class SyncCampaignPrices extends Command
{
    protected $signature = 'campaigns:sync-prices';

    protected $description = 'Apply active campaign discounts and restore expired product prices';

    public function handle(CampaignPriceSynchronizer $synchronizer): int
    {
        $synchronizer->sync();
        $this->info('Campaign product prices synchronized.');

        return self::SUCCESS;
    }
}
