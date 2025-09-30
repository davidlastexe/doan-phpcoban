<!DOCTYPE html>
<html lang="vi">

<?php
use App\Helpers\Helpers;

Helpers::layout("head", ["title" => "Đăng nhập"]);
?>

<body>
  <div class="container mx-auto grid h-screen place-items-center">
    <form
      id="login-form"
      novalidate
    >
      <div class="flex flex-col mx-auto md:w-96 w-full">
        <h1 class="text-2xl font-bold mb-4 text-center">Đăng nhập</h1>
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

        <div class="flex flex-col gap-2 mb-4">
          <label
            for="password"
            class="required"
          >Mật khẩu</label>
          <input
            id="password"
            name="password"
            type="password"
            placeholder="Đặt mật khẩu"
            class="input w-full"
            data-field="password"
            required
          />
          <div
            class="error-log hidden"
            data-field="password"
          ></div>
        </div>

        <div class="border-t h-[1px] my-6"></div>

        <div class="flex flex-col gap-2 items-center">
          <button
            type="submit"
            class="btn w-full"
          >Đăng nhập</button>
          <div>
            <a
              href="<?php echo _HOST_URL; ?>/forgot-password"
              class="underline"
            >Quên mật khẩu?</a>
          </div>
          <div>
            <span>Chưa có tài khoản?
              <a
                href="<?php echo _HOST_URL; ?>/register"
                class="underline"
              >Đăng ký</a>
            </span>
          </div>
        </div>
      </div>
    </form>
  </div>
  <script
    type="module"
    src="./public/js/pages/auth/login.js"
  ></script>
</body>

</html>