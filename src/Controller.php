<?php

declare(strict_types=1);

namespace App;

class Controller {
    protected function json($data, $code = 200): void
    {
        http_response_code($code);
        #header('Content-Type: application/json');
        echo json_encode($data);
    }

    protected function input(): array
    {
        return json_decode(file_get_contents('php://input'), true) ?? [];
    }
}
