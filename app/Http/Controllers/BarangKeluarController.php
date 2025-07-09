<?php

namespace App\Http\Controllers;

use App\Models\BarangKeluar;
use App\Models\Barang;
use Illuminate\Http\Request;

class BarangKeluarController extends Controller
{
    public function index()
    {
        return response()->json(BarangKeluar::with('barang')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'barang_id' => 'required|exists:barang,id',
            'jumlah' => 'required|integer|min:1',
            'harga' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        $barang = Barang::findOrFail($validated['barang_id']);

        if ($barang->stok < $validated['jumlah']) {
            return response()->json(['message' => 'Stok barang tidak mencukupi.'], 400);
        }

        // Kurangi stok barang
        $barang->stok -= $validated['jumlah'];
        $barang->save();

        $barangKeluar = BarangKeluar::create($validated);

        return response()->json([
            'message' => 'Barang keluar berhasil dicatat.',
            'data' => $barangKeluar
        ], 201);
    }

    public function show(BarangKeluar $barangKeluar)
    {
        return response()->json($barangKeluar->load('barang'));
    }

    public function update(Request $request, $id)
{
    $barangKeluar = BarangKeluar::findOrFail($id);

    $request->validate([
        'barang_id' => 'required|exists:barang,id',
        'jumlah' => 'required|integer|min:1',
        'harga' => 'required|numeric|min:0',
        'keterangan' => 'nullable|string',
    ]);

    $barang = Barang::findOrFail($request->barang_id);

    // Rollback stok lama
    $barang->stok += $barangKeluar->jumlah;

    // Kurangi stok baru
    if ($barang->stok < $request->jumlah) {
        return response()->json(['message' => 'Stok barang tidak mencukupi untuk update.'], 400);
    }

    $barang->stok -= $request->jumlah;
    $barang->save();

    $barangKeluar->barang_id = $request->barang_id;
    $barangKeluar->jumlah = $request->jumlah;
    $barangKeluar->harga = $request->harga;
    $barangKeluar->keterangan = $request->keterangan; 
    $barangKeluar->save();

    return response()->json([
        'message' => 'Barang keluar berhasil diupdate.',
        'data' => $barangKeluar
        ]);
    }




    public function destroy(BarangKeluar $barangKeluar)
    {
        // Kembalikan stok barang yang dihapus (opsional)
        $barang = $barangKeluar->barang;
        $barang->stok += $barangKeluar->jumlah;
        $barang->save();

        $barangKeluar->delete();

        return response()->json(['message' => 'Barang keluar dihapus & stok dikembalikan.']);
    }
}
