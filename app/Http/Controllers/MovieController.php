<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function show(\App\Models\Movie $movie)
    {
        $movie->load(['showtimes.studio', 'reviews.user']); // Eager load reviews
        return view('movies.show', compact('movie'));
    }

    public function storeReview(Request $request, \App\Models\Movie $movie)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000',
        ]);

        // Check if user already reviewed
        $existingReview = $movie->reviews()->where('user_id', auth()->id())->first();
        if ($existingReview) {
            return back()->withErrors(['error' => 'You have already reviewed this movie.']);
        }

        $movie->reviews()->create([
            'user_id' => auth()->id(),
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        return back()->with('status', 'Review submitted successfully!');
    }
}
