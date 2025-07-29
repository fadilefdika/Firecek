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
                    $editUrl = route('admin.media.edit', $row->id);
                    $deleteUrl = route('admin.media.destroy', $row->id);

                    return '
                        <a href="'.$editUrl.'" class="btn btn-sm btn-warning">Edit</a>
                        <form action="'.$deleteUrl.'" method="POST" style="display:inline-block">
                            '.csrf_field().method_field('DELETE').'
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm(\'Hapus data ini?\')">Hapus</button>
                        </form>
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
            'nama' => 'required|string|max:255',
        ]);

        Media::create($request->all());
        return redirect()->route('media.index')->with('success', 'Media berhasil ditambahkan.');
    }

    public function edit(Media $media)
    {
        return view('admin.media.edit', compact('media'));
    }

    public function update(Request $request, Media $media)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $media->update($request->all());
        return redirect()->route('media.index')->with('success', 'Media berhasil diperbarui.');
    }

    public function destroy(Media $media)
    {
        $media->delete();
        return redirect()->route('media.index')->with('success', 'Media berhasil dihapus.');
    }
}