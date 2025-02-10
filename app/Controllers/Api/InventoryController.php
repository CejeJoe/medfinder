<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Services\ApiIntegrationService;
use App\Models\PharmacyDrugModel;

class InventoryController extends ResourceController
{
    protected $apiIntegrationService;
    protected $pharmacyDrugModel;

    public function __construct()
    {
        $this->apiIntegrationService = new ApiIntegrationService();
        $this->pharmacyDrugModel = new PharmacyDrugModel();
    }

    public function batchUpload()
    {
        $pharmacyId = session()->get('pharmacy_id');
        
        $file = $this->request->getFile('inventory_file');
        if (!$file->isValid() || $file->getClientExtension() !== 'csv') {
            return $this->respond([
                'success' => false,
                'message' => 'Please upload a valid CSV file'
            ], 400);
        }

        try {
            $result = $this->apiIntegrationService->processCSVUpload(
                $pharmacyId,
                $file->getTempName()
            );

            return $this->respond([
                'success' => true,
                'message' => 'Inventory updated successfully',
                'updated_count' => $result
            ]);
        } catch (\Exception $e) {
            return $this->respond([
                'success' => false,
                'message' => 'Failed to process inventory update'
            ], 500);
        }
    }

    public function updateStock($id)
    {
        $pharmacyId = session()->get('pharmacy_id');
        $rules = [
            'stock' => 'required|integer|min[0]',
            'price' => 'required|numeric|min[0]'
        ];

        if (!$this->validate($rules)) {
            return $this->respond([
                'success' => false,
                'message' => $this->validator->getErrors()
            ], 400);
        }

        try {
            $this->pharmacyDrugModel->update($id, [
                'stock' => $this->request->getVar('stock'),
                'price' => $this->request->getVar('price')
            ]);

            return $this->respond([
                'success' => true,
                'message' => 'Stock updated successfully'
            ]);
        } catch (\Exception $e) {
            return $this->respond([
                'success' => false,
                'message' => 'Failed to update stock'
            ], 500);
        }
    }

    public function syncFHIR()
    {
        $pharmacyId = session()->get('pharmacy_id');
        $rules = [
            'fhir_endpoint' => 'required|valid_url',
            'api_token' => 'required'
        ];

        if (!$this->validate($rules)) {
            return $this->respond([
                'success' => false,
                'message' => $this->validator->getErrors()
            ], 400);
        }

        try {
            $result = $this->apiIntegrationService->syncFHIRInventory(
                $pharmacyId,
                $this->request->getVar('fhir_endpoint'),
                ['token' => $this->request->getVar('api_token')]
            );

            return $this->respond([
                'success' => true,
                'message' => 'FHIR sync completed successfully',
                'updated_count' => $result
            ]);
        } catch (\Exception $e) {
            return $this->respond([
                'success' => false,
                'message' => 'Failed to sync with FHIR endpoint'
            ], 500);
        }
    }
}

