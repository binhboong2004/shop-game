---
description: Quy trình chuẩn hóa để tạo các trang quản trị tổng thể (Quản lý thành viên, Cấu hình Website, Kiểm duyệt giao dịch), đảm bảo tính bảo mật cao và khả năng xử lý dữ liệu lớn.
---

Bước 1: Thiết lập Môi trường Admin (High Security)
Layout Master: Sử dụng file layout tại resources/views/admin/layouts/master.blade.php.

Assets riêng biệt: Tuyệt đối chỉ sử dụng CSS/JS từ public/assets/admin

Middleware: Đảm bảo mọi trang Admin đều được bảo vệ bởi Middleware auth và admin.

Bước 2: Khởi tạo Trang Quản trị
Tạo file tại: resources/views/admin/pages/{chuc-nang}.blade.php.

Cấu trúc chuẩn:

@extends('admin.layouts.master'): Kế thừa khung quản trị (Sidebar, Topbar).

@section('content_header'): Thường dùng để hiển thị Breadcrumbs (Đường dẫn Breadcrumb) và Tiêu đề trang (H1).

@section('content'): Vùng chứa dữ liệu quản trị.

Bước 3: Phát triển Giao diện Quản lý Dữ liệu
Datatables (Bảng thông minh): Thiết kế bảng có khả năng lọc, sắp xếp, và xuất file (Excel/PDF).

Form Cấu hình:

Sử dụng các Input đặc thù: Switch (bật/tắt tính năng), Datepicker, Select2.

Bắt buộc có thông báo xác nhận (Confirm Modal) trước khi thực hiện các hành động nhạy cảm như Xóa hoặc Khóa tài khoản.

Thống kê Tổng (Analytics): Sử dụng các Small Box hoặc Info Box để hiển thị tổng doanh thu, số user mới, và yêu cầu rút tiền đang chờ.

Tuân thủ Design System:

Sử dụng đúng mã màu Accent Color (#E70814) và Dark Mode đã quy định.

Sử dụng các class UI có sẵn để đồng bộ giao diện.

Responsive: Đảm bảo các class Bootstrap hoặc CSS tùy chỉnh hiển thị tốt trên Mobile, tablet,...

Bước 4: Cấu hình Route & Liên kết
Khai báo Route: Mở file routes/web.php để tạo đường dẫn cho trang mới (ví dụ: Route::view('/ten-trang', 'admin.pages.ten-trang');).

Cập nhật Link: Thay đổi các thẻ <a href="..."> cũ thành href="{{ route('name') }}" hoặc href="{{ url('/path') }}" để đảm bảo hệ thống chuyển trang mượt mà.

Xử lý Link Sidebar: Cập nhật file Sidebar partial để mục menu tương ứng có class active khi người dùng đang ở trang đó.