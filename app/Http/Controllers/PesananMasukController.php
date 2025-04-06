<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\BiayaKirim;
use App\Models\DaftarProduk;
use App\Models\Ekspedisi;
use App\Models\Keranjang;
use App\Models\Pembeli;
use App\Models\Pengiriman;
use App\Models\Pesanan;
use App\Models\Stok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Response;

class PesananMasukController extends Controller
{
    public function index()
    {
        $pesanan = Pesanan::orderBy('created_at', 'desc')->get();

        $data = [
            'pesanan' => $pesanan
        ];

        return view('PesananMasuk', $data);
    }

    public function detail($id)
    {
        $pesanan = Pesanan::with('keranjang')->where('id', $id)->first();

        if (!$pesanan) {
            return back()->withErrors('Pesanan tidak ditemukan');
        }

        $dafter_produk = DaftarProduk::where('keranjang_id', $pesanan->keranjang_id)->get();
        $pengiriman = Pengiriman::where('id', $pesanan->pengiriman_id)->first();
        $pembeli = Pembeli::where('id', $pesanan->keranjang->pembeli_id)->first();
        $sales = Akun::where('id', $pesanan->keranjang->akun_id)->first();

        $ekspedisi = Ekspedisi::where('status', 'aktif')->get();
        $biaya_kirim = BiayaKirim::where('status', 'aktif')->get();

        $data = [
            'pesanan' => $pesanan,
            'daftar_produk' => $dafter_produk,
            'pengiriman' => $pengiriman,
            'pembeli' => $pembeli,
            'sales' => $sales,
            'ekspedisi' => $ekspedisi,
            'biaya_kirim' => $biaya_kirim
        ];

        return view('PesananMasukDetail', $data);
    }

    public function BuatSkemaPengiriman($id, Request $request)
    {
        $request->validate([
            'nama_kurir' => 'required',
            'no_wa_kurir' => 'required',
            'foto_kurir' => 'required|image|mimes:jpeg,png,jpg',
            'ekspedisi_id' => 'required',
            'biaya_kirim_id' => 'required',
            'alamat_tujuan' => 'required',
            'jumlah_pengiriman' => 'required',
        ]);

        $pesanan = Pesanan::where('id', $id)->where('status', 'diperiksa')->first();

        if (!$pesanan) {
            return back()->withErrors('Pesanan tidak ditemukan');
        }

        $pengiriman = new Pengiriman();
        $pengiriman->nama_kurir = $request->input('nama_kurir');
        $pengiriman->no_wa_kurir = $request->input('no_wa_kurir');
        $pengiriman->ekspedisi_id = $request->input('ekspedisi_id');
        $pengiriman->biaya_kirim_id = $request->input('biaya_kirim_id');
        $pengiriman->alamat_tujuan = $request->input('alamat_tujuan');
        $pengiriman->jumlah_pengiriman = $request->input('jumlah_pengiriman');

        $biaya_kirim = BiayaKirim::where('id', $pengiriman->biaya_kirim_id)->first();

        try {
            $lokasi_full = $request->file('foto_kurir')->store('uploads/foto_orang', 'public');
            $pengiriman->foto_kurir = basename($lokasi_full);
            $pengiriman->save();

            $pesanan->pengiriman_id = $pengiriman->id;
            $pesanan->biaya_pengiriman = $biaya_kirim->nominal * $pengiriman->jumlah_pengiriman;
            $pesanan->updated_at = now();
            $pesanan->save();

            return back()->with('success', 'Skema pengiriman berhasil dibuat');
        } catch (\Throwable $th) {
            Log::error('PengirimanController : ' . $th);
            return back()->withErrors('Skema pengiriman gagal dibuat');
        }
    }

