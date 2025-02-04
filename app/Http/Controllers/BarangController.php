<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::with('kategori')->get();
        $kategori = Kategori::all();

        $data = [
            'barang' => $barang,
            'kategori' => $kategori,
        ];

        return view('barang', $data);
    }

    public function tambah(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'required|integer',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $barang = new Barang();
        $barang->nama_barang = $request->input('nama_barang');
        $barang->kategori_id = $request->input('kategori');
        $barang->harga = $request->input('harga');
        $barang->stok = $request->input('stok');

        if ($request->hasFile('foto')) {
            $lokasi_full = $request->file('foto')->store('uploads/foto_barang', 'public');
            $barang->foto = basename($lokasi_full);
        }

        try {
            $barang->save();
            return back();
        } catch (\Throwable $th) {
            return back()->withErrors('Periksa kembali data anda');
        }
    }

    public function edit(Request $request)
    {
        $request->validate([
            'nama_barang_edit' => 'required|string|max:255',
            'kategori_edit' => 'required|integer',
            'harga_edit' => 'required|numeric|min:0',
            'stok_edit' => 'required|integer|min:0',
            'foto_edit' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $barang = Barang::find($request->input('id_edit'));

        if (!$barang) {
            return redirect()->back()->withErrors('Barang tidak ditemukan.');
        }

        $barang->nama_barang = $request->input('nama_barang_edit');
        $barang->kategori_id = $request->input('kategori_edit');
        $barang->harga = $request->input('harga_edit');
        $barang->stok = $request->input('stok_edit');

        if ($request->hasFile('foto_edit')) {
            if ($barang->foto) {
                Storage::disk('public')->delete('uploads/foto_barang/' . $barang->foto);
            }
            $lokasi_full = $request->file('foto_edit')->store('uploads/foto_barang', 'public');
            $barang->foto = basename($lokasi_full);
        }

        try {
            $barang->save();
            return back();
        } catch (\Throwable $th) {
            return back()->withErrors('Periksa kembali data anda');
        }
    }

    public function hapus(Request $request)
    {
        $barang = Barang::find($request->input('id_hapus'));

        if (!$barang) {
            return redirect()->back()->withErrors('Barang tidak ditemukan.');
        }

        if ($barang->foto) {
            Storage::disk('public')->delete('uploads/foto_barang/' . $barang->foto);
        }

        if ($barang->delete()) {
            return back();
        } else {
            return back()->withErrors('Periksa kembali data anda');
        }
    }
}
