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
}