    public function EditSkemaPengiriman($id, Request $request)
    {
        $request->validate([
            'nama_kurir_edit' => 'required',
            'no_wa_kurir_edit' => 'required',
            'foto_kurir_edit' => 'nullable|image|mimes:jpeg,png,jpg',
            'ekspedisi_id_edit' => 'required',
            'biaya_kirim_id_edit' => 'required',
            'alamat_tujuan_edit' => 'required',
            'jumlah_pengiriman_edit' => 'required',
        ]);

        $pesanan = Pesanan::where('id', $id)->where('status', 'diperiksa')->orWhere('status', 'diterima')->first();

        if (!$pesanan) {
            return back()->withErrors('Pesanan tidak ditemukan');
        }

        $pengiriman = Pengiriman::where('id', $pesanan->pengiriman_id)->first();

        $pengiriman->nama_kurir = $request->input('nama_kurir_edit');
        $pengiriman->no_wa_kurir = $request->input('no_wa_kurir_edit');
        $pengiriman->ekspedisi_id = $request->input('ekspedisi_id_edit');
        $pengiriman->biaya_kirim_id = $request->input('biaya_kirim_id_edit');
        $pengiriman->alamat_tujuan = $request->input('alamat_tujuan_edit');
        $pengiriman->jumlah_pengiriman = $request->input('jumlah_pengiriman_edit');

        if ($request->hasFile('foto_kurir_edit')) {
            $lokasi_full = $request->file('foto_kurir_edit')->store('uploads/foto_orang', 'public');
            Storage::disk('public')->delete('uploads/foto_orang/' . $pengiriman->foto_kurir);
            $pengiriman->foto_kurir = basename($lokasi_full);
        }

        $biaya_kirim = BiayaKirim::where('id', $pengiriman->biaya_kirim_id)->first();

        $pengiriman->updated_at = now();

        $pesanan->biaya_pengiriman = $biaya_kirim->nominal * $pengiriman->jumlah_pengiriman;
        $pesanan->updated_at = now();

        try {
            $pengiriman->save();
            $pesanan->save();
            return back()->with('success', 'Skema pengiriman berhasil diubah');
        } catch (\Throwable $th) {
            Log::error('PengirimanController : ' . $th);
            return back()->withErrors('Skema pengiriman gagal diubah');
        }
    }

    public function CetakNotaPembeli($id)
    {
        $pesanan = Pesanan::where('id', $id)->first();

        if (!$pesanan) {
            return back()->withErrors('Pesanan tidak ditemukan');
        }

        $keranjang = Keranjang::where('id', $pesanan->keranjang_id)->first();
        $sales = Akun::where('id', $keranjang->akun_id)->first();
        $pembeli = Pembeli::where('id', $keranjang->pembeli_id)->first();

        $daftar_produk = DaftarProduk::with('produk')
            ->where('keranjang_id', $pesanan->keranjang_id)
            ->orderBy('updated_at', 'desc')
            ->get();

        $pengiriman = Pengiriman::with('biaya_kirim')->where('id', $pesanan->pengiriman_id)->first();

        $pendapatan = 0;
        $laba = 0;

        foreach ($daftar_produk as $item) {
            $pendapatan += $item->jumlah * $item->produk->harga;
            $laba +=  $item->jumlah * ($item->produk->harga - $item->produk->modal - $item->produk->biaya_sales);
        }

        $pendapatan += $pesanan->biaya_pengiriman;

        $nama = md5(now());

        $data = [
            'pesanan' => $pesanan,
            'daftar_produk' => $daftar_produk,
            'pengiriman' => $pengiriman,
            'sales' => $sales,
            'pembeli' => $pembeli
        ];

        $pdf = PDF::loadView('NotaPembeli', $data)->setPaper('a6', 'portrait');

        try {
            if ($pesanan->nota_pembeli) {
                Storage::disk('public')->delete("uploads/nota_pembeli/{$pesanan->nota_pembeli}.pdf");
            }
            Storage::disk('public')->put("uploads/nota_pembeli/{$nama}.pdf", $pdf->output());

            $pesanan->nota_pembeli = $nama;
            $pesanan->pendapatan = $pendapatan;
            $pesanan->laba = $laba;
            $pesanan->status = 'diterima';
            $pesanan->updated_at = now();
            $pesanan->save();

            $pesan = "Halo, kami dari Rancangan Perkasa\n\n";
            $pesan .= "Pesanan anda bernama *$keranjang->judul* telah *DITERIMA*\n";
            $pesan .= "Anda sudah bisa download nota pembelian yang sah\n\n";
            $pesan .= "Jika anda ingin membatalkan pesanan atau menanyakan hal - hal terkait pesanan silahkan hubungi admin\n";
            $pesan .= "Terima kasih telah menggunakan layanan kami";

            $pesan_terenkripsi = urlencode($pesan);
            $nomor_wa = "62" . substr($sales->no_wa, 1);

            $link = "https://wa.me/$nomor_wa?text=$pesan_terenkripsi";

            session()->flash('link', $link);
            session()->flash('judul', $keranjang->judul);


            return back()->with('pesan', 'Pesanan berhasil diperiksa');
        } catch (\Throwable $th) {
            Log::error('PesananController : ' . $th);
        }
    }

