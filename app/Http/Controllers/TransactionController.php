<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{

    public function index()
    {
        $transactions = Transaction::with('entity')->get();
        return response()->json($transactions);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|unique:TRANSACTION,id',
            'entity_id' => 'required|exists:ENTITY,id',
            'transaction_code' => 'required|string|max:100',
            'transaction_start_date' => 'required|date',
            'items' => 'required|array', 
        ]);

        try {
            DB::beginTransaction();

            $currentUserId = Auth::id() ?? $request->creator_id;

            $transaction = Transaction::create([
                'id' => $request->id,
                'entity_id' => $request->entity_id,
                'transaction_code' => $request->transaction_code,
                'transaction_start_date' => $request->transaction_start_date,
                'transaction_end_date' => $request->transaction_end_date,
                'transaction_type' => $request->transaction_type,
                'transaction_status' => $request->transaction_status ?? 'OPEN',
                'transaction_image_start' => $request->transaction_image_start,
                'transaction_image_finish' => $request->transaction_image_finish,
                'creator_id' => $currentUserId,
            ]);

            if ($request->has('items')) {
                $transaction->items()->attach($request->items);
            }

            DB::commit();
            return response()->json(['message' => 'Transaksi berhasil dibuat', 'data' => $transaction], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Gagal simpan transaksi: ' . $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $transaction = Transaction::with(['entity', 'items'])->find($id);

        if (!$transaction) {
            return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
        }

        return response()->json($transaction);
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
        }

        $transaction->update($request->except(['id', 'creator_id']));

        // Update relasi item menggunakan sync
        if ($request->has('items')) {
            $transaction->items()->sync($request->items);
        }

        return response()->json(['message' => 'Transaksi berhasil diperbarui', 'data' => $transaction]);
    }

    public function destroy($id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
        }

        try {
            DB::beginTransaction();
            $transaction->items()->detach();
            $transaction->delete();
            DB::commit();

            return response()->json(['message' => 'Transaksi berhasil dihapus']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Gagal hapus transaksi'], 500);
        }
    }
}
