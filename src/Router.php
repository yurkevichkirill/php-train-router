<?php

namespace App;

class Router
{
    private array $routes = [];
    public function __construct(array $externalRoutes)
    {
        $this->routes = $externalRoutes;
    }

    public function handler($uri, $method): void
    {
        #$method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($uri, PHP_URL_PATH);
        $uri = $this->normalizePath($uri);

        if (isset($this->routes[$method][$uri])) {
            $handler = $this->routes[$method][$uri];
            $this->callHandler($handler, []);
            return;
        }

        [$dynamicKey, $param] = $this->createDynamicData($uri);

        $dynamicUris = preg_grep($dynamicKey, array_keys($this->routes["GET"]));
        if(count($dynamicUris) === 1) {
            $dynamicUri = array_values($dynamicUris)[0];
            $call = $this->routes["GET"][$dynamicUri];
            $this->callHandler($call, [$param]);
            return;
        }

        $this->notFound();
    }

    private function createDynamicData(string $uri): array
    {
        $segments = explode('/', $uri);
        $param = $this->extractParam($segments);
        $segments[count($segments) - 1] = '\{\w+\}';
        $dynamicKey = "#^" . implode('/', $segments) . "$#";
        return array($dynamicKey, $param);
    }

    private function extractParam(array $segments): string
    {
        return end($segments);
    }

    private function normalizePath($path): string
    {
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

    private function notFound(): void
    {
        http_response_code(404);
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Not Found']);
    }
}