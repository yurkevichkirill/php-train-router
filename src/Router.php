<?php

namespace App;

class Router
{
    private $routes = [];

    public function addRoutes(array $routes) {
        foreach ($routes as $route) {
            list($method, $path, $handler) = $route;
            $method = strtoupper($method);

            $pattern = $this->pathToPattern($path);

            $this->routes[$method][$pattern] = [
                'handler' => $handler,
                'original_path' => $path,
            ];
        }
    }

    public function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        if (isset($this->routes[$method])) {
            foreach ($this->routes[$method] as $pattern => $routeData) {
                if(preg_match($pattern, $uri, $matches)) {
                    $params = [];
                    foreach($matches as $key => $value) {
                        if(is_string($key)) {
                            $params[$key] = $value;
                        }
                    }
                    $this->callHandler($routeData['handler'], $params);
                    return;
                }
            }
        }

        $this->notFound();
    }

    private function pathToPattern($path) {
        $pattern = preg_replace('/\{(\w+)\}/', '(?P<$1>[^/]+)', $path);
        return '#^' . $pattern . '$#';
    }

    private function callHandler($handler, $params) {
        if (is_callable($handler)) {
            call_user_func_array($handler, $params);
        } elseif (is_array($handler) && count($handler) === 2) {
            $controller = new $handler[0]();
            call_user_func_array([$controller, $handler[1]], $params);
        } elseif (is_string($handler) && strpos($handler, '@') !== false) {
            list($class, $method) = explode('@', $handler);
            $controller = new $class();
            call_user_func_array([$controller, $method], $params);
        }
    }

    private function notFound() {
        http_response_code(404);
        echo json_encode(['error' => 'Not Found']);
    }
}