<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShowtimeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $showtimes = \App\Models\Showtime::with(['movie', 'studio'])->latest()->paginate(15);
        return view('admin.showtimes.index', compact('showtimes'));
    }

    public function create()
    {
        $movies = \App\Models\Movie::all();
        $studios = \App\Models\Studio::all();
        return view('admin.showtimes.create', compact('movies', 'studios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'studio_id' => 'required|exists:studios,id',
            'start_time' => 'required|date',
            'price' => 'required|numeric|min:0',
        ]);

        \App\Models\Showtime::create($request->all());

        return redirect()->route('admin.showtimes.index')->with('success', 'Showtime scheduled successfully');
    }

    public function edit($id)
    {
        $showtime = \App\Models\Showtime::findOrFail($id);
        $movies = \App\Models\Movie::all();
        $studios = \App\Models\Studio::all();
        return view('admin.showtimes.edit', compact('showtime', 'movies', 'studios'));
    }

    public function update(Request $request, $id)
    {
        $showtime = \App\Models\Showtime::findOrFail($id);

        $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'studio_id' => 'required|exists:studios,id',
            'start_time' => 'required|date',
            'price' => 'required|numeric|min:0',
        ]);

        $showtime->update($request->all());

        return redirect()->route('admin.showtimes.index')->with('success', 'Showtime updated successfully');
    }

    public function destroy($id)
    {
        $showtime = \App\Models\Showtime::findOrFail($id);
        $showtime->delete();
        
        return redirect()->route('admin.showtimes.index')->with('success', 'Showtime deleted successfully');
    }
}
