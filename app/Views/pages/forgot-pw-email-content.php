<!DOCTYPE html>
<html lang="vi">

<body
  style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 20px;"
>
  <div
    style="max-width: 600px; margin: 20px auto; padding: 30px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);"
  >
    <h2 style="text-align: center; margin-top: 0;">Yêu Cầu Đặt Lại Mật Khẩu</h2>

    <p>Chào <strong><?php echo $user['full_name']; ?></strong>,</p>

    <p>Chúng tôi đã nhận được yêu cầu đặt lại mật khẩu cho tài khoản Ăn Vặt Shop của bạn. Vui lòng nhấn vào nút bên dưới
      để tạo một mật khẩu mới.</p>

    <div style="text-align: center; margin: 30px 0;">
      <a
        href="<?php echo $forgotPasswordLink; ?>"
        style="background-color: #dc3545; color: #ffffff; padding: 15px 30px; text-decoration: none; border-radius: 5px; font-size: 16px; font-weight: bold;"
      >Đặt Lại Mật Khẩu</a>
    </div>

    <p>Vì lý do bảo mật, liên kết này sẽ chỉ có hiệu lực trong vòng <strong>5 phút</strong>.</p>

    <p style="font-size: 0.9em; color: #666;">Nếu nút trên không hoạt động, bạn có thể sao chép và dán đường link sau
      vào trình duyệt:<br>
      <a
        href="<?php echo $forgotPasswordLink; ?>"
        style="color: #007bff; word-break: break-all;"
      ><?php echo $forgotPasswordLink; ?></a>
    </p>

    <hr style="border: none; border-top: 1px solid #eee; margin: 30px 0;">

    <p style="font-size: 0.8em; color: #888; text-align: center;">Nếu bạn không phải là người thực hiện yêu cầu này, hãy
      bỏ qua email này. Tài khoản của bạn vẫn an toàn.</p>
  </div>
</body>

</html>