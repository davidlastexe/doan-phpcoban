<?php
namespace App\Models;

use App\Core\Database;

class User {
  private $db;

  public function __construct() {
    $this->db = new Database();
  }

  // IDEA: thêm construct có tham số là email user hoặc id

  public function emailExists($email) {
    $count = $this->db->countRows("SELECT id FROM `users` WHERE `email` = ?", [$email]);
    return $count > 0;
  }

  public function createUser($data) {
    return $this->db->insert('users', $data);
  }

  public function findUserByEmail(string $email) {
    $sql = "SELECT * FROM `users`
            WHERE `email` = :email";
    return $this->db->getOne($sql, ['email' => $email]);
  }

  public function findUserByEmailVeriToken(string $token) {
    $sql = "SELECT `id` FROM `users`
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

  public function getRoles() {
    $sql = "SELECT * FROM `roles`";
    return $this->db->getAll($sql);
  }

  public function getPermissions() {
    $sql = "SELECT * FROM `permissions`";
    return $this->db->getAll($sql);
  }

  public function getRolesUser(int $userId) {
    $sql = "SELECT `name` FROM `role_user`
            INNER JOIN `roles` ON `role_user`.`role_id` = `roles`.`id`
            WHERE `user_id` = :user_id";
    return $this->db->getAll($sql, ['user_id' => $userId]);
  }

  public function getPermissionsUser(int $userId) {
    $sql = "SELECT `permissions`.`name` FROM `permission_role`
            INNER JOIN `permissions` ON `permission_role`.`permission_id` = `permissions`.`id`
            INNER JOIN `role_user` ON `permission_role`.`role_id` = `role_user`.`role_id`
            WHERE `role_user`.`user_id` = :user_id";
    return $this->db->getAll($sql, ['user_id' => $userId]);
  }

  public function getUserIpAddress() {
    if (isset($_SERVER['HTTP_CLIENT_IP'])) {
      return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
      $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
      return trim($ips[0]);
    } elseif (isset($_SERVER['HTTP_X_REAL_IP'])) {
      return $_SERVER['HTTP_X_REAL_IP'];
    } elseif (isset($_SERVER['REMOTE_ADDR'])) {
      return $_SERVER['REMOTE_ADDR'];
    }
    return '';
  }

  public function setRoleUser(string $role, int $userId) {
    /**
     * TODO:
     * 1. select bảng roles tìm khớp với $role
     * 2. lấy id của role và $userId insert vào bảng role_user
     * 3. trả về true or false
     */
  }
}