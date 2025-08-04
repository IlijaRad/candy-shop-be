<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReviewResource;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

final class ReviewController
{

    public function store(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        $data = $request->validate([
            'author_name' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
        ]);

        $data['user_id'] = $request->user()->id;
        $data['product_id'] = $product->id;

        $review = Review::create($data);

        return new ReviewResource($review);
    }

    public function index(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        $reviews = $product->reviews()->paginate(10);

        $averageRating = $product->reviews()->avg('rating');
        $averageRating = round($averageRating);

        return response()->json([
            'reviews' => ReviewResource::collection($reviews),
            'average_rating' => $averageRating,
            'meta' => [
                'current_page' => $reviews->currentPage(),
                'per_page' => $reviews->perPage(),
                'total' => $reviews->total(),
                'last_page' => $reviews->lastPage(),
            ],
            'links' => [
                'first' => $reviews->url(1),
                'last' => $reviews->url($reviews->lastPage()),
                'prev' => $reviews->previousPageUrl(),
                'next' => $reviews->nextPageUrl(),
            ]
        ]);
    }

    public function show($slug, Review $review)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        if ($review->product_id !== $product->id) {
            return response()->json(['message' => 'Review does not belong to this product.'], 404);
        }

        return new ReviewResource($review);
    }

    public function update(Request $request, $slug, Review $review)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        if ($review->product_id !== $product->id) {
            return response()->json(['message' => 'Review does not belong to this product.'], 404);
        }

        if ($request->user()->id !== $review->user_id) {
            return response()->json(['message' => 'You are not authorized to update this review.'], 403);
        }

        $data = $request->validate([
            'author_name' => ['sometimes', 'required', 'string', 'max:255'],
            'content' => ['sometimes', 'required', 'string'],
            'rating' => ['sometimes', 'required', 'integer', 'min:1', 'max:5'],
        ]);

        $review->update($data);

        return new ReviewResource($review);
    }

    public function destroy(Request $request, $slug, Review $review)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        if ($review->product_id !== $product->id) {
            return response()->json(['message' => 'Review does not belong to this product.'], 404);
        }

        if ($request->user()->id !== $review->user_id) {
            return response()->json(['message' => 'You are not authorized to delete this review.'], 403);
        }

        $review->delete();

        return response()->noContent();
    }
}
