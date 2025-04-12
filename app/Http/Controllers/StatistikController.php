<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Carbon\Carbon;

class StatistikController extends Controller
{
    public function index()
    {
        $tahunSekarang = Carbon::now()->year;
        $bulanSekarang = Carbon::now()->month;

        $BulanTahunList = Pesanan::selectRaw('DISTINCT YEAR(updated_at) AS tahun, MONTH(updated_at) AS bulan')
            ->orderByRaw('tahun DESC, bulan DESC')
            ->get();

        $tahunList = Pesanan::selectRaw('YEAR(updated_at) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        $data = [
            'tahunSekarang' => $tahunSekarang,
            'bulanSekarang' => $bulanSekarang,
            'tahunList' => $tahunList,
            'BulanTahunList' => $BulanTahunList
        ];

        return view('Statistik', $data);
    }

    public function DataOmzetHarian($tahun, $bulan)
    {
        $bulanSekarang = Carbon::now()->month;
        $tahunSekarang = Carbon::now()->year;

        if (!empty($bulan)) {
            $bulanSekarang = $bulan;
        }

        if (!empty($tahun)) {
            $tahunSekarang = $tahun;
        }

        $OmzetHarian = Pesanan::whereYear('updated_at', $tahunSekarang)
            ->whereMonth('updated_at', $bulanSekarang)
            ->where('status', 'selesai')
            ->get()
            ->groupBy(function ($item) {
                return $item->updated_at->format('d');
            })
            ->map(function ($group) {
                return $group->sum('pendapatan');
            })
            ->sortKeys();

        $data = [
            'labels' => $OmzetHarian->keys()->values(),
            'data' => $OmzetHarian->values()
        ];

        return response()->json($data);
    }

    public function DataOmzetBulanan($tahun)
    {
        $tahunSekarang = Carbon::now()->year;

        if (!empty($tahun)) {
            $tahunSekarang = $tahun;
        }

        $OmzetBulanan = Pesanan::whereYear('updated_at', $tahunSekarang)
            ->where('status', 'selesai')
            ->get()
            ->groupBy(function ($item) {
                return $item->updated_at->format('F');
            })
            ->map(function ($group) {
                return $group->sum('pendapatan');
            })
            ->sortKeys();

        $data = [
            'labels' => $OmzetBulanan->keys()->values(),
            'data' => $OmzetBulanan->values()
        ];

        return response()->json($data);
    }

    public function DataOmzetTahunan($tahunAwal, $tahunAkhir)
    {
        $OmzetTahunan = Pesanan::where('status', 'selesai')
            ->get()
            ->groupBy(function ($item) {
                return $item->updated_at->format('Y');
            })
            ->filter(function ($group, $tahun) use ($tahunAwal, $tahunAkhir) {
                return $tahun >= $tahunAwal && $tahun <= $tahunAkhir;
            })
            ->map(function ($group) {
                return $group->sum('pendapatan');
            })
            ->sortKeys();

        $data = [
            'labels' => $OmzetTahunan->keys()->values(),
            'data' => $OmzetTahunan->values()
        ];

        return response()->json($data);
    }

    public function DataLabaHarian($tahun, $bulan)
    {
        $bulanSekarang = Carbon::now()->month;
        $tahunSekarang = Carbon::now()->year;

        if (!empty($bulan)) {
            $bulanSekarang = $bulan;
        }

        if (!empty($tahun)) {
            $tahunSekarang = $tahun;
        }

        $OmzetHarian = Pesanan::whereYear('updated_at', $tahunSekarang)
            ->whereMonth('updated_at', $bulanSekarang)
            ->where('status', 'selesai')
            ->get()
            ->groupBy(function ($item) {
                return $item->updated_at->format('d');
            })
            ->map(function ($group) {
                return $group->sum('laba');
            })
            ->sortKeys();

        $data = [
            'labels' => $OmzetHarian->keys()->values(),
            'data' => $OmzetHarian->values()
        ];

        return response()->json($data);
    }

    public function DataLabaBulanan($tahun)
    {
        $tahunSekarang = Carbon::now()->year;

        if (!empty($tahun)) {
            $tahunSekarang = $tahun;
        }

        $OmzetBulanan = Pesanan::whereYear('updated_at', $tahunSekarang)
            ->where('status', 'selesai')
            ->get()
            ->groupBy(function ($item) {
                return $item->updated_at->format('F');
            })
            ->map(function ($group) {
                return $group->sum('laba');
            })
            ->sortKeys();

        $data = [
            'labels' => $OmzetBulanan->keys()->values(),
            'data' => $OmzetBulanan->values()
        ];

        return response()->json($data);
    }

    public function DataLabaTahunan($tahunAwal, $tahunAkhir)
    {
        $OmzetTahunan = Pesanan::where('status', 'selesai')
            ->get()
            ->groupBy(function ($item) {
                return $item->updated_at->format('Y');
            })
            ->filter(function ($group, $tahun) use ($tahunAwal, $tahunAkhir) {
                return $tahun >= $tahunAwal && $tahun <= $tahunAkhir;
            })
            ->map(function ($group) {
                return $group->sum('laba');
            })
            ->sortKeys();

        $data = [
            'labels' => $OmzetTahunan->keys()->values(),
            'data' => $OmzetTahunan->values()
        ];

        return response()->json($data);
    }
}
