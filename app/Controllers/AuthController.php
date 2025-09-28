<?php
namespace App\Controllers;

class AuthController {
  public function __construct() {
    // if (isLoggedIn()) {
    //   header('Location: '._HOST_URL.'/dashboard');
    //   exit();
    // }
  }

  public function showLoginPage() {
    require_once _PATH_URL_VIEWS.'/pages/login.php';
  }

  public function showRegisterPage() {
    require_once _PATH_URL_VIEWS.'/pages/register.php';
  }

  public function showActivatePage() {
    require_once _PATH_URL_VIEWS.'/pages/activate.php';
  }

  public function showForgotPasswordPage() {
    require_once _PATH_URL_VIEWS.'/pages/forgot-password.php';
  }
}