@php
use Illuminate\Support\Facades\Auth;
$cartCount = 0;
if (Auth::check()) {
    $userCart = \App\Models\Cart::where('user_id', Auth::id())->first();
    $cartCount = $userCart ? $userCart->items->sum('quantity') : 0;
} else {
    $guestId = request()->cookie('guest_id');
    if ($guestId) {
        $guestCart = \App\Models\Cart::where('guest_id', $guestId)->first();
        $cartCount = $guestCart ? $guestCart->items->sum('quantity') : 0;
    }
}
@endphp

<header class="w-full bg-white z-50 flex flex-col" x-data="{ mobileOpen: false, userMenuOpen: false }">
    
    <div class="bg-near-black text-white h-9 hidden md:flex items-center text-[11px] font-bold uppercase">
        <div class="max-w-[1780px] w-full mx-auto px-4 sm:px-6 lg:px-10 flex justify-between items-center h-full">
            <div class="flex items-center gap-6 h-full">
                <a href="#" class="flex items-center gap-1.5 hover:text-primary transition h-full"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.242-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>Hệ thống showroom</a>
                <a href="#" class="flex items-center gap-1.5 hover:text-primary transition h-full"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>Bán hàng trực tuyến</a>
                <a href="#" class="hover:text-primary transition h-full flex items-center">Trang tin công nghệ</a>
                <a href="#" class="flex items-center gap-1.5 hover:text-primary transition h-full"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>Tư vấn Build PC</a>
                <a href="#" class="hover:text-primary transition h-full flex items-center">Phần mềm hay</a>
            </div>
            
            <div class="flex items-center gap-3 h-full relative">
                @auth
                    
                    <div class="relative h-full flex items-center" @click.away="userMenuOpen = false">
                        <button @click="userMenuOpen = !userMenuOpen" class="flex items-center gap-2 hover:text-primary transition font-bold text-[11px] uppercase focus:outline-none">
                            Xin chào, {{ Auth::user()->name }}
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        
                        <div x-show="userMenuOpen" x-transition.opacity class="absolute right-0 top-full mt-1 w-48 bg-white border border-slate-100 rounded-md shadow-2xl py-2 z-50 text-near-black normal-case">
                            @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-xs font-bold hover:bg-slate-50 transition">
                                <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                                Trang quản trị
                            </a>
                            <div class="border-t border-slate-50 my-1"></div>
                            @endif
                            
                            <a href="{{ route('orders.history') }}" class="flex items-center gap-3 px-4 py-2.5 text-xs font-bold hover:bg-slate-50 transition">
                                <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                Đơn hàng của tôi
                            </a>
                            <div class="border-t border-slate-50 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2.5 text-xs font-bold text-red-600 hover:bg-red-50 transition">Đăng xuất</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('register') }}" class="hover:text-primary transition normal-case">Đăng ký</a>
                    <span class="text-secondary-gray">|</span>
                    <a href="{{ route('login') }}" class="hover:text-primary transition normal-case">Đăng nhập</a>
                @endauth
            </div>
        </div>
    </div>

    
    <div class="bg-white py-4 md:py-6 border-b border-slate-100">
        <div class="max-w-[1780px] mx-auto px-4 sm:px-6 lg:px-10 flex flex-wrap lg:flex-nowrap items-center justify-between gap-6">
            
            <a href="{{ route('home') }}" class="flex-shrink-0">
                <div class="flex items-center gap-1">
                    <svg class="w-10 h-10 text-primary" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2L2 7l10 5l10-5l-10-5zM2 17l10 5l10-5M2 12l10 5l10-5" />
                    </svg>
                    <span class="text-3xl font-black text-near-black">Bo<span class="text-primary">PC</span></span>
                </div>
            </a>

            
            <div class="flex-1 max-w-3xl order-last lg:order-none w-full">
                <form action="{{ route('search') }}" method="GET" class="flex items-center w-full h-12 bg-white border border-primary/40 rounded-md focus-within:ring-4 focus-within:ring-primary/10 focus-within:border-primary transition-all overflow-hidden shadow-sm">
                    
                    @php
                        $searchCategories = \App\Models\Category::whereNull('parent_id')->get();
                    @endphp
                    <select name="cat" class="hidden sm:block h-full bg-slate-50 border-y-0 border-l-0 px-4 border-r border-slate-200 text-xs font-bold text-secondary-gray focus:ring-0 cursor-pointer hover:bg-slate-100 transition-colors max-w-[150px]">
                        <option value="">Tất cả danh mục</option>
                        @foreach($searchCategories as $cat)
                        <option value="{{ $cat->slug }}" {{ request('cat') == $cat->slug ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Tìm kiếm sản phẩm..."
                        class="flex-1 h-full px-4 bg-transparent border-none focus:ring-0 text-sm font-bold text-near-black placeholder-secondary-gray">
                    
                    <button type="submit" class="w-14 h-full bg-primary text-white flex items-center justify-center transition-all hover:bg-primary-hover">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="8" />
                            <path d="M21 21l-4.35-4.35" />
                        </svg>
                    </button>
                </form>
                
                <div class="hidden sm:flex gap-4 mt-2 text-[11px] text-secondary-gray font-medium">
                    <a href="#" class="hover:text-primary transition">PC Gaming</a>
                    <a href="#" class="hover:text-primary transition">Linh kiện máy tính</a>
                    <a href="#" class="hover:text-primary transition">Màn hình</a>
                    <a href="#" class="hover:text-primary transition">Laptop</a>
                </div>
            </div>

            
            <div class="flex items-center gap-2 sm:gap-4 shrink-0">
                <div class="hidden xl:flex items-center gap-3 px-3 py-2 bg-slate-50/50 rounded-md">
                    <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center border border-slate-200 shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    </div>
                    <div>
                        <div class="text-[10px] font-bold text-near-black">Hotline mua hàng</div>
                        <div class="text-sm font-black text-near-black">1900 1234</div>
                    </div>
                </div>

                <a href="{{ route('order.tracking') }}" class="hidden lg:flex items-center gap-3 px-3 py-2 bg-slate-50/50 rounded-md transition group">
                    <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center border border-slate-200 shrink-0 group-hover:bg-slate-50 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <div class="text-[10px] font-bold text-near-black">Tra cứu</div>
                        <div class="text-xs font-black text-near-black">Đơn hàng</div>
                    </div>
                </a>

                <a href="{{ route('cart.index') }}" class="flex items-center gap-3 px-4 py-2 bg-slate-50/50 rounded-md transition group">
                    <div class="relative w-10 h-10 rounded-full bg-white flex items-center justify-center border border-slate-200 shrink-0 group-hover:bg-slate-50 transition">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        @if($cartCount > 0)
                        <span class="absolute -top-1 -right-1 w-4 h-4 bg-primary text-white text-[9px] font-black rounded-md flex items-center justify-center border-2 border-white">
                            {{ $cartCount > 9 ? '9+' : $cartCount }}
                        </span>
                        @endif
                    </div>
                    <div class="hidden lg:block">
                        <div class="text-[10px] font-bold text-near-black">Giỏ hàng</div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    
    <nav class="bg-white border-b border-slate-100 hidden md:block">
        <div class="max-w-[1780px] mx-auto px-4 sm:px-6 lg:px-10 flex h-12">
            
            <div class="relative h-full shrink-0 group z-50">
                <div class="h-full bg-near-black text-white px-6 flex items-center gap-3 cursor-pointer hover:bg-near-black/90 transition min-w-[260px]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <span class="text-xs font-black uppercase">Danh mục sản phẩm</span>
                </div>
                
                @php
                    $globalCategories = \App\Models\Category::whereNull('parent_id')->with('children')->get();
                @endphp
                
                @if($globalCategories->count() > 0)
                <div class="absolute top-full left-0 w-full bg-white border-x border-b border-slate-100 shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 rounded-b-md divide-y divide-slate-50 pt-1 pb-2">
                    @foreach($globalCategories as $category)
                    <div class="relative group/item">
                        <a href="{{ route('home', ['category' => $category->slug]) }}" class="flex items-center justify-between px-6 py-3 hover:bg-slate-50 transition-colors">
                            <span class="text-xs font-bold text-near-black uppercase">{{ $category->name }}</span>
                            @if($category->children->count() > 0)
                            <svg class="w-3.5 h-3.5 text-secondary-gray/50" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            @endif
                        </a>
                        
                        @if($category->children->count() > 0)
                        <div class="absolute top-0 left-[99%] w-56 bg-white border border-slate-100 shadow-xl opacity-0 invisible group-hover/item:opacity-100 group-hover/item:visible transition-all duration-200 rounded-md divide-y divide-slate-50 ml-1 py-1">
                            @foreach($category->children as $child)
                            <a href="{{ route('home', ['category' => $child->slug]) }}" class="block px-5 py-2.5 text-xs font-bold text-secondary-gray hover:text-primary hover:bg-slate-50 transition-colors">
                                {{ $child->name }}
                            </a>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            
            @php
            $menuItems = [
                ['label' => 'PC Gaming', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>'],
                ['label' => 'PC Workstation 2D 3D', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>'],
                ['label' => 'PC AMD Gaming', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>'],
                ['label' => 'PC Mini', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>'],
                ['label' => 'PC Văn phòng', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>'],
                ['label' => 'Linh kiện máy tính', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>'],
            ];
            @endphp
            <div class="flex-1 overflow-x-auto scrollbar-none flex">
                @foreach($menuItems as $item)
                <a href="#" class="h-full px-5 flex items-center gap-2 text-[11px] font-bold text-near-black hover:text-primary transition-colors uppercase whitespace-nowrap">
                    <svg class="w-4 h-4 text-near-black/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $item['icon'] !!}</svg>
                    {{ $item['label'] }}
                </a>
                @endforeach
            </div>
        </div>
    </nav>
</header>
