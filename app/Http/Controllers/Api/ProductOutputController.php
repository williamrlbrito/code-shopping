<?php

namespace CodeShopping\Http\Controllers\Api;

use CodeShopping\Http\Controllers\Controller;
use CodeShopping\Http\Resources\ProductOutputResource;
use CodeShopping\Models\ProductOutput;
use Illuminate\Http\Request;

class ProductOutputController extends Controller
{
    public function index()
    {
        $outputs = ProductOutput::with('product')->paginate();
        return ProductOutputResource::collection($outputs);
    }

    public function store(Request $request)
    {
        //
    }

    public function show(ProductOutput $output)
    {
        return new ProductOutputResource($output);
    }
}
