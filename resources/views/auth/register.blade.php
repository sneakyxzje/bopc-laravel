@extends('layouts.app')

@section('title', 'Đăng ký - BO PC')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center py-12 sm:px-6 lg:px-8">

    <div class="max-w-md w-full space-y-8">
        <div class="bg-white p-8 rounded-3xl shadow-xl shadow-slate-200/60 border border-slate-100">
            <form class="space-y-6" action="{{ route('register') }}" method="POST"
                x-data="{
                    name: '{{ old('name') }}',
                    phone: '{{ old('phone') }}',
                    address: '{{ old('address') }}',
                    email: '{{ old('email') }}',
                    password: '',
                    password_confirmation: '',
                    showPassword: false,
                    showConfirmPassword: false,
                    
                    errors: {
                        name: '',
                        phone: '',
                        address: '',
                        email: '',
                        password: '',
                        confirmation: ''
                    },

                    validateName() {
                        this.errors.name = (this.name.length > 0 && this.name.length < 2) ? 'Họ tên quá ngắn' : '';
                    },
                    validatePhone() {
                        const phoneRegex = /(84|0[3|5|7|8|9])+([0-9]{8})\b/;
                        this.errors.phone = (this.phone.length > 0 && !phoneRegex.test(this.phone)) ? 'Số điện thoại không hợp lệ' : '';
                    },
                    validateEmail() {
                        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                        this.errors.email = (this.email.length > 0 && !emailRegex.test(this.email)) ? 'Email không đúng định dạng' : '';
                    },
                    validatePassword() {
                        this.errors.password = (this.password.length > 0 && this.password.length < 8) ? 'Tối thiểu 8 ký tự' : '';
                        this.validateConfirmation();
                    },
                    validateConfirmation() {
                        this.errors.confirmation = (this.password_confirmation.length > 0 && this.password !== this.password_confirmation) ? 'Mật khẩu nhập lại không khớp' : '';
                    }
                }">
                @csrf
                <div class="flex items-center justify-center">
                    <h1 class="font-bold text-xl uppercase text-[#0e4d3d]">Đăng ký tài khoản</h1>
                </div>

                <div class="space-y-2">
                    <label for="name" class="text-xs font-bold text-slate-700 uppercase tracking-widest px-1">Họ và tên</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-[#0e4d3d] transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <input id="name" name="name" type="text" x-model="name" x-on:input.debounce.300ms="validateName()" required autofocus autocomplete="name"
                            class="block w-full pl-11 pr-4 py-3 border-2 border-slate-100 bg-slate-50/50 rounded-2xl text-slate-700 placeholder-slate-400 focus:outline-none focus:border-[#0e4d3d]/50 focus:bg-white transition-all text-sm sm:text-base @error('name') border-red-500 @enderror"
                            placeholder="Nguyễn Văn A...">
                    </div>
                    <p x-show="errors.name" x-text="errors.name" class="text-red-500 text-xs mt-1 px-1 font-medium" x-cloak></p>
                    @error('name')
                    <p class="text-red-500 text-xs mt-1 px-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="phone" class="text-xs font-bold text-slate-700 uppercase tracking-widest px-1">Số điện thoại</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-[#0e4d3d] transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <input id="phone" name="phone" type="text" x-model="phone" x-on:input.debounce.300ms="validatePhone()"
                            class="block w-full pl-11 pr-4 py-3 border-2 border-slate-100 bg-slate-50/50 rounded-2xl text-slate-700 placeholder-slate-400 focus:outline-none focus:border-[#0e4d3d]/50 focus:bg-white transition-all text-sm sm:text-base @error('phone') border-red-500 @enderror"
                            placeholder="09xx xxx xxx">
                    </div>
                    <p x-show="errors.phone" x-text="errors.phone" class="text-red-500 text-xs mt-1 px-1 font-medium" x-cloak></p>
                    @error('phone')
                    <p class="text-red-500 text-xs mt-1 px-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="address" class="text-xs font-bold text-slate-700 uppercase tracking-widest px-1">Địa chỉ</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-[#0e4d3d] transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <input id="address" name="address" type="text" x-model="address"
                            class="block w-full pl-11 pr-4 py-3 border-2 border-slate-100 bg-slate-50/50 rounded-2xl text-slate-700 placeholder-slate-400 focus:outline-none focus:border-[#0e4d3d]/50 focus:bg-white transition-all text-sm sm:text-base @error('address') border-red-500 @enderror"
                            placeholder="Số nhà, tên đường, quận/huyện...">
                    </div>
                    @error('address')
                    <p class="text-red-500 text-xs mt-1 px-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="email" class="text-xs font-bold text-slate-700 uppercase tracking-widest px-1">Email</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-[#0e4d3d] transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206" />
                            </svg>
                        </div>
                        <input id="email" name="email" type="email" x-model="email" x-on:input.debounce.300ms="validateEmail()" required autocomplete="email"
                            class="block w-full pl-11 pr-4 py-3 border-2 border-slate-100 bg-slate-50/50 rounded-2xl text-slate-700 placeholder-slate-400 focus:outline-none focus:border-[#0e4d3d]/50 focus:bg-white transition-all text-sm sm:text-base @error('email') border-red-500 @enderror"
                            placeholder="name@example.com">
                    </div>
                    <p x-show="errors.email" x-text="errors.email" class="text-red-500 text-xs mt-1 px-1 font-medium" x-cloak></p>
                    @error('email')
                    <p class="text-red-500 text-xs mt-1 px-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="password" class="text-xs font-bold text-slate-700 uppercase tracking-widest px-1">Mật khẩu</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-[#0e4d3d] transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                                <path d="M7 11V7a5 5 0 0110 0v4" />
                            </svg>
                        </div>
                        <input id="password" name="password" type="password" x-model="password" x-on:input.debounce.300ms="validatePassword()" :type="showPassword ? 'text' : 'password'" required autocomplete="new-password"
                            class="block w-full pl-11 pr-12 py-3 border-2 border-slate-100 bg-slate-50/50 rounded-2xl text-slate-700 placeholder-slate-400 focus:outline-none focus:border-[#0e4d3d]/50 focus:bg-white transition-all text-sm sm:text-base @error('password') border-red-500 @enderror"
                            placeholder="••••••••">
                        <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-[#0e4d3d] transition-colors">
                            <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display: none;">
                                <path d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.049m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88L4.22 4.22m15.56 15.56l-5.66-5.66m0 0a9.96 9.96 0 001.443-4.1C16.477 7.943 12.687 5 8.21 5c-1.1 0-2.148.187-3.123.535" />
                            </svg>
                        </button>
                    </div>
                    <p x-show="errors.password" x-text="errors.password" class="text-red-500 text-xs mt-1 px-1 font-medium" x-cloak></p>
                    @error('password')
                    <p class="text-red-500 text-xs mt-1 px-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="password_confirmation" class="text-xs font-bold text-slate-700 uppercase tracking-widest px-1">Nhập lại mật khẩu</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-[#0e4d3d] transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                                <path d="M7 11V7a5 5 0 0110 0v4" />
                            </svg>
                        </div>
                        <input id="password_confirmation" name="password_confirmation" type="password" x-model="password_confirmation" x-on:input.debounce.300ms="validateConfirmation()" :type="showConfirmPassword ? 'text' : 'password'" required autocomplete="new-password"
                            class="block w-full pl-11 pr-12 py-3 border-2 border-slate-100 bg-slate-50/50 rounded-2xl text-slate-700 placeholder-slate-400 focus:outline-none focus:border-[#0e4d3d]/50 focus:bg-white transition-all text-sm sm:text-base"
                            placeholder="••••••••">
                        <button type="button" @click="showConfirmPassword = !showConfirmPassword" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-[#0e4d3d] transition-colors">
                            <svg x-show="!showConfirmPassword" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg x-show="showConfirmPassword" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display: none;">
                                <path d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.049m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88L4.22 4.22m15.56 15.56l-5.66-5.66m0 0a9.96 9.96 0 001.443-4.1C16.477 7.943 12.687 5 8.21 5c-1.1 0-2.148.187-3.123.535" />
                            </svg>
                        </button>
                    </div>
                    <p x-show="errors.confirmation" x-text="errors.confirmation" class="text-red-500 text-xs mt-1 px-1 font-medium" x-cloak></p>
                </div>

                <div>
                    <button type="submit"
                        class="group relative cursor-pointer w-full flex justify-center py-3.5 px-4 border border-transparent text-sm font-black rounded-2xl text-white bg-[#0e4d3d] hover:bg-[#0a3a2e] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0e4d3d] transition-all transform hover:-translate-y-0.5 active:translate-y-0 shadow-lg shadow-green-900/20 uppercase tracking-widest">
                        Đăng ký ngay
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
                    Đã có tài khoản?
                    <a href="{{ route('login') }}" class="inline-flex items-center font-black text-red-500 hover:text-red-600 transition-all ml-1 group">
                        Đăng nhập ngay
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