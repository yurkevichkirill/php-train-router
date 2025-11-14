<?php

namespace App;

class Router
{
    public function dispatch(array $routes) {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = $this->normalizePath($uri);

        $searchPattern = $this->uriToSearchPattern($uri);

        foreach ($routes as $route) {
            list($routeMethod, $routePath, $handler) = $route;

            if (strtoupper($routeMethod) !== $method) {
                continue;
            }

            if ($this->isRouteCompatible($routePath, $searchPattern, $uri)) {
                $pattern = $this->pathToPattern($routePath);

                if (preg_match($pattern, $uri, $matches)) {
                    $params = [];
                    foreach ($matches as $key => $value) {
                        if (is_string($key)) {
                            $params[$key] = $value;
                        }
                    }
                    $this->callHandler($handler, $params);
                    return;
                }
            }
        }

        $this->notFound();
    }

    private function uriToSearchPattern($uri) {
        $parts = explode('/', trim($uri, '/'));
        $patternParts = [];

        foreach ($parts as $part) {
            if (empty($part)) continue;

            if (is_numeric($part)) {
                $patternParts[] = '\d+';
            } else {
                $patternParts[] = '[^/]+';
            }
        }

        if (empty($patternParts)) {
            return '#^/$#';
        }

        return '#^/' . implode('/', $patternParts) . '$#';
    }

    private function isRouteCompatible($routePath, $searchPattern, $uri) {
        $uriSegments = count(array_filter(explode('/', $uri)));
        $routeSegments = count(array_filter(explode('/', $routePath)));

        if ($uriSegments !== $routeSegments) {
            return false;
        }

        $routeTemplate = preg_replace('/\{[^}]+\}/', '[^/]+', $routePath);
        $routeTemplate = '#^' . $routeTemplate . '$#';

        return preg_match($routeTemplate, $uri);
    }

    private function normalizePath($path) {
        $path = preg_replace('#/+#', '/', $path);
        if ($path !== '/' && substr($path, -1) === '/') {
            $path = rtrim($path, '/');
        }
        return $path;
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
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Not Found']);
    }
}