    public function DownloadNotaPembeli($id)
    {
        $pesanan = Pesanan::where('id', $id)->whereNotIn('status', ['diperiksa', 'ditolak'])->first();

        if (!$pesanan) {
            return back()->withErrors('Pesanan tidak ditemukan');
        }

        if (!$pesanan->nota_pembeli) {
            return back()->withErrors('Nota pembeli tidak ditemukan');
        }

        return response()->download(storage_path("app/public/uploads/nota_pembeli/{$pesanan->nota_pembeli}.pdf"));
    }

    public function DownloadNotaKurir($id)
    {
        $pesanan = Pesanan::where('id', $id)->whereNotIn('status', ['diperiksa', 'diterima', 'ditolak'])->first();

        if (!$pesanan) {
            return back()->withErrors('Pesanan tidak ditemukan');
        }

        if (!$pesanan->nota_kurir) {
            return back()->withErrors('Nota kurir tidak ditemukan');
        }

        return response()->download(storage_path("app/public/uploads/nota_kurir/{$pesanan->nota_kurir}.pdf"));
    }

    public function DownloadLaporanSales($id)
    {
        $pesanan = Pesanan::where('id', $id)->whereNotIn('status', ['diperiksa', 'diterima', 'ditolak'])->first();

        if (!$pesanan) {
            return back()->withErrors('Pesanan tidak ditemukan');
        }

        if (!$pesanan->laporan_sales) {
            return back()->withErrors('Laporan sales tidak ditemukan');
        }

        return response()->download(storage_path("app/public/uploads/laporan_sales/{$pesanan->laporan_sales}.pdf"));
    }

    public function DownloadLaporanInternal($id)
    {
        $pesanan = Pesanan::where('id', $id)->whereNotIn('status', ['diperiksa', 'diterima', 'ditolak'])->first();

        if (!$pesanan) {
            return back()->withErrors('Pesanan tidak ditemukan');
        }

        if (!$pesanan->laporan_internal) {
            return back()->withErrors('Laporan internal tidak ditemukan');
        }

        return response()->download(storage_path("app/public/uploads/laporan_internal/{$pesanan->laporan_internal}.pdf"));
    }

