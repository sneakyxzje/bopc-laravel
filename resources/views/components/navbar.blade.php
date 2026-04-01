<div class="bg-[#0e4d3d]">
    <div class="max-w-screen-xl mx-auto px-4 flex items-center justify-between gap-2 py-1.5">

        <div class="flex items-center gap-1.5 flex-wrap">

            <a href="#"
                class="inline-flex items-center gap-1.5 text-white text-xs font-medium px-3 py-1 rounded-full border border-white/25 bg-white/10 hover:bg-white/20 transition whitespace-nowrap">
                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z" />
                    <circle cx="12" cy="10" r="3" />
                </svg>
                Hệ thống showroom
            </a>

            <a href="#"
                class="inline-flex items-center gap-1.5 text-white text-xs font-medium px-3 py-1 rounded-full border border-white/25 bg-white/10 hover:bg-white/20 transition whitespace-nowrap">
                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.15 12a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.06 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.09 8.91a16 16 0 0 0 5.98 5.98l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21 16.92z" />
                </svg>
                Bán hàng trực tuyến
            </a>

            <a href="#" class="text-white/80 text-xs font-medium px-3 py-1 hover:text-white transition whitespace-nowrap">
                Trang tin công nghệ
            </a>

            <a href="#"
                class="inline-flex items-center gap-1.5 text-[#0e4d3d] text-xs font-semibold px-3 py-1 rounded-full bg-[#e8f5e9] hover:bg-[#c8e6c9] transition whitespace-nowrap">
                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="#0e4d3d" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="2" y="3" width="20" height="14" rx="2" />
                    <line x1="8" y1="21" x2="16" y2="21" />
                    <line x1="12" y1="17" x2="12" y2="21" />
                </svg>
                TƯ VẤN BUILD PC
            </a>

            <a href="#" class="text-white/80 text-xs font-medium px-3 py-1 hover:text-white transition whitespace-nowrap">
                Phần mềm hay
            </a>

        </div>

        <div class="flex items-center gap-1 text-white text-xs font-medium shrink-0">
            @auth
            <span class="opacity-90">Chào, {{ Auth::user()->name }}</span>
            <span class="opacity-40 mx-1">|</span>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="hover:underline opacity-90 cursor-pointer">Đăng xuất</button>
            </form>
            @else
            <a href="{{ route('register') }}" class="hover:underline opacity-90">Đăng ký</a>
            <span class="opacity-40 mx-1">|</span>
            <a href="{{ route('login') }}" class="hover:underline opacity-90">Đăng nhập</a>
            @endauth
        </div>

    </div>
</div>

<div class="sticky top-0 z-50 bg-white/95 backdrop-blur-md shadow-sm">
    <div class="max-w-screen-xl mx-auto px-4 py-3 flex items-start justify-between gap-4 lg:gap-8">

        <a href="{{ route('home') }}" class="flex items-center gap-2 shrink-0 pt-0.5">
            <div class="w-10 h-10 bg-[#0e4d3d] rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
                </svg>
            </div>
            <span class="text-2xl font-black tracking-tight text-[#0e4d3d] leading-none hidden sm:block">
                BO<span class="text-red-500">PC</span>
            </span>
        </a>

        <div class="flex-1 min-w-0 max-w-3xl">
            <form action="#" method="GET">
                <div class="flex items-center border-2 border-slate-200 rounded-lg overflow-hidden focus-within:border-[#0e4d3d] transition-colors bg-white">

                    <select name="category"
                        class="hidden lg:block appearance-none bg-slate-100 border-r border-slate-200 pl-3 pr-7 h-11 text-sm font-medium text-slate-700 cursor-pointer outline-none shrink-0
                               bg-[url('data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20width%3D%2212%22%20height%3D%2212%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%23475569%22%20stroke-width%3D%222.5%22%3E%3Cpolyline%20points%3D%226%209%2012%2015%2018%209%22/%3E%3C/svg%3E')]
                               bg-no-repeat bg-[center_right_8px]">
                        <option value="">Tất cả danh mục</option>
                        <option value="pc-gaming">PC Gaming</option>
                        <option value="linh-kien">Linh kiện máy tính</option>
                        <option value="man-hinh">Màn hình</option>
                    </select>

                    <input type="text"
                        name="q"
                        placeholder="Tìm kiếm sản phẩm..."
                        class="flex-1 px-3 h-11 text-sm text-slate-700 placeholder-slate-400 outline-none min-w-0" />

                    <button type="submit"
                        class="w-12 h-11 bg-red-500 hover:bg-red-600 transition flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="8" />
                            <path d="M21 21l-4.35-4.35" />
                        </svg>
                    </button>

                </div>

                <div class="hidden sm:flex items-center gap-3 mt-1.5 px-1">
                    <a href="#" class="text-[11px] text-slate-500 hover:text-[#0e4d3d] transition">PC Gaming</a>
                    <a href="#" class="text-[11px] text-slate-500 hover:text-[#0e4d3d] transition">Linh kiện máy tính</a>
                    <a href="#" class="text-[11px] text-slate-500 hover:text-[#0e4d3d] transition">Màn hình</a>
                </div>
            </form>
        </div>

        <div class="flex items-center gap-2 lg:gap-3 shrink-0 pt-[2px]">

            <a href="tel:0986552233"
                class="hidden xl:flex items-center gap-2.5 px-3 py-1.5 border border-slate-200 rounded-xl hover:border-[#0e4d3d] hover:bg-green-50 transition group">
                <div class="w-8 h-8 rounded-full bg-green-50 group-hover:bg-green-100 flex items-center justify-center transition">
                    <svg class="w-4 h-4 text-[#0e4d3d]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.15 12a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.06 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.09 8.91a16 16 0 0 0 5.98 5.98l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21 16.92z" />
                    </svg>
                </div>
                <div class="leading-tight">
                    <div class="text-[10px] text-slate-400 font-medium">Hotline mua hàng</div>
                    <div class="text-xs font-bold text-[#0e4d3d]">xxx.xxxx.xxx</div>
                </div>
            </a>

            <a href="#"
                class="hidden md:flex items-center gap-2.5 px-3 py-1.5 border border-slate-200 rounded-xl hover:border-[#0e4d3d] hover:bg-green-50 transition group">
                <div class="w-8 h-8 rounded-full bg-slate-50 group-hover:bg-green-100 flex items-center justify-center transition">
                    <svg class="w-4 h-4 text-slate-600 group-hover:text-[#0e4d3d] transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="2" y="3" width="20" height="14" rx="2" />
                        <line x1="8" y1="21" x2="16" y2="21" />
                        <line x1="12" y1="17" x2="12" y2="21" />
                    </svg>
                </div>
                <div class="leading-tight">
                    <div class="text-[10px] text-slate-400 font-medium">Xây dựng</div>
                    <div class="text-xs font-bold text-slate-700">Cấu hình PC</div>
                </div>
            </a>

            <a href="#"
                class="flex items-center gap-2 px-3 py-1.5 border border-slate-200 rounded-xl hover:border-[#0e4d3d] hover:bg-green-50 transition group relative">
                <div class="relative">
                    <svg class="w-5 h-5 text-slate-600 group-hover:text-[#0e4d3d] transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="9" cy="21" r="1" />
                        <circle cx="20" cy="21" r="1" />
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" />
                    </svg>
                </div>
                <span class="text-sm font-semibold text-slate-700 group-hover:text-[#0e4d3d] transition hidden sm:block">Giỏ hàng</span>
            </a>

        </div>
    </div>
