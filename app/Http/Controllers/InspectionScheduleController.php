<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InspectionSchedule;
use App\Models\Schedule;
use Illuminate\Routing\Controller;

class InspectionScheduleController extends Controller
{
    public function index()
    {
        // Ambil semua jenis inspeksi
        $scheduleTypes = Schedule::all();

        // Peta warna berdasarkan nama jenis inspeksi (schedule_name)
        $colorMap = [
            'Check Vendor' => '#f87171',
            'Check Self' => '#60a5fa',
            'Refill' => '#34d399',
            'Service' => '#fbbf24',
        ];

        // Ambil semua agenda + relasi ke jenis
        $schedules = InspectionSchedule::with('typeRelation')->get()->map(function ($s) use ($colorMap) {
            $scheduleName = $s->typeRelation->schedule_name ?? 'Unknown';

            return [
                'id' => $s->id,
                'title' => $s->title,
                'start' => $s->start_date . 'T' . $s->start_time,
                'end' => $s->end_date . 'T' . $s->end_time,
                'jenis' => $scheduleName,
                'type_id' => $s->typeRelation->id ?? null, // tambahkan ini
                'color' => $colorMap[$scheduleName] ?? '#9ca3af',
            ];
            
        });

        return view('admin.schedule.index', compact('schedules', 'scheduleTypes'));
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
            'id' => 'required|exists:fc_inspection_schedules,id',
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
