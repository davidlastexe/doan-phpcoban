<!DOCTYPE html>
<html lang="vi">

<?php
use App\Helpers\Helpers;

Helpers::layout("head", ["title" => "Đăng ký"]);
?>

<body>
  <div class="container mx-auto grid h-screen place-items-center">
    <div
      id="register-toast"
      class="toast toast-top toast-center"
    >
    </div>
    <form
      id="register-form"
      novalidate
    >
      <div class="flex flex-col mx-auto md:w-96 w-full">
        <h1 class="text-2xl font-bold mb-4 text-center">Đăng ký</h1>

        <div class="flex flex-col gap-2 mb-4">
          <label
            for="full_name"
            class="required"
          >Họ Tên</label>
          <input
            id="full_name"
            type="text"
            name="full_name"
            placeholder="Nhập tên"
            class="input w-full"
            data-field="full_name"
            required
          />
          <div
            class="error-log hidden"
            data-field="full_name"
          ></div>
        </div>

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
          <label for="phone_number">Số điện thoại</label>
          <input
            id="phone_number"
            name="phone_number"
            type="tel"
            placeholder="Nhập số điện thoại"
            class="input w-full"
            data-field="phone_number"
          />
          <div
            class="error-log hidden"
            data-field="phone_number"
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

        <div class="flex flex-col gap-2">
          <label
            for="confirm_password"
            class="required"
          >
            Xác nhận mật khẩu
          </label>
          <input
            id="confirm_password"
            name="confirm_password"
            type="password"
            placeholder="Xác nhận mật khẩu"
            class="input w-full"
            data-field="confirm_password"
            required
          />
          <div
            class="error-log hidden"
            data-field="confirm_password"
          ></div>
        </div>

        <div class="border-t h-[1px] my-6"></div>

        <div class="flex flex-col gap-2 items-center">
          <button
            type="submit"
            class="btn w-full"
          >Đăng ký</button>
          <div>
            <span>Đã có tài khoản?
              <a
                href="<?php echo _HOST_URL; ?>/login"
                class="underline"
              >Đăng nhập</a>
            </span>
          </div>
        </div>
      </div>
    </form>
  </div>
  <script
    type="module"
    src="./public/js/pages/register.js"
  ></script>
</body>

</html>