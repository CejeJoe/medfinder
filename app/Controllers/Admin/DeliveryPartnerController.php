<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DeliveryPartnerModel;
use App\Models\PharmacyModel;

class DeliveryPartnerController extends BaseController
{
    protected $deliveryPartnerModel;
    protected $pharmacyModel;

    public function __construct()
    {
        $this->deliveryPartnerModel = new DeliveryPartnerModel();
        $this->pharmacyModel = new PharmacyModel();
    }

    public function index()
    {
        $data['delivery_partners'] = $this->deliveryPartnerModel->findAll();
        return view('admin/delivery_partners/index', $data);
    }

    public function create()
    {
        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'name' => 'required|min_length[3]|max_length[255]',
                'contact_number' => 'required|min_length[10]|max_length[15]',
                'email' => 'required|valid_email|is_unique[delivery_partners.email]',
                'address' => 'required|min_length[5]',
                'vehicle_type' => 'required',
                'license_number' => 'required|is_unique[delivery_partners.license_number]',
            ];

            if ($this->validate($rules)) {
                $data = [
                    'name' => $this->request->getPost('name'),
                    'contact_number' => $this->request->getPost('contact_number'),
                    'email' => $this->request->getPost('email'),
                    'address' => $this->request->getPost('address'),
                    'vehicle_type' => $this->request->getPost('vehicle_type'),
                    'license_number' => $this->request->getPost('license_number'),
                    'is_available' => $this->request->getPost('is_available') ? 1 : 0,
                ];

                $this->deliveryPartnerModel->insert($data);
                return redirect()->to('/admin/delivery-partners')->with('success', 'Delivery partner created successfully');
            } else {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
        }

        $data['pharmacies'] = $this->pharmacyModel->findAll();
        return view('admin/delivery_partners/create', $data);
    }

    public function edit($id)
    {
        $deliveryPartner = $this->deliveryPartnerModel->find($id);

        if (!$deliveryPartner) {
            return redirect()->to('/admin/delivery-partners')->with('error', 'Delivery partner not found');
        }

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'name' => 'required|min_length[3]|max_length[255]',
                'contact_number' => 'required',
                'email' => "required|valid_email|is_unique[delivery_partners.email,id,$id]",
                'address' => 'required|min_length[5]',
                'vehicle_type' => 'required',
                'license_number' => "required",
            ];

            if ($this->validate($rules)) {
                $data = [
                    'name' => $this->request->getPost('name'),
                    'contact_number' => $this->request->getPost('contact_number'),
                    'email' => $this->request->getPost('email'),
                    'address' => $this->request->getPost('address'),
                    'vehicle_type' => $this->request->getPost('vehicle_type'),
                    'license_number' => $this->request->getPost('license_number'),
                    'is_available' => $this->request->getPost('is_available') ? 1 : 0,
                    // 'pharmacy_id' => $this->request->getPost('pharmacy_id')
                ];

                $this->deliveryPartnerModel->update($id, $data);
                return redirect()->to('/admin/delivery-partners')->with('success', 'Delivery partner updated successfully');
            } else {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
        }

        $data['delivery_partner'] = $deliveryPartner;
        // $data['pharmacies'] = $this->pharmacyModel->findAll();
        return view('admin/delivery_partners/edit', $data);
    }

    public function delete($id)
    {
        $deliveryPartner = $this->deliveryPartnerModel->find($id);

        if (!$deliveryPartner) {
            return redirect()->to('/admin/delivery-partners')->with('error', 'Delivery partner not found');
        }

        $this->deliveryPartnerModel->delete($id);
        return redirect()->to('/admin/delivery-partners')->with('success', 'Delivery partner deleted successfully');
    }
}

