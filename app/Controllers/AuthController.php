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

  public function showActivatePage() {
    require_once _PATH_URL_VIEWS.'/pages/activate.php';
  }
}