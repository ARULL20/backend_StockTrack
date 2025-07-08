<?php

namespace App\Http\Controllers;

use App\Models\Makanan;
use Illuminate\Http\Request;

class MakananController extends Controller
{
    public function index()
    {
        return response()->json(Makanan::with('kategoriMakanan')->get());
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
        return response()->json($makanan->load('kategoriMakanan'));
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
}
