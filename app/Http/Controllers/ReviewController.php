<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        if (! $request->user()) {
            abort(403);
        }

        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'body' => ['nullable', 'string', 'max:2000'],
        ]);

        if ($product->reviews()->where('user_id', $request->user()->id)->exists()) {
            return back()->with('review_error', __('messages.review_already_submitted'));
        }

        Review::create([
            'user_id' => $request->user()->id,
            'product_id' => $product->id,
            'rating' => $validated['rating'],
            'body' => $validated['body'] ?? null,
            'is_approved' => false,
        ]);

        return back()->with('review_success', __('messages.review_submitted_pending'));
    }

    public function destroy(Request $request, Review $review)
    {
        if ($review->user_id !== $request->user()->id && ! $request->user()->is_admin) {
            abort(403);
        }

        $review->delete();

        return back()->with('review_success', __('messages.review_deleted'));
    }
}
