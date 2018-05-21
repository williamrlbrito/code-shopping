<?php

namespace CodeShopping\Http\Controllers\Api;

use CodeShopping\Models\Category;
use CodeShopping\Models\Product;
use Illuminate\Http\Request;
use CodeShopping\Http\Controllers\Controller;

class ProductCategoryController extends Controller
{
    public function index(Product $product)
    {
        return $product->categories;
    }

    public function store(Request $request, Product $product)
    {
        $changed = $product->categories()->sync($request->categories);
        $attached = $changed['attached'];

        /*** @var \Illuminate\Database\Eloquent\Collection */
        $categories = Category::whereIn('id', $attached)->get();
        return $categories->count() ? response()->json($categories, 201) : [];
    }

    public function destroy($id)
    {
        //
    }
}