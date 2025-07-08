<?php

namespace App\Http\Controllers;

use App\Models\KategoriBarang;
use Illuminate\Http\Request;

class KategoriBarangController extends Controller
{
    // Middleware auth di constructor (boleh pakai ini)
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    // GET: /api/kategori-barang
    public function index()
    {
        return response([
            'data' => KategoriBarang::all()
        ], 200);
    }

    // POST: /api/kategori-barang
    public function store(Request $request)
    {
        if ($request->user()->role !== 'admin') {
            return response(['message' => 'Forbidden'], 403);
        }

        $validated = $request->validate([
            'nama' => 'required|string',
            'deskripsi' => 'nullable|string',
        ]);

        $kategori = KategoriBarang::create($validated);

        return response([
            'message' => 'KategoriBarang created',
            'data' => $kategori
        ], 201);
    }

    // GET: /api/kategori-barang/{id}
    public function show($id)
    {
        $kategori = KategoriBarang::find($id);

        if (!$kategori) {
            return response(['message' => 'Not Found'], 404);
        }

        return response(['data' => $kategori], 200);
    }

    // PUT/PATCH: /api/kategori-barang/{id}
    public function update(Request $request, $id)
    {
        if ($request->user()->role !== 'admin') {
            return response(['message' => 'Forbidden'], 403);
        }

        $kategori = KategoriBarang::find($id);

        if (!$kategori) {
            return response(['message' => 'Not Found'], 404);
        }

        $validated = $request->validate([
            'nama' => 'required|string',
            'deskripsi' => 'nullable|string',
        ]);

        $kategori->update($validated);

        return response([
            'message' => 'KategoriBarang updated',
            'data' => $kategori
        ], 200);
    }

    // DELETE: /api/kategori-barang/{id}
    public function destroy(Request $request, $id)
    {
        if ($request->user()->role !== 'admin') {
            return response(['message' => 'Forbidden'], 403);
        }

        $kategori = KategoriBarang::find($id);

        if (!$kategori) {
            return response(['message' => 'Not Found'], 404);
        }

        $kategori->delete();

        return response(['message' => 'KategoriBarang deleted'], 200);
    }
}
