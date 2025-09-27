<?php
date_default_timezone_set("Asia/Ho_Chi_Minh");
session_start();
ob_start();

require_once __DIR__.'/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

require_once __DIR__.'/../app/Configs/configs.php';

use App\Core\Router;
use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\PageController;
use App\Controllers\Api\AuthController as ApiAuthController;
use App\Helpers\Helpers;

$router = new Router();

$router->get('/', HomeController::class, 'index');
$router->get('/dashboard', PageController::class, 'dashboard');
$router->get('/login', AuthController::class, 'showLoginForm');
$router->get('/register', AuthController::class, 'showRegisterForm');
$router->get('/activate', AuthController::class, 'showActivatePage');

// API
$router->get('/api/check-email', ApiAuthController::class, 'checkEmail');
$router->post('/api/activate', ApiAuthController::class, 'activateAccount');
$router->post('/api/register', ApiAuthController::class, 'handleRegister');
$router->post('/api/login', ApiAuthController::class, 'handleLogin');

$requestUri = $_SERVER['REQUEST_URI'];
$requestPath = parse_url($requestUri, PHP_URL_PATH);
$requestMethod = $_SERVER['REQUEST_METHOD'];
$finalPath = Helpers::removePathFolder($requestPath);

$router->dispatch($finalPath, $requestMethod);

ob_end_flush();