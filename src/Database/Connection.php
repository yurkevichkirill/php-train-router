<?php
namespace Core\Database;

class Connection
{
    private $host;
    private $username;
    private $password;
    private $database;
    private $connected = false;

    public function __construct($host = 'localhost', $username = 'root', $password = '', $database = 'test')
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
    }

    public function connect()
    {
        $this->connected = true;
        return "Connected to database: {$this->database}@{$this->host}";
    }

    public function disconnect()
    {
        $this->connected = false;
        return "Disconnected from database";
    }

    public function isConnected()
    {
        return $this->connected;
    }

    public function query($sql)
    {
        if (!$this->connected) {
            return "Error: Not connected to database";
        }
        return "Executing query: " . $sql;
    }
}