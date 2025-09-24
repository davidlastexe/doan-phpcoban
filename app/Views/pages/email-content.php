<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
  >
  <title>Kích hoạt tài khoản</title>
</head>

<body
  style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; background-color: #f4f4f4; margin: 0; padding: 20px;"
>
  <div
    style="max-width: 600px; margin: 0 auto; background-color: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);"
  >
    <h2 style="color: #0056b3; text-align: center; margin-top: 0;">Chào mừng bạn đến với Ăn Vặt Shop!</h2>

    <p>Chào <strong><?php echo $formData['full_name']; ?></strong>,</p>
    <p>Cảm ơn bạn đã tin tưởng và đăng ký tài khoản tại cửa hàng của chúng tôi. Chỉ còn một bước cuối cùng nữa thôi!</p>
    <p>Vui lòng nhấn vào nút bên dưới để kích hoạt tài khoản và bắt đầu hành trình khám phá thế giới đồ ăn vặt hấp dẫn.
    </p>

    <div style="text-align: center; margin: 30px 0;">
      <a
        href="<?php echo $activationLink; ?>"
        style="background-color: #007bff; color: #ffffff; padding: 15px 30px; text-decoration: none; border-radius: 5px; font-size: 16px; font-weight: bold;"
      >Kích Hoạt Tài Khoản</a>
    </div>

    <p>Vì lý do bảo mật, link kích hoạt sẽ hết hạn sau <strong>30 phút</strong>.</p>
    <p style="font-size: 0.9em; color: #666;">Nếu nút trên không hoạt động, bạn có thể sao chép và dán đường link sau
      vào trình duyệt:<br>
      <a
        href="<?php echo $activationLink; ?>"
        style="color: #007bff; word-break: break-all;"
      ><?php echo $activationLink; ?></a>
    </p>

    <hr style="border: none; border-top: 1px solid #eee; margin: 30px 0;">

    <p style="font-size: 0.8em; color: #888; text-align: center;">Nếu bạn không phải là người thực hiện đăng ký này, vui
      lòng bỏ qua email.</p>
  </div>
</body>

</html>