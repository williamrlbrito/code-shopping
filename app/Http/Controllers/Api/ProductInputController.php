<?php

namespace CodeShopping\Http\Controllers\Api;

use CodeShopping\Http\Controllers\Controller;
use CodeShopping\Http\Requests\ProductInputRequest;
use CodeShopping\Models\Product;
use CodeShopping\Models\ProductInput;

class ProductInputController extends Controller
{
    public function store(ProductInputRequest $request, Product $product)
    {
        $data['amount'] = $request->amount;
        $data['product_id'] = $product->id;
        ProductInput::create($data);

        $product->stock += $data['amount'];
        $product->save();
        $product->refresh();

        return response($product, 201);
    }
}
