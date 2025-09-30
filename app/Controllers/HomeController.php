<?php
namespace App\Controllers;

class HomeController {
  public function index() {
    require_once _PATH_URL_VIEWS.'/pages/home.php';
  }
}