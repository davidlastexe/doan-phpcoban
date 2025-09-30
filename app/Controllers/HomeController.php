<?php
namespace App\Controllers;

use App\Core\View;

class HomeController {
  public function index() {
    View::render('pages/home', [
      'title' => 'Trang chủ'
    ]);
  }
}