@extends('layouts.App')
@section('title', 'Rancangan Perkasa | Pesanan Masuk')

@section('content')
<h2 class="text-2xl md:text-4xl text-center font-bold text-gray-700 mb-2">Daftar Pesanan Masuk</h2>
<div class="mt-6 flex gap-4 flex-wrap justify-center md:justify-start items-center">
    @foreach ($pesanan as $item)
    <div class="w-full md:w-1/4 p-4 rounded-lg bg-grey-100 shadow shadow-lg border border-grey-300">
        <h1 class="text-center text-xl md:text-sm font-bold mb-4">{{$item->keranjang->judul}}</h1>
        <div class="flex justify-between">
            <p>{{$item->status}}</p>
            <p>{{$item->created_at->format('d-m-Y')}}</p>
        </div>
        <div class="mt-4 flex">
            <button onclick="window.location.href='/pesanan-masuk/{{$item->id}}'" class="w-full px-4 py-2 text-sm text-white bg-blue-950 rounded hover:bg-blue-600">Kelola</button>
        </div>
    </div>
    @endforeach
</div>
@endsection