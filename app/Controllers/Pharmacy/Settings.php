<?php

namespace App\Controllers\Pharmacy;

use App\Controllers\BaseController;
use App\Models\PharmacyModel;

class Settings extends BaseController
{
    public function index()
    {
        $pharmacyModel = new PharmacyModel();
        $pharmacyId = session()->get('pharmacy_id');
        $pharmacy = $pharmacyModel->find($pharmacyId);

        if ($this->request->getMethod() === 'POST') {
            $data = [
                'name' => $this->request->getPost('name'),
                'address' => $this->request->getPost('address'),
                'contact_number' => $this->request->getPost('contact_number'),
                'delivery_available' => $this->request->getPost('delivery_available') ? 1 : 0,
                'delivery_terms' => $this->request->getPost('delivery_terms'),
            ];

            if ($pharmacyModel->update($pharmacyId, $data)) {
                return redirect()->to('/pharmacy/settings')->with('success', 'Settings updated successfully');
            } else {
                return redirect()->back()->withInput()->with('errors', $pharmacyModel->errors());
            }
        }

        $data = [
            'title' => 'Pharmacy Settings',
            'pharmacy' => $pharmacy
        ];

        return view('pharmacy_owner/settings', $data);
    }
}

