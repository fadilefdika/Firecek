<?php

namespace App\Http\Controllers;

use App\Models\ScheduleType;
use Illuminate\Http\Request;
use App\Models\InspectionSchedule;
use Illuminate\Routing\Controller;
use Yajra\DataTables\Facades\DataTables;

class ScheduleTypeController extends Controller
{
    public function index()
    {
        return view('admin.master-data.schedule-type.index');
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = ScheduleType::select(['id', 'schedule_name']);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    return '
                        <button type="button" class="btn btn-sm btn-warning edit-type" data-id="'.$row->id.'" data-name="'.$row->schedule_name.'">Edit</button>
                        <button type="button" class="btn btn-sm btn-danger delete-type" data-id="'.$row->id.'">Delete</button>
                    ';
                })
                ->rawColumns(['action']) // penting agar tombol HTML tidak di-escape
                ->make(true);
        }
    }

    public function create()
    {
        return view('admin.schedule-type.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'schedule_name' => 'required|string|max:255',
        ]);

        ScheduleType::create($request->all());
        return redirect()->route('admin.schedule-type.index')->with('success', 'Schedule Type Successfully Registered.');
    }

    public function edit(ScheduleType $scheduleType)
    {
        return view('admin.schedule-type.edit', compact('scheduleType'));
    }

    public function update(Request $request, ScheduleType $scheduleType)
    {
        $request->validate([
            'schedule_name' => 'required|string|max:255',
        ]);

        $scheduleType->update($request->all());
        return redirect()->route('admin.schedule-type.index')->with('success', 'Schedule Type successfully updated.');
    }

    public function destroy(ScheduleType $scheduleType)
    {
        try {
            // Lakukan penghapusan data
            $scheduleType->delete();

            // Kembalikan respon JSON (Inilah yang ditunggu oleh blok success di JS)
            return response()->json([
                'status'  => 'success',
                'message' => 'Schedule Type successfully deleted.'
            ]);
            
        } catch (\Exception $e) {
            // Jika gagal (misal: data masih dipakai oleh tabel lain/foreign key)
            return response()->json([
                'status'  => 'error',
                'message' => 'Failed to delete data. It might be used elsewhere.'
            ], 500);
        }
    }
}
