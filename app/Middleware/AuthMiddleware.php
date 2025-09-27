<?php
namespace App\Middleware;

use App\Helpers\Helpers;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;

class AuthMiddleware {
  public static function handle() {
    $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? null;

    if (!$authHeader) {
      Helpers::sendJsonResponse(false, 'Yêu cầu thiếu token xác thực.', null, 401);
    }

    if (!preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
      Helpers::sendJsonResponse(false, 'Định dạng token không hợp lệ.', null, 401);
    }
    $token = $matches[1];

    try {
      $secretKey = $_ENV['ACCESS_TOKEN_SECRET'];

      $decodedPayload = JWT::decode($token, new Key($secretKey, 'HS256'));

      return $decodedPayload;
    } catch (ExpiredException $e) {
      Helpers::sendJsonResponse(false, 'Token đã hết hạn.', ['code' => 'TOKEN_EXPIRED'], 401);
    } catch (SignatureInvalidException $e) {
      Helpers::sendJsonResponse(false, 'Token không hợp lệ.', null, 401);
    } catch (Exception $e) {
      Helpers::sendJsonResponse(false, 'Token không hợp lệ.', null, 401);
    }
  }
}