    public function Proses($id, Request $request)
    {
        $request->validate([
            'bukti_pelunasan' => 'required|image|mimes:jpeg,png,jpg',
        ]);

        $pesanan = Pesanan::where('id', $id)->where('status', 'diterima')->first();

        if (!$pesanan) {
            return back()->withErrors('Pesanan tidak ditemukan');
        }

        $daftar_produk = DaftarProduk::with('produk')
            ->with('produk.stok')
            ->where('keranjang_id', $pesanan->keranjang_id)
            ->orderBy('updated_at', 'desc')
            ->get();

        foreach ($daftar_produk as $item) {
            if ($item->produk->stok->jumlah / $item->produk->isi < $item->jumlah) {
                return back()->withErrors('Stok ' . $item->produk->nama . ' tidak mencukupi');
            }
        }

        $keranjang = Keranjang::where('id', $pesanan->keranjang_id)->first();
        $sales = Akun::where('id', $keranjang->akun_id)->first();
        $pembeli = Pembeli::where('id', $keranjang->pembeli_id)->first();

        $pengiriman = Pengiriman::with('biaya_kirim')->where('id', $pesanan->pengiriman_id)->first();

        $nama = md5(now());

        $data = [
            'pesanan' => $pesanan,
            'daftar_produk' => $daftar_produk,
            'pengiriman' => $pengiriman,
            'sales' => $sales,
            'pembeli' => $pembeli
        ];

        $nota_pembeli = PDF::loadView('NotaPembeliLunas', $data)->setPaper('a6', 'portrait');
        $nota_kurir = PDF::loadView('NotaKurir', $data)->setPaper('a6', 'portrait');
        $laporan_internal = PDF::loadView('LaporanInternal', $data)->setPaper('a4', 'portrait');
        $laporan_sales = PDF::loadView('LaporanSales', $data)->setPaper('a4', 'portrait');

        try {
            if ($pesanan->nota_pembeli) {
                Storage::disk('public')->delete("uploads/nota_pembeli/{$pesanan->nota_pembeli}.pdf");
            }
            Storage::disk('public')->put("uploads/nota_pembeli/{$nama}.pdf", $nota_pembeli->output());
            Storage::disk('public')->put("uploads/nota_kurir/{$nama}.pdf", $nota_kurir->output());
            Storage::disk('public')->put("uploads/laporan_internal/{$nama}.pdf", $laporan_internal->output());
            Storage::disk('public')->put("uploads/laporan_sales/{$nama}.pdf", $laporan_sales->output());

            $lokasi_full = $request->file('bukti_pelunasan')->store('uploads/bukti_pelunasan', 'public');
            $pesanan->bukti_pelunasan = basename($lokasi_full);
            $pesanan->nota_pembeli = $nama;
            $pesanan->nota_kurir = $nama;
            $pesanan->laporan_internal = $nama;
            $pesanan->laporan_sales = $nama;
            $pesanan->status = 'diproses';
            $pesanan->updated_at = now();
            $pesanan->save();

            foreach ($daftar_produk as $item) {
                $stok = Stok::where('id', $item->produk->stok->id)->first();
                $stok->jumlah -= $item->jumlah * $item->produk->isi;
                $stok->updated_at = now();
                $stok->save();
            }

            $pesan = "Halo, kami dari Rancangan Perkasa\n\n";
            $pesan .= "Pesanan anda bernama *$keranjang->judul* telah *DIPROSES*\n";
            $pesan .= "Anda sudah bisa download ulang nota pembelian yang sah\n\n";
            $pesan .= "Jika anda ingin membatalkan pesanan atau menanyakan hal - hal terkait pesanan silahkan hubungi admin\n";
            $pesan .= "Terima kasih telah menggunakan layanan kami";

            $pesan_terenkripsi = urlencode($pesan);
            $nomor_wa = "62" . substr($sales->no_wa, 1);

            $link = "https://wa.me/$nomor_wa?text=$pesan_terenkripsi";

            session()->flash('link', $link);
            session()->flash('judul', $keranjang->judul);

            return back()->with('diproses', 'Pesanan berhasil diproses');
        } catch (\Throwable $th) {
            Log::error('PesananController : ' . $th);
            return back()->withErrors('Gagal memproses pesanan');
        }
    }

