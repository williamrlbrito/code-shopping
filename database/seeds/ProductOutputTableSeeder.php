<?php

use Illuminate\Database\Seeder;

class ProductOutputTableSeeder extends Seeder
{
    public function run()
    {
        $products = \CodeShopping\Models\Product::all();
        factory(\CodeShopping\Models\ProductOutput::class, 100)
            ->make()
            ->each(function ($output) use ($products) {
                $product = $products->random();
                $output->product_id = $product->id;
                $output->save();
            });
    }
}
