<?php
namespace App\Controllers;

use App\Models\User;

class UserController
{
    public function index()
    {
        $user = new User("John Doe");
        return "User: " . $user->getName();
    }

    public function show($id)
    {
        return "Showing user #" . $id;
    }

    public function create($name)
    {
        $user = new User($name);
        return "Created user: " . $user->getName();
    }
}