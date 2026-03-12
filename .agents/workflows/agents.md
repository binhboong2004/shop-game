---
description: Quy trình chuẩn hóa để tạo các trang chức năng cho đại lý, đảm bảo tính đồng bộ với giao diện quản trị và tối ưu hóa trải nghiệm người dùng hệ thống.
---

Bước 1: Xác định cấu trúc Hệ thống Agent
Layout Master: Sử dụng file layout riêng dành cho Agent (thường nằm tại resources/views/agents/layouts/master.blade.php).

Assets Quản trị: Chỉ sử dụng CSS/JS từ thư mục public/assets/agents để tránh xung đột với giao diện khách hàng (Clients).

Phân quyền: Đảm bảo trang đang thiết kế nằm trong nhóm Route có Middleware check quyền Agent.

Bước 2: Khởi tạo Trang Chức năng
Tạo file tại: resources/views/agents/pages/{ten-chuc-nang}.blade.php.

Cấu trúc khung:

@extends('agents.layouts.master'): Kế thừa thanh Sidebar và Topbar của quản trị.

@section('title', 'Tên chức năng'): Định nghĩa tiêu đề trang động.

@section('content'): Nội dung chính (thường là Dashboard, Table hoặc Form).

Bước 3: Phát triển UI đặc thù cho Quản trị
Bảng dữ liệu (Tables): Sử dụng các class bảng chuẩn, có hỗ trợ phân trang và bộ lọc tìm kiếm.

Thành phần biểu mẫu (Forms):

Sử dụng @csrf cho mọi form gửi dữ liệu.

Tái sử dụng các partials như thông báo lỗi @include('agents.partials.errors') hoặc thông báo thành công.

Thống kê (Widgets): Thiết kế các thẻ Card hiển thị số dư, doanh thu, tổng đơn hàng bằng Grid hệ thống.

Tuân thủ Design System:

Sử dụng đúng mã màu Accent Color (#E70814) và Dark Mode đã quy định.

Sử dụng các class UI có sẵn để đồng bộ giao diện.

Responsive: Đảm bảo các class Bootstrap hoặc CSS tùy chỉnh hiển thị tốt trên Mobile, tablet,...

Bước 4: Cấu hình Route & Liên kết
Khai báo Route: Mở file routes/web.php để tạo đường dẫn cho trang mới (ví dụ: Route::view('/ten-trang', 'agents.pages.ten-trang');).

Cập nhật Link: Thay đổi các thẻ <a href="..."> cũ thành href="{{ route('name') }}" hoặc href="{{ url('/path') }}" để đảm bảo hệ thống chuyển trang mượt mà.

Xử lý Link Sidebar: Cập nhật file Sidebar partial để mục menu tương ứng có class active khi người dùng đang ở trang đó.