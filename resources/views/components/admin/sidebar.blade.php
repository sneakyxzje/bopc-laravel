<aside
    :class="sidebarOpen ? 'w-72' : 'w-20'"
    class="bg-white border-r border-slate-100 flex flex-col fixed inset-y-0 left-0 z-50 shadow-[var(--shadow-airbnb)]">

    <div class="h-20 flex items-center px-8 shrink-0">
        <a href="{{ route('home') }}" class="flex items-center gap-2 overflow-hidden">
            <svg class="w-7 h-7 text-primary shrink-0" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2L2 7l10 5l10-5l-10-5zM2 17l10 5l10-5M2 12l10 5l10-5" />
            </svg>
            <span class="text-xl font-bold text-near-black whitespace-nowrap" :class="sidebarOpen ? 'opacity-100' : 'opacity-0 invisible'">
                BoPC <span class="text-primary">Admin</span>
            </span>
        </a>
    </div>

    <nav class="flex-1 overflow-y-auto px-4 mt-4">
        <div class="space-y-8">
            <div>
                <p class="px-4 text-[10px] font-bold text-secondary-gray uppercase mb-4" x-show="sidebarOpen">Overview</p>
                <div class="space-y-1">
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center gap-4 px-4 py-3 rounded-md group {{ request()->routeIs('admin.dashboard') ? 'bg-slate-50 text-near-black shadow-sm' : 'text-secondary-gray hover:bg-slate-50 hover:text-near-black' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.dashboard') ? 'text-primary' : 'text-secondary-gray/60 group-hover:text-primary' }}" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        <span class="text-[14px] font-bold" x-show="sidebarOpen">Bảng điều khiển</span>
                    </a>

                    <a href="{{ route('admin.banners.index') }}"
                        class="flex items-center gap-4 px-4 py-3 rounded-md group {{ request()->routeIs('admin.banners*') ? 'bg-slate-50 text-near-black shadow-sm' : 'text-secondary-gray hover:bg-slate-50 hover:text-near-black' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.banners*') ? 'text-primary' : 'text-secondary-gray/60 group-hover:text-primary' }}" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="text-[14px] font-bold" x-show="sidebarOpen">Quản lý Banners</span>
                    </a>
                </div>
            </div>

            <div>
                <p class="px-4 text-[10px] font-bold text-secondary-gray uppercase mb-4" x-show="sidebarOpen">E-Commerce</p>
                <div class="space-y-1">
                    
                    <a href="{{ route('admin.orders.index') }}"
                        class="flex items-center gap-4 px-4 py-3 rounded-md group {{ request()->routeIs('admin.orders*') ? 'bg-slate-50 text-near-black shadow-sm' : 'text-secondary-gray hover:bg-slate-50 hover:text-near-black' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.orders*') ? 'text-primary' : 'text-secondary-gray/60 group-hover:text-primary' }}" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <span class="text-[14px] font-bold" x-show="sidebarOpen">Đơn hàng</span>
                    </a>

                    <div x-data="{ open: {{ request()->is('admin/products*') || request()->is('admin/categories*') || request()->is('admin/brands*') ? 'true' : 'false' }} }">
                        <button @click="open = !open"
                            class="w-full flex items-center justify-between px-4 py-3 rounded-md group {{ request()->is('admin/products*') ? 'text-near-black' : 'text-secondary-gray hover:bg-slate-50 hover:text-near-black' }}">
                            <div class="flex items-center gap-4">
                                <svg class="w-5 h-5 {{ request()->is('admin/products*') ? 'text-primary' : 'text-secondary-gray/60 group-hover:text-primary' }}" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                                <span class="text-[14px] font-bold" x-show="sidebarOpen">Sản phẩm</span>
                            </div>
                            <svg x-show="sidebarOpen" :class="open ? 'rotate-180' : ''" class="w-4 h-4 text-secondary-gray/40" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open && sidebarOpen" class="pl-12 py-2 space-y-3">
                            <a href="{{ route('admin.products.index') }}" class="block text-xs font-bold uppercase {{ request()->routeIs('admin.products.index') ? 'text-primary' : 'text-secondary-gray hover:text-near-black' }}">Danh sách SP</a>
                            <a href="{{ route('admin.categories.index') }}" class="block text-xs font-bold uppercase {{ request()->routeIs('admin.categories.index') ? 'text-primary' : 'text-secondary-gray hover:text-near-black' }}">Danh mục</a>
                            <a href="{{ route('admin.brands.index') }}" class="block text-xs font-bold uppercase {{ request()->routeIs('admin.brands.index') ? 'text-primary' : 'text-secondary-gray hover:text-near-black' }}">Thương hiệu</a>
                        </div>
                    </div>

                    
                    <a href="{{ route('admin.users.index') }}"
                        class="flex items-center gap-4 px-4 py-3 rounded-md group {{ request()->routeIs('admin.users*') ? 'bg-slate-50 text-near-black shadow-sm' : 'text-secondary-gray hover:bg-slate-50 hover:text-near-black' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.users*') ? 'text-primary' : 'text-secondary-gray/60 group-hover:text-primary' }}" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span class="text-[14px] font-bold" x-show="sidebarOpen">Khách hàng</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    
    <div class="p-6 border-t border-slate-50 bg-slate-50/30">
        <button @click="sidebarOpen = !sidebarOpen"
            class="w-full flex items-center justify-center p-2 rounded-md border border-slate-200 text-secondary-gray/60 hover:bg-white hover:text-primary">
            <svg :class="sidebarOpen ? '' : 'rotate-180'" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
            </svg>
        </button>
    </div>
</aside>