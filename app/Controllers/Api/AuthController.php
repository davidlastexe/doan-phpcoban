<?php
namespace App\Controllers\Api;

use Exception, App\Models\User;
use App\Helpers\Helpers;
use DateTime, DateInterval;
use Firebase\JWT\JWT;
use App\Models\RefreshToken;
use DateTimeImmutable;

class AuthController {
  public function checkEmail() {
    $email = $_GET['email'];

    if (empty($email)) {
      Helpers::sendJsonResponse(false, 'Email không được để trống', null, 400);
    }

    try {
      $userModel = new User();
      $exists = $userModel->emailExists($email);
      Helpers::sendJsonResponse(true, 'Kiểm tra email thành công', ['exists' => $exists]);
    } catch (Exception $e) {
      error_log("Check email failed: ".$e->getMessage());
      Helpers::sendJsonResponse(false, 'Lỗi hệ thống', null, 500);
    }

    exit();
  }

  public function handleRegister() {
    if (!Helpers::isPost()) {
      Helpers::sendJsonResponse(false, 'Phương thức không hợp lệ.', null, 405);
    }

    $formData = $_POST;
    $errors = [];
    $userModel = new User();

    // Validate full_name
    if (empty($formData['full_name']))
      $errors['full_name'][] = "Họ tên không được bỏ trống!";
    else if (strlen($formData['full_name']) < 5)
      $errors['full_name'][] = "Họ tên phải có ít nhất 5 ký tự!";

    // Validate email
    if (empty($formData['email']))
      $errors['email'][] = "Email không được bỏ trống!";
    else if (!Helpers::validateEmail($formData['email']))
      $errors['email'][] = "Email không hợp lệ!";
    else if ($userModel->emailExists($formData['email'])) {
      $errors['email'][] = "Email đã tồn tại!";
    }

    // Validate phone_number
    if (!empty($formData['phone_number']) && !Helpers::isPhone($formData['phone_number'])) {
      $errors['phone_number'][] = "Số điện thoại không hợp lệ!";
    }

    // Validate password
    if (empty($formData['password']))
      $errors['password'][] = "Mật khẩu không được để trống!";
    else if (strlen($formData['password']) < 6)
      $errors['password'][] = "Mật khẩu phải lớn hơn 6 ký tự!";

    // Validate confirm_password
    if (empty($formData['confirm_password']))
      $errors['confirm_password'][] = "Hãy nhập lại mật khẩu!";
    else if ($formData['confirm_password'] !== $formData['password'])
      $errors['confirm_password'][] = "Mật khẩu không khớp!";

    if (!empty($errors)) {
      // Mã 422 (Unprocessable Entity) là mã chuẩn cho lỗi validation
      Helpers::sendJsonResponse(false, 'Dữ liệu không hợp lệ. Vui lòng kiểm tra lại.', ['errors' => $errors], 422);
    }

    $emailVerificationToken = bin2hex(random_bytes(32));
    $now = new DateTime();
    $expiresAt = $now->add(new DateInterval('PT30M'));
    $expiresAtFormatted = $expiresAt->format('Y-m-d H:i:s');

    $dataToInsert = [
      'full_name' => $formData['full_name'],
      'email' => $formData['email'],
      'password' => password_hash($formData['password'], PASSWORD_DEFAULT),
      'email_verification_token' => $emailVerificationToken,
      'verification_expires_at' => $expiresAtFormatted,
    ];
    if (!empty($formData['phone_number'])) {
      $dataToInsert['phone_number'] = $formData['phone_number'];
    }

    if (!$userModel->createUser($dataToInsert)) {
      // Mã 500 (Internal Server Error) cho lỗi từ phía server (ví dụ: lỗi database)
      Helpers::sendJsonResponse(false, 'Đăng ký thất bại do lỗi hệ thống. Vui lòng thử lại!', null, 500);
    }

    $activationLink = _HOST_URL."/activate?token=$emailVerificationToken";
    $subject = "Xác nhận email và kích hoạt tài khoản Ăn Vặt Shop";
    ob_start();
    require_once _PATH_URL_VIEWS.'/pages/email-content.php';
    $content = ob_get_clean();

    Helpers::sendMail($formData['email'], $subject, $content);

    // Mã 201 (Created) là mã chuẩn cho việc tạo thành công một tài nguyên mới
    Helpers::sendJsonResponse(true, 'Đăng ký thành công! Vui lòng kiểm tra email để xác thực tài khoản.', null, 201);
  }

