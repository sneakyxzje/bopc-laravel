<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Bộ PC')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white min-h-screen selection:bg-primary/20">
    
    @include('components.navbar')

    <main class="max-w-[1780px] mx-auto px-4 sm:px-6 lg:px-10 pb-20">
        @yield('content')
    </main>

    
    @include('components.footer')

    
    @if(session('success') || session('error'))
    <div id="flash-toast"
         class="fixed bottom-6 right-6 z-[9999] flex items-center gap-3 px-5 py-4 shadow-2xl text-sm font-bold max-w-sm
                {{ session('success') ? 'bg-near-black text-white' : 'bg-red-600 text-white' }}">
        @if(session('success'))
        <svg class="w-5 h-5 text-emerald-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
        </svg>
        @else
        <svg class="w-5 h-5 text-red-200 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
        </svg>
        @endif
        <span class="flex-1">{{ session('success') ?? session('error') }}</span>
        <button onclick="this.closest('#flash-toast').remove()" class="ml-2 opacity-60 hover:opacity-100 text-lg leading-none">&times;</button>
    </div>
    <script>
        setTimeout(() => {
            const t = document.getElementById('flash-toast');
            if (t) { t.style.transition = 'opacity 0.4s'; t.style.opacity = '0'; setTimeout(() => t.remove(), 400); }
        }, 4000);
    </script>
    @endif
</body>

</html>