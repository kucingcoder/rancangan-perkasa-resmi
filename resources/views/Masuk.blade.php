<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rancangan Perkasa | Masuk</title>
    <link rel="icon" href="Images/logo simbol.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">
    @if ($errors->any())
    <div id="alert" class="bg-red-300 border border-red-300 text-red-dark px-12 py-3 rounded fixed top-0 right-0 m-4 z-50" role="alert">
        <strong class="font-bold">Gagal!</strong>
        <span class="block sm:inline">{{ $errors->first() }}</span>
        <span class="absolute top-0 right-0 px-1 py-3" onclick="tutup()">
            <svg
                class="fill-current h-6 w-6 text-red cursor-pointer"
                role="button"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20">
                <title>Close</title>
                <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
            </svg>
        </span>
    </div>
    @endif

    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md mx-4">
        <h1 class="text-3xl md:text-4xl font-bold mb-6 text-center text-blue-900">Rancangan Perkasa</h1>
        <form action="/masuk" method="POST">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-md font-medium md:text-lg text-gray-700">Email</label>
                <input type="email" id="email" name="email"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-md md:text-lg"
                    placeholder="saya@gmail.com" autocomplete="email" required>
            </div>
            <div class="mb-6 relative">
                <label for="password" class="block text-md font-medium md:text-lg text-gray-700">Password</label>
                <input type="password" id="password" name="password"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-md md:text-lg"
                    placeholder="••••••••" autocomplete="current-password" required>
                <button type="button" id="togglePassword" class="absolute inset-y-0 mt-6 md:mt-8 right-0 px-3 flex items-center text-gray-600">
                    <i class="text-blue-950 fas fa-eye"></i>
                </button>
            </div>
            <button type="submit"
                class="w-full bg-blue-950 text-white py-2 px-4 rounded-md hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">MASUK</button>
        </form>
    </div>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordField = document.getElementById('password');
            const toggleIcon = this.querySelector('i');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        });

        function tutup() {
            pesan = document.getElementById("alert");
            pesan.style.display = "none";
        }
    </script>
</body>

</html>