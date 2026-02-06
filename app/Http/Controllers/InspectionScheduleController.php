<?php

namespace App\Http\Controllers;

use App\Models\Apar;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Models\AparInspection;
use App\Models\InspectionSchedule;
use App\Models\ScheduleType;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class InspectionScheduleController extends Controller
{
    public function index()
    {
        // Ambil semua jenis inspeksi
        $scheduleTypes = ScheduleType::all();

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
    
    // public function checklist(Request $request){
    //     $scheduleId = $request->input('schedule_id');
    //     return view('admin.schedule.checklist', compact('scheduleId'));
    // }

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

        DB::beginTransaction();

        try {
            // Simpan agenda inspeksi
            $schedule = InspectionSchedule::create([
                'title' => $request->title,
                'schedule_type_id' => $request->type,
                'start_date' => $request->start_date,
                'start_time' => $request->start_time,
                'end_date' => $request->end_date,
                'end_time' => $request->end_time,
                'notes' => $request->notes
            ]);

            // Jika type == 2, masukkan semua APAR ke inspeksi
            if ($request->type == 2) {
                $allApar = Apar::all();

                foreach ($allApar as $apar) {
                    AparInspection::create([
                        'inspection_schedule_id' => $schedule->id,
                        'apar_id' => $apar->id,
                        'status' => null,
                        'notes' => null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.schedule.index')
                ->with('success', 'The agenda has been saved successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal menyimpan agenda inspeksi: ' . $e->getMessage(), [
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);

            return back()->with('error', 'An error occurred while saving. Please try again.');
        }
    }

    public function show($id){
        $schedule = InspectionSchedule::with(['aparInspections', 'typeRelation'])->findOrFail($id);

        return view('admin.schedule.show', compact('schedule'));
    }

    public function getInspections($scheduleId)
    {
        $schedule = InspectionSchedule::with('aparInspections.apar.location', 'aparInspections.apar.media')->findOrFail($scheduleId);

        $inspections = $schedule->aparInspections;

        return DataTables::of($inspections)
            ->addColumn('lokasi', fn($i) => $i->apar->location?->location_name ?? '-')
            ->addColumn('detail', fn($i) => $i->apar->location_detail ?? '-')
            ->addColumn('brand', fn($i) => $i->apar->brand ?? '-')
            ->addColumn('media', fn($i) => $i->apar->media?->media_name ?? '-')
            ->addColumn('status', function ($i) {
                return $i->is_checked
                    ? '<span class="badge bg-success bg-opacity-10 text-success">✓ Selesai</span>'
                    : '<span class="badge bg-warning bg-opacity-10 text-warning">Belum</span>';
            })
            ->addColumn('note', fn($i) => $i->note ?? '-')
            ->rawColumns(['status'])
            ->make(true);

    }

    public function update(Request $request)
    {

        $request->validate([
            'id' => 'required|exists:fc_inspection_schedules,id',
            'title' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after_or_equal:start_time',
            'schedule_type_id' => 'required|exists:fc_schedule_type,id', // ⬅ validasi foreign key
        ]);

        $schedule = InspectionSchedule::find($request->id);

        $schedule->title = $request->title;
        $schedule->start_date = date('Y-m-d', strtotime($request->start_time));
        $schedule->start_time = date('H:i:s', strtotime($request->start_time));
        $schedule->end_date = date('Y-m-d', strtotime($request->end_time));
        $schedule->end_time = date('H:i:s', strtotime($request->end_time));
        $schedule->schedule_type_id = $request->schedule_type_id; // ⬅ update foreign key

        $schedule->save();

        return redirect()->back()->with('success', 'Agenda berhasil diperbarui.');
    }

}
