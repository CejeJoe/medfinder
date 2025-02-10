<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\OrderModel;
use App\Libraries\RecommendationSystem;

class UserDashboard extends BaseController
{
    protected $userModel;
    protected $orderModel;
    protected $recommendationSystem;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->orderModel = new OrderModel();
        $this->recommendationSystem = new RecommendationSystem();
    }

    public function index()
    {
        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);

        if (!$user) {
            return redirect()->to('/login')->with('error', 'User not found. Please login again.');
        }

        $recentOrders = $this->orderModel->where('user_id', $userId)
                                         ->orderBy('created_at', 'DESC')
                                         ->limit(5)
                                         ->find();

        $data = [
            'user' => $user,
            'recentOrders' => $recentOrders
        ];

        return view('user/dashboard', $data);
    }

    public function profile()
    {
        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);

        if (!$user) {
            return redirect()->to('/login')->with('error', 'User not found. Please login again.');
        }

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'name' => 'required|min_length[3]|max_length[100]',
                'email' => 'required|valid_email',
                'phone' => 'permit_empty|min_length[10]|max_length[15]',
                'address' => 'permit_empty|min_length[5]|max_length[255]',
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $data = [
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
                'phone' => $this->request->getPost('phone'),
                'address' => $this->request->getPost('address'),
            ];

            $this->userModel->update($userId, $data);
            return redirect()->to('/user/profile')->with('success', 'Profile updated successfully.');
        }

        return view('user/profile', ['user' => $user]);
    }

    public function orderHistory()
    {
        $userId = session()->get('user_id');
        $orders = $this->orderModel->where('user_id', $userId)
                                   ->orderBy('created_at', 'DESC')
                                   ->paginate(10);

        $data = [
            'orders' => $orders,
            'pager' => $this->orderModel->pager
        ];

        return view('user/order_history', $data);
    }

    public function changePassword()
    {
        $userId = session()->get('user_id');

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'current_password' => 'required',
                'new_password' => 'required|min_length[8]',
                'confirm_password' => 'required|matches[new_password]',
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $user = $this->userModel->find($userId);

            if (!password_verify($this->request->getPost('current_password'), $user['password'])) {
                return redirect()->back()->with('error', 'Current password is incorrect.');
            }

            $this->userModel->update($userId, [
                'password' => password_hash($this->request->getPost('new_password'), PASSWORD_DEFAULT)
            ]);

            return redirect()->to('/user/profile')->with('success', 'Password changed successfully.');
        }

        return view('user/change_password');
    }
    public function getDrugRecommendations()
    {
        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);

        $userDrugHistory = $this->orderModel->getUserDrugHistory($userId);
        $this->recommendationSystem->trainModel($userDrugHistory);

        $recommendations = $this->recommendationSystem->getRecommendations($user['age'], $user['gender']);

        return view('user/recommendations', ['recommendations' => $recommendations]);
    }
}
