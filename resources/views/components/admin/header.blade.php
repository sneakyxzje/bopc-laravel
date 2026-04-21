<header class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-10 sticky top-0 z-40 bg-white/80 backdrop-blur-md">
    <div class="flex items-center gap-4">
        <h1 class="text-sm font-bold text-secondary-gray uppercase">
            Admin / @yield('page_title')
        </h1>
    </div>

    <div class="flex items-center gap-8">
        
        <button class="relative p-2 text-secondary-gray hover:text-primary">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
            <span class="absolute top-2 right-2 w-2 h-2 bg-primary rounded-md border-2 border-white"></span>
        </button>

        
        <div class="flex items-center gap-4 pl-8 border-l border-[#f2f2f2]">
            <div class="text-right hidden sm:block">
                <p class="text-sm font-bold text-near-black leading-none mb-1">{{ Auth::user()->name }}</p>
                <p class="text-[10px] text-secondary-gray font-bold uppercase">Administrator</p>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-airbnb-brand px-5 py-2.5 text-[11px] font-bold uppercase shadow-lg shadow-primary/15">
                    Logout
                </button>
            </form>
        </div>
    </div>
</header>