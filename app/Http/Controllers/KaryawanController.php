<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawan = Karyawan::orderBy('nama', 'asc')->get();

        $data = [
            'karyawan' => $karyawan
        ];

        return view('Karyawan', $data);
    }

    public function Tambah(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required',
            'alamat' => 'required',
            'no_wa' => 'required',
            'foto' => 'required|image|mimes:jpeg,png,jpg',
            'gaji' => 'required',
            'deskripsi' => 'required',
        ]);

        $cek_nama = Karyawan::where('nama', $request->input('nama'))->first();
        if ($cek_nama) {
            return back()->withErrors('Karyawan ' . $request->input('nama') . ' sudah ada');
        }

        $cek_no_wa = Karyawan::where('no_wa', $request->input('no_wa'))->first();
        if ($cek_no_wa) {
            return back()->withErrors('No Wa ' . $request->input('no_wa') . ' sudah ada');
        }

        $karyawan = new Karyawan();
        $karyawan->nama = $request->input('nama');
        $karyawan->jenis_kelamin = $request->input('jenis_kelamin');
        $karyawan->tanggal_lahir = $request->input('tanggal_lahir');
        $karyawan->alamat = $request->input('alamat');
        $karyawan->no_wa = $request->input('no_wa');
        $karyawan->gaji = $request->input('gaji');
        $karyawan->deskripsi = $request->input('deskripsi');

        try {
            $lokasi_full = $request->file('foto')->store('uploads/foto_orang', 'public');
            $karyawan->foto = basename($lokasi_full);

            $karyawan->save();
            return back()->with('success', 'Karyawan ' . $karyawan->nama . ' berhasil ditambahkan');
        } catch (\Throwable $th) {
            Log::error('KaryawanController : ' . $th);
            return back()->withErrors('Periksa kembali data anda');
        }
    }

    public function Edit(Request $request)
    {
        $request->validate([
            'id_edit' => 'required',
            'nama_edit' => 'required',
            'jenis_kelamin_edit' => 'required',
            'tanggal_lahir_edit' => 'required',
            'alamat_edit' => 'required',
            'no_wa_edit' => 'required',
            'gaji_edit' => 'required',
            'foto_edit' => 'nullable|image|mimes:jpeg,png,jpg',
            'deskripsi_edit' => 'required',
        ]);

        $id = $request->input('id_edit');
        $karyawan = Karyawan::where('id', $id)->first();

        if (!$karyawan) {
            return redirect()->back()->withErrors('Karyawan tidak ditemukan.');
        }

        $karyawan->nama = $request->input('nama_edit');
        $karyawan->jenis_kelamin = $request->input('jenis_kelamin_edit');
        $karyawan->tanggal_lahir = $request->input('tanggal_lahir_edit');
        $karyawan->alamat = $request->input('alamat_edit');
        $karyawan->no_wa = $request->input('no_wa_edit');
        $karyawan->gaji = $request->input('gaji_edit');
        $karyawan->deskripsi = $request->input('deskripsi_edit');
        $karyawan->updated_at = now();

        if ($request->hasFile('foto_edit')) {
            $lokasi_full = $request->file('foto_edit')->store('uploads/foto_orang', 'public');
            Storage::disk('public')->delete('uploads/foto_orang/' . $karyawan->foto);
            $karyawan->foto = basename($lokasi_full);
        }

        try {
            $karyawan->save();
            return back()->with('success', 'Karyawan ' . $karyawan->nama . ' diubah');
        } catch (\Throwable $th) {
            Log::error('KaryawanController : ' . $th);
            return back()->withErrors('Periksa kembali data anda');
        }
    }

    public function UbahStatus(Request $request)
    {
        $id = $request->input('id_status');
        $karyawan = Karyawan::where('id', $id)->first();

        if (!$karyawan) {
            return redirect()->back()->withErrors('Karyawan tidak ditemukan.');
        }

        if ($karyawan->status == 'aktif') {
            $karyawan->status = 'nonaktif';
        } else {
            $karyawan->status = 'aktif';
        }

        $karyawan->updated_at = now();

        try {
            $karyawan->save();
            return back()->with('success', 'Status ' . $karyawan->nama . ' diubah');
        } catch (\Throwable $th) {
            Log::error('KaryawanController : ' . $th);
            return back()->withErrors('Periksa kembali data anda');
        }
    }
}