</div>

<div class="bg-white border-b border-slate-100 shadow-sm">
    <div class="max-w-screen-xl mx-auto px-4 flex items-center overflow-x-auto scrollbar-none">

        <button class="flex items-center gap-2 bg-[#1a1a2e] text-white font-bold text-sm px-5 h-12 whitespace-nowrap shrink-0 hover:bg-[#0e0e1f] transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <line x1="3" y1="6" x2="21" y2="6" />
                <line x1="3" y1="12" x2="21" y2="12" />
                <line x1="3" y1="18" x2="21" y2="18" />
            </svg>
            DANH MỤC SẢN PHẨM
        </button>

        @php
        $navItems = [
        ['label' => 'PC GAMING', 'icon' => 'gaming', 'href' => '#'],
        ['label' => 'PC WORKSTATION 2D 3D', 'icon' => 'workstation', 'href' => '#'],
        ['label' => 'PC AMD GAMING', 'icon' => 'amd', 'href' => '#'],
        ['label' => 'PC MINI', 'icon' => 'mini', 'href' => '#'],
        ['label' => 'PC VĂN PHÒNG', 'icon' => 'office', 'href' => '#'],
        ['label' => 'Linh kiện máy tính', 'icon' => 'parts', 'href' => '#'],
        ];
        @endphp

        @foreach($navItems as $item)
        <a href="{{ $item['href'] }}"
            class="flex items-center gap-2 px-4 h-12 text-xs font-semibold text-slate-700 whitespace-nowrap border-r border-slate-100 hover:text-[#0e4d3d] hover:bg-green-50 transition shrink-0 last:border-r-0">

            @if($item['icon'] === 'gaming')
            <svg class="w-4 h-4 text-[#0e4d3d] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <rect x="2" y="6" width="20" height="12" rx="3" />
                <line x1="6" y1="12" x2="10" y2="12" />
                <line x1="8" y1="10" x2="8" y2="14" />
                <circle cx="16" cy="11" r="0.5" fill="currentColor" />
                <circle cx="18" cy="13" r="0.5" fill="currentColor" />
            </svg>
            @elseif($item['icon'] === 'workstation')
            <svg class="w-4 h-4 text-[#0e4d3d] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <rect x="2" y="3" width="20" height="14" rx="2" />
                <path d="M8 21h8M12 17v4" />
            </svg>
            @elseif($item['icon'] === 'amd')
            <svg class="w-4 h-4 text-red-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <polygon points="12 2 22 8.5 22 15.5 12 22 2 15.5 2 8.5" />
            </svg>
            @elseif($item['icon'] === 'mini')
            <svg class="w-4 h-4 text-[#0e4d3d] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <rect x="5" y="5" width="14" height="14" rx="2" />
                <rect x="9" y="9" width="6" height="6" rx="1" />
            </svg>
            @elseif($item['icon'] === 'office')
            <svg class="w-4 h-4 text-[#0e4d3d] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <rect x="2" y="7" width="20" height="15" rx="2" />
                <path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2" />
                <line x1="12" y1="12" x2="12" y2="16" />
                <line x1="10" y1="14" x2="14" y2="14" />
            </svg>
            @else
            <svg class="w-4 h-4 text-[#0e4d3d] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M9 3H5a2 2 0 0 0-2 2v4m6-6h10a2 2 0 0 1 2 2v4M9 3v18m0 0h10a2 2 0 0 0 2-2V9M9 21H5a2 2 0 0 1-2-2V9m0 0h18" />
            </svg>
            @endif

            {{ $item['label'] }}
        </a>
        @endforeach

    </div>
</div>