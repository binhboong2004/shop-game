---
description: Quy trình chuẩn hóa để tạo một trang con (view) mới trong hệ thống Laravel, đảm bảo kế thừa đúng Layout tổng thể và tái sử dụng các thành phần (partials) của ShopNickVN.
---

Bước 1: Phân tích và Chuẩn bị (Blade Context)
Xác định Layout: Kiểm tra file resources/views/clients/layouts/master.blade.php để nắm bắt các vị trí @yield('content'), @stack('css') và @stack('js').

Kế thừa Assets: Đảm bảo các file CSS/JS dùng chung trong public/assets/clients đã được link đúng thông qua hàm {{ asset() }} trong file Master.

Bước 2: Khởi tạo File Blade mới
Tạo file mới tại resources/views/clients/pages/{ten-trang}.blade.php.

Cấu trúc bắt buộc:

@extends('clients.layouts.master'): Để kế thừa khung Header/Footer.

@section('content'): Bao bọc toàn bộ nội dung chính của trang.

Sử dụng @push('css') hoặc @push('js') nếu trang cần thêm các thư viện riêng biệt.

Bước 3: Phát triển Nội dung (Main Content)
Tái sử dụng Component: Nếu nội dung có các phần lặp lại (như danh sách thẻ nạp, danh sách game), hãy sử dụng @include('clients.partials.{name}').

Tuân thủ Design System:

Sử dụng đúng mã màu Accent Color (#E70814) và Dark Mode đã quy định.

Sử dụng các class UI có sẵn trong sanphamchitiet.css để đồng bộ giao diện.

Responsive: Đảm bảo các class Bootstrap hoặc CSS tùy chỉnh hiển thị tốt trên Mobile.

Bước 4: Cấu hình Route & Liên kết
Khai báo Route: Mở file routes/web.php để tạo đường dẫn cho trang mới (ví dụ: Route::view('/ten-trang', 'clients.pages.ten-trang');).

Cập nhật Link: Thay đổi các thẻ <a href="..."> cũ thành href="{{ route('name') }}" hoặc href="{{ url('/path') }}" để đảm bảo hệ thống chuyển trang mượt mà.