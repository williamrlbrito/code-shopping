<?php

namespace CodeShopping\Providers;

use CodeShopping\Models\ProductInput;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        \Schema::defaultStringLength(191);
        ProductInput::created(function ($input) {
            $product = $input->product;
            $product->stock += $input->amount;
            $product->save();
        });
    }

    public function register()
    {
        //
    }
}
