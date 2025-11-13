<?php
namespace App\Models;

class User
{
    private $name;
    private $email;

    public function __construct($name, $email = null)
    {
        $this->name = $name;
        $this->email = $email;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function toArray()
    {
        return [
            'name' => $this->name,
            'email' => $this->email
        ];
    }
}