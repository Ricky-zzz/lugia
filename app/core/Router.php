<?php
class Router {
    private $routes = [];

    public function get($path, $callback) {
        $this->routes['GET'][$path] = $callback;
    }

    public function post($path, $callback) {
        $this->routes['POST'][$path] = $callback;
    }

public function resolve() {
    $method = $_SERVER['REQUEST_METHOD'];
    
    // Ensure leading slash and trim any trailing slashes
    $path = '/' . trim($_GET['url'] ?? '/', '/');

    $callback = $this->routes[$method][$path] ?? false;

    if (!$callback) {
        http_response_code(404);
        require __DIR__ . "/../views/errors/404.php";
        return;
    }

    if (is_array($callback)) {
        $controller = new $callback[0];
        $method = $callback[1];
        return call_user_func([$controller, $method]);
    }

    return call_user_func($callback);
}

}
