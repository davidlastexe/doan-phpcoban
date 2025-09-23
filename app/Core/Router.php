<?php
namespace App\Core;

class Router {
  protected $routes = [
    'GET' => [],
    'POST' => []
  ];

  protected function add($method, $uri, $controller, $action) {
    $this->routes[$method][$uri] = [
      'controller' => $controller,
      'method' => $action
    ];
  }

  public function get($uri, $controller, $action) {
    $this->add('GET', $uri, $controller, $action);
  }

  public function post($uri, $controller, $action) {
    $this->add('POST', $uri, $controller, $action);
  }

  public function dispatch($uri, $method) {
    if (isset($this->routes[$method]) && array_key_exists($uri, $this->routes[$method])) {
      $route = $this->routes[$method][$uri];
      $controllerName = $route['controller'];
      $methodName = $route['method'];

      $controller = new $controllerName();
      $controller->$methodName();
    } else {
      http_response_code(404);
      echo "404 - Page Not Found";
    }
  }
}