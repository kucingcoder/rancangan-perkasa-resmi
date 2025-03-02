<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="icon" href="/Images/logo simbol.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" />
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">

    <style>
        .luxurious-script-regular {
            font-family: "Pacifico", cursive;
            font-weight: 400;
            font-style: normal;
        }
    </style>
</head>

<body class="h-min-screen w-min-screen">
    <nav class="bg-white shadow-md p-4 sticky top-0 z-50">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Logo -->
            <div class="">
                <a href="/"><img src="/Images/Rancangan Perkasa.png" class="w-32" alt="logo"></a>
            </div>

            <!-- Menu untuk Desktop -->
            <ul class="hidden md:flex space-x-6 text-gray-700">
                <li class="flex items-center space-x-2">
                    <a href="/" class="text-gray-500 hover:text-blue-950">Ikhtisar</a>
                </li>
                <li class="flex items-center space-x-2">
                    <a href="/katalog/6bde6ca2-f0f3-11ef-a016-1063c8e04372" class="text-gray-500 hover:text-blue-950">Katalog</a>
                </li>
                <li class="flex items-center space-x-2">
                    <a href="/kontak" class="text-gray-500 hover:text-blue-950">Kontak</a>
                </li>
                <li class="flex items-center space-x-2">
                    <a href="/jam-kerja" class="text-gray-500 hover:text-blue-950">Jam Kerja</a>
                </li>
            </ul>

            <!-- Tombol Hamburger untuk Mobile -->
            <button id="menu-btn" class="md:hidden text-gray-700 text-2xl">
                ☰
            </button>
        </div>

        <!-- Menu untuk Mobile -->
        <div id="mobile-menu" class="hidden md:hidden flex flex-col space-y-4 p-4 bg-white absolute top-16 right-0 w-full">
            <a href="/" class="flex items-center space-x-2 text-gray-500">Ikhtisar</a>
            <a href="/katalog/6bde6ca2-f0f3-11ef-a016-1063c8e04372" class="flex items-center space-x-2 text-gray-500">Katalog</a>
            <a href="/kontak" class="flex items-center space-x-2 text-gray-500">Kontak</a>
            <a href="/jam-kerja" class="flex items-center space-x-2 text-gray-500">Jam Kerja</a>
        </div>
    </nav>

    <script>
        const menuBtn = document.getElementById("menu-btn");
        const mobileMenu = document.getElementById("mobile-menu");

        menuBtn.addEventListener("click", () => {
            mobileMenu.classList.toggle("hidden");
        });
    </script>


    <div class="w-full h-full">
        @yield('content')
    </div>
</body>

</html>