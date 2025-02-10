<?php

namespace App\Controllers\Auth;
use App\Controllers\BaseController;

use App\Models\UserModel;

class UserRegistration extends BaseController
{
    public function index()
    {
        helper(['form']);
        $data = [];
        return view('auth/register', $data);
    }

    public function process()
    {
        helper(['form']);
        $rules = [
            'name' => 'required|min_length[3]|max_length[50]',
            'username' => 'required|min_length[3]|max_length[30]|is_unique[users.username]',
            'email'    => 'required|min_length[6]|max_length[50]|valid_email|is_unique[users.email]',
            'phone'    => 'required|min_length[10]|max_length[15]',
            'password' => 'required|min_length[8]|max_length[255]',
            'password_confirm' => 'matches[password]',
        ];

        if ($this->validate($rules)) {
            $userModel = new UserModel();
            $data = [
                'name'     => $this->request->getVar('name'),
                'username' => $this->request->getVar('username'),
                'email'    => $this->request->getVar('email'),
                'phone'    => $this->request->getVar('phone'),
                'password' => $this->request->getVar('password'),
                'role' => 'user',
            ];
            $userModel->registerUser($data);
            return redirect()->to('/login')->with('success', 'Registration successful. You can now log in.');
        } else {
            $data['validation'] = $this->validator;
            return view('auth/register', $data);
        }
    }
}

