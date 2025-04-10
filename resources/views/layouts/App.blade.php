<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="icon" href="/Images/logo simbol.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>
    <div class="flex">
        <!-- Hamburger Icon -->
        <span id="tombol-menu" class="fixed text-white text-4xl top-5 left-4 cursor-pointer z-50 md:hidden" onclick="openSidebar()">
            <i class="bi bi-list px-2 bg-blue-950 rounded-md"></i>
        </span>

        <!-- Sidebar -->
        <div class="sidebar fixed top-0 bottom-0 lg:left-0 p-2 w-full md:w-1/6 overflow-y-auto text-center bg-blue-950 transform -translate-x-full md:translate-x-0 transition-transform duration-300 z-50">
            <div class="text-gray-100 text-xl">
                <div class="p-2.5 mt-1 flex items-center justify-between">
                    <div onclick="location.href='/dashboard'" style="cursor: pointer;" class="flex items-center bg-white rounded-md px-2 py-1 w-1/2 md:w-full h-16">
                        <img src="/Images/Rancangan Perkasa.png" alt="Rancangan Perkasa">
                    </div>
                    <i class="bi bi-x cursor-pointer md:hidden" style="font-size: 3rem;" onclick="openSidebar()"></i>
                </div>
                <div class="my-2 bg-gray-600 h-[1px]"></div>
            </div>

            @if(session('jenis') === 'owner' || session('jenis') === 'admin')
            <div onclick="location.href='/statistik'" class="p-2.5 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white">
                <span class="text-2xl md:text-lg text-gray-200 font-bold">Statistik</span>
            </div>
            @endif

            @if(session('jenis') === 'sales' || session('jenis') === 'admin')
            <div onclick="location.href='/pesanan'" class="p-2.5 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white">
                <span class="text-2xl md:text-lg text-gray-200 font-bold">Pesanan</span>
            </div>
            @endif

            @if(session('jenis') === 'admin')
            <div onclick="location.href='/pesanan-masuk'" class="p-2.5 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white">
                <span class="text-2xl md:text-lg text-gray-200 font-bold">Pesanan Masuk</span>
            </div>
            @endif

            @if(session('jenis') === 'sales' || session('jenis') === 'admin')
            <div onclick="location.href='/keranjang'" class="p-2.5 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white">
                <span class="text-2xl md:text-lg text-gray-200 font-bold">Keranjang</span>
            </div>
            @endif

            @if(session('jenis') === 'admin')
            <div onclick="location.href='/stok'" class="p-2.5 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white">
                <span class="text-2xl md:text-lg text-gray-200 font-bold">Stok</span>
            </div>

            <div onclick="location.href='/produk'" class="p-2.5 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white">
                <span class="text-2xl md:text-lg text-gray-200 font-bold">Produk</span>
            </div>

            <div onclick="location.href='/akun'" class="p-2.5 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white">
                <span class="text-2xl md:text-lg text-gray-200 font-bold">Akun</span>
            </div>

            <div onclick="location.href='/karyawan'" class="p-2.5 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white">
                <span class="text-2xl md:text-lg text-gray-200 font-bold">Karyawan</span>
            </div>

            <div onclick="location.href='/biaya-kirim'" class="p-2.5 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white">
                <span class="text-2xl md:text-lg text-gray-200 font-bold">Biaya Kirim</span>
            </div>

            <div onclick="location.href='/ekspedisi'" class="p-2.5 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white">
                <span class="text-2xl md:text-lg text-gray-200 font-bold">Ekspedisi</span>
            </div>
            @endif

            <div class="mb-2 mt-4 bg-gray-600 h-[1px]"></div>

            <div onclick="location.href='/katalog/<?= session('id') ?>'" class="p-2.5 flex items-center justify-center rounded-md px-4 duration-300 cursor-pointer bg-lime-600 hover:bg-lime-700 text-white">
                <span class="text-2xl md:text-lg font-bold">Katalogku</span>
            </div>

            <div class="mb-2 mt-4 bg-gray-600 h-[1px]"></div>

            <div class="w-full flex justify-around">
                <div onclick="location.href='/profil'" class="p-2.5 w-1/2 flex mr-2 items-center justify-center rounded-md px-4 duration-300 cursor-pointer bg-yellow-600 hover:bg-yellow-800 text-white">
                    <span class="text-2xl md:text-lg font-bold">Profil</span>
                </div>
                <div onclick="location.href='/keluar'" class="p-2.5 w-1/2 flex items-center justify-center rounded-md px-4 duration-300 cursor-pointer bg-red-600 hover:bg-red-800 text-white">
                    <span class="text-2xl md:text-lg font-bold">Logout</span>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-10 ml-0 md:ml-[16.666667%] mt-8 md:mt-0">
            @yield('content')
        </div>
    </div>

    <script type="text/javascript">
        let tombol_menu = false;

        function openSidebar() {
            const sidebar = document.querySelector(".sidebar");
            sidebar.classList.toggle("-translate-x-full");

            if (tombol_menu == true) {
                document.querySelector("#tombol-menu").classList.add("hidden");
                tombol_menu = false;
            } else {
                document.querySelector("#tombol-menu").classList.remove("hidden");
                tombol_menu = true;
            }
        }

        if (window.innerWidth < 768) {
            document.querySelector(".sidebar").classList.add("-translate-x-full");
            tombol_menu = true;
        }
    </script>
</body>

</html>