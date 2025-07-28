<?php

namespace App\Http\Controllers;

use App\Models\Apar;
use App\Models\Media;
use App\Models\Location;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
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
        $location= Location::all();
        return view('admin.apar.index', compact('media','location'));
    }

    public function getData(Request $request)
    {
        $data = Apar::with(['media', 'location']); // HAPUS ->orderBy()

        return DataTables::of($data)
            ->addColumn('media_id', fn($row) => $row->media->media_name ?? '-')
            ->addColumn('location_id', fn($row) => $row->location->location_name ?? '-')
            ->rawColumns(['media_id', 'location_id'])
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

    public function showQR($id)
    {
        $apar = DB::selectOne("SELECT * FROM apar WHERE id = ?", [$id]);
        $qr = QrCode::size(200)->generate(route('apar.detail', $apar->id));
        return view('apar.qr', compact('qr'));
    }


    public function exportPDF()
    {
        $data = DB::select("SELECT * FROM apar");
        $pdf = Pdf::loadView('apar.pdf', compact('data'));
        return $pdf->download('inventory_apar.pdf');
    }

}
