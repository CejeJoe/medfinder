<?php

namespace App\Controllers\Pharmacy;

use App\Controllers\BaseController;
use App\Models\DrugModel;
use App\Models\PharmacyDrugModel;
use App\Models\StockHistoryModel;
use App\Models\PharmacyModel;

class Inventory extends BaseController
{
    protected $drugModel;
    protected $pharmacyDrugModel;
    protected $stockHistoryModel;
    protected $pharmacyModel;

    public function __construct()
    {
        $this->drugModel = new DrugModel();
        $this->pharmacyDrugModel = new PharmacyDrugModel();
        $this->stockHistoryModel = new StockHistoryModel();
        $this->pharmacyModel = new PharmacyModel();
    }

    public function index()
    {
        $pharmacyId = session()->get('pharmacy_id');
        $data['inventory'] = $this->pharmacyDrugModel->getPharmacyInventory($pharmacyId);
        return view('pharmacy_owner/inventory/index', $data);
    }

    public function add()
    {
        if ($this->request->getMethod() === 'POST') {
            $pharmacyId = session()->get('pharmacy_id');
            $drugName = $this->request->getPost('drug_name');
            $price = $this->request->getPost('price');
            $stock = $this->request->getPost('stock');
            $featured = $this->request->getPost('featured') ? 1 : 0;

            // Find the drug by name
            $drug = $this->drugModel->where('name', $drugName)->first();

            if ($drug) {
                $data = [
                    'pharmacy_id' => $pharmacyId,
                    'drug_id' => $drug['id'],
                    'price' => $price,
                    'stock' => $stock,
                    'featured' => $featured
                ];

                $this->pharmacyDrugModel->insert($data);
                return redirect()->to('/pharmacy/inventory')->with('success', 'Drug added to inventory successfully');
            } else {
                return redirect()->back()->with('error', 'Drug not found in the database');
            }
        }

        return view('pharmacy_owner/inventory/add');
    }

    public function edit($id)
    {
        $pharmacyDrug = $this->pharmacyDrugModel->find($id);

        if ($this->request->getMethod() === 'POST') {
            $oldStock = $pharmacyDrug['stock'];
            $newStock = $this->request->getPost('stock');
            $price = $this->request->getPost('price');
            $featured = $this->request->getPost('featured') ? 1 : 0;

            $this->pharmacyDrugModel->update($id, [
                'price' => $price,
                'stock' => $newStock,
                'featured' => $featured
            ]);

            $this->stockHistoryModel->logStockChange($id, $oldStock, $newStock, session()->get('user_id'));

            return redirect()->to('/pharmacy/inventory')->with('success', 'Inventory item updated successfully');
        }
        $data['pharmacyDrug'] = $pharmacyDrug;
        $data['drug'] = $this->drugModel->find($pharmacyDrug['drug_id']);
        return view('pharmacy_owner/inventory/edit', $data);
    }

    public function delete($id)
    {
        $pharmacyId = session()->get('pharmacy_id');
        
        // First verify that the item belongs to the pharmacy
        $item = $this->pharmacyDrugModel->getInventoryItem($pharmacyId, $id);
        
        if (!$item) {
            return redirect()->to('/pharmacy/inventory')->with('error', 'Item not found or access denied');
        }

        try {
            // Delete the inventory item
            $this->pharmacyDrugModel->delete($id);
            return redirect()->to('/pharmacy/inventory')->with('success', 'Item deleted successfully');
        } catch (\Exception $e) {
            return redirect()->to('/pharmacy/inventory')->with('error', 'Failed to delete item');
        }
    }
    public function updateAvailability()
    {
        $pharmacyId = session()->get('pharmacy_id');
        $drugId = $this->request->getPost('drug_id');
        $availability = $this->request->getPost('availability');
        
        $success = $this->pharmacyDrugModel->updateGeneralAvailability($pharmacyId, $drugId, $availability);
        
        return $this->response->setJSON(['success' => $success]);
    }

    public function thresholdUpdate()
    {
        $pharmacyId = session()->get('pharmacy_id');
        $updates = $this->request->getPost('updates');

        $success = true;
        foreach ($updates as $update) {
            $result = $this->pharmacyDrugModel->updateGeneralAvailability($pharmacyId, $update['drug_id'], $update['availability']);
            if (!$result) {
                $success = false;
            }
        }

        return $this->response->setJSON(['success' => $success]);
    }
    public function bulkUpload()
    {
        if ($this->request->getMethod() === 'POST') {
            $file = $this->request->getFile('csv_file');
            $pharmacyId = session()->get('pharmacy_id');

            if ($file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move(WRITEPATH . 'uploads', $newName);

                $csvData = array_map('str_getcsv', file(WRITEPATH . 'uploads/' . $newName));
                array_shift($csvData); // Remove header row

                $pharmacy = $this->pharmacyModel->find($pharmacyId);

                foreach ($csvData as $row) {
                    $drugName = $row[0];
                    $price = $row[1];
                    $stock = $row[2];
                    $featured = isset($row[3]) && strtolower($row[3]) === 'yes' ? 1 : 0;

                    // Find the drug by name
                    $drug = $this->drugModel->where('name', $drugName)->first();

                    if ($drug) {
                        $existingDrug = $this->pharmacyDrugModel->where('pharmacy_id', $pharmacyId)
                                                                ->where('drug_id', $drug['id'])
                                                                ->first();

                        $data = [
                            'pharmacy_id' => $pharmacyId,
                            'drug_id' => $drug['id'],
                            'price' => $price,
                            'stock' => $stock,
                            'featured' => $featured,
                            'drug_name' => $drug['name'],
                            'category' => $drug['category'],
                            'prescription_required' => $drug['prescription_required'],
                            'pharmacy_name' => $pharmacy['name'],
                            'address' => $pharmacy['address'],
                            'latitude' => $pharmacy['latitude'],
                            'longitude' => $pharmacy['longitude'],
                            'delivery_available' => $pharmacy['delivery_available'],
                            'rating' => $pharmacy['rating'],
                            'general_availability' => $stock > 0 ? 'in_stock' : 'out_of_stock',
                        ];

                        if ($existingDrug) {
                            $this->pharmacyDrugModel->update($existingDrug['id'], $data);
                        } else {
                            $this->pharmacyDrugModel->insert($data);
                        }
                    }
                }

                return redirect()->to('/pharmacy/inventory')->with('success', 'Bulk upload completed successfully');
            }
        }

        return view('pharmacy_owner/inventory/bulk_upload');
    }
    public function downloadTemplate()
    {
        $data = "Drug Name,Price,Stock,Featured\n";
        $data .= "Paracetamol,10.99,100,Yes\n";
        $data .= "Ibuprofen,15.50,50,No\n";

        return $this->response->download('inventory_template.csv', $data);
    }
}
