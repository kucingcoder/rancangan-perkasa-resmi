<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Carbon\Carbon;

class StatistikController extends Controller
{
    public function index()
    {
        $tahunSekarang = Carbon::now()->year;
        $tahunList = Pesanan::selectRaw('YEAR(updated_at) as tahun')
            ->distinct()
            ->orderBy('tahun')
            ->pluck('tahun');

        $data = [
            'tahunSekarang' => $tahunSekarang,
            'tahunList' => $tahunList,
        ];

        return view('Statistik', $data);
    }

    public function DataOmzet($tahun)
    {
        $tahunSekarang = Carbon::now()->year;

        if (!empty($tahun)) {
            $tahunSekarang = $tahun;
        }

        $tahunAwal = $tahunSekarang - 9;

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

        $OmzetTahunan = Pesanan::all()
            ->where('status', 'selesai')
            ->groupBy(function ($item) {
                return $item->updated_at->format('Y');
            })
            ->filter(function ($group, $tahun) use ($tahunAwal) {
                return $tahun >= $tahunAwal;
            })
            ->map(function ($group) {
                return $group->sum('pendapatan');
            })
            ->sortKeys();

        $data = [
            'omzet_bulanan' => [
                'labels' => $OmzetBulanan->keys()->values(),
                'data' => $OmzetBulanan->values()
            ],
            'omzet_tahunan' => [
                'labels' => $OmzetTahunan->keys()->values(),
                'data' => $OmzetTahunan->values()
            ]
        ];

        return response()->json($data);
    }

    public function DataLaba($tahun)
    {
        $tahunSekarang = Carbon::now()->year;

        if (!empty($tahun)) {
            $tahunSekarang = $tahun;
        }

        $tahunAwal = $tahunSekarang - 9;

        $LabaBulanan = Pesanan::whereYear('updated_at', $tahunSekarang)
            ->where('status', 'selesai')
            ->get()
            ->groupBy(function ($item) {
                return $item->updated_at->format('F');
            })
            ->map(function ($group) {
                return $group->sum('laba');
            })
            ->sortKeys();

        $LabaTahunan = Pesanan::all()
            ->where('status', 'selesai')
            ->groupBy(function ($item) {
                return $item->updated_at->format('Y');
            })
            ->filter(function ($group, $tahun) use ($tahunAwal) {
                return $tahun >= $tahunAwal;
            })
            ->map(function ($group) {
                return $group->sum('laba');
            })
            ->sortKeys();

        $data = [
            'laba_bulanan' => [
                'labels' => $LabaBulanan->keys()->values(),
                'data' => $LabaBulanan->values()
            ],
            'laba_tahunan' => [
                'labels' => $LabaTahunan->keys()->values(),
                'data' => $LabaTahunan->values()
            ]
        ];

        return response()->json($data);
    }
}
