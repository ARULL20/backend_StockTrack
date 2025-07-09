<?php

namespace App\Http\Controllers;

use App\Models\Gudang;
use Illuminate\Http\Request;

class GudangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        return response(['data' => Gudang::all()], 200);
    }

    public function store(Request $request)
    {
        if (!in_array($request->user()->role, ['admin', 'pegawai'])) {
            return response(['message' => 'Forbidden'], 403);
        }

        $validated = $request->validate([
            'nama' => 'required|string',
            'lokasi' => 'nullable|string',
            'deskripsi' => 'nullable|string',
        ]);

        $gudang = Gudang::create($validated);

        return response(['message' => 'Gudang created', 'data' => $gudang], 201);
    }

    public function show($id)
    {
        $gudang = Gudang::find($id);
        if (!$gudang) {
            return response(['message' => 'Not Found'], 404);
        }
        return response(['data' => $gudang], 200);
    }

    public function update(Request $request, $id)
    {
        if (!in_array($request->user()->role, ['admin', 'pegawai'])) {
            return response(['message' => 'Forbidden'], 403);
        }

        $gudang = Gudang::find($id);
        if (!$gudang) {
            return response(['message' => 'Not Found'], 404);
        }

        $validated = $request->validate([
            'nama' => 'required|string',
            'lokasi' => 'nullable|string',
            'deskripsi' => 'nullable|string',
        ]);

        $gudang->update($validated);

        return response(['message' => 'Gudang updated', 'data' => $gudang], 200);
    }

    public function destroy(Request $request, $id)
    {
        if (!in_array($request->user()->role, ['admin', 'pegawai'])) {
            return response(['message' => 'Forbidden'], 403);
        }

        $gudang = Gudang::find($id);
        if (!$gudang) {
            return response(['message' => 'Not Found'], 404);
        }

        $gudang->delete();
        return response(['message' => 'Gudang deleted'], 200);
    }
}
