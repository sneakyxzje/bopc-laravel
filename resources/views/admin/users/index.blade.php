@extends('layouts.admin')

@section('title', 'Quản lý khách hàng')
@section('page_title', 'Quản lý khách hàng')

@section('content')
<div class="mx-auto">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div class="flex-1 max-w-md">
            <form action="{{ route('admin.users.index') }}" method="GET" class="relative">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Tìm theo tên, email, số điện thoại..."
                    class="w-full pl-10 pr-4 py-2.5 bg-white border border-zinc-200 rounded-md focus:ring-primary focus:border-primary shadow-sm text-sm">
                <div class="absolute left-3 top-2.5 text-zinc-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </form>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-600 rounded-md text-sm font-bold flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-600 rounded-md text-sm font-bold flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
        {{ session('error') }}
    </div>
    @endif

    <div class="bg-white rounded-md border border-zinc-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-zinc-50/50 border-b border-zinc-100">
                        <th class="px-6 py-4 text-[11px] font-black text-zinc-400 uppercase">Khách hàng</th>
                        <th class="px-6 py-4 text-[11px] font-black text-zinc-400 uppercase">Liên hệ</th>
                        <th class="px-6 py-4 text-[11px] font-black text-zinc-400 uppercase text-center">Vai trò</th>
                        <th class="px-6 py-4 text-[11px] font-black text-zinc-400 uppercase text-center">Trạng thái</th>
                        <th class="px-6 py-4 text-[11px] font-black text-zinc-400 uppercase">Ngày tham gia</th>
                        <th class="px-6 py-4 text-[11px] font-black text-zinc-400 uppercase text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse($users as $user)
                    <tr class="hover:bg-zinc-50/50 group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">

                                <div>
                                    <div class="text-sm font-bold text-zinc-900">{{ $user->name }}</div>
                                    <div class="text-[11px] text-zinc-400 font-medium italic">ID: #{{ $user->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-xs font-semibold text-zinc-600">{{ $user->email }}</div>
                            <div class="text-[11px] text-zinc-400">{{ $user->phone ?? 'Chưa cập nhật SĐT' }}</div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($user->role === 'admin')
                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-black bg-indigo-50 text-indigo-600 border border-indigo-100 uppercase">Quản trị viên</span>
                            @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-black bg-zinc-100 text-zinc-500 border border-zinc-200 uppercase">Khách hàng</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($user->is_active)
                            <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-600 uppercase">
                                Hoạt động
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1 text-[10px] font-bold text-red-500 uppercase">
                                Bị khóa
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-xs text-zinc-500">
                            {{ $user->created_at->format('d/m/Y') }}
                            <div class="text-[10px] text-zinc-400">{{ $user->created_at->diffForHumans() }}</div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                @if($user->role !== 'admin')
                                <form action="{{ route('admin.users.toggle_status', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        title="{{ $user->is_active ? 'Khóa tài khoản' : 'Mở khóa tài khoản' }}"
                                        class="w-8 h-8 rounded-md flex items-center justify-center bg-white border border-zinc-200 shadow-sm hover:shadow-md 
                                                {{ $user->is_active ? 'text-amber-500 hover:bg-amber-50' : 'text-emerald-500 hover:bg-emerald-50' }}">
                                        @if($user->is_active)
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                        @else
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z" />
                                        </svg>
                                        @endif
                                    </button>
                                </form>

                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa khách hàng này? Thao tác này không thể hoàn tác!')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Xóa khách hàng"
                                        class="w-8 h-8 rounded-md flex items-center justify-center bg-white border border-zinc-200 shadow-sm hover:shadow-md text-red-500 hover:bg-red-50">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-zinc-400 italic">
                            Không tìm thấy khách hàng nào phù hợp...
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
        <div class="px-6 py-4 bg-zinc-50/50 border-t border-zinc-100">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>
@endsection