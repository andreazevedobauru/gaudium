<?php
namespace App\Router;

class Router {
    private $routes = [];

    public function add($method, $path, $callback) {
        $this->routes[$method][$path] = $callback;
    }

    public function dispatch($method, $path) {
        foreach ($this->routes[$method] ?? [] as $routePath => $callback) {
            if ($path === $routePath) {
                return call_user_func($callback);
            }
        }

        // Se nenhuma rota corresponder, retorne um 404
        header("HTTP/1.0 404 Not Found");
        echo '404 Not Found';
        exit;
    }
}
