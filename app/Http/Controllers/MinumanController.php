<?php

namespace App\Http\Controllers;

use App\Models\Minuman;
use Illuminate\Http\Request;

class MinumanController extends Controller
{
    public function index()
    {
        return Minuman::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric',
            'kategori_minuman_id' => 'required|exists:kategori_minuman,id',
        ]);

        return Minuman::create($request->all());
    }

    public function show($id)
    {
        return Minuman::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $minuman = Minuman::findOrFail($id);

        $request->validate([
            'nama' => 'string',
            'deskripsi' => 'nullable|string',
            'harga' => 'numeric',
            'kategori_minuman_id' => 'exists:kategori_minuman,id',
        ]);

        $minuman->update($request->all());

        return $minuman;
    }

    public function destroy($id)
    {
        $minuman = Minuman::findOrFail($id);
        $minuman->delete();

        return response()->json(['message' => 'Minuman deleted']);
    }
}
