<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\DeliveryPartnerModel;

class DriverRegistration extends BaseController
{
    protected $userModel;
    protected $deliveryPartnerModel;
    protected $db;


    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->deliveryPartnerModel = new DeliveryPartnerModel();
        $this->db = \Config\Database::connect();

    }

    public function index()
    {
        return view('auth/driver_registration');
    }

    public function register()
    {
        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
                'email' => 'required|valid_email|is_unique[users.email]',
                'password' => 'required|min_length[8]',
                'confirm_password' => 'required|matches[password]',
                'vehicle_type' => 'required|in_list[motorcycle,car,van]',
            ];

            if (!$this->validate($rules)) {
                log_message('error', 'Driver registration validation failed: ' . json_encode($this->validator->getErrors()));
                return redirect()->back()
                    ->withInput()
                    ->with('errors', $this->validator->getErrors());
            }

            try {
                $this->db->transStart();

                // Data for users table
                $userData = [
                    'username' => $this->request->getPost('username'),
                    'email' => $this->request->getPost('email'),
                    'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                    'role' => 'driver',
                    // 'phone' => $this->request->getPost('phone'),
                    // profile_image can be added later
                    // created_at and updated_at should be handled by the model
                ];

                // Insert into users table
                $userId = $this->userModel->insert($userData);
                if (!$userId) {
                    throw new \RuntimeException('Failed to create user account');
                }

                // Data for delivery_partners table
                $driverData = [
                    'user_id' => $userId,
                    'name' => $this->request->getPost('username'),
                    // 'contact_number' => $this->request->getPost('contact_number'),
                    'email' => $this->request->getPost('email'),
                    'vehicle_type' => $this->request->getPost('vehicle_type'),
                    'license_number' => $this->request->getPost('license_number'),
                    // 'address' => $this->request->getPost('address'),
                    'is_available' => 1  // Set default availability
                    // created_at and updated_at should be handled by the model
                ];

                // Insert into delivery_partners table
                if (!$this->deliveryPartnerModel->insert($driverData)) {
                    throw new \RuntimeException('Failed to create delivery partner record');
                }

                $this->db->transComplete();

                if ($this->db->transStatus() === false) {
                    log_message('error', 'Driver registration transaction failed');
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Registration failed. Please try again.');
                }

                return redirect()->to('login')
                    ->with('success', 'Registration successful. Your account is pending approval.');

            } catch (\Exception $e) {
                $this->db->transRollback();
                log_message('error', 'Driver registration error: ' . $e->getMessage());
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Registration failed. Please try again.');
            }
        }

        return redirect()->back()
            ->with('error', 'Invalid request method');
    }
}