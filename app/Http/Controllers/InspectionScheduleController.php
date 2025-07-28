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
}
