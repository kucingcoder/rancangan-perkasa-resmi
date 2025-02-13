<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Drivers\Gd\Encoders\WebpEncoder;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::with('kategori')->where('status', 'aktif')->orderBy('nama_barang', 'asc')->get();

        $kategori = Kategori::all();

        $data = [
            'barang' => $barang,
            'kategori' => $kategori,
        ];

        return view('Barang', $data);
    }

    public function tambah(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'required|integer',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'deskripsi' => 'required|string',
        ]);

        $cek_barang = Barang::where('nama_barang', $request->input('nama_barang'))->where('status', 'aktif')->first();

        if ($cek_barang) {
            return back()->withErrors('Barang ' . $request->input('nama_barang') . ' sudah ada');
        }

        $barang = new Barang();
        $barang->nama_barang = $request->input('nama_barang');
        $barang->kategori_id = $request->input('kategori');
        $barang->harga = $request->input('harga');
        $barang->stok = $request->input('stok');
        $barang->deskripsi = $request->input('deskripsi');

        if ($request->hasFile('foto')) {
            $image = $request->file('foto');
            $filename = md5(now());
            $lokasi_full = 'uploads/foto_barang/' . $filename . '.webp';

            $manager = new ImageManager(new Driver());
            $imageWebp = $manager->read($image->getPathname())->encode(new WebpEncoder());
            Storage::disk('public')->put($lokasi_full, $imageWebp);

            $barang->foto = $filename;
        } else {
            return back()->withErrors('Periksa kembali data anda');
        }

        try {
            $barang->save();
            return back()->with('success', 'Barang ' . $barang->nama_barang . ' tersimpan');
        } catch (\Throwable $th) {
            Log::error('KategoriController : ' . $th);
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
        $barang->deskripsi = $request->input('deskripsi_edit');

        if ($request->hasFile('foto_edit')) {
            try {
                $image = $request->file('foto_edit');
                $filename = md5(now());
                $lokasi_full = 'uploads/foto_barang/' . $filename . '.webp';

                $manager = new ImageManager(new Driver());
                $imageWebp = $manager->read($image->getPathname())->encode(new WebpEncoder());
                Storage::disk('public')->put($lokasi_full, $imageWebp);
                Storage::disk('public')->delete('uploads/foto_barang/' . $barang->foto . '.webp');
                $barang->foto = $filename;
            } catch (\Throwable $th) {
                Log::error('BarangController : ' . $th);
            }
        }

        $barang->updated_at = now();

        try {
            $barang->save();
            return back()->with('success', 'Barang ' . $barang->nama_barang . ' diubah');
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

        $barang->status = 'nonaktif';
        $barang->updated_at = now();

        try {
            $barang->save();
            return back()->with('success', 'Barang ' . $barang->nama_barang . ' dihapus');
        } catch (\Throwable $th) {
            Log::error('BarangController : ' . $th);
            return back()->withErrors('Periksa kembali data anda');
        }
    }
}
