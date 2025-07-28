<?php

namespace App\Http\Controllers;

use App\Models\InspectionSchedule;
use Illuminate\Http\Request;

class InspectionScheduleController extends Controller
{
    public function index()
    {
        $colorMap = [
            'pengecekan vendor' => '#f87171',
            'pengecekan sendiri' => '#60a5fa',
            'isi ulang apar' => '#34d399',
            'service' => '#fbbf24',
        ];
    
        $schedules = InspectionSchedule::all()->map(function ($s) use ($colorMap) {
            return [
                'id' => $s->id,
                'title' => $s->title,
                'start' => $s->start_date . 'T' . $s->start_time,
                'end' => $s->end_date . 'T' . $s->end_time,
                'color' => $colorMap[$s->jenis] ?? '#9ca3af',
            ];
        });
    
        return view('admin.schedule.index', compact('schedules'));
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'type' => 'required',
            'start_date' => 'required|date',
            'start_time' => 'required',
            'end_date' => 'required|date',
            'end_time' => 'required',
            'notes' => 'nullable'
        ]);

        InspectionSchedule::create($request->all());

        return redirect()->route('admin.schedule.index')->with('success', 'Agenda berhasil disimpan.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:inspection_schedules,id',
            'title' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after_or_equal:start_time',
            'jenis' => 'required|string',
        ]);

        $schedule = InspectionSchedule::find($request->id);

        // Update field
        $schedule->title = $request->title;
        $schedule->start_date = date('Y-m-d', strtotime($request->start_time));
        $schedule->start_time = date('H:i:s', strtotime($request->start_time));
        $schedule->end_date = date('Y-m-d', strtotime($request->end_time));
        $schedule->end_time = date('H:i:s', strtotime($request->end_time));
        $schedule->jenis = $request->jenis;

        $schedule->save();

        return redirect()->back()->with('success', 'Agenda berhasil diperbarui.');
    }
}
