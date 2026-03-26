@extends('layouts.app')

@section('title', 'Đăng nhập - BO PC')

@section('content')
<div class="min-h-[70vh] flex items-center  justify-center py-12 sm:px-6 lg:px-8">

    <div class=" w-full space-y-8">
        <div class="bg-white p-8 rounded-3xl shadow-xl shadow-slate-200/60 border border-slate-100">
            <form class="space-y-6" action="{{ route('login') }}" method="POST">
                @csrf
                <div class="flex items-center justify-center">
                    <h1 class="font-bold text-xl uppercase text-[#0e4d3d]">Đăng nhập</h1>
                </div>
                <div class="space-y-2">
                    <label for="email" class="text-xs font-bold text-slate-700 uppercase tracking-widest px-1">Địa chỉ Email</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-[#0e4d3d] transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206" />
                            </svg>
                        </div>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                            class="block w-full pl-11 pr-4 py-3 border-2 border-slate-100 bg-slate-50/50 rounded-2xl text-slate-700 placeholder-slate-400 focus:outline-none focus:border-[#0e4d3d]/50 focus:bg-white transition-all text-sm sm:text-base @error('email') border-red-500 @enderror"
                            placeholder="name@example.com">
                    </div>
                    @error('email')
                    <p class="text-red-500 text-xs mt-1 px-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2" x-data="{ show: false }">
                    <div class="flex items-center justify-between px-1">
                        <label for="password" class="text-xs font-bold text-slate-700 uppercase tracking-widest">Mật khẩu</label>
                        @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-[11px] font-bold text-red-500 hover:text-red-600 transition uppercase tracking-wider">Quên mật khẩu?</a>
                        @endif
                    </div>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-[#0e4d3d] transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                                <path d="M7 11V7a5 5 0 0110 0v4" />
                            </svg>
                        </div>
                        <input id="password" name="password" :type="show ? 'text' : 'password'" autocomplete="current-password" required
                            class="block w-full pl-11 pr-12 py-3 border-2 border-slate-100 bg-slate-50/50 rounded-2xl text-slate-700 placeholder-slate-400 focus:outline-none focus:border-[#0e4d3d]/50 focus:bg-white transition-all text-sm sm:text-base @error('password') border-red-500 @enderror"
                            placeholder="••••••••">
                        
                        <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-[#0e4d3d] transition-colors">
                            <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg x-show="show" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display: none;">
                                <path d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.049m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88L4.22 4.22m15.56 15.56l-5.66-5.66m0 0a9.96 9.96 0 001.443-4.1C16.477 7.943 12.687 5 8.21 5c-1.1 0-2.148.187-3.123.535" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                    <p class="text-red-500 text-xs mt-1 px-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center">
                    <input id="remember-me" name="remember" type="checkbox"
                        class="h-4 w-4 text-[#0e4d3d] focus:ring-[#0e4d3d] border-slate-300 rounded-lg cursor-pointer transition-all">
                    <label for="remember-me" class="ml-2 block text-sm text-slate-600 font-medium cursor-pointer">
                        Ghi nhớ đăng nhập
                    </label>
                </div>

                <div>
                    <button type="submit"
                        class="group relative cursor-pointer w-full flex justify-center py-3.5 px-4 border border-transparent text-sm font-black rounded-2xl text-white bg-[#0e4d3d] hover:bg-[#0a3a2e] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0e4d3d] transition-all transform hover:-translate-y-0.5 active:translate-y-0 shadow-lg shadow-green-900/20 uppercase tracking-widest">
                        Đăng nhập ngay
                    </button>
                </div>
            </form>

            <div class="mt-8 relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-slate-100"></div>
                </div>
                <div class="relative flex justify-center text-xs uppercase tracking-widest">
                    <span class="px-3 bg-white text-slate-400 font-bold">Hoặc</span>
                </div>
            </div>

            <div class="mt-8 text-center">
                <p class="text-sm text-slate-600 font-medium">
                    Chưa có tài khoản?
                    <a href="{{route('register')}}" class="inline-flex items-center font-black text-red-500 hover:text-red-600 transition-all ml-1 group">
                        Đăng ký miễn phí
                        <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                </p>
            </div>
        </div>


    </div>
</div>
@endsection