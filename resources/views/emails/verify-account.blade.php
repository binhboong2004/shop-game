<!DOCTYPE html>
<html>
<head>
    <title>Xác nhận tạo tài khoản</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <div style="max-w-md: 600px; margin: 0 auto; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <h2 style="color: #E70814; text-align: center;">Chào mừng đến với ShopNickVN!</h2>
        <p>Chào <strong>{{ $user->name }}</strong>,</p>
        <p>Cảm ơn bạn đã đăng ký tài khoản tại hệ thống của chúng tôi.</p>
        <p>Vui lòng click vào nút bên dưới để xác thực địa chỉ email của bạn và kích hoạt tài khoản:</p>
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ $tokenUrl }}" style="background-color: #E70814; color: #ffffff; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block;">Kích Hoạt Tài Khoản</a>
        </div>
        <p>Nếu bạn không phải là người tạo tài khoản này, vui lòng bỏ qua email này.</p>
        <hr style="border: 0; border-top: 1px solid #eeeeee; margin: 20px 0;">
        <p style="font-size: 12px; color: #888888; text-align: center;">Trân trọng,<br>Ban Quản Trị ShopNickVN</p>
    </div>
</body>
</html>
