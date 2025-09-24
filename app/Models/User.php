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
}