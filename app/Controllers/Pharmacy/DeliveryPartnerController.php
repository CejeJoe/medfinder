<?php

namespace App\Controllers\Pharmacy;

use App\Controllers\BaseController;
use App\Models\DeliveryPartnerModel;

class DeliveryPartnerController extends BaseController
{
    protected $deliveryPartnerModel;
    protected $pharmacyId;


    public function __construct()
    {
        $this->deliveryPartnerModel = new DeliveryPartnerModel();
        $this->pharmacyId = session()->get('pharmacy_id');  // Initialize pharmacy_id from session
        // Check if pharmacy_id is not null or empty
        if (!$this->pharmacyId) {
        return redirect()->to('/login')->with('error', 'Please log in to access this page');
    }
    }

    public function index()
    {
        $data['delivery_partners'] = $this->deliveryPartnerModel->getAvailableDeliveryPartners($this->pharmacyId);
        return view('pharmacy_owner/delivery_partners/index', $data);
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
                'license_number' => 'required|is_unique[delivery_partners.license_number]'
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
                    'pharmacy_id' => null
                ];

                $this->deliveryPartnerModel->insert($data);
                return redirect()->to('/pharmacy/delivery-partners')->with('success', 'Delivery partner created successfully');
            } else {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
        }

        return view('pharmacy_owner/delivery_partners/create');
    }

    public function edit($id)
    {
        $deliveryPartner = $this->deliveryPartnerModel->find($id);

        if (!$deliveryPartner) {
            return redirect()->to('/pharmacy/delivery-partners')->with('error', 'Delivery partner not found');
        }

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'name' => 'required|min_length[3]|max_length[255]',
                'contact_number' => 'required|min_length[10]|max_length[15]',
                'email' => "required|valid_email|is_unique[delivery_partners.email,id,$id]",
                'address' => 'required|min_length[5]',
                'vehicle_type' => 'required',
                'license_number' => "required|is_unique[delivery_partners.license_number,id,$id]"
            ];

            if ($this->validate($rules)) {
                $data = [
                    'name' => $this->request->getPost('name'),
                    'contact_number' => $this->request->getPost('contact_number'),
                    'email' => $this->request->getPost('email'),
                    'address' => $this->request->getPost('address'),
                    'vehicle_type' => $this->request->getPost('vehicle_type'),
                    'license_number' => $this->request->getPost('license_number'),
                    'is_available' => $this->request->getPost('is_available') ? 1 : 0
                ];

                $this->deliveryPartnerModel->update($id, $data);
                return redirect()->to('/pharmacy/delivery-partners')->with('success', 'Delivery partner updated successfully');
            } else {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
        }

        $data['delivery_partner'] = $deliveryPartner;
        return view('pharmacy_owner/delivery_partners/edit', $data);
    }

    public function delete($id)
    {
        $deliveryPartner = $this->deliveryPartnerModel->find($id);

        if (!$deliveryPartner) {
            return redirect()->to('/pharmacy/delivery-partners')->with('error', 'Delivery partner not found');
        }

        $this->deliveryPartnerModel->delete($id);
        return redirect()->to('/pharmacy/delivery-partners')->with('success', 'Delivery partner deleted successfully');
    }
}

