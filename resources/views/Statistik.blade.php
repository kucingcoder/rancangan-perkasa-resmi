@extends('layouts.App')
@section('title', 'Rancangan Perkasa | Statistik')

@section('content')
<div class="w-full flex flex-col md:flex-row gap-4">
    <div class="bg-white rounded-2xl shadow-lg p-6 md:w-1/2 max-w-xl">
        <h2 class="text-2xl font-bold mb-4 text-center">Omzet Bulanan</h2>
        <canvas id="omzet_bulanan" class="w-full h-64"></canvas>
        <select onchange="getDataOmzet(this.value)" name="tahun" id="tahun" class="mt-4 w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
            @foreach ($tahunList as $thn)
            <option value="{{$thn}}">{{$thn}}</option>
            @endforeach
        </select>
    </div>

    <div class="bg-white rounded-2xl shadow-lg p-6 md:w-1/2 w-full max-w-xl">
        <h2 class="text-2xl font-bold mb-4 text-center">Omzet Tahunan</h2>
        <canvas id="omzet_tahunan" class="w-full h-64"></canvas>
    </div>
</div>

<div class="mt-4 w-full flex flex-col md:flex-row gap-4">
    <div class="bg-white rounded-2xl shadow-lg p-6 md:w-1/2 max-w-xl">
        <h2 class="text-2xl font-bold mb-4 text-center">Laba Bulanan</h2>
        <canvas id="laba_bulanan" class="w-full h-64"></canvas>
        <select onchange="getDataLaba(this.value)" name="tahun" id="tahun" class="mt-4 w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
            @foreach ($tahunList as $thn)
            <option value="{{$thn}}">{{$thn}}</option>
            @endforeach
        </select>
    </div>

    <div class="bg-white rounded-2xl shadow-lg p-6 md:w-1/2 w-full max-w-xl">
        <h2 class="text-2xl font-bold mb-4 text-center">Laba Tahunan</h2>
        <canvas id="laba_tahunan" class="w-full h-64"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    getDataOmzet("{{ $tahunSekarang }}");
    getDataLaba("{{ $tahunSekarang }}");

    let chartOmzetBulanan = null;
    let chartOmzetTahunan = null;

    function getDataOmzet(tahun) {
        fetch('/statistik/data-omzet/' + tahun)
            .then(response => response.json())
            .then(data => {
                const ctxOmzetBulanan = document.getElementById('omzet_bulanan').getContext('2d');
                const ctxOmzetTahunan = document.getElementById('omzet_tahunan').getContext('2d');

                if (chartOmzetBulanan) {
                    chartOmzetBulanan.destroy();
                }

                if (chartOmzetTahunan) {
                    chartOmzetTahunan.destroy();
                }

                chartOmzetBulanan = new Chart(ctxOmzetBulanan, {
                    type: 'bar',
                    data: {
                        labels: data.omzet_bulanan.labels,
                        datasets: [{
                            label: 'Omzet Bulanan',
                            data: data.omzet_bulanan.data,
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
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

                chartOmzetTahunan = new Chart(ctxOmzetTahunan, {
                    type: 'line',
                    data: {
                        labels: data.omzet_tahunan.labels,
                        datasets: [{
                            label: 'Omzet Tahunan',
                            data: data.omzet_tahunan.data,
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
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            });
    }

    let chartLabaBulanan = null;
    let chartLabaTahunan = null;

    function getDataLaba(tahun) {
        fetch('/statistik/data-laba/' + tahun)
            .then(response => response.json())
            .then(data => {
                const ctxLabaBulanan = document.getElementById('laba_bulanan').getContext('2d');
                const ctxLabaTahunan = document.getElementById('laba_tahunan').getContext('2d');

                if (chartLabaBulanan) {
                    chartLabaBulanan.destroy();
                }

                if (chartLabaTahunan) {
                    chartLabaTahunan.destroy();
                }

                chartLabaBulanan = new Chart(ctxLabaBulanan, {
                    type: 'bar',
                    data: {
                        labels: data.laba_bulanan.labels,
                        datasets: [{
                            label: 'Laba Bulanan',
                            data: data.laba_bulanan.data,
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
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

                chartLabaTahunan = new Chart(ctxLabaTahunan, {
                    type: 'line',
                    data: {
                        labels: data.laba_tahunan.labels,
                        datasets: [{
                            label: 'Laba Tahunan',
                            data: data.laba_tahunan.data,
                            backgroundColor: '#3b82f6',
                            borderColor: '#3b82f6',
                            tension: 0.3,
                            fill: false,
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            })
            .catch(error => {
                console.error('Gagal mengambil data statistik:', error);
            });
    }
</script>
@endsection