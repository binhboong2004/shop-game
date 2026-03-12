---
trigger: always_on
---

# Tiêu chuẩn thiết kế ShopNickVN

## 1. Phong cách giao diện (UI Style)
- **Tông màu chủ đạo:** Dark Mode. Sử dụng tông màu đỏ chuyên nghiệp (#E70814) giống như file `index.html`.
- **Màu nhấn (Accent Color):** Màu đỏ rực (#E70814) cho các nút quan trọng (CTA) và icon.
- **Header/Footer/<!-- Floating Chat Button -->:** Luôn giữ nguyên cấu trúc từ file `index.html`.
- **Hiệu ứng:** Các nút bấm và Card sản phẩm phải có hiệu ứng `hover` (thay đổi độ sáng hoặc scale nhẹ).

## 2. Quy định về Code (Coding Standards)
- **HTML:** Cấu trúc chuẩn SEO, sử dụng thẻ ngữ nghĩa (semantic tags).
- **CSS:** Ưu tiên viết Tailwind CSS hoặc dùng các class đã định nghĩa sẵn để đảm bảo tính đồng nhất.
- **Responsive:** Mọi giao diện mới phải hiển thị tốt trên Mobile và Desktop.

## 3. Workflow thực hiện trang mới
1. Đọc cấu trúc từ `index.html` để lấy Header/Footer/<!-- Floating Chat Button -->.
2. Thiết kế phần Body theo mục đích trang (Sản phẩm, Mã giảm giá, Vòng quay may mắn, Nạp thẻ, Tin tức, Hỗ trợ).
3. Đảm bảo các link điều hướng (`<a>`) liên kết chính xác giữa các trang con.