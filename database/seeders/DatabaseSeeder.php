<?php

namespace Database\Seeders;

use App\Models\User;
use App\Modules\Catalog\Models\Category;
use App\Modules\Catalog\Models\Product;
use App\Modules\Reviews\Models\Review;
use App\Modules\Vouchers\Models\Voucher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Instructor-owned demo data. Teams add their own seeders as database/seeders/<Module>Seeder.php
 * and ask the instructor to call them below.
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create(['name' => 'Shop Admin', 'email' => 'admin@shop.test', 'password' => 'password', 'role' => 'admin']);
        $customer = User::create(['name' => 'Juan Dela Cruz', 'email' => 'customer@shop.test', 'password' => 'password', 'role' => 'customer']);

        $catalog = [
            'Coffee' => [
                ['Kapeng Barako 250g', 220, 'Strong Liberica coffee from Batangas.'],
                ['Benguet Arabica 250g', 280, 'Medium roast highland Arabica.'],
                ['Sagada Coffee 500g', 450, 'Dark roast from the Cordilleras.'],
            ],
            'Snacks' => [
                ['Tablea Chocolate 200g', 150, 'Pure cacao tablets for sikwate.'],
                ['Dried Mangoes 200g', 120, 'Sweet dried Cebu mangoes.'],
                ['Panutsa 10pcs', 90, 'Peanut brittle with muscovado.'],
            ],
            'Home' => [
                ['Abaca Placemat Set', 380, 'Set of 4 handwoven abaca placemats.'],
                ['Rattan Fruit Basket', 520, 'Handmade rattan basket.'],
                ['Banig Table Runner', 300, 'Woven pandan table runner.'],
            ],
            'Apparel' => [
                ['Barong Tagalog Polo', 1500, 'Embroidered jusi polo barong.'],
                ['Inabel Scarf', 650, 'Handwoven Ilocos inabel scarf.'],
                ['Bayong Tote Bag', 480, 'Buri palm tote bag.'],
            ],
        ];

        foreach ($catalog as $categoryName => $products) {
            $category = Category::create(['name' => $categoryName, 'slug' => Str::slug($categoryName)]);

            foreach ($products as $i => [$name, $price, $description]) {
                Product::create([
                    'category_id' => $category->id,
                    'name' => $name,
                    'slug' => Str::slug($name),
                    'description' => $description,
                    'price' => $price,
                    'stock' => $i === 2 ? 3 : 25, // one low-stock product per category for Inventory team
                    'is_active' => true,
                ]);
            }
        }

        // Demo voucher (Vouchers module is unassigned)
        Voucher::create(['code' => 'WELCOME10', 'type' => 'percent', 'value' => 10, 'min_spend' => 300]);

        // Reviews team demo reviews
        Review::create(['product_id' => 1, 'user_id' => $customer->id, 'rating' => 5, 'comment' => 'Matapang at mabango. Sulit!']);
        Review::create(['product_id' => 2, 'user_id' => $customer->id, 'rating' => 4, 'comment' => 'Smooth, not too bitter.']);

        // TODO (Shipping team): $this->call(ShippingRateSeeder::class);
    }
}
