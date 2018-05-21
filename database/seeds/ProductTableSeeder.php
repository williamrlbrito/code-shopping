<?php

use Illuminate\Database\Seeder;
use CodeShopping\Models\Category;
use CodeShopping\Models\Product;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** @var \Illuminate\Database\Eloquent\Collection $categories */
        $categories = Category::all();
        factory(\CodeShopping\Models\Product::class, 30)
            ->create()
            ->each(function (Product $product) use ($categories) {
                $categoryId = $categories->random()->id;
                $product->categories()->attach($categoryId);
            });
    }
}
