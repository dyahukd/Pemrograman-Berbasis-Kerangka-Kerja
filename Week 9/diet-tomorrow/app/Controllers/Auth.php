<?php

namespace App\Controllers;

use App\Models\User;

class Auth extends BaseController
{
    public function register()
    {
        return view('auth/register');
    }

    public function doRegister()
    {
        $rules = [
            'name' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'phone' => 'permit_empty|max_length[20]',
            'password' => 'required|min_length[8]',
            'password_confirm' => 'required|matches[password]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $userModel = new User();

        $userModel->insert([
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'password_hash' => password_hash(
                $this->request->getPost('password'),
                PASSWORD_DEFAULT
            ),
            'role' => 'customer',
        ]);

        $user = $userModel->find($userModel->getInsertID());

        session()->regenerate();

        session()->set([
            'user_id' => $user['id'],
            'user_name' => $user['name'],
            'user_role' => $user['role'],
            'isLoggedIn' => true,
        ]);

        return redirect()->to(site_url('/'))
            ->with('success', 'Welcome to DIET TOMORROW!');
    }

    public function login()
    {
        return view('auth/login', ['adminMode' => false]);
    }

    public function adminLogin()
    {
        return view('auth/login', ['adminMode' => true]);
    }

    public function doLogin()
    {
        return $this->attemptLogin(false);
    }

    public function doAdminLogin()
    {
        return $this->attemptLogin(true);
    }

    private function attemptLogin($adminOnly)
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $userModel = new User();
        $user = $userModel->where('email', $email)->first();

        if (
            !$user ||
            !password_verify($password, $user['password_hash'])
        ) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Email or password is incorrect.');
        }

        if ($adminOnly && $user['role'] !== 'admin') {
            return redirect()->back()
                ->withInput()
                ->with('error', 'You do not have admin access.');
        }

        if (!$adminOnly && $user['role'] !== 'customer') {
            return redirect()->back()
                ->with('error', 'Please use the admin login page.');
        }

        session()->regenerate();

        session()->set([
            'user_id' => $user['id'],
            'user_name' => $user['name'],
            'user_role' => $user['role'],
            'isLoggedIn' => true,
        ]);

        if ($user['role'] === 'admin') {
            return redirect()->to(site_url('admin/dashboard'));
        }

        return redirect()->to(site_url('/'))
            ->with('success', 'Welcome back, ' . $user['name'] . '!');
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to(site_url('/'))
            ->with('success', 'You have been logged out.');
    }
}