<?php

namespace App\Http\Controllers;

use App\Models\KategoriMakanan;
use Illuminate\Http\Request;

class KategoriMakananController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    // GET: /api/kategori-makanan
    public function index()
    {
        return response([
            'data' => KategoriMakanan::all()
        ], 200);
    }

    // POST: /api/kategori-makanan
    public function store(Request $request)
    {
        if (!in_array($request->user()->role, ['admin', 'pegawai'])) {
            return response(['message' => 'Forbidden'], 403);
        }

        $validated = $request->validate([
            'nama' => 'required|string',
            'deskripsi' => 'nullable|string',
        ]);

        $kategori = KategoriMakanan::create($validated);

        return response([
            'message' => 'KategoriMakanan created',
            'data' => $kategori
        ], 201);
    }

    // GET: /api/kategori-makanan/{id}
    public function show($id)
    {
        $kategori = KategoriMakanan::find($id);

        if (!$kategori) {
            return response(['message' => 'Not Found'], 404);
        }

        return response(['data' => $kategori], 200);
    }

    // PUT/PATCH: /api/kategori-makanan/{id}
    public function update(Request $request, $id)
    {
        if (!in_array($request->user()->role, ['admin', 'pegawai'])) {
            return response(['message' => 'Forbidden'], 403);
        }

        $kategori = KategoriMakanan::find($id);

        if (!$kategori) {
            return response(['message' => 'Not Found'], 404);
        }

        $validated = $request->validate([
            'nama' => 'required|string',
            'deskripsi' => 'nullable|string',
        ]);

        $kategori->update($validated);

        return response([
            'message' => 'KategoriMakanan updated',
            'data' => $kategori
        ], 200);
    }

    // DELETE: /api/kategori-makanan/{id}
    public function destroy(Request $request, $id)
    {
        if (!in_array($request->user()->role, ['admin', 'pegawai'])) {
            return response(['message' => 'Forbidden'], 403);
        }

        $kategori = KategoriMakanan::find($id);

        if (!$kategori) {
            return response(['message' => 'Not Found'], 404);
        }

        $kategori->delete();

        return response(['message' => 'KategoriMakanan deleted'], 200);
    }
}
