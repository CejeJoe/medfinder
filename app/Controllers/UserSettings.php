<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserSettings extends BaseController
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

        $data = [
            'title' => 'User Settings',
            'user' => $user
        ];

        return view('user/settings', $data);
    }

    public function update()
    {
        $userId = session()->get('user_id');

        $rules = [
            'name' => 'required|min_length[3]|max_length[50]',
            'email' => 'required|valid_email',
            'phone' => 'required|min_length[10]|max_length[15]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'notification_preferences' => json_encode($this->request->getPost('notification_preferences') ?? []),
        ];

        if ($this->userModel->update($userId, $data)) {
            return redirect()->to('user/settings')->with('success', 'Settings updated successfully');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to update settings');
        }
    }
}

