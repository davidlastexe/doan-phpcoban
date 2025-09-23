<?php
namespace App\Controllers;


class AuthController {
  public function __construct() {
    // if (isLoggedIn()) {
    //   header('Location: '._HOST_URL.'/dashboard');
    //   exit();
    // }
  }

  public function showLoginForm() {
    require_once _PATH_URL_VIEWS.'/pages/login.php';
  }

  public function showRegisterForm() {
    require_once _PATH_URL_VIEWS.'/pages/register.php';
  }

  // public function handleRegister() {
  //   if (!isPost()) {
  //     http_response_code(405);
  //     echo 'Invalid request method';
  //     return;
  //   }

  //   $filter = filterData();
  //   $errors = [];

  //   $userModel = new User();

  //   // Validate fullname
  //   if (empty($filter['fullname']))
  //     $errors['fullname'][] = "Họ tên không được bỏ trống!";
  //   else if (strlen($filter['fullname']) < 5)
  //     $errors['fullname'][] = "Họ tên phải có ít nhất 5 ký tự!";

  //   // Validate email
  //   if (empty($filter['email']))
  //     $errors['email'][] = "Email không được bỏ trống!";
  //   else if (!validateEmail($filter['email']))
  //     $errors['email'][] = "Email không hợp lệ!";
  //   else if ($userModel->emailExists($filter['email'])) {
  //     $errors['email'][] = "Email đã tồn tại!";
  //   }

  //   // Validate phone
  //   if (!empty($filter['phone']) && !isPhone($filter['phone'])) {
  //     $errors['phone'][] = "Số điện thoại không hợp lệ!";
  //   }

  //   // Validate password
  //   if (empty($filter['password']))
  //     $errors['password'][] = "Mật khẩu không được để trống!";
  //   else if (strlen($filter['password']) < 6)
  //     $errors['password'][] = "Mật khẩu phải lớn hơn 6 ký tự!";

  //   // Validate repassword
  //   if (empty($filter['repassword']))
  //     $errors['repassword'][] = "Hãy nhập lại mật khẩu!";
  //   else if ($filter['repassword'] !== $filter['password'])
  //     $errors['repassword'][] = "Mật khẩu không khớp!";

  //   if (!empty($errors)) {
  //     setSession('form_errors', json_encode($errors));
  //     setSession('old_data', json_encode($filter));
  //     header('Location: '._HOST_URL.'/register');
  //     exit();
  //   }

  //   $emailVerificationToken = sha1(uniqid().time());
  //   $data = [
  //     'fullname' => $filter['fullname'],
  //     'email' => $filter['email'],
  //     'password' => password_hash($filter['password'], PASSWORD_DEFAULT),
  //     'email_verification_token' => $emailVerificationToken,
  //     'group_id' => 1,
  //   ];
  //   if (!empty($filter['phone'])) {
  //     $data['phone'] = $filter['phone'];
  //   }

  //   if (!$userModel->createUser($data)) {
  //     setSession('form_errors', json_encode(['register' => ['Đăng ký thất bại, vui lòng thử lại!']]));
  //     setSession('old_data', json_encode($filter));
  //     header('Location: '._HOST_URL.'/register');
  //     exit();
  //   }

  //   removeSession('form_errors');
  //   removeSession('old_data');

  //   header('Location: '._HOST_URL.'/login?register=success');
  //   exit();
  // }
}