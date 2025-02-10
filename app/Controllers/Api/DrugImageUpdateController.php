<?php

namespace App\Controllers\Api;

use CodeIgniter\Controller;
use App\Models\DrugModel;

class DrugImageUpdateController extends Controller
{
    protected $drugModel;

    public function __construct()
    {
        $this->drugModel = new DrugModel();
    }

    public function updateImages()
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
                if ($existingDrug) {
                    $imageUrl = $drug['openfda']['image_url'][0] ?? null;
                    $thumbnailUrl = $drug['openfda']['thumbnail_url'][0] ?? null;

                    if ($imageUrl && $thumbnailUrl) {
                        $savedImageUrl = $this->fetchAndSaveImage($drugName, $imageUrl);
                        $savedThumbnailUrl = $this->fetchAndSaveThumbnail($drugName, $thumbnailUrl);

                        $drugData = [
                            'image_url' => $savedImageUrl,
                            'thumbnail_url' => $savedThumbnailUrl
                        ];

                        $updated = $this->drugModel->update($existingDrug['id'], $drugData);
                        if ($updated) {
                            $results[] = "Images updated for drug: {$drugName}";
                        } else {
                            $results[] = "Failed to update images for drug: {$drugName}";
                        }
                        $count++;
                    } else {
                        $results[] = "No image URLs found for drug: {$drugName}";
                    }
                }
            }
        }

        return view('api/update_images', ['results' => $results]);
    }

    private function fetchAndSaveImage($drugName, $imageUrl)
    {
        $imageName = 'drug_' . uniqid() . '.jpg';
        $imagePath = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'full_size' . DIRECTORY_SEPARATOR . $imageName;

        // Ensure the directory exists
        if (!is_dir(dirname($imagePath))) {
            mkdir(dirname($imagePath), 0755, true);
        }

        // Fetch the image from the API
        file_put_contents($imagePath, file_get_contents($imageUrl));

        return '/uploads/full_size/' . $imageName;
    }

    private function fetchAndSaveThumbnail($drugName, $thumbnailUrl)
    {
        $thumbnailName = 'drug_' . uniqid() . '_thumb.jpg';
        $thumbnailPath = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'thumbnails' . DIRECTORY_SEPARATOR . $thumbnailName;

        // Ensure the directory exists
        if (!is_dir(dirname($thumbnailPath))) {
            mkdir(dirname($thumbnailPath), 0755, true);
        }

        // Fetch the thumbnail from the API
        file_put_contents($thumbnailPath, file_get_contents($thumbnailUrl));

        return '/uploads/thumbnails/' . $thumbnailName;
    }
}
