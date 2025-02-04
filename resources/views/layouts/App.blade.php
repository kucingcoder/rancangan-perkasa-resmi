<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="icon" href="Images/logo simbol.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div class="flex">
        <!-- Hamburger Icon -->
        <span id="tombol-menu" class="fixed text-white text-4xl top-5 left-4 cursor-pointer z-50 md:hidden" onclick="openSidebar()">
            <i class="bi bi-list px-2 bg-blue-950 rounded-md"></i>
        </span>

        <!-- Sidebar -->
        <div class="sidebar fixed top-0 bottom-0 lg:left-0 p-2 w-full md:w-1/6 overflow-y-auto text-center bg-blue-950 transform -translate-x-full md:translate-x-0 transition-transform duration-300">
            <div class="text-gray-100 text-xl">
                <div class="p-2.5 mt-1 flex items-center justify-between">
                    <div class="flex items-center bg-white rounded-md px-2 py-1 w-1/2 md:w-full">
                        <img src="Images/Rancangan Perkasa.png" alt="Rancangan Perkasa">
                    </div>
                    <i class="bi bi-x cursor-pointer md:hidden" style="font-size: 3rem;" onclick="openSidebar()"></i>
                </div>
                <div class="my-2 bg-gray-600 h-[1px]"></div>
            </div>

            <div class="p-2.5 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white">
                <i class="bi bi-house-door-fill"></i>
                <span class="text-2xl md:text-lg ml-4 text-gray-200 font-bold">Home</span>
            </div>

            <div class="p-2.5 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white">
                <i class="bi bi-bookmark-fill"></i>
                <span class="text-2xl md:text-lg ml-4 text-gray-200 font-bold">Bookmark</span>
            </div>

            <div class="mb-2 mt-4 bg-gray-600 h-[1px]"></div>

            <div onclick="location.href='/keluar'" class="p-2.5 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white">
                <i class="bi bi-box-arrow-in-right h1"></i>
                <span class="text-2xl ml-4 md:text-lg text-gray-200 font-bold">Logout</span>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-10 ml-0 md:ml-[16.666667%]">
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