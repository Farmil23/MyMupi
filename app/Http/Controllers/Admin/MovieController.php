<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index()
    {
        $movies = \App\Models\Movie::latest()->paginate(10);
        return view('admin.movies.index', compact('movies'));
    }

    public function create()
    {
        return view('admin.movies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'synopsis' => 'nullable|string',
            'genre' => 'required|string',
            'duration_minutes' => 'required|integer',
            'rating' => 'required|numeric|min:0|max:10',
            'release_date' => 'required|date',
            'poster_url' => 'nullable|url',
            'poster_file' => 'nullable|image|max:2048'
        ]);

        $poster = 'https://placehold.co/400x600?text=No+Image';

        if ($request->hasFile('poster_file')) {
            $path = $request->file('poster_file')->store('posters', 'public');
            $poster = asset('storage/' . $path);
        } elseif ($request->poster_url) {
             $poster = $request->poster_url;
        }

        \App\Models\Movie::create([
            'title' => $request->title,
            'description' => $request->description,
            'synopsis' => $request->synopsis ?? $request->description, // Default to description if empty
            'genre' => $request->genre,
            'duration_minutes' => $request->duration_minutes,
            'rating' => $request->rating,
            'release_date' => $request->release_date,
            'poster' => $poster,
        ]);

        return redirect()->route('admin.movies.index')->with('success', 'Movie added successfully');
    }
    public function edit($id)
    {
        $movie = \App\Models\Movie::findOrFail($id);
        return view('admin.movies.edit', compact('movie'));
    }

    public function update(Request $request, $id)
    {
        $movie = \App\Models\Movie::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'genre' => 'required|string',
            'duration_minutes' => 'required|integer',
            'rating' => 'required|numeric|min:0|max:10',
            'release_date' => 'required|date',
            'poster_url' => 'nullable|url',
            'poster_file' => 'nullable|image|max:2048'
        ]);

        $data = $request->except(['poster_file', 'poster_url']);

        if ($request->hasFile('poster_file')) {
            $path = $request->file('poster_file')->store('posters', 'public');
            $data['poster'] = asset('storage/' . $path);
        } elseif ($request->poster_url) {
             $data['poster'] = $request->poster_url;
        }

        $movie->update($data);

        return redirect()->route('admin.movies.index')->with('success', 'Movie updated successfully');
    }

    public function destroy($id)
    {
        $movie = \App\Models\Movie::findOrFail($id);
        $movie->delete();

        return redirect()->route('admin.movies.index')->with('success', 'Movie deleted successfully');
    }
}
