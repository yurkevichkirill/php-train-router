<?php

namespace App\Attributes;

#[\Attribute]
class Delete extends Route
{
    public function __construct(string $routePath, string $method = 'DELETE')
    {
        parent::__construct($routePath, $method);
    }
}