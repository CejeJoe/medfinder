<?php

namespace App\Controllers\Api;

use CodeIgniter\Controller;
use App\Models\DrugModel;

class DrugUpdateController extends Controller
{
    protected $drugModel;

    public function __construct()
    {
        $this->drugModel = new DrugModel();
    }

    public function updateDrugs()
    {
        $apiUrl = 'https://api.fda.gov/drug/label.json?limit=100';
        $response = file_get_contents($apiUrl);
        $data = json_decode($response, true);

        $results = [];
        $count = 0;

        if (isset($data['results'])) {
            foreach ($data['results'] as $drug) {
                if ($count >= 50) {
                    break;
                }

                $drugName = $drug['openfda']['brand_name'][0] ?? '';
                if (empty($drugName)) {
                    continue;
                }

                $existingDrug = $this->drugModel->where('name', $drugName)->first();
                if (!$existingDrug) {
                    $manufacturerCountry = $this->extractCountry($drug['openfda']['manufacturer_name'][0] ?? '');
                    $price = $this->calculatePrice($drug['openfda']['brand_name'][0] ?? '');

                    $imageUrl = $this->saveImage($drugName);
                    $thumbnailUrl = $this->saveThumbnail($drugName);

                    $drugData = [
                        'name' => $drugName,
                        'manufacturer_country' => $manufacturerCountry,
                        'manufacturer_name' => $drug['openfda']['manufacturer_name'][0] ?? '',
                        'category' => $drug['openfda']['product_type'][0] ?? '',
                        'description' => $drug['description'][0] ?? '',
                        'price' => $price,
                        'image_url' => $imageUrl,
                        'thumbnail_url' => $thumbnailUrl,
                        'status' => 'active',
                        'is_featured' => 0,
                        'expiry_date' => date('Y-m-d', strtotime('+1 year')),
                        'is_approved' => 1,
                        'dosage' => $drug['dosage_and_administration'][0] ?? '',
                        'form' => $drug['openfda']['dosage_form'][0] ?? '',
                        'side_effects' => $drug['adverse_reactions'][0] ?? '',
                        'contraindications' => $drug['contraindications'][0] ?? '',
                        'generic_name' => $drug['openfda']['generic_name'][0] ?? '',
                        'prescription_required' => 1,
                        'manufacturer' => $drug['openfda']['manufacturer_name'][0] ?? '',
                        'indications' => $drug['indications_and_usage'][0] ?? '',
                        'pharmacology' => $drug['clinical_pharmacology'][0] ?? '',
                        'dosage_administration' => $drug['dosage_and_administration'][0] ?? '',
                        'storage_conditions' => $drug['storage_and_handling'][0] ?? '',
                        'shelf_life' => '2 years'
                    ];

                    $this->drugModel->insertDrug($drugData);
                    $results[] = "Drug added: {$drugName}";
                    $count++;
                }
            }
        }

        return view('api/update_results', ['results' => $results]);
    }

    public function fillMissingFields()
    {
        $drugs = $this->drugModel->findAll();

        foreach ($drugs as $drug) {
            $updateData = [];

            if (empty($drug['manufacturer_country']) || empty($drug['expiry_date']) || empty($drug['indications']) || empty($drug['pharmacology']) || empty($drug['dosage_administration']) || empty($drug['storage_conditions']) || empty($drug['shelf_life'])) {
                $apiUrl = 'https://api.fda.gov/drug/label.json?search=openfda.brand_name:"' . urlencode($drug['name']) . '"';
                $response = @file_get_contents($apiUrl);

                if ($response === FALSE) {
                    continue; // Skip this drug if the API request fails
                }

                $data = json_decode($response, true);

                if (isset($data['results'][0])) {
                    $drugData = $data['results'][0];

                    if (empty($drug['manufacturer_country'])) {
                        $updateData['manufacturer_country'] = $this->extractCountry($drugData['openfda']['manufacturer_name'][0] ?? '');
                    }

                    if (empty($drug['expiry_date']) || $drug['expiry_date'] == '0000-00-00') {
                        $updateData['expiry_date'] = date('Y-m-d', strtotime('+1 year'));
                    }

                    if (empty($drug['indications'])) {
                        $updateData['indications'] = $drugData['indications_and_usage'][0] ?? 'Not specified';
                    }

                    if (empty($drug['pharmacology'])) {
                        $updateData['pharmacology'] = $drugData['clinical_pharmacology'][0] ?? 'Not specified';
                    }

                    if (empty($drug['dosage_administration'])) {
                        $updateData['dosage_administration'] = $drugData['dosage_and_administration'][0] ?? 'Not specified';
                    }

                    if (empty($drug['storage_conditions'])) {
                        $updateData['storage_conditions'] = $drugData['storage_and_handling'][0] ?? 'Store in a cool, dry place';
                    }

                    if (empty($drug['shelf_life'])) {
                        $updateData['shelf_life'] = '2 years';
                    }

                    if (!empty($updateData)) {
                        $this->drugModel->update($drug['id'], $updateData);
                    }
                }
            }
        }

        return 'Missing fields filled successfully';
    }

    private function extractCountry($manufacturerName)
    {
        // Logic to extract the country from the manufacturer name
        // This is a placeholder implementation, you should replace it with actual logic
        $countries = ['USA', 'Canada', 'Germany', 'France', 'India', 'China', 'Japan', 'UK', 'Uganda'];
        foreach ($countries as $country) {
            if (stripos($manufacturerName, $country) !== false) {
                return $country;
            }
        }
        return 'Unknown';
    }

    private function calculatePrice($drugName)
    {
        // Logic to calculate a reasonable price in Ugandan Shillings
        // This is a placeholder implementation, you should replace it with actual logic
        return rand(1000, 100000);
    }

    private function saveImage($drugName)
    {
        $imageName = 'drug_' . uniqid() . '.jpg';
        $imagePath = FCPATH . 'uploads\full_size\/' . $imageName;

        // Save a placeholder image
        copy(FCPATH . 'uploads\placeholder.jpg', $imagePath);

        return '/uploads/full_size/' . $imageName;
    }

    private function saveThumbnail($drugName)
    {
        $thumbnailName = 'drug_' . uniqid() . '_thumb.jpg';
        $thumbnailPath = FCPATH . 'uploads/thumbnails/' . $thumbnailName;

        // Save a placeholder thumbnail
        copy(FCPATH . 'uploads/placeholder_thumb.jpg', $thumbnailPath);

        return '/uploads/thumbnails/' . $thumbnailName;
    }
}
