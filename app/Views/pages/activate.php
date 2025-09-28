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
    <div class="flex flex-col mx-auto md:w-96 w-full">
      <h1
        id="activate-noti"
        class="text-2xl font-bold mb-4 text-center"
      >Vui lòng chờ kích hoạt tài khoản...</h1>
    </div>
  </div>
  <script
    type="module"
    src="./public/js/pages/activate.js"
  ></script>
</body>

</html>