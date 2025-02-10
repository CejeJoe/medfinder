<?php

namespace App\Controllers\Pharmacy;

use App\Controllers\BaseController;
use App\Models\PharmacyDrugModel;

class StockCheck extends BaseController
{
    protected $pharmacyDrugModel;

    public function __construct()
    {
        $this->pharmacyDrugModel = new PharmacyDrugModel();
    }

    public function checkAvailability()
    {
        $drugId = $this->request->getGet('drug_id');
        $pharmacyId = $this->request->getGet('pharmacy_id');

        $item = $this->pharmacyDrugModel->where('drug_id', $drugId)
                                        ->where('pharmacy_id', $pharmacyId)
                                        ->first();

        if ($item) {
            return $this->response->setJSON([
                'available' => $item['general_availability'] !== 'out_of_stock',
                'status' => $item['general_availability'],
                'message' => ucfirst(str_replace('_', ' ', $item['general_availability']))
            ]);
        }

        return $this->response->setJSON([
            'available' => false,
            'status' => 'not_found',
            'message' => 'Drug not found in pharmacy inventory'
        ]);
    }
}

