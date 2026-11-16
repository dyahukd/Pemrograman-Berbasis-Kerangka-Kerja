<?php

namespace App\Controllers;

class AuthController extends BaseController
{
    public function login()
    {
        if (session()->get('logged_in')) return redirect()->to('/dashboard');
        return view('auth/login');
    }

    public function attempt()
    {
        $username=trim((string)$this->request->getPost('username'));
        $password=(string)$this->request->getPost('password');
        $user=db_connect()->table('users')->where('username',$username)->get()->getRowArray();

        if (!$user || !password_verify($password,$user['password'])) {
            return redirect()->back()->withInput()->with('error','Username atau password salah.');
        }

        session()->regenerate(true);
        session()->set([
            'logged_in'=>true,'user_id'=>$user['id'],'username'=>$user['username'],
            'nama'=>$user['nama'],'role'=>$user['role']
        ]);
        return redirect()->to('/dashboard')->with('success','Login berhasil.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success','Anda berhasil logout.');
    }
}
