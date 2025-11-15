<?php

namespace App\Controllers;

use App\Controller;

class UserController extends Controller
{
    public function index()
    {
        $users = [
            ['id' => 1, 'name' => 'John Doe', 'email' => 'john@example.com'],
            ['id' => 2, 'name' => 'Jane Smith', 'email' => 'jane@example.com']
        ];

        $this->json([
            'status' => 'success',
            'data' => $users
        ]);
    }

    public function show($id)
    {
        $user = [
            'id' => $id,
            'name' => 'User ' . $id,
            'email' => "user{$id}@example.com"
        ];

        $this->json([
            'status' => 'success',
            'data' => $user
        ]);
    }

    public function store()
    {
        $input = $this->input();

        $user = [
            'id' => rand(1000, 9999),
            'name' => $input['name'] ?? 'New User',
            'email' => $input['email'] ?? 'new@example.com'
        ];

        $this->json([
            'status' => 'success',
            'message' => 'User created',
            'data' => $user
        ], 201);
    }
}