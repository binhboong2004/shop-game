@extends('clients.layouts.master')
@section('title', 'Xác thực Email')

@section('content')
<div class="container mx-auto px-4 py-16">
    <div class="max-w-md mx-auto bg-[#1A1A1A] rounded-xl shadow-lg overflow-hidden border border-[#333]">
        <div class="p-8">
            <div class="text-center mb-8">
                <i class="fas fa-envelope-open-text text-5xl text-[#E70814] mb-4"></i>
                <h2 class="text-2xl font-bold text-white mb-2">Xác Thực Email Của Bạn</h2>
                <p class="text-gray-400">
                    Cảm ơn bạn đã đăng ký! Trước khi bắt đầu, vui lòng xác thực địa chỉ email bằng cách nhấp vào liên kết chúng tôi vừa gửi qua email cho bạn.
                </p>
                <p class="text-gray-400 mt-2">
                    Nếu bạn không nhận được email, chúng tôi sẽ vui lòng gửi cho bạn một email khác.
                </p>
            </div>

            @if (session('resent'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">Một liên kết xác thực mới đã được gửi đến địa chỉ email bạn cung cấp trong quá trình đăng ký.</span>
                </div>
            @endif

            <div class="flex flex-col space-y-4">
                <form method="POST" action="{{ route('verification.send') }}" class="w-full">
                    @csrf
                    <button type="submit" class="w-full bg-[#E70814] hover:bg-red-700 text-white font-bold py-3 px-4 rounded transition duration-300">
                        Gửi lại Email xác thực
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}" class="w-full text-center mt-4">
                    @csrf
                    <button type="submit" class="text-gray-400 hover:text-white underline transition duration-300">
                        Đăng xuất
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
