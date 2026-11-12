<?php

namespace Tests\Feature;

use App\Models\HomeSlider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeSliderTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_uses_active_admin_sliders_instead_of_products_for_hero(): void
    {
        HomeSlider::create([
            'title' => 'Admin-authored headline',
            'image' => 'sliders/winter-banner.webp',
            'content_type' => 'custom',
            'sort_order' => 1,
            'slide_duration' => 5500,
            'is_active' => true,
        ]);
        HomeSlider::create([
            'title' => 'Inactive slider headline',
            'image' => 'sliders/hidden-banner.webp',
            'content_type' => 'custom',
            'sort_order' => 2,
            'slide_duration' => 5500,
            'is_active' => false,
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee('Admin-authored headline')
            ->assertSee('uploads/sliders/winter-banner.webp', false)
            ->assertDontSee('Inactive slider headline');
    }
}
