@extends('layouts.App')
@section('title', 'Rancangan Perkasa | Statistik')

@section('content')
<h1 class="mt-8 text-2xl md:text-4xl font-bold">STATISTIK HARIAN</h1>

<?php
function getNamaBulan($noBulan)
{
    $namaBulan = [
        1 => "Januari",
        "Februari",
        "Maret",
        "April",
        "Mei",
        "Juni",
        "Juli",
        "Agustus",
        "September",
        "Oktober",
        "November",
        "Desember"
    ];

    return $namaBulan[(int)$noBulan] ?? "Bulan tidak valid";
}
?>

<div class="mt-4 w-full flex flex-col md:flex-row gap-4">
    <div class="bg-white rounded-2xl shadow-lg p-6 md:w-1/2 max-w-xl">
        <h2 class="text-2xl font-bold mb-4 text-center">Laba Harian</h2>
        <canvas id="laba_harian" class="w-full h-64"></canvas>
        <select onchange="getDataLaba(this.value)" class="mt-4 w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
            @foreach ($BulanTahunList as $item)
            <option value="{{$item}}">{{getNamaBulan($item->bulan) . " - " . $item->tahun}}</option>
            @endforeach
        </select>
    </div>

    <div class="bg-white rounded-2xl shadow-lg p-6 md:w-1/2 max-w-xl">
        <h2 class="text-2xl font-bold mb-4 text-center">Omzet Harian</h2>
        <canvas id="omzet_harian" class="w-full h-64"></canvas>
        <select onchange="getOmzetHarian(this.value)" class="mt-4 w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
            @foreach ($BulanTahunList as $item)
            <option value="{{$item}}">{{getNamaBulan($item->bulan) . " - " . $item->tahun}}</option>
            @endforeach
        </select>
    </div>
</div>

<h1 class="mt-16 text-2xl md:text-4xl font-bold">STATISTIK BULANAN</h1>
<div class="mt-4 w-full flex flex-col md:flex-row gap-4">
    <div class="bg-white rounded-2xl shadow-lg p-6 md:w-1/2 max-w-xl">
        <h2 class="text-2xl font-bold mb-4 text-center">Laba Bulanan</h2>
        <canvas id="laba_bulanan" class="w-full h-64"></canvas>
        <select onchange="getDataLaba(this.value)" class="mt-4 w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
            @foreach ($tahunList as $thn)
            <option value="{{$thn}}">{{$thn}}</option>
            @endforeach
        </select>
    </div>

    <div class="bg-white rounded-2xl shadow-lg p-6 md:w-1/2 max-w-xl">
        <h2 class="text-2xl font-bold mb-4 text-center">Omzet Bulanan</h2>
        <canvas id="omzet_bulanan" class="w-full h-64"></canvas>
        <select onchange="getDataOmzet(this.value)" class="mt-4 w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
            @foreach ($tahunList as $thn)
            <option value="{{$thn}}">{{$thn}}</option>
            @endforeach
        </select>
    </div>
</div>

