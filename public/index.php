<?php
date_default_timezone_set("Asia/Ho_Chi_Minh");
session_start();
ob_start();

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../app/Configs/configs.php';

use App\Core\Router;
use App\Controllers\HomeController;
use App\Controllers\AuthController;
// use App\Controllers\PageController;
// use App\Controllers\Api\AuthController as ApiAuthController;

require_once _PATH_URL_APP.'/Helpers/helpers.php';

$router = new Router();

$router->get('/', HomeController::class, 'index');
// $router->get('/dashboard', PageController::class, 'dashboard');
$router->get('/login', AuthController::class, 'showLoginForm');
$router->get('/register', AuthController::class, 'showRegisterForm');
// $router->get('/api/check-email', ApiAuthController::class, 'checkEmail');

// $router->post('/register', AuthController::class, 'handleRegister');

$requestUri = $_SERVER['REQUEST_URI'];
$requestPath = parse_url($requestUri, PHP_URL_PATH);
$requestMethod = $_SERVER['REQUEST_METHOD'];
$finalPath = removePathFolder($requestPath);

$router->dispatch($finalPath, $requestMethod);

ob_end_flush();