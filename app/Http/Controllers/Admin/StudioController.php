<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Studio;

class StudioController extends Controller
{
    public function index()
    {
        $studios = Studio::latest()->paginate(10);
        return view('admin.studios.index', compact('studios'));
    }

    public function create()
    {
        return view('admin.studios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'total_rows' => 'required|integer|min:1|max:26', // A-Z
            'seats_per_row' => 'required|integer|min:1|max:20',
        ]);

        Studio::create([
            'name' => $request->name,
            'total_rows' => $request->total_rows,
            'seats_per_row' => $request->seats_per_row,
            'capacity' => $request->total_rows * $request->seats_per_row
        ]);

        return redirect()->route('admin.studios.index')
            ->with('success', 'Studio created successfully.');
    }

    public function edit(Studio $studio)
    {
        return view('admin.studios.edit', compact('studio'));
    }

    public function update(Request $request, Studio $studio)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'total_rows' => 'required|integer|min:1|max:26',
            'seats_per_row' => 'required|integer|min:1|max:20',
        ]);

        $studio->update([
            'name' => $request->name,
            'total_rows' => $request->total_rows,
            'seats_per_row' => $request->seats_per_row,
            'capacity' => $request->total_rows * $request->seats_per_row
        ]);

        return redirect()->route('admin.studios.index')
            ->with('success', 'Studio updated successfully.');
    }

    public function destroy(Studio $studio)
    {
        // Optional: Check if studio has showtimes before deleting
        $studio->delete();
        return redirect()->route('admin.studios.index')
            ->with('success', 'Studio deleted successfully.');
    }
}
