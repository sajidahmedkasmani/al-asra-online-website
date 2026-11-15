<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Models\ProductCategory;
use Tests\TestCase;

class ProductUrlTest extends TestCase
{
    public function test_product_url_uses_its_category_and_product_slugs(): void
    {
        $product = new Product(['slug' => 'coffee-beater', 'category' => 'other']);
        $product->setRelation('productCategory', new ProductCategory([
            'name' => 'Kitchen Use',
            'slug' => 'kitchen-use',
        ]));

        $this->assertSame('/kitchen-use/coffee-beater', parse_url($product->product_url, PHP_URL_PATH));
    }

    public function test_product_url_falls_back_to_the_legacy_category_slug(): void
    {
        $product = new Product(['slug' => 'coffee-beater', 'category' => 'Kitchen Use']);

        $this->assertSame('/kitchen-use/coffee-beater', parse_url($product->product_url, PHP_URL_PATH));
    }
}
