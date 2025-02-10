<?php

namespace App\Controllers;

use App\Models\UserModel;

class Profile extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $userId = session()->get('user_id');
        $data['user'] = $this->userModel->find($userId);
        return view('profile/index', $data);
    }

    public function update()
    {
        $userId = session()->get('user_id');
        $rules = [
            'name' => 'required|min_length[3]|max_length[50]',
            'email' => 'required|valid_email',
            'phone' => 'required|min_length[10]|max_length[15]',
            'address' => 'required|min_length[10]',
        ];

        if ($this->validate($rules)) {
            $data = [
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
                'phone' => $this->request->getPost('phone'),
                'address' => $this->request->getPost('address'),
            ];

            $this->userModel->update($userId, $data);
            return redirect()->to('/profile')->with('success', 'Profile updated successfully');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
    }
}

