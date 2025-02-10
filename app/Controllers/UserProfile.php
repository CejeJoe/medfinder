<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserProfile extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);

        if (!$user) {
            return redirect()->to('/login')->with('error', 'User not found. Please login.');
        }

        return view('user/profile', ['user' => $user]);
    }

    public function update()
    {
        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);

        if (!$user) {
            return redirect()->to('/login')->with('error', 'User not found. Please login.');
        }

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'name' => 'required|min_length[3]|max_length[100]',
                'email' => 'required|valid_email',
                'phone' => 'required|min_length[10]|max_length[15]',
                'address' => 'required|min_length[5]|max_length[255]',
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $data = [
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
                'phone' => $this->request->getPost('phone'),
                'address' => $this->request->getPost('address'),
                'preferences' => json_encode($this->request->getPost('preferences') ?? []),
            ];

            if ($this->userModel->update($userId, $data)) {
                return redirect()->to('/user/profile')->with('success', 'Profile updated successfully.');
            } else {
                return redirect()->back()->withInput()->with('error', 'Failed to update profile. Please try again.');
            }
        }

        return view('user/edit_profile', ['user' => $user]);
    }
}