  public function handleLogin() {
    if (!Helpers::isPost()) {
      Helpers::sendJsonResponse(false, 'Phương thức không hợp lệ.', null, 405);
    }

    $formData = $_POST;
    $errors = [];

    // Validate email
    if (empty($formData['email']))
      $errors['email'][] = "Email không được bỏ trống!";
    else if (!Helpers::validateEmail($formData['email']))
      $errors['email'][] = "Email không hợp lệ!";

    // Validate password
    if (empty($formData['password']))
      $errors['password'][] = "Mật khẩu không được để trống!";

    if (!empty($errors)) {
      Helpers::sendJsonResponse(false, 'Dữ liệu không hợp lệ. Vui lòng kiểm tra lại.', ['errors' => $errors], 422);
    }

    $userModel = new User();
    $user = $userModel->findUserByEmail($formData['email']);

    if (!$user || !password_verify($formData['password'], $user['password'])) {
      Helpers::sendJsonResponse(false, 'Email hoặc mật khẩu không chính xác.', null, 401);
    }

    if ($user['is_activated'] == 0) {
      Helpers::sendJsonResponse(false, 'Tài khoản của bạn chưa được kích hoạt. Vui lòng kiểm tra email.', null, 403);
    }

    $tokenModel = new RefreshToken();

    $deviceLimit = intval($_ENV['DEVICE_LOGIN_LIMIT']) ?? 5;
    $currentTokenCount = $tokenModel->getTokenCountForUser($user['id']);
    if ($currentTokenCount >= $deviceLimit) {
      $tokenModel->deleteOldestTokenForUser($user['id'], $deviceLimit - 1);
    }

    $refreshToken = bin2hex(random_bytes(32));
    $refreshTokenHash = hash('sha256', $refreshToken);
    $refreshTokenExpiresAt = (new DateTime())->add(new DateInterval('P30D'));

    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
    $ipAddress = $userModel->getUserIpAddress();

    $isSaved = $tokenModel->saveToken($user['id'], $refreshTokenHash, $refreshTokenExpiresAt->format('Y-m-d H:i:s'), $userAgent, $ipAddress);

    if (!$isSaved) {
      Helpers::sendJsonResponse(false, 'Lỗi hệ thống, không thể tạo phiên đăng nhập.', null, 500);
    }

    setcookie(
      'refresh_token',
      $refreshToken,
      [
        'expires' => $refreshTokenExpiresAt->getTimestamp(),
        'path' => '/',
        'secure' => true,
        'httponly' => true,
        'samesite' => 'Strict'
      ]
    );

    $secretKey = $_ENV['ACCESS_TOKEN_SECRET'];
    $issuedAt = new DateTimeImmutable();
    $expire = $issuedAt->modify('+15 minutes')->getTimestamp();
    $roles = array_column($userModel->getRolesUser($user['id']), 'name');
    $permissions = array_column($userModel->getPermissionsUser($user['id']), 'name');

    $payload = [
      'iat' => $issuedAt->getTimestamp(),     // Issued At
      'exp' => $expire,                       // Expiration Time
      'data' => [
        'userId' => $user['id'],
        'roles' => $roles,
        'permissions' => $permissions
      ]
    ];

    $accessToken = JWT::encode($payload, $secretKey, 'HS256');

    $responseData = [
      'access_token' => $accessToken,
      'expires_in' => $expire,
    ];

    Helpers::sendJsonResponse(true, 'Đăng nhập thành công!', $responseData);
  }

  public function activateAccount() {
    if (!Helpers::isPost()) {
      Helpers::sendJsonResponse(false, 'Phương thức không hợp lệ.', null, 405);
    }

    $token = $_POST['token'] ?? null;

    if (!$token)
      Helpers::sendJsonResponse(false, 'Token xác thực không được cung cấp.', null, 400);// 400 bad request

    $userModel = new User();
    $user = $userModel->findUserByEmailVeriToken($token);

    if ($user) {
      $isActivated = $userModel->activateUserAccount($user['id']);

      if ($isActivated)
        Helpers::sendJsonResponse(true, 'Tài khoản đã được kích hoạt thành công.');
      else
        Helpers::sendJsonResponse(false, 'Có lỗi xảy ra trong quá trình kích hoạt.', null, 500); // 500 internal server error
    } else
      Helpers::sendJsonResponse(false, 'Link kích hoạt không hợp lệ hoặc đã hết hạn.', null, 400);
  }
}