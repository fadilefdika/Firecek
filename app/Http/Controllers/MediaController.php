<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Yajra\DataTables\Facades\DataTables;

class MediaController extends Controller
{
    public function index()
    {
        return view('admin.master-data.media.index');
    }

    public function getData(Request $request)
    {
       if ($request->ajax()) {
            $data = Media::select(['id', 'media_name']);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    return '
                        <button type="button" class="btn btn-sm btn-warning edit-type" data-id="'.$row->id.'" data-name="'.$row->media_name.'">Edit</button>
                        <button type="button" class="btn btn-sm btn-danger delete-type" data-id="'.$row->id.'">Delete</button>
                    ';
                })
                ->rawColumns(['action']) // penting agar tombol HTML tidak di-escape
                ->make(true);
        }
    }

    public function create()
    {
        return view('admin.media.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'media_name' => 'required|string|max:255',
        ]);

        Media::create($request->all());
        return redirect()->route('media.index')->with('success', 'Media Successfully Registered.');
    }

    public function edit(Media $media)
    {
        return view('admin.media.edit', compact('media'));
    }

    public function update(Request $request, Media $media)
    {
        $request->validate([
            'media_name' => 'required|string|max:255',
        ]);

        $media->update($request->all());
        return redirect()->route('admin.media.index')->with('success', 'Media successfully updated.');
    }

     public function destroy(Media $media)
    {
        try {
            // Lakukan penghapusan data
            $media->delete();

            // Kembalikan respon JSON (Inilah yang ditunggu oleh blok success di JS)
            return response()->json([
                'status'  => 'success',
                'message' => 'Media successfully deleted.'
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