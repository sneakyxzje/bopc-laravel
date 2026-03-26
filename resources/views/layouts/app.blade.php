<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Bộ PC')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <!-- Các component dùng chung sẽ thêm ở đây -->
    @include('components.navbar')
    <main class="max-w-screen-xl mx-auto px-4">
        @yield('content')
    </main>

</body>

</html>