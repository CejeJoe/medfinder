<?php

namespace App\Controllers\Pharmacy;

use App\Controllers\BaseController;
use App\Models\PharmacyModel;


class Profile extends BaseController
{
    protected $session;
    protected $pharmacyModel;

    public function __construct()
    {
        $this->session = session();
        $this->pharmacyModel = new PharmacyModel();
    }
    private function checkAuth()
    {
        if (!$this->session->get('logged_in') || $this->session->get('role') !== 'pharmacy_admin') {
            return redirect()->to('/login');
        }
    }
public function index()
    {
        $this->checkAuth();
        $userId = $this->session->get('user_id');
        $pharmacy = $this->pharmacyModel->where('user_id', $userId)->first();

        if ($this->request->getMethod() === 'POST') {
            $this->pharmacyModel->update($pharmacy['id'], [
                'name' => $this->request->getPost('name'),
                'address' => $this->request->getPost('address'),
                'contact_number' => $this->request->getPost('contact_number'),
                'delivery_available' => $this->request->getPost('delivery_available') ? 1 : 0,
                'delivery_terms' => $this->request->getPost('delivery_terms'),
            ]);
            return redirect()->to('/pharmacy/profile')->with('success', 'Profile updated successfully');
        }

        return view('pharmacy_owner/profile', ['pharmacy' => $pharmacy]);
    }
}