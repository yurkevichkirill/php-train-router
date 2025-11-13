<?php
namespace Core\Database;

class Connection
{
    private $host;

    public function __construct($host = 'localhost')
    {
        $this->host = $host;
    }

    public function connect()
    {
        return "Connected to {$this->host}";
    }
}