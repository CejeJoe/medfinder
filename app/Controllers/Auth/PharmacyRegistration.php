<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\PharmacyModel;
use App\Models\NotificationModel;

class PharmacyRegistration extends BaseController
{
    protected $userModel;
    protected $pharmacyModel;
    protected $db;
    protected $notificationModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->pharmacyModel = new PharmacyModel();
        $this->db = \Config\Database::connect();
        $this->notificationModel = new NotificationModel();
    }

    public function index()
    {
        return view('auth/pharmacy_registration');
    }

    public function register()
    {
        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
                'email' => 'required|valid_email',
                'password' => 'required|min_length[8]',
                'confirm_password' => 'required|matches[password]',
                'pharmacy_name' => 'required|min_length[3]',
                'pharmacy_address' => 'required',
                'pharmacy_contact' => 'required'
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $this->db->transStart();

            $userData = [
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'contact_number' => $this->request->getPost('phone'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'role' => 'pharmacy_admin'
            ];

            $userId = $this->userModel->insert($userData);
            $superAdminId = 1;
            $this->notificationModel->addNotification(
                $superAdminId,
                'new_pharmacy',
                "New pharmacy registered: {$userData['username']}"
            );
            $pharmacyData = [
                'user_id' => $userId,
                'name' => $this->request->getPost('pharmacy_name'),
                'address' => $this->request->getPost('pharmacy_address'),
                'is_approved' => false
            ];

            $this->pharmacyModel->insert($pharmacyData);

            // // Insert into delivery_partners table
            // $deliveryPartnerData = [
            //     'user_id' => $userId,
            //     'name' => $this->request->getPost('pharmacy_name'),
            //     'contact_number' => $this->request->getPost('pharmacy_contact'),
            //     'email' => $this->request->getPost('email'),
            //     'address' => $this->request->getPost('pharmacy_address'),
            //     'is_approved' => false,
            //     'vehicle_type' => 'pharmacy', // or any default value you prefer
            //     'license_number' => 'N/A' // or generate a unique identifier if needed
            // ];

            // $this->db->table('delivery_partners')->insert($deliveryPartnerData);

            $this->db->transComplete();

            if ($this->db->transStatus() === false) {
                return redirect()->back()->withInput()->with('error', 'Registration failed. Please try again.');
            }

            return redirect()->to('login')->with('success', 'Registration successful. Your account is pending approval.');
        }

        return redirect()->back();
    }
}
