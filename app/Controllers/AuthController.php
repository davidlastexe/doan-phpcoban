<?php
namespace App\Controllers;

use App\Helpers\Helpers;
use App\Models\User;

class AuthController {
  public function showLoginPage() {
    require_once _PATH_URL_VIEWS.'/pages/auth/login.php';
  }

  public function showRegisterPage() {
    require_once _PATH_URL_VIEWS.'/pages/auth/register.php';
  }

  public function showActivatePage() {
    if (empty($_GET['token']))
      Helpers::redirect();

    require_once _PATH_URL_VIEWS.'/pages/auth/activate.php';
  }

  public function showForgotPasswordPage() {
    require_once _PATH_URL_VIEWS.'/pages/auth/forgot-password.php';
  }

  public function showResetPasswordPage() {
    if (empty($_GET['token']))
      Helpers::redirect();

    $userModel = new User();
    $user = $userModel->findUserByForgotPasswordToken($_GET['token']);

    require_once _PATH_URL_VIEWS.'/pages/auth/reset-password.php';
  }
}