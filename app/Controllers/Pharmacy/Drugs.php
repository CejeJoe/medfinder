<?php

namespace App\Controllers\Pharmacy;

use App\Controllers\BaseController;
use App\Models\DrugModel;
use App\Models\PharmacyDrugModel;

class Drugs extends BaseController
{
    protected $drugModel;
    protected $pharmacyDrugModel;
    protected $pharmacyId;

    public function __construct()
    {
        $this->drugModel = new DrugModel();
        $this->pharmacyDrugModel = new PharmacyDrugModel();
        $this->pharmacyId = session()->get('pharmacy_id');  // Initialize pharmacy_id from session
            // Check if pharmacy_id is not null or empty
            if (!$this->pharmacyId) {
            return redirect()->to('/login')->with('error', 'Please log in to access this page');
        }
    }

    public function index()
    {
        // Ensure pharmacy_id is available
        if (!$this->pharmacyId) {
            return redirect()->to('/login')->with('error', 'No pharmacy selected');
        }
        
        $drugs = $this->pharmacyDrugModel
            ->select('pharmacy_drugs.*, drugs.name, drugs.category')
            ->join('drugs', 'drugs.id = pharmacy_drugs.drug_id')
            ->where('pharmacy_drugs.pharmacy_id', $this->pharmacyId)
            ->paginate(10);

        $data = [
            'title' => 'Manage Drugs',
            'drugs' => $drugs,
            'pager' => $this->pharmacyDrugModel->pager
        ];

        return view('pharmacy_owner/drugs/index', $data);
    }

    public function add()
    {
        // $pharmacyId = session()->get('pharmacy_id');  // Initialize pharmacy_id from session

        $data = [
            'title' => 'Add New Drug'
        ];

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'drug_id' => 'required|numeric',
                'price' => 'required|numeric',
                'stock' => 'required|numeric',
                'prescription_required' => 'required|in_list[0,1]'
            ];

            if ($this->validate($rules)) {
                $drugData = [
                    'pharmacy_id' => $this->pharmacyId,  // Use pharmacy_id from session
                    'drug_id' => $this->request->getPost('drug_id'),
                    'price' => $this->request->getPost('price'),
                    'stock' => $this->request->getPost('stock'),
                    'prescription_required' => $this->request->getPost('prescription_required')
                ];

                $this->pharmacyDrugModel->insert($drugData);
                return redirect()->to('/pharmacy/drugs')->with('success', 'Drug added successfully');
            } else {
                $data['validation'] = $this->validator;
            }
        }

        // Get all drugs for the dropdown
        $data['allDrugs'] = $this->drugModel->findAll();

        return view('pharmacy_owner/drugs/add', $data);
    }

    public function edit($id)
    {
        $drug = $this->pharmacyDrugModel
            ->select('pharmacy_drugs.*, drugs.name, drugs.category')
            ->join('drugs', 'drugs.id = pharmacy_drugs.drug_id')
            ->where('pharmacy_drugs.id', $id)
            ->where('pharmacy_drugs.pharmacy_id', $this->pharmacyId)
            ->first();

        if (!$drug) {
            return redirect()->to('/pharmacy/drugs')->with('error', 'Drug not found');
        }

        $data = [
            'title' => 'Edit Drug',
            'drug' => $drug
        ];

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'price' => 'required|numeric',
                'stock' => 'required|numeric',
                'prescription_required' => 'required|in_list[0,1]'
            ];

            if ($this->validate($rules)) {
                $updateData = [
                    'price' => $this->request->getPost('price'),
                    'stock' => $this->request->getPost('stock'),
                    'prescription_required' => $this->request->getPost('prescription_required')
                ];

                $this->pharmacyDrugModel->update($id, $updateData);
                return redirect()->to('/pharmacy/drugs')->with('success', 'Drug updated successfully');
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('pharmacy_owner/drugs/edit', $data);
    }

    public function delete($id)
    {
        $drug = $this->pharmacyDrugModel
            ->where('id', $id)
            ->where('pharmacy_id', $this->pharmacyId)
            ->first();

        if (!$drug) {
            return redirect()->to('/pharmacy/drugs')->with('error', 'Drug not found');
        }

        $this->pharmacyDrugModel->delete($id);
        return redirect()->to('/pharmacy/drugs')->with('success', 'Drug removed successfully');
    }
}
