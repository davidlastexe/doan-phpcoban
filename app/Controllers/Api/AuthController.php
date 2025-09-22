<?php
namespace App\Controllers\Api;

use Exception, App\Models\User;

class AuthController {
  // public function checkEmail() {
  //   header('Content-Type: application/json');

  //   $email = $_GET['email'];

  //   if (empty($email)) {
  //     echo json_encode(['error' => 'Email is required']);
  //     exit();
  //   }

  //   $userModel = new User();

  //   try {
  //     $exists = $userModel->emailExists($email);
  //     echo json_encode(['exists' => $exists]);
  //   } catch (Exception $e) {
  //     http_response_code(500);
  //     echo json_encode(['error' => $e->getMessage()]);
  //   }

  //   exit();
  // }
}