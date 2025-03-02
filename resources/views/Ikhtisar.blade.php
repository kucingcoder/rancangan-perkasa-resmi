@extends('layouts.Landing')
@section('title', 'Rancangan Perkasa | Ikhtisar')

@section('content')
<div class="h-screen flex justify-center bg-cover bg-center" style="background-image: url('/Images/photo/landing.webp');">
    <div class="mt-72 md:mt-40 flex flex-col items-center">
        <h1 class="text-3xl md:text-5xl luxurious-script-regular text-blue-950 drop-shadow-md">
            Solusi Interior & Eksterior
        </h1>
        <h1 class="text-2xl md:text-4xl luxurious-script-regular text-blue-950 drop-shadow-md">
            Jasa Desain & Bahan Bangunan
        </h1>
    </div>
</div>

<div class="flex flex-col md:flex-row p-8 md:p-16 gap-8 items-center">
    <div class="md:w-1/2">
        <h1 class="text-3xl mb-4 font-bold text-center md:text-left">TENTANG KAMI</h1>
        <p class="text-xl text-justify"><strong>CV RANCANGAN PERKASA</strong> adalah perusahaan yang bergerak di bidang distribusi jasa dan bahan untuk kebutuhan interior dan eksterior bangunan. Berdiri sejak tahun 30 Oktober 2024. Kami berkomitmen untuk menyediakan solusi terbaik yang inovatif, berkualitas tinggi dan efisien bagi para mitra bisnis serta pelanggan. Dengan pengalaman yang luas dan tenaga kerja profesional, CV Rancangan Perkasa telah dipercaya sebagai mitra dalam berbagai proyek skala kecil hingga besar di seluruh Indonesia.</p>
    </div>
    <div class="md:w-1/2">
        <img class="w-full" src="/Images/photo/tentang-kami.webp" alt="tentang kami">
    </div>
</div>

<div class="flex flex-col-reverse md:flex-row p-8 md:p-16 gap-8 items-center">
    <div class="md:w-1/2">
        <img class="w-full" src="/Images/photo/visi-misi.webp" alt="visi misi">
    </div>
    <div class="md:w-1/2">
        <h1 class="text-3xl mb-4 font-bold text-center md:text-left">VISI & MISI</h1>
        <h1 class="text-3xl mb-4 font-bold text-left">VISI</h1>
        <p class="text-xl text-justify mb-4">Menjadi distributor terdepan dalam penyediaan bahan dan jasa berkualitas untuk interior dan eksterior.</p>
        <h1 class="text-3xl mb-4 font-bold text-left">MISI</h1>
        <div class="px-4">
            <ul class="list-decimal list-outside text-xl text-justify">
                <li class="mb-2">Memberikan layanan terbaik melalui inovasi dan profesionalisme sehingga client merasa puas.</li>
                <li class="mb-2">Menyediakan produk berkualitas tinggi yang sesuai dengan kebutuhan pelanggan.</li>
                <li class="mb-2">Membangun hubungan yang saling menguntungkan dengan mitra bisnis dan pelanggan.</li>
                <li class="mb-2">Mendukung pembangunan yang berkelanjutan dengan menyediakan bahan yang ramah lingkungan.</li>
            </ul>
        </div>
    </div>
</div>

