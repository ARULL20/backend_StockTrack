<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $barang = Barang::with(['kategoriBarang', 'gudang'])->get();
        return response()->json($barang);
    }

    public function store(Request $request)
    {
        if ($request->user()->role !== 'admin') {
            return response(['message' => 'Forbidden'], 403);
        }

        $validated = $request->validate([
            'nama' => 'required|string',
            'deskripsi' => 'nullable|string',
            'stok' => 'required|integer',
            'harga' => 'required|numeric',
            'kategori_barang_id' => 'required|exists:kategori_barang,id',
            'gudang_id' => 'required|exists:gudangs,id',
        ]);

        $barang = Barang::create($validated);

        return response()->json(['message' => 'Barang created', 'data' => $barang], 201);
    }

    public function show($id)
    {
        $barang = Barang::with(['kategoriBarang', 'gudang'])->find($id);

        if (!$barang) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        return response()->json($barang);
    }

    public function update(Request $request, $id)
    {
        if ($request->user()->role !== 'admin') {
            return response(['message' => 'Forbidden'], 403);
        }

        $barang = Barang::find($id);

        if (!$barang) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        $validated = $request->validate([
            'nama' => 'required|string',
            'deskripsi' => 'nullable|string',
            'stok' => 'required|integer',
            'harga' => 'required|numeric',
            'kategori_barang_id' => 'required|exists:kategori_barang,id',
            'gudang_id' => 'required|exists:gudangs,id',
        ]);

        $barang->update($validated);

        return response()->json(['message' => 'Barang updated', 'data' => $barang]);
    }

    public function destroy(Request $request, $id)
    {
        if ($request->user()->role !== 'admin') {
            return response(['message' => 'Forbidden'], 403);
        }

        $barang = Barang::find($id);

        if (!$barang) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        $barang->delete();

        return response()->json(['message' => 'Barang deleted']);
    }

    public function uploadGambar(Request $request, $id)
    {
        $request->validate([
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $barang = Barang::findOrFail($id);

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $path = $file->store('gambar_barang', 'public');

            $barang->gambar = $path;
            $barang->save();
        }

        return response()->json([
            'message' => 'Gambar berhasil diupload.',
            'data' => $barang
        ]);
    }

   public function stokTipis()
{
    $barangStokTipis = Barang::where('stok', '<', 5)->get();

    return response()->json([
        'status' => true,
        'data' => $barangStokTipis,
    ]);
}
}
