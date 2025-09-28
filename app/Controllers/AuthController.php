<?php
namespace App\Controllers;

use App\Models\User;

class AuthController {
  public function showLoginPage() {
    require_once _PATH_URL_VIEWS.'/pages/login.php';
  }

  public function showRegisterPage() {
    require_once _PATH_URL_VIEWS.'/pages/register.php';
  }

  public function showActivatePage() {
    if (empty($_GET['token']))
      // TODO: xây dựng hàm helper redirect
      header("Location: {$_ENV['BASE_PROJECT_NAME']}");

    require_once _PATH_URL_VIEWS.'/pages/activate.php';
  }

  public function showForgotPasswordPage() {
    require_once _PATH_URL_VIEWS.'/pages/forgot-password.php';
  }

  public function showResetPasswordPage() {
    if (empty($_GET['token']))
      header("Location: {$_ENV['BASE_PROJECT_NAME']}");

    $userModel = new User();
    $user = $userModel->findUserByForgotPasswordToken($_GET['token']);

    require_once _PATH_URL_VIEWS.'/pages/reset-password.php';
  }
}