<?php

namespace App\Services;

use CodeIgniter\HTTP\CURLRequest;
use App\Models\PharmacyDrugModel;
use App\Models\NotificationModel;

class ApiIntegrationService
{
    protected $client;
    protected $pharmacyDrugModel;
    protected $notificationModel;

    public function __construct()
    {
        $this->client = \Config\Services::curlrequest();
        $this->pharmacyDrugModel = new PharmacyDrugModel();
        $this->notificationModel = new NotificationModel();
    }

    public function syncFHIRInventory($pharmacyId, $fhirEndpoint, $credentials)
    {
        try {
            $response = $this->client->request('GET', $fhirEndpoint . '/MedicationStatement', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $credentials['token'],
                    'Accept' => 'application/fhir+json'
                ]
            ]);

            if ($response->getStatusCode() === 200) {
                $medications = json_decode($response->getBody(), true);
                return $this->processFHIRMedications($pharmacyId, $medications);
            }

            return false;
        } catch (\Exception $e) {
            log_message('error', 'FHIR sync failed: ' . $e->getMessage());
            return false;
        }
    }

    protected function processFHIRMedications($pharmacyId, $medications)
    {
        $updates = [];
        foreach ($medications['entry'] as $entry) {
            $medication = $entry['resource'];
            $updates[] = [
                'pharmacy_id' => $pharmacyId,
                'drug_name' => $medication['medicationCodeableConcept']['text'],
                'stock' => $medication['quantity']['value'] ?? 0,
                'price' => $medication['price']['value'] ?? 0,
                'updated_at' => date('Y-m-d H:i:s')
            ];
        }

        return $this->pharmacyDrugModel->updateBatch($updates, 'drug_name');
    }

    public function processCSVUpload($pharmacyId, $file)
    {
        $handle = fopen($file, 'r');
        $header = fgetcsv($handle);
        $updates = [];

        while (($row = fgetcsv($handle)) !== false) {
            $data = array_combine($header, $row);
            $updates[] = [
                'pharmacy_id' => $pharmacyId,
                'drug_name' => $data['drug_name'],
                'stock' => $data['stock'],
                'price' => $data['price'],
                'updated_at' => date('Y-m-d H:i:s')
            ];

            // Check for low stock and notify
            if ($data['stock'] <= $data['low_stock_threshold']) {
                $this->notificationModel->addNotification(
                    $pharmacyId,
                    'low_stock',
                    "Low stock alert for {$data['drug_name']}: {$data['stock']} units remaining"
                );
            }
        }

        fclose($handle);
        return $this->pharmacyDrugModel->updateBatch($updates, 'drug_name');
    }
}

