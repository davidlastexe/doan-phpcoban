<!DOCTYPE html>
<html lang="vi">

<?php
layout("head", ["title" => "Đăng nhập"]);
?>

<body>
  <div class="container mx-auto grid h-screen place-items-center">
    <form @submit.prevent="() => {}" method="post" action="" novalidate>
      <div class="flex flex-col mx-auto md:w-96 w-full">
        <h1 class="text-2xl font-bold mb-4 text-center">Đăng ký</h1>
        <div class="flex flex-col gap-2 mb-4">
          <label for="fullname" class="required">Họ Tên</label>
          <input id="fullname" type="text" name="fullname" placeholder="Nhập tên" class="input w-full" />
        </div>

        <div class="flex flex-col gap-2 mb-4">
          <label for="email" class="required">Email</label>
          <input id="email" name="email" type="email" placeholder="Nhập Email" class="input w-full" />
        </div>

        <div class="flex flex-col gap-2 mb-4">
          <label for="password" class="required">Mật khẩu</label>
          <input id="password" name="password" type="password" placeholder="Đặt mật khẩu" class="input w-full" />
        </div>

        <div class="flex flex-col gap-2">
          <label for="password_confirmation" class="required">
            Xác nhận mật khẩu
          </label>
          <input id="password_confirmation" name="password_confirmation" type="password" placeholder="Xác nhận mật khẩu" class="input w-full" />
        </div>

        <div class="border-t h-[1px] my-6"></div>

        <div class="flex flex-col gap-2">
          <button type="submit" class="btn">Đăng ký</button>
        </div>
      </div>
    </form>
  </div>
</body>

</html>