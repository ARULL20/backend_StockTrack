<?php

namespace App\Http\Controllers;

use App\Models\Minuman;
use Illuminate\Http\Request;

class MinumanController extends Controller
{
    public function index()
    {
        $minuman = Minuman::with('kategoriMinuman')->get();
        $minuman->transform(function ($item) {
            $item->gambar_url = $item->gambar ? asset('storage/' . $item->gambar) : null;
            return $item;
        });
        return response()->json($minuman);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric',
            'kategori_minuman_id' => 'required|exists:kategori_minuman,id',
        ]);

        $minuman = Minuman::create($validated);

        return response()->json($minuman, 201);
    }

    public function show(Minuman $minuman)
    {
        $minuman->load('kategoriMinuman');
        $minuman->gambar_url = $minuman->gambar ? asset('storage/' . $minuman->gambar) : null;
        return response()->json($minuman);
    }

    public function update(Request $request, Minuman $minuman)
    {
        $validated = $request->validate([
            'nama' => 'sometimes|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'sometimes|numeric',
            'kategori_minuman_id' => 'sometimes|exists:kategori_minuman,id',
        ]);

        $minuman->update($validated);

        return response()->json($minuman);
    }

    public function destroy(Minuman $minuman)
    {
        $minuman->delete();

        return response()->json(['message' => 'Minuman deleted successfully']);
    }

    public function uploadGambar(Request $request, $id)
    {
        $request->validate([
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $minuman = Minuman::findOrFail($id);

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $path = $file->store('gambar_minuman', 'public');

            $minuman->gambar = $path;
            $minuman->save();
        }

        return response()->json([
            'message' => 'Gambar minuman berhasil diupload.',
            'data' => $minuman
        ]);
    }
}
