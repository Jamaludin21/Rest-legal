<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;

class UserController extends ResourceController
{
    protected $format = 'json';
    use ResponseTrait;

    public function index()
    {
        $model = new UserModel();
        $users = $model->findAll();
        return $this->respond($users);
    }

    // Get user by ID
    public function show($id = null)
    {
        $model = new UserModel();
        $user = $model->find($id);

        if ($user) {
            return $this->respond($user);
        } else {
            return $this->failNotFound('No user found with id ' . $id);
        }
    }

    // Register a new user
    public function register()
    {
        $model = new UserModel();
        $data = $this->request->getJSON(true);

        if (empty($data)) {
            return $this->fail('No data received', 400);
        }

        if (!isset($data['password'])) {
            return $this->fail('Password is required', 400);
        }

        // Hash the password
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        if ($model->insert($data)) {
            log_message('info', 'User created successfully');
            return $this->respondCreated(['status' => 'success', 'message' => 'User created successfully.']);
        } else {
            log_message('error', 'User creation failed. Errors: ' . json_encode($model->errors()));
            return $this->fail($model->errors());
        }
    }

    // Login user
    public function login()
    {
        $model = new UserModel();
        $data = $this->request->getJSON(true);
        if (empty($data)) {
            return $this->fail('No data received', 400);
        }

        if (!isset($data['email']) || !isset($data['password'])) {
            return $this->fail('Email and password are required', 400);
        }

        $user = $model->where('email', $data['email'])->first();


        if ($user && password_verify($data['password'], $user['password'])) {
            return $this->respond(['status' => 'success', 'message' => 'Login successful', 'user' => $user]);
        } else {
            return $this->failUnauthorized('Invalid email or password');
        }
    }

    // Update user
    public function update($id = null)
    {
        $model = new UserModel();
        $data = $this->request->getJSON(true);

        if (empty($data)) {
            return $this->fail('No data received', 400);
        }

        if (!isset($data['password'])) {
            return $this->fail('Password is required', 400);
        }

        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        if ($model->update($id, $data)) {
            return $this->respond(['status' => 'success', 'message' => 'User updated successfully.']);
        } else {
            return $this->fail($this->model->errors());
        }
    }

    // Delete user
    public function delete($id = null)
    {
        $model = new UserModel();
        if ($model->delete($id)) {
            return $this->respondDeleted(['status' => 'success', 'message' => 'User deleted successfully.']);
        } else {
            return $this->failNotFound('User not found');
        }
    }
}