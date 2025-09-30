<!DOCTYPE html>
<html lang="en">

<?php
use App\Helpers\Helpers;
Helpers::layout("head", ["title" => "Quên mật khẩu"]);
?>

<body>
  <div class="container mx-auto grid h-screen place-items-center">
    <form
      id="forgot-form"
      novalidate
    >
      <div class="flex flex-col mx-auto md:w-96 w-full">
        <h1 class="text-2xl font-bold mb-4 text-center">Quên mật khẩu</h1>
        <div class="flex flex-col gap-2 mb-4">
          <label for="email_phone_number">Email / Số điện thoại</label>
          <input
            name="email_phone_number"
            type="text"
            placeholder="Nhập Email / Số điện thoại"
            class="input w-full"
            data-field="email_phone_number"
            required
          />
          <div
            class="error-log hidden"
            data-field="email_phone_number"
          ></div>
        </div>

        <div class="border-t h-[1px] my-6"></div>

        <div class="flex flex-col gap-2 items-center">
          <button
            type="submit"
            class="btn w-full"
          >Gửi</button>
        </div>
      </div>
    </form>
  </div>
  <script
    type="module"
    src="./public/js/pages/auth/forgot-password.js"
  ></script>
</body>

</html>