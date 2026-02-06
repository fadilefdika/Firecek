<?php
namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::all();
        return response()->json($items);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|unique:ITEM,id',
            'item_name' => 'required|string|max:100',
            'entities' => 'nullable|array',
        ]);

        try {
            DB::beginTransaction();

            $currentUserId = Auth::id() ?? $request->user_id; 

            $item = Item::create([
                'id' => $request->id,
                'item_name' => $request->item_name,
                'creator_id' => $currentUserId, 
            ]);

            if ($request->has('entities')) {
                foreach ($request->entities as $entity) {
                    $item->entities()->attach($entity['entity_id'], [
                        'size' => $entity['size'] ?? null,
                        'notes' => $entity['notes'] ?? null,
                        'creator_id' => $currentUserId, 
                    ]);
                }
            }

            DB::commit();
            return response()->json(['message' => 'Item berhasil dibuat', 'data' => $item], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Gagal: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $item = Item::find($id);

        if (!$item) {
            return response()->json(['message' => 'Item tidak ditemukan'], 404);
        }

        $request->validate([
            'item_name' => 'sometimes|required|string|max:100',
        ]);

        $item->update($request->only('item_name'));

        if ($request->has('entities')) {
            $currentUserId = Auth::id() ?? $request->user_id;
            $syncData = [];
            foreach ($request->entities as $entity) {
                $syncData[$entity['entity_id']] = [
                    'size' => $entity['size'] ?? null,
                    'notes' => $entity['notes'] ?? null,
                    'creator_id' => $currentUserId,
                ];
            }
            $item->entities()->sync($syncData);
        }

        return response()->json(['message' => 'Item diperbarui', 'data' => $item]);
    }

    public function destroy($id)
    {
        $item = Item::find($id);
        if (!$item) return response()->json(['message' => 'Not found'], 404);

        $item->entities()->detach();
        $item->delete();

        return response()->json(['message' => 'Item dihapus']);
    }
}