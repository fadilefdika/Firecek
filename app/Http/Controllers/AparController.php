<?php

namespace App\Http\Controllers;

use App\Models\Apar;
use App\Models\Media;
use App\Models\Location;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\InspectionQuestion;
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
        $data = Apar::with(['media', 'location']); // HAPUS ->orderBy()

        return DataTables::of($data)
            ->addColumn('media_id', fn($row) => $row->media->media_name ?? '-')
            ->addColumn('location_id', fn($row) => $row->location->location_name ?? '-')
            ->addColumn('location_detail', fn($row) => $row->location_detail ?? '-')
            ->addColumn('action', function($row) {
                $url = route('admin.apar.show', $row->id);
                return '<a href="' . $url . '" class="btn btn-sm btn-info text-white btn-detail">Detail</a>';
            })
            ->rawColumns(['media_id', 'location_id', 'action'])
            ->make(true);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'brand' => 'required|string|max:100',
            'media_id' => 'required|integer',
            'type' => 'nullable|string|max:50',
            'capacity' => 'nullable|numeric|min:0',
            'expired_date' => 'nullable|date',
            'location_id' => 'nullable|integer',
            'location_detail' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }

        DB::beginTransaction();

        try {
            Apar::create([
                'brand' => $request->brand,
                'media_id' => $request->media_id,
                'type' => $request->type,
                'capacity' => $request->capacity,
                'expired_date' => $request->expired_date,
                'location_id' => $request->location_id,
                'location_detail' => $request->location_detail,
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Data APAR berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info('Gagal menambahkan data APAR: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menambahkan data APAR: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $apar = Apar::with(['location', 'media'])->findOrFail($id); 
        $medias = Media::all();
        $locations = Location::all();

        // Ambil pertanyaan berdasarkan media
        $questions = InspectionQuestion::with('options')
            ->where('media_id', $apar->media_id)
            ->get();

        return view('admin.apar.show', compact('apar', 'medias', 'locations', 'questions'));
    }

    public function edit($id)
    {
        $apar = Apar::findOrFail($id);

        return response()->json([
            'id' => $apar->id,
            'brand' => $apar->brand,
            'media_id' => $apar->media_id,
            'type' => $apar->type,
            'capacity' => $apar->capacity,
            'expired_date' => $apar->expired_date,
            'location_id' => $apar->location_id,
            'location_detail' => $apar->location_detail,
        ]);
    }

    public function update(Request $request, $id)
    {
        $apar = Apar::findOrFail($id);
        $apar->update($request->all());

        return redirect()->back()->with('success', 'Data APAR berhasil diupdate.');
    }

    public function generateQrCode($id)
    {
        $apar = Apar::findOrFail($id);

        $url = route('admin.apar.show', $apar->id); // URL menuju halaman detail

        return QrCode::size(300)->generate($url);
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
