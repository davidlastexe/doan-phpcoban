<?php
namespace App\Models;

use App\Core\Database;

class User {
  private $db;

  public function __construct() {
    $this->db = new Database();
  }

  public function emailExists($email) {
    $count = $this->db->countRows("SELECT id FROM `users` WHERE `email` = ?", [$email]);
    return $count > 0;
  }

  public function createUser($data) {
    return $this->db->insert('users', $data);
  }

  public function findUserByValidToken(string $token) {
    $sql = "SELECT * FROM `users`
            WHERE `email_verification_token` = :token
            AND `verification_expires_at` > NOW()
            AND `is_activated` = 0";
    return $this->db->getOne($sql, ['token' => $token]);
  }

  public function activateUserAccount(int $userId) {
    $data = [
      'is_activated' => 1,
      'email_verification_token' => null,
      'email_verified_at' => date('Y:m:d H:i:s')
    ];
    return $this->db->update('users', $data, "`id` = :id", ['id' => $userId]);
  }
}