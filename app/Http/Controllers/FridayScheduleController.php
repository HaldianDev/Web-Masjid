<?php

namespace App\Http\Controllers;

use App\Models\FridaySchedule;
use Illuminate\Http\Request;

class FridayScheduleController extends Controller
{
    public function index()
    {
        $schedules = FridaySchedule::orderBy('date', 'desc')->paginate(10);
        return view('admin.friday_schedules.index', compact('schedules'));
    }

    public function create()
    {
        return view('admin.friday_schedules.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date|unique:friday_schedules',
            'imam' => 'required|string|max:255',
            'khotib' => 'required|string|max:255',
            'muadzin' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        FridaySchedule::create($validated);

        return redirect()->route('admin.friday-schedules.index')->with('success', 'Jadwal shalat Jumat berhasil ditambahkan.');
    }

    public function edit(FridaySchedule $fridaySchedule)
    {
        return view('admin.friday_schedules.edit', compact('fridaySchedule'));
    }

    public function update(Request $request, FridaySchedule $fridaySchedule)
    {
        $validated = $request->validate([
            'date' => 'required|date|unique:friday_schedules,date,' . $fridaySchedule->id,
            'imam' => 'required|string|max:255',
            'khotib' => 'required|string|max:255',
            'muadzin' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $fridaySchedule->update($validated);

        return redirect()->route('admin.friday-schedules.index')->with('success', 'Jadwal shalat Jumat berhasil diperbarui.');
    }

    public function destroy(FridaySchedule $fridaySchedule)
    {
        $fridaySchedule->delete();
        return redirect()->route('admin.friday-schedules.index')->with('success', 'Jadwal shalat Jumat berhasil dihapus.');
    }
}
