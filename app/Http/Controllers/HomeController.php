<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Movie::with('showtimes');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('genre')) {
            $query->where('genre', $request->genre);
        }

        $movies = $query->latest()->get();
        $genres = Movie::select('genre')->distinct()->pluck('genre');

        return view('welcome', compact('movies', 'genres'));
    }
}
