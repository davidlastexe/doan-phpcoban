<?php
namespace App\Controllers;

use App\Core\View;
use App\Helpers\Helpers;

class DashboardController {
  public function index() {
    if (!Helpers::isLoggedIn())
      Helpers::redirect();

    View::render('pages/dashboard/index', [
      'title' => 'Dashboard'
    ]);
  }
}