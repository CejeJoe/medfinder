<?php

namespace App\Controllers;

use App\Models\DrugModel;
use App\Models\PharmacyDrugModel;

class Drug extends BaseController
{
    protected $drugModel;
    protected $pharmacyDrugModel;

    public function __construct()
    {
        $this->drugModel = new DrugModel();
        $this->pharmacyDrugModel = new PharmacyDrugModel();
    }

    public function view($id)
    {
        // Fetch the pharmacy drug details
        $pharmacyDrug = $this->pharmacyDrugModel->find($id);
        if (!$pharmacyDrug) {
            return redirect()->to('/')->with('error', 'Pharmacy drug not found.');
        }

        // Fetch the drug details from the DrugModel using the drug_id from PharmacyDrugModel
        $drug = $this->drugModel->find($pharmacyDrug['drug_id']);
        if (!$drug) {
            return redirect()->to('/')->with('error', 'Drug not found.');
        }

        // Add pharmacy-specific details to the drug array
        $drug['price'] = $pharmacyDrug['price'];
        $drug['stock'] = $pharmacyDrug['stock'];

        // Fetch pharmacies that have this drug
        $pharmacies = $this->pharmacyDrugModel->where('drug_id', $pharmacyDrug['drug_id'])->findAll();

        return view('drug/view', [
            'drug' => $drug,
            'pharmacies' => $pharmacies
        ]);
    }
}