<h1 class="mt-16 text-2xl md:text-4xl font-bold">STATISTIK TAHUNAN</h1>
<div class="mt-4 w-full flex flex-col md:flex-row gap-4">
    <div class="bg-white rounded-2xl shadow-lg p-6 md:w-1/2 w-full max-w-xl">
        <h2 class="text-2xl font-bold mb-4 text-center">Laba Tahunan</h2>
        <canvas id="laba_tahunan" class="w-full h-64"></canvas>
        <div class="flex gap-4 items-center">
            <select onchange="getLabaTahunan()" id="laba_tahunan_min" class="mt-4 w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                @foreach ($tahunList as $thn)
                <option value="{{$thn}}">{{$thn}}</option>
                @endforeach
            </select>

            <p class="text-center text-2xl">Hingga</p>

            <select onchange="getLabaTahunan()" id="laba_tahunan_max" class="mt-4 w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                @foreach ($tahunList as $thn)
                <option value="{{ $thn }}" {{ $loop->last ? 'selected' : '' }}>{{ $thn }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-lg p-6 md:w-1/2 w-full max-w-xl">
        <h2 class="text-2xl font-bold mb-4 text-center">Omzet Tahunan</h2>
        <canvas id="omzet_tahunan" class="w-full h-64"></canvas>
        <div class="flex gap-4 items-center">
            <select onchange="getOmzetTahunan()" id="omzet_tahunan_min" class="mt-4 w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                @foreach ($tahunList as $thn)
                <option value="{{$thn}}">{{$thn}}</option>
                @endforeach
            </select>

            <p class="text-center text-2xl">Hingga</p>

            <select onchange="getOmzetTahunan()" id="omzet_tahunan_max" class="mt-4 w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                @foreach ($tahunList as $thn)
                <option value="{{ $thn }}" {{ $loop->last ? 'selected' : '' }}>{{ $thn }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    getOmzetHarian('{ "tahun": "{{$tahunSekarang}}", "bulan": "{{$bulanSekarang}}"}');
    getOmzetBulanan('{{$tahunSekarang}}');
    getOmzetTahunan();

    getLabaHarian('{ "tahun": "{{$tahunSekarang}}", "bulan": "{{$bulanSekarang}}"}');
    getLabaBulanan('{{$tahunSekarang}}');
    getLabaTahunan();

    let chartOmzetHarian = null;
    let chartOmzetBulanan = null;
    let chartOmzetTahunan = null;
    let chartLabaHarian = null;
    let chartLabaBulanan = null;
    let chartLabaTahunan = null;

    function getOmzetHarian(TahunBulan) {
        objek = JSON.parse(TahunBulan);
        fetch('/statistik/data-omzet-harian/' + objek.tahun + '/' + objek.bulan)
            .then(response => response.json())
            .then(data => {
                const ctx = document.getElementById('omzet_harian').getContext('2d');
                if (chartOmzetHarian) {
                    chartOmzetHarian.destroy();
                }
                chartOmzetHarian = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Omzet Harian',
                            data: data.data,
                            backgroundColor: '#3b82f6',
                            borderRadius: 8,
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                    }
                });
            });
    }

    function getOmzetBulanan(tahun) {
        fetch('/statistik/data-omzet-bulanan/' + tahun)
            .then(response => response.json())
            .then(data => {
                const ctx = document.getElementById('omzet_bulanan').getContext('2d');
                if (chartOmzetBulanan) {
                    chartOmzetBulanan.destroy();
                }
                chartOmzetBulanan = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Omzet Bulanan',
                            data: data.data,
                            backgroundColor: '#3b82f6',
                            borderRadius: 8,
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                    }
                });
            });
    }

    function getOmzetTahunan() {
        omzet_tahun_min = document.getElementById('omzet_tahunan_min').value;
        omzet_tahun_max = document.getElementById('omzet_tahunan_max').value;
        fetch('/statistik/data-omzet-tahunan/' + omzet_tahun_min + '/' + omzet_tahun_max)
            .then(response => response.json())
            .then(data => {
                const ctx = document.getElementById('omzet_tahunan').getContext('2d');
                if (chartOmzetTahunan) {
                    chartOmzetTahunan.destroy();
                }
                chartOmzetTahunan = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Omzet Tahunan',
                            data: data.data,
                            backgroundColor: '#3b82f6',
                            borderRadius: 8,
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                    }
                });
            });
    }

    function getLabaHarian(TahunBulan) {
        objek = JSON.parse(TahunBulan);
        fetch('/statistik/data-laba-harian/' + objek.tahun + '/' + objek.bulan)
            .then(response => response.json())
            .then(data => {
                const ctx = document.getElementById('laba_harian').getContext('2d');
                if (chartLabaHarian) {
                    chartLabaHarian.destroy();
                }
                chartLabaHarian = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Laba Harian',
                            data: data.data,
                            backgroundColor: '#3b82f6',
                            borderRadius: 8,
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                    }
                });
            });
    }

    function getLabaBulanan(tahun) {
        fetch('/statistik/data-laba-bulanan/' + tahun)
            .then(response => response.json())
            .then(data => {
                const ctx = document.getElementById('laba_bulanan').getContext('2d');
                if (chartLabaBulanan) {
                    chartLabaBulanan.destroy();
                }
                chartLabaBulanan = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Laba Bulanan',
                            data: data.data,
                            backgroundColor: '#3b82f6',
                            borderRadius: 8,
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                    }
                });
            });
    }

    function getLabaTahunan() {
        laba_tahun_min = document.getElementById('laba_tahunan_min').value;
        laba_tahun_max = document.getElementById('laba_tahunan_max').value;
        fetch('/statistik/data-laba-tahunan/' + laba_tahun_min + '/' + laba_tahun_max)
            .then(response => response.json())
            .then(data => {
                const ctx = document.getElementById('laba_tahunan').getContext('2d');
                if (chartLabaTahunan) {
                    chartLabaTahunan.destroy();
                }
                chartLabaTahunan = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Laba Tahunan',
                            data: data.data,
                            backgroundColor: '#3b82f6',
                            borderRadius: 8,
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                    }
                });
            });
    }
</script>
@endsection