<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('styles')
</head>

<body class="bg-[#f8fafc] font-sans antialiased text-near-black" x-data="{ sidebarOpen: true }">

    <x-admin.sidebar />

    <div
        class="min-h-screen flex flex-col"
        :style="sidebarOpen ? 'margin-left: 288px' : 'margin-left: 80px'">
        <x-admin.header />

        <main class="p-8 flex-1">
            @yield('content')
        </main>

        <footer class="p-8 py-4 text-center text-xs text-secondary-gray border-t border-slate-100">
            &copy; {{ date('Y') }} BoPC. Quản lý hệ thống toàn diện.
        </footer>
    </div>

    @stack('scripts')

    
    @if(session('success') || session('error'))
    <div id="flash-toast"
         class="fixed bottom-6 right-6 z-[9999] flex items-center gap-3 px-5 py-4 shadow-2xl text-sm font-bold max-w-sm pointer-events-auto
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