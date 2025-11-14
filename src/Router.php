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

        if (isset($routes[$method])) {
            foreach ($routes[$method] as $pattern => $handler) {
                if (strpos($pattern, '#^') !== 0) {
                    continue;
                }

                if (preg_match($pattern, $uri, $matches)) {
                    $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                    $this->callHandler($handler, $params);
                    return;
                }
            }
        }

        $this->notFound();
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