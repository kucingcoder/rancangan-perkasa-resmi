@extends('layouts.App')
@section('title', 'Rancangan Perkasa | Profil')

@section('content')
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

@if (session('success'))
<div id="alert" class="bg-green-300 border border-green-300 text-green-dark px-12 py-3 rounded fixed top-0 right-0 m-4 z-50" role="alert">
    <strong class="font-bold">Berhasil!</strong>
    <span class="block sm:inline">{{ session('success') }}</span>
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

<form action="/profil-edit" method="POST">
    @csrf
    <h2 class="text-2xl md:text-4xl font-bold text-gray-700 mb-2">Profil</h2>
    <div class="w-full flex flex-col md:flex-row">
        <div class="md:mr-8 w-full md:w-1/2 flex flex-col">
            <div class="mb-4">
                <label for="nama" class="block text-md font-medium md:text-lg text-gray-700">Nama</label>
                <input type="text" id="nama" name="nama"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-md md:text-lg"
                    placeholder="Nama" autocomplete="name" value="{{$akun->nama}}" required>
            </div>
            <div class="mb-4">
                <label for="jenis_kelamin" class="block text-md font-medium md:text-lg text-gray-700">Jenis Kelamin</label>
                <select id="jenis_kelamin" name="jenis_kelamin"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-md md:text-lg"
                    required>
                    <option value="{{$akun->jenis_kelamin}}">{{$akun->jenis_kelamin}}</option>
                    <?php if ($akun->jenis_kelamin == "laki-laki") {
                        echo '<option value="perempuan">Perempuan</option>';
                    } else {
                        echo '<option value="laki-laki">Laki - laki</option>';
                    } ?>
                </select>
            </div>
            <div class="mb-4">
                <label for="alamat" class="block text-md font-medium md:text-lg text-gray-700">Alamat</label>
                <textarea id="alamat" name="alamat"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-md md:text-lg"
                    placeholder="Alamat" style="resize: none;" required>{{$akun->alamat}}</textarea>
            </div>
        </div>
        <div class="w-full md:w-1/2 flex flex-col">
            <div class="mb-4">
                <label for="email" class="block text-md font-medium md:text-lg text-gray-700">Email</label>
                <input type="email" id="email" name="email"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-md md:text-lg"
                    placeholder="saya@gmail.com" autocomplete="email" value="{{$akun->email}}" required>
            </div>
            <div class="mb-4">
                <label for="no_wa" class="block text-md font-medium md:text-lg text-gray-700">Nomor Whatsapp</label>
                <input type="text" id="no_wa" name="no_wa"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-md md:text-lg"
                    placeholder="08xxxxxxx" autocomplete="phone" value="{{$akun->no_wa}}" required>
            </div>
        </div>
    </div>
    <button type="submit"
        class="w-full md:w-fit bg-blue-950 text-white py-2 px-4 rounded-md hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">PERBAHARUI</button>
</form>

<div class="mt-8"></div>

<form action="/profil-ganti-sandi" method="POST">
    @csrf
    <h2 class="text-2xl md:text-4xl font-bold text-gray-700 mb-2">Ganti Sandi</h2>
    <div class="mb-6 relative">
        <label for="password_lama" class="block text-md font-medium md:text-lg text-gray-700">Password Lama</label>
        <input type="password" id="password_lama" name="password_lama"
            class="mt-1 block w-full md:w-1/3 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-md md:text-lg"
            placeholder="••••••••" autocomplete="current-password" required>
        <button type="button" id="togglePasswordLama" class="absolute inset-y-0 mt-6 md:mt-8 right-0 md:left-1/3 px-3 flex items-center text-gray-600">
            <i class="text-blue-950 fas fa-eye"></i>
        </button>
    </div>
    <div class="mb-6 relative">
        <label for="password_baru" class="block text-md font-medium md:text-lg text-gray-700">Password Baru</label>
        <input type="password" id="password_baru" name="password_baru"
            class="mt-1 block w-full md:w-1/3 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-md md:text-lg"
            placeholder="••••••••" autocomplete="current-password" required>
        <button type="button" id="togglePasswordBaru" class="absolute inset-y-0 mt-6 md:mt-8 right-0 md:left-1/3 px-3 flex items-center text-gray-600">
            <i class="text-blue-950 fas fa-eye"></i>
        </button>
    </div>

    <div class="mb-6 relative">
        <label for="konfirmasi_password" class="block text-md font-medium md:text-lg text-gray-700">Konformasi Password Baru</label>
        <input type="password" id="konfirmasi_password" name="konfirmasi_password"
            class="mt-1 block w-full md:w-1/3 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-md md:text-lg"
            placeholder="••••••••" autocomplete="current-password" required>
        <button type="button" id="togglePasswordKonfirmasi" class="absolute inset-y-0 mt-6 md:mt-8 right-0 md:left-1/3 px-3 flex items-center text-gray-600">
            <i class="text-blue-950 fas fa-eye"></i>
        </button>
    </div>
    <button type="submit"
        class="w-full md:w-fit bg-blue-950 text-white py-2 px-4 rounded-md hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">GANTI SANDI</button>
</form>

<script>
    document.getElementById('togglePasswordLama').addEventListener('click', function() {
        const passwordField = document.getElementById('password_lama');
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

    document.getElementById('togglePasswordBaru').addEventListener('click', function() {
        const passwordField = document.getElementById('password_baru');
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

    document.getElementById('togglePasswordKonfirmasi').addEventListener('click', function() {
        const passwordField = document.getElementById('konfirmasi_password');
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
@endsection