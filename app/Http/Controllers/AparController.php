<?php

namespace App\Http\Controllers;

use App\Models\Apar;
use App\Models\Media;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Models\AparInspection;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\InspectionQuestion;
use App\Models\InspectionSchedule;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AparController extends Controller
{
    public function index()
    {
        $media = Media::all();
        $location = Location::all();

        $totalApar = Apar::count();
        // $belumDigunakan = Apar::where('status', 'belum_digunakan')->count();
        // $digunakan = Apar::where('status', 'digunakan')->count();

        $jumlahMedia = Apar::select('media_id')->distinct()->count();
        $jumlahBrand = Apar::select('brand')->distinct()->count();
        $jumlahLokasi = Apar::select('location_id')->distinct()->count();
        $jumlahTipe = Apar::select('type')->distinct()->count();

        return view('admin.apar.index', compact(
            'media',
            'location',
            'totalApar',
            // 'belumDigunakan',
            // 'digunakan',
            'jumlahMedia',
            'jumlahBrand',
            'jumlahLokasi',
            'jumlahTipe'
        ));
    }

    public function getData(Request $request)
    {
        $data = Apar::with(['media', 'location'])->select('fc_apar.*');

        return DataTables::of($data)
            ->addColumn('media_id', fn($row) => optional($row->media)->media_name ?? '-')
            ->addColumn('location_id', fn($row) => optional($row->location)->location_name ?? '-')
            ->addColumn('location_detail', fn($row) => $row->location_detail ?? '-')
            ->addColumn('expired_date', function ($row) {
                return $row->expired_date 
                    ? \Carbon\Carbon::parse($row->expired_date)->translatedFormat('d F Y') 
                    : '-';
            })            
            ->addColumn('action', function ($row) {
                $url = route('admin.apar.show', $row->id);
                return '<a href="' . $url . '" class="btn btn-sm btn-danger text-white btn-detail">Detail</a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }


   public function store(Request $request)
    {
        $request->validate([
            'brand' => 'required|string|max:100',
            'media_id' => 'required|integer',
            'type' => 'nullable|string|max:50',
            'capacity' => 'nullable|numeric|min:0',
            'expired_date' => 'nullable|date',
            'location_id' => 'nullable|integer',
            'location_detail' => 'nullable|string|max:255',
            'tube_weight' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // 'apar_code' tidak perlu dimasukkan di sini karena 
            // sudah dihandle otomatis oleh boot() method di Model
            Apar::create($request->all());

            DB::commit();
            return redirect()->back()->with('success', 'APAR unit successfully registered.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error Store APAR: ' . $e->getMessage());
            return redirect()->back()->with('error', 'System error: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $apar = Apar::with(['location', 'media', 'aparInspections.schedule'])->findOrFail($id); 
        $medias = Media::all();
        $locations = Location::all();

        // Sort inspections by schedule date
        $apar->aparInspections = $apar->aparInspections->sortBy(fn($i) => $i->schedule->start_date);

        // Ambil pertanyaan checklist sesuai media
        $questions = InspectionQuestion::with('options')
            ->where('media_id', $apar->media_id)
            ->get();

        return view('admin.apar.show', compact('apar', 'medias', 'locations', 'questions'));
    }


    public function edit($id)
    {
        $apar = Apar::findOrFail($id);

        return response()->json($apar);
    }

    public function update(Request $request, $id)
    {
        $apar = Apar::findOrFail($id);

        $request->validate([
            'brand'           => 'required|string|max:100',
            'media_id'        => 'required|integer',
            'type'            => 'nullable|string|max:50',
            'capacity'        => 'nullable|numeric|min:0',
            'expired_date'    => 'nullable|date',
            'location_id'     => 'nullable|integer',
            'location_detail' => 'nullable|string|max:255',
            'tube_weight'     => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $apar->update($request->all());
            
            DB::commit();
            return redirect()->back()->with('success', 'APAR data successfully updated.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Update APAR Failed: " . $e->getMessage());
            
            return redirect()->back()->with('error', 'A system error occurred while updating data.');
        }
    }

    public function checklist($id, $inspection_schedule_id)
    {
        $apar = Apar::findOrFail($id);

        // Ambil pertanyaan berdasarkan media_id dari APAR
        $questions = InspectionQuestion::with('options')
            ->where('media_id', $apar->media_id)
            ->get();

        $inspection = InspectionSchedule::findOrFail($inspection_schedule_id);


        return view('admin.apar.checklist', [
            'questions' => $questions,
            'inspection' => $inspection,
            'apar' => $apar,
            'aparId' => $id,
            'scheduleId' => $inspection_schedule_id,
        ]);
    }

    public function generateQrCode($id)
    {
        $apar = Apar::findOrFail($id);
        $url = route('admin.apar.show', $apar->id);

        // Generate QR Code sebagai SVG string
        $qrcodeString = QrCode::size(200)->generate($url);

        // Konversi ke Base64 agar DomPDF bisa merendernya sebagai Image
        $qrcode = base64_encode($qrcodeString);

        $pdf = Pdf::loadView('admin.apar.pdf-qrcode', compact('apar', 'qrcode'));
        
        // Set paper size ke ukuran label (misal: 10cm x 10cm) atau A4
        $pdf->setPaper([0, 0, 283, 283], 'portrait'); 

        return $pdf->download('QR_Code_' . $id . '.pdf');
    }


    public function showQr($id)
    {
        $apar = Apar::findOrFail($id);
        $url = route('admin.apar.show', $apar->id);

        return view('admin.apar.qrcode', [
            'qr' => QrCode::size(200)->generate($url), // 200 px = 2 cm saat print
            'apar' => $apar,
        ]);
    }


    public function exportPDF()
    {
        $data = DB::select("SELECT * FROM apar");
        $pdf = Pdf::loadView('apar.pdf', compact('data'));
        return $pdf->download('inventory_apar.pdf');
    }

}
