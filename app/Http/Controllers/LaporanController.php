<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\BarangKeluar;
use Barryvdh\DomPDF\Facade\Pdf;


class LaporanController extends Controller
{
    /**
     * Menampilkan total pemasukan.
     * Hanya bisa diakses oleh admin (via middleware).
     */
    public function readPemasukanTotal()
    {
        // Contoh logika: total pemasukan dari semua barang = harga * stok
        $totalPemasukan = Barang::selectRaw('SUM(harga * stok) as total')->value('total');

        return response()->json([
            'status' => true,
            'total_pemasukan' => $totalPemasukan,
        ]);
    }

    /**
     * Menampilkan total pengeluaran.
     * Hanya bisa diakses oleh admin (via middleware).
     */
    public function readPengeluaranTotal()
    {
        //Contoh logika: total pengeluaran dari barang keluar = SUM(harga * jumlah)
       $totalPengeluaran = BarangKeluar::selectRaw('SUM(harga * jumlah) as total')->value('total');



        return response()->json([
            'status' => true,
            'total_pengeluaran' => $totalPengeluaran,
        ]);
    }

     public function exportPemasukanPDF()
    {
        $pemasukan = Barang::all();
        $total = Barang::selectRaw('SUM(harga * stok) as total')->value('total');

        $pdf = Pdf::loadView('pdf.pemasukan', compact('pemasukan', 'total'));
        return $pdf->download('laporan_pemasukan.pdf');
    }

    /**
     * Export Pengeluaran ke PDF
     */
    public function exportPengeluaranPDF()
    {
        $pengeluaran = BarangKeluar::with('barang')->get();
        $total = BarangKeluar::selectRaw('SUM(harga * jumlah) as total')->value('total');

        $pdf = Pdf::loadView('pdf.pengeluaran', compact('pengeluaran', 'total'));
        return $pdf->download('laporan_pengeluaran.pdf');
    }
}
