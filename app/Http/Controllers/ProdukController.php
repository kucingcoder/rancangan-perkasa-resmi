<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Stok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Drivers\Gd\Encoders\WebpEncoder;
use Intervention\Image\ImageManager;

class ProdukController extends Controller
{
    public function index()
    {
        $Produk = Produk::where('status', 'aktif')->get();
        $Stok = Stok::where('status', 'aktif')->get();

        $data = [
            'Produk' => $Produk,
            'Stok' => $Stok
        ];

        return view('Produk', $data);
    }

    public function tambah(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'foto' => 'required|image|mimes:jpeg,png,jpg',
            'deskripsi' => 'required',
            'isi' => 'required',
            'satuan' => 'required',
            'modal_produk' => 'required',
            'harga' => 'required',
            'biaya_sales' => 'required',
            'stok_id' => 'required',
        ]);

        $cek_produk = Produk::where('nama', $request->input('nama'))->where('status', 'aktif')->first();

        if ($cek_produk) {
            return back()->withErrors('Produk sudah ada');
        }

        $produk = new Produk;
        $produk->nama = $request->input('nama');
        $produk->deskripsi = $request->input('deskripsi');
        $produk->isi = $request->input('isi');
        $produk->satuan = $request->input('satuan');
        $produk->modal = $request->input('modal_produk');
        $produk->harga = $request->input('harga');
        $produk->biaya_sales = $request->input('biaya_sales');
        $produk->stok_id = $request->input('stok_id');

        if ($request->hasFile('foto')) {
            $image = $request->file('foto');
            $filename = md5(now());
            $lokasi_full = 'uploads/foto_produk/' . $filename . '.webp';

            $manager = new ImageManager(new Driver());
            $imageWebp = $manager->read($image->getPathname())->encode(new WebpEncoder());
            Storage::disk('public')->put($lokasi_full, $imageWebp);

            $produk->foto = $filename;
        } else {
            return back()->withErrors('Periksa kembali data anda');
        }

        try {
            $produk->save();
            return back()->with('success', 'Produk ' . $produk->nama . ' ditambahkan');
        } catch (\Throwable $th) {
            Log::error('ProdukController : ' . $th);
            return back()->withErrors('Periksa kembali data anda');
        }
    }

    public function edit(Request $request)
    {
        $request->validate([
            'id_edit' => 'required',
            'nama_edit' => 'required',
            'foto_edit' => 'nullable|image|mimes:jpeg,png,jpg',
            'deskripsi_edit' => 'required',
            'isi_edit' => 'required',
            'satuan_edit' => 'required',
            'modal_produk_edit' => 'required',
            'harga_edit' => 'required',
            'biaya_sales_edit' => 'required',
            'stok_id_edit' => 'required',
        ]);

        $produk = Produk::find($request->input('id_edit'));

        if (!$produk) {
            return redirect()->back()->withErrors('Produk tidak ditemukan.');
        }

        $produk->nama = $request->input('nama_edit');
        $produk->deskripsi = $request->input('deskripsi_edit');
        $produk->isi = $request->input('isi_edit');
        $produk->satuan = $request->input('satuan_edit');
        $produk->modal = $request->input('modal_produk_edit');
        $produk->harga = $request->input('harga_edit');
        $produk->biaya_sales = $request->input('biaya_sales_edit');
        $produk->stok_id = $request->input('stok_id_edit');

        if ($request->hasFile('foto_edit')) {
            $image = $request->file('foto_edit');
            $filename = md5(now());
            $lokasi_full = 'uploads/foto_produk/' . $filename . '.webp';

            $manager = new ImageManager(new Driver());
            $imageWebp = $manager->read($image->getPathname())->encode(new WebpEncoder());
            Storage::disk('public')->put($lokasi_full, $imageWebp);
            Storage::disk('public')->delete('uploads/foto_produk/' . $produk->foto . '.webp');

            $produk->foto = $filename;
        }

        try {
            $produk->save();
            return back()->with('success', 'Produk ' . $produk->nama . ' diubah');
        } catch (\Throwable $th) {
            Log::error('ProdukController : ' . $th);
            return back()->withErrors('Periksa kembali data anda');
        }
    }

    public function hapus(Request $request)
    {
        $produk = Produk::find($request->input('id_hapus'));

        if (!$produk) {
            return redirect()->back()->withErrors('Produk tidak ditemukan.');
        }

        $produk->status = 'nonaktif';
        $produk->updated_at = now();

        try {
            $produk->save();
            return back()->with('success', 'Produk ' . $produk->nama . ' dihapus');
        } catch (\Throwable $th) {
            Log::error('ProdukController : ' . $th);
            return back()->withErrors('Periksa kembali data anda');
        }
    }
}
