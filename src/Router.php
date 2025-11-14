<?php

namespace App;

class Router
{
    public function dispatch(array $routes) {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = $this->normalizePath($uri);

        if (isset($routes[$method][$uri])) {
            $handler = $routes[$method][$uri];
            $this->callHandler($handler, []);
            return;
        }

        $dynamicKey = $this->createDynamicKey($uri);
        if (isset($routes[$method][$dynamicKey])) {
            $handler = $routes[$method][$dynamicKey];
            $param = $this->extractParam($uri);
            $this->callHandler($handler, [$param]);
            return;
        }

        $this->notFound();
    }

    private function createDynamicKey(string $uri): string
    {
        $segments = explode('/', trim($uri, '/'));

        if (count($segments) > 1) {
            $segments[count($segments) - 1] = '{id}';
            return '/' . implode('/', $segments);
        }

        return $uri;
    }

    private function extractParam(string $uri): string
    {
        $segments = explode('/', trim($uri, '/'));
        return end($segments);
    }

    private function normalizePath($path) {
        $path = preg_replace('#/+#', '/', $path);
        if ($path !== '/' && substr($path, -1) === '/') {
            $path = rtrim($path, '/');
        }
        return $path;
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
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Not Found']);
    }
}