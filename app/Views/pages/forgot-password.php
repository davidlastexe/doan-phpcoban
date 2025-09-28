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
          <label
            for="email"
            class="required"
          >Email</label>
          <input
            id="email"
            name="email"
            type="email"
            placeholder="Nhập Email"
            class="input w-full"
            data-field="email"
            required
          />
          <div
            class="error-log hidden"
            data-field="email"
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
    src="./public/js/pages/forgot-password.js"
  ></script>
</body>

</html>