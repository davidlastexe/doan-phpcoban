<!DOCTYPE html>
<html lang="en">

<?php
use App\Helpers\Helpers;
Helpers::layout("head", ["title" => "Kích hoạt tài khoản"]);
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
        <h1 class="text-2xl font-bold mb-4 text-center">Kích hoạt tài khoản</h1>

        <!-- NOTE: Thực hiện việc kích hoạt rồi trả về thông báo cho user -->

        <a href="<?php echo _HOST_URL; ?>/login"><button type="button" class="btn w-full">Đến trang đăng nhập</button></a>
      </div>
    </form>
  </div>
</body>

</html>