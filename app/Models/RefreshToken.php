<?php
namespace App\Models;

use App\Core\Database;

class RefreshToken {
  private $db;

  public function __construct() {
    $this->db = new Database();
  }

  public function saveToken($userId, $tokenHash, $expiresAt, $userAgent, $ipAddress) {
    $data = [
      'user_id' => $userId,
      'token_hash' => $tokenHash,
      'expires_at' => $expiresAt,
      'user_agent' => $userAgent,
      'ip_address' => $ipAddress,
    ];
    return $this->db->insert('refresh_tokens', $data);
  }

  public function getTokenCountForUser($userId) {
    $sql = "SELECT `created_at` FROM `refresh_tokens`
            WHERE `user_id` = :user_id";
    return $this->db->countRows($sql, ['user_id' => $userId]);
  }

  public function deleteOldestTokenForUser($userId) {
    $condition = "user_id = :user_id
                  ORDER BY created_at
                  LIMIT 1";
    return $this->db->delete('refresh_tokens', $condition, ['user_id' => $userId]);
  }
}