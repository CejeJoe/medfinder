<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class UserManagement extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data['users'] = $this->userModel->paginate(10);
        $data['pager'] = $this->userModel->pager;

        return view('admin/users/index', $data);
    }

    public function create()
    {
        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'username' => 'required|min_length[3]|is_unique[users.username]',
                'email' => 'required|valid_email|is_unique[users.email]',
                'password' => 'required|min_length[8]',
                'confirm_password' => 'required|matches[password]',
                'role' => 'required|in_list[user,pharmacy_admin,admin,driver]',
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $this->userModel->insert([
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'role' => $this->request->getPost('role'),
            ]);

            return redirect()->to('/admin/users')->with('success', 'User created successfully.');
        }

        return view('admin/users/create');
    }

    public function edit($id)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'User not found.');
        }

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'username' => "required|min_length[3]|is_unique[users.username,id,$id]",
                'email' => "required|valid_email|is_unique[users.email,id,$id]",
                'role' => 'required|in_list[user,pharmacy_admin,admin,driver]',
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $this->userModel->update($id, [
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'role' => $this->request->getPost('role'),
            ]);

            return redirect()->to('/admin/users')->with('success', 'User updated successfully.');
        }

        return view('admin/users/edit', ['user' => $user]);
    }

    public function delete($id)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'User not found.');
        }

        $this->userModel->delete($id);

        return redirect()->to('/admin/users')->with('success', 'User deleted successfully.');
    }
}