<div class="p-8 md:p-16 gap-8 items-center">
    <h1 class="text-3xl mb-4 font-bold text-center md:text-left">NILAI-NILAI PERUSAHAAN</h1>
    <div class="flex flex-col md:flex-row gap-4">
        <div class="w-full md:w-1/3 p-4 bg-white shadow-xl border border-grey-300 rounded-lg">
            <h1 class="text-xl mb-4 font-bold text-center">INTEGRITAS</h1>
            <p class="text-xl text-justify">Kami berkomitmen untuk menjalankan setiap aspek bisnis dengan jujur, transparan, dan bertanggung jawab, sehingga menciptakan kepercayaan jangka panjang dengan pelanggan dan mitra bisnis.</p>
        </div>
        <div class="w-full md:w-1/3 p-4 bg-white shadow-xl border border-grey-300 rounded-lg">
            <h1 class="text-xl mb-4 font-bold text-center">KUALITAS</h1>
            <p class="text-xl text-justify">Kualitas adalah prioritas utama kami. Setiap produk dan layanan yang kami tawarkan dirancang untuk memenuhi standar terbaik, memastikan kepuasan dan loyalitas pelanggan.</p>
        </div>
        <div class="w-full md:w-1/3 p-4 bg-white shadow-xl border border-grey-300 rounded-lg">
            <h1 class="text-xl mb-4 font-bold text-center">INOVASI</h1>
            <p class="text-xl text-justify">Kami terus berinovasi dengan mengikuti perkembangan teknologi dan tren desain terkini, memberikan solusi modern yang relevan dan kreatif.</p>
        </div>
    </div>
    <div class="flex flex-col md:flex-row gap-4 mt-4">
        <div class="w-full md:w-1/3 p-4 bg-white shadow-xl border border-grey-300 rounded-lg">
            <h1 class="text-xl mb-4 font-bold text-center">PROFESIONALISME</h1>
            <p class="text-xl text-justify">Dalam setiap langkah kerja, kami menjunjung tinggi etika profesional, disiplin, dan dedikasi untuk memberikan hasil yang maksimal.</p>
        </div>
        <div class="w-full md:w-1/3 p-4 bg-white shadow-xl border border-grey-300 rounded-lg">
            <h1 class="text-xl mb-4 font-bold text-center">KOLABORASI</h1>
            <p class="text-xl text-justify">Kami percaya bahwa kesuksesan dicapai melalui kerja sama yang solid dengan pelanggan, mitra bisnis, dan seluruh tim perusahaan.</p>
        </div>
        <div class="w-full md:w-1/3 p-4 bg-white shadow-xl border border-grey-300 rounded-lg">
            <h1 class="text-xl mb-4 font-bold text-center">KEPUASAN PELANGGAN</h1>
            <p class="text-xl text-justify">Pelanggan adalah fokus utama kami. Kami mendengarkan kebutuhan mereka dan memberikan layanan yang melebihi ekspektasi.</p>
        </div>
    </div>
</div>

<div class="flex flex-col md:flex-row p-8 md:p-16 gap-8 items-center">
    <div class="md:w-1/2">
        <h1 class="text-3xl mb-4 font-bold text-center md:text-left">KEUNGGULAN KAMI</h1>

        <h1 class="text-2xl mb-4 font-bold text-left">Distribusi Bahan Interior dan Eksterior</h1>
        <div class="px-6">
            <ul class="list-disc list-outside text-xl text-justify">
                <li class="mb-2">Bahan bangunan seperti kayu, kaca, logam dan bahan komposit</li>
                <li class="mb-2">Material finishing seperti cat, wallpaper dan pelapis lantai</li>
            </ul>
        </div>

        <h1 class="text-2xl mb-4 font-bold text-left">Jasa Konsultasi dan Desain</h1>
        <div class="px-6">
            <ul class="list-disc list-outside text-xl text-justify">
                <li class="mb-2">Konsultasi desain interior dan eksterior</li>
                <li class="mb-2">Penyediaan solusi kreatif dan fungsional sesuai kebutuhan proyek</li>
            </ul>
        </div>

        <h1 class="text-2xl mb-4 font-bold text-left">Pengerjaan Proyek</h1>
        <div class="px-6">
            <ul class="list-disc list-outside text-xl text-justify">
                <li class="mb-2">Instalasi interior seperti plafon, lantai dan dinding</li>
                <li class="mb-2">Pemasangan eksterior seperti fasad, pagar dan kanopi</li>
            </ul>
        </div>
    </div>
    <div class="md:w-1/2">
        <img class="w-full" src="/Images/photo/keunggulan-kami1.webp" alt="keunggulan kami">
    </div>
</div>

<div class="flex flex-col-reverse md:flex-row p-8 md:p-16 gap-8 items-center">
    <div class="md:w-1/2">
        <img class="w-full" src="/Images/photo/keunggulan-kami.webp" alt="keunggulan kami">
    </div>
    <div class="md:w-1/2">
        <h1 class="text-3xl mb-4 font-bold text-center md:text-left">KEUNGGULAN KAMI</h1>

        <h1 class="text-2xl font-bold text-left">Distribusi Bahan Interior dan Eksterior</h1>
        <p class="text-xl text-justify mb-4">Produk dan jasa yang kami tawarkan telah melalui uji kualitas untuk memastikan kepuasan pelanggan</p>

        <h1 class="text-2xl font-bold text-left">Tim Profesional</h1>
        <p class="text-xl text-justify mb-4">Didukung oleh tenaga ahli yang berpengalaman di bidangnya</p>

        <h1 class="text-2xl font-bold text-left">Pelayanan Terbaik</h1>
        <p class="text-xl text-justify mb-4">Fokus pada kebutuhan dan kepuasan pelanggan</p>

        <h1 class="text-2xl font-bold text-left">Jaringan Luas</h1>
        <p class="text-xl text-justify">Kemitraan dengan berbagai produsen bahan berkualitas tinggi</p>
    </div>
</div>
@endsection