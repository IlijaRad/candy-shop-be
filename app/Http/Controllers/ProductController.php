<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;

final class ProductController
{
    public function index()
    {
        $products = Product::with('reviews')->paginate(10);

        return ProductResource::collection($products);
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        return new ProductResource($product->load('reviews'));
    }

    // Create a new product
    // public function store(Request $request)
    // {
    //     $data = $request->validate([
    //  'name' => 'required|string',
    // 'slug' => 'required|string|unique:products',
    // 'sku' => 'required|string|unique:products',
    // 'price' => 'required|numeric',
    // 'discounted_price' => 'nullable|numeric',
    // 'stock' => 'required|integer',
    // 'description' => 'nullable|string',
    // 'category_id' => 'required|exists:categories,id',
    // 'brand_id' => 'required|exists:brands,id',
    // 'product_information' => 'array',
    // 'product_information.nutritional_values' => 'array',
    // 'product_information.ingredients' => 'nullable|string',
    // 'product_information.allergens' => 'nullable|string',
    // 'product_information.country_of_origin' => 'nullable|string',
    //     ]);

    //     $product = Product::create($data);

    //     return new ProductResource($product);
    // }

    // // Update a product
    // public function update(Request $request, Product $product)
    // {
    //     $data = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'description' => 'nullable|string',
    //         'price' => 'required|numeric',
    //         'stock' => 'required|integer',
    //         'sku' => 'required|string|unique:products,sku,' . $product->id,
    //         'category_id' => 'nullable|exists:categories,id',
    //         'brand_id' => 'nullable|exists:brands,id',
    //         'nutritional_values' => 'nullable|string',
    //         'ingredients' => 'nullable|string',
    //         'allergens' => 'nullable|string',
    //         'country_of_origin' => 'nullable|string',
    //     ]);

    //     $product->update($data);

    //     return new ProductResource($product);
    // }

    // // Delete a product
    // public function destroy(Product $product)
    // {
    //     $product->delete();
    //     return response()->json(null, 204);
    // }
}
