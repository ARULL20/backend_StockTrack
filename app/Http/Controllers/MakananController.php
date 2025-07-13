<?php

namespace App\Http\Controllers;

use App\Models\Makanan;
use Illuminate\Http\Request;

class MakananController extends Controller
{
    public function index()
{
    $makanan = Makanan::with('kategoriMakanan')->get();
    $makanan->transform(function ($item) {
        $item->gambar_url = $item->gambar ? asset('storage/' . $item->gambar) : null;
        return $item;
    });
    return response()->json($makanan);
}
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric',
            'kategori_makanan_id' => 'required|exists:kategori_makanan,id',
        ]);

        $makanan = Makanan::create($validated);

        return response()->json($makanan, 201);
    }

   public function show(Makanan $makanan)
    {
    $makanan->load('kategoriMakanan');
    $makanan->gambar_url = $makanan->gambar ? asset('storage/' . $makanan->gambar) : null;
    return response()->json($makanan);
    }
    public function update(Request $request, Makanan $makanan)
    {
        $validated = $request->validate([
            'nama' => 'sometimes|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'sometimes|numeric',
            'kategori_makanan_id' => 'sometimes|exists:kategori_makanan,id',
        ]);

        $makanan->update($validated);

        return response()->json($makanan);
    }

    public function destroy(Makanan $makanan)
    {
        $makanan->delete();

        return response()->json(['message' => 'Makanan deleted successfully']);
    }

    public function uploadGambar(Request $request, $id)
{
    $request->validate([
        'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $makanan = Makanan::findOrFail($id);

    if ($request->hasFile('gambar')) {
        $file = $request->file('gambar');
        $path = $file->store('gambar_makanan', 'public');

        $makanan->gambar = $path;
        $makanan->save();
    }

    return response()->json([
        'message' => 'Gambar makanan berhasil diupload.',
        'data' => $makanan
    ]);
}

}
