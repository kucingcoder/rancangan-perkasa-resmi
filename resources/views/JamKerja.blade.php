@extends('layouts.Landing')
@section('title', 'Rancangan Perkasa | Jam Kerja')

@section('content')
<div class="h-screen flex items-center justify-center bg-cover bg-center p-8" style="background-image: url('/Images/photo/jam-kerja.webp');">
    <div class="w-full md:w-1/3 h-fit p-4 bg-white/20 shadow-xl border border-grey-300 rounded-lg">
        <h1 class="mb-6 text-2xl md:text-5xl luxurious-script-regular text-blue-950 drop-shadow-md text-center">
            JAM KERJA
        </h1>

        <p class="text-xl md:text-2xl">08:00 - 11:30 Open Order Website</p>
        <p class="text-xl md:text-2xl">11:45 - 12:45 Ishoma</p>
        <p class="text-xl md:text-2xl">12:30 - 15:00 open order website</p>
        <p class="text-xl md:text-2xl">15:00 - 16:30 close order website</p>
        <p class="text-xl md:text-2xl">15:00 - 16:30 rekap sales</p>
        <p></p>
        <p class="text-xl md:text-2xl">16:30 - 19:00 jam lembur</p>
        <p class="text-xl md:text-2xl">19:00 - 08:00 Close order website</p>
    </div>
</div>
@endsection