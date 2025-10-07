<?php
namespace App\Controllers;

use App\Core\View;

class DashboardController {
  public function index() {
    View::render('pages/dashboard/index', [
      'title' => 'Dashboard'
    ]);
  }
}