<?php

// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\SMTP;
// use PHPMailer\PHPMailer\Exception;

function layout($layoutName, $data = []) {
  $name = _PATH_URL_VIEWS."/layouts/{$layoutName}.php";
  if (file_exists($name))
    require_once $name;
}

// function sendMail($emailTo, $subject, $content) {
//   $mail = new PHPMailer(true);

//   try {
//     //Server settings
//     $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
//     $mail->isSMTP();                                            //Send using SMTP
//     $mail->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
//     $mail->SMTPAuth = true;                                   //Enable SMTP authentication
//     $mail->Username = 'anhtraidep001@gmail.com';                     //SMTP username
//     $mail->Password = 'uplmpaowottlquky';                               //SMTP password
//     $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
//     $mail->Port = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

//     //Recipients
//     $mail->setFrom('anhtraidep001@gmail.com', 'NgocMarketing Course');
//     $mail->addAddress($emailTo);

//     //Content
//     $mail->CharSet = "UTF-8";
//     $mail->isHTML(true);
//     $mail->Subject = $subject;
//     $mail->Body = $content;

//     return $mail->send();
//   } catch (Exception $ex) {
//     echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
//     return false;
//   }
// }

function isPost() {
  if ($_SERVER["REQUEST_METHOD"] === 'POST')
    return true;
  return false;
}

function isGet() {
  if ($_SERVER["REQUEST_METHOD"] === 'GET')
    return true;
  return false;
}

function filterData($method = '') {
  $filterArr = [];
  $inputData = [];

  if (empty($method)) {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
      $inputData = $_GET;
    } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $inputData = $_POST;
    }
  } else if ($method === 'GET') {
    $inputData = $_GET;
  } else if ($method === 'POST') {
    $inputData = $_POST;
  }

  if (!empty($inputData)) {
    foreach ($inputData as $key => $value) {
      $key = strip_tags($key);
      if (is_array($value)) {
        $sanitizedValue = filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
        foreach ($sanitizedValue as &$item) {
          $item = trim($item);
        }
        $filterArr[$key] = $sanitizedValue;
      } else {
        $filterArr[$key] = trim(filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS));
      }
    }
  }
  return $filterArr;
}

function validateEmail($email) {
  if (!empty($email)) {
    $checkEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
    return $checkEmail;
  }
  return false;
}

function validateInt($number) {
  if (!empty($number)) {
    $checkNumber = filter_var($number, FILTER_VALIDATE_INT);
    return $checkNumber;
  }
  return false;
}

function isPhone($phone) {
  $phone = preg_replace('/[^0-9+]/', '', $phone);
  if (strpos($phone, '+84') === 0)
    $phone = '0'.substr($phone, 3);
  $regex = '/^(0)(3[2-9]|5[6|8|9]|7[0|6-9]|8[1-6|8|9]|9[0-4|6-9])[0-9]{7}$/';
  return preg_match($regex, $phone) > 0;
}

function getMsg($msg, $type) {
  echo "<div class=\"alert alert-{$type}\" role=\"alert\">{$msg}</div>";
}

function removePathFolder($requestPath) {
  if (BASE_DIR != '') {
    if (strpos($requestPath, BASE_DIR) === 0) {
      $requestPath = substr($requestPath, strlen(BASE_DIR));
    }
  }

  if (empty($requestPath)) {
    $requestPath = '/';
  }

  return $requestPath;
}