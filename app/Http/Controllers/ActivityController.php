<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index()
    {
        $activities = Activity::orderBy('event_date', 'desc')->paginate(10);
        return view('admin.activities.index', compact('activities'));
    }

    public function create()
    {
        return view('admin.activities.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'event_date' => 'required|date',
            'event_time' => 'required|string|max:100',
            'speaker' => 'nullable|string|max:100',
            'location' => 'required|string|max:255',
            'image_path' => 'nullable|string',
        ]);

        Activity::create($validated);

        return redirect()->route('admin.activities.index')->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    public function edit(Activity $activity)
    {
        return view('admin.activities.edit', compact('activity'));
    }

    public function update(Request $request, Activity $activity)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'event_date' => 'required|date',
            'event_time' => 'required|string|max:100',
            'speaker' => 'nullable|string|max:100',
            'location' => 'required|string|max:255',
            'image_path' => 'nullable|string',
        ]);

        $activity->update($validated);

        return redirect()->route('admin.activities.index')->with('success', 'Kegiatan berhasil diperbarui.');
    }

    public function destroy(Activity $activity)
    {
        $activity->delete();
        return redirect()->route('admin.activities.index')->with('success', 'Kegiatan berhasil dihapus.');
    }
}
