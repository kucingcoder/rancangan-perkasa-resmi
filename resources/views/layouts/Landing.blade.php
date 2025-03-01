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

    <style>
        .datatable-input {
            width: 100%;
            padding: 8px;
            font-size: 14px;
            border: 2px solid rgb(163, 163, 163);
            border-radius: 4px;
            outline: none;
        }

        .datatable-input:focus {
            width: 100%;
            padding: 8px;
            font-size: 14px;
            border: 2px solid rgb(30, 30, 30);
            border-radius: 4px;
            outline: none;
        }
    </style>
</head>

<body>
    <div class="flex flex-col min-h-screen">
        @yield('content')
    </div>
</body>

</html>