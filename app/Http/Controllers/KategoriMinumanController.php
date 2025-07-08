<?php

namespace App\Http\Controllers;

use App\Models\KategoriMinuman;
use Illuminate\Http\Request;

class KategoriMinumanController extends Controller
{
    public function index()
    {
        return response()->json(KategoriMinuman::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $kategoriMinuman = KategoriMinuman::create($validated);

        return response()->json($kategoriMinuman, 201);
    }

    public function show($id)
    {
        $kategoriMinuman = KategoriMinuman::findOrFail($id);
        return response()->json($kategoriMinuman);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $kategoriMinuman = KategoriMinuman::findOrFail($id);
        $kategoriMinuman->update($validated);

        return response()->json($kategoriMinuman);
    }

    public function destroy($id)
    {
        $kategoriMinuman = KategoriMinuman::findOrFail($id);
        $kategoriMinuman->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
