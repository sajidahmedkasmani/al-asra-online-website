<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class MarketingAttributionTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Route::middleware('web')->get('/__test/marketing-attribution', fn () => response()->noContent());
    }

    public function test_it_captures_utm_parameters_and_keeps_the_first_touch(): void
    {
        $this->get('/__test/marketing-attribution?utm_source=facebook&utm_medium=paid_social&utm_campaign=summer-sale&utm_content=carousel&ref=agent-17')
            ->assertNoContent()
            ->assertSessionHas('marketing_attribution.utm_source', 'facebook')
            ->assertSessionHas('marketing_attribution.utm_medium', 'paid_social')
            ->assertSessionHas('marketing_attribution.utm_campaign', 'summer-sale')
            ->assertSessionHas('marketing_attribution.referral_code', 'agent-17')
            ->assertSessionHas('marketing_attribution.landing_page', '/__test/marketing-attribution');

        $this->get('/__test/marketing-attribution?utm_source=google&utm_medium=organic')
            ->assertNoContent()
            ->assertSessionHas('marketing_attribution.utm_source', 'facebook');
    }

    public function test_it_identifies_an_organic_search_referrer_without_utm_tags(): void
    {
        $this->withHeaders(['referer' => 'https://www.google.com/search?q=al-asra'])
            ->get('/__test/marketing-attribution')
            ->assertNoContent()
            ->assertSessionHas('marketing_attribution.utm_source', 'google.com')
            ->assertSessionHas('marketing_attribution.utm_medium', 'organic')
            ->assertSessionHas('marketing_attribution.referrer', 'google.com');
    }

    public function test_it_tracks_partner_codes_and_later_campaign_visits_after_direct_visits(): void
    {
        $this->get('/__test/marketing-attribution')
            ->assertNoContent()
            ->assertSessionMissing('marketing_attribution');

        $this->get('/__test/marketing-attribution?forwarder=forwarder-42')
            ->assertNoContent()
            ->assertSessionHas('marketing_attribution.utm_source', 'partner')
            ->assertSessionHas('marketing_attribution.utm_medium', 'referral')
            ->assertSessionHas('marketing_attribution.referral_code', 'forwarder-42');
    }
}