    public function Kirim($id)
    {
        $pesanan = Pesanan::where('id', $id)->where('status', 'diproses')->first();

        if (!$pesanan) {
            return back()->withErrors('Pesanan tidak ditemukan');
        }

        $pesanan->status = 'dikirim';
        $pesanan->updated_at = now();

        try {
            $pesanan->save();
            return back()->with('success', 'Pesanan berhasil dikirim');
        } catch (\Throwable $th) {
            Log::error('PesananController : ' . $th);
            return back()->withErrors('Pesanan gagal dikirim');
        }
    }

    public function Selesai($id, Request $request)
    {
        $request->validate([
            'foto_bukti' => 'required|image|mimes:jpeg,png,jpg',
        ]);

        $pesanan = Pesanan::where('id', $id)->where('status', 'dikirim')->first();

        if (!$pesanan) {
            return back()->withErrors('Pesanan tidak ditemukan');
        }

        $pengiriman = Pengiriman::where('id', $pesanan->pengiriman_id)->first();

        try {
            $lokasi_full = $request->file('foto_bukti')->store('uploads/bukti_pengiriman', 'public');
            $pengiriman->foto_bukti = basename($lokasi_full);
            $pengiriman->updated_at = now();
            $pengiriman->save();

            $pesanan->status = 'selesai';
            $pesanan->updated_at = now();
            $pesanan->save();
            return back()->with('success', 'Pesanan berhasil selesai');
        } catch (\Throwable $th) {
            Log::error('PesananController : ' . $th);
            return back()->withErrors('Pesanan gagal selesai');
        }
    }

    public function Tolak($id, Request $request)
    {
        $request->validate([
            'alasan' => 'required'
        ]);

        $alasan = $request->input('alasan');

        $pesanan = Pesanan::where('id', $id)->whereNotIn('status', ['ditolak', 'selesai'])->first();

        if (!$pesanan) {
            return back()->withErrors('Pesanan tidak ditemukan');
        }

        $pesanan->status = 'ditolak';
        $pesanan->alasan_ditolak = $alasan;
        $pesanan->updated_at = now();

        try {
            $pesanan->save();
            return back()->with('success', 'Pesanan berhasil ditolak');
        } catch (\Throwable $th) {
            Log::error('PesananController : ' . $th);
            return back()->withErrors('Pesanan gagal ditolak');
        }
    }

    public function DownloadFotoKurir($id)
    {
        $pesanan = Pesanan::with('pengiriman')->where('id', $id)->whereNotIn('status', ['diperiksa'])->first();

        if (!$pesanan) {
            return back()->withErrors('Pesanan tidak ditemukan');
        }

        if (!$pesanan->pengiriman->foto_kurir) {
            return back()->withErrors('Foto kurir tidak ditemukan');
        }

        return response()->download(storage_path("app/public/uploads/foto_orang/{$pesanan->pengiriman->foto_kurir}"));
    }

    public function DownloadBuktiPembayaran($id)
    {
        $pesanan = Pesanan::where('id', $id)->whereNotIn('status', ['diperiksa', 'diterima', 'ditolak'])->first();

        if (!$pesanan) {
            return back()->withErrors('Pesanan tidak ditemukan');
        }

        if (!$pesanan->bukti_pelunasan) {
            return back()->withErrors('Foto bukti pembayaran tidak ditemukan');
        }

        return response()->download(storage_path("app/public/uploads/bukti_pelunasan/{$pesanan->bukti_pelunasan}"));
    }

    public function DownloadBuktiPengiriman($id)
    {
        $pesanan = Pesanan::with('pengiriman')->where('id', $id)->where('status', 'selesai')->first();

        if (!$pesanan) {
            return back()->withErrors('Pesanan tidak ditemukan');
        }

        if (!$pesanan->pengiriman->foto_bukti) {
            return back()->withErrors('Foto bukti pengiriman tidak ditemukan');
        }

        return response()->download(storage_path("app/public/uploads/bukti_pengiriman/{$pesanan->pengiriman->foto_bukti}"));
    }
}
