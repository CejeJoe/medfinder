<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DrugModel;
use CodeIgniter\Files\File;

class DrugImageController extends BaseController
{
    protected $drugModel;

    public function __construct()
    {
        $this->drugModel = new DrugModel();
    }

    public function index()
    {
        $data['drugs'] = $this->drugModel->findAll();
        return view('admin/drug_management/upload_image', $data);
    }

    public function uploadImage()
    {
        // Validation for the image upload
        $validationRule = [
            'drug_image' => [
                'label' => 'Drug Image',
                'rules' => [
                    'uploaded[drug_image]',
                    'is_image[drug_image]',
                    'mime_in[drug_image,image/jpg,image/jpeg,image/png]',
                    'max_size[drug_image,2048]', // Maximum size in KB
                ],
            ],
        ];
    
        if (!$this->validate($validationRule)) {
            return $this->response->setJSON([
                'success' => false,
                'error' => $this->validator->getErrors()
            ]);
        }
    
        // Proceed if validation passes
        $img = $this->request->getFile('drug_image');
    
        // Check if the file has moved already
        if (!$img->hasMoved()) {
            // Generate a random filename for the image (using a timestamp or unique identifier)
            $randomName = uniqid('drug_', true) . '.' . $img->getExtension(); // Random name with extension
    
            // Store the image directly in the public/uploads/ directory
            $filepath = FCPATH . 'uploads/' . $randomName; // Directly save the file in public/uploads/
    
            // Move the uploaded image to the public/uploads folder with a random name
            $img->move(FCPATH . 'uploads', $randomName);
    
            // Initialize the image service to manipulate the image
            $image = \Config\Services::image()->withFile($filepath);
    
            // Resize the full-size image (e.g., 800x600)
            $image->resize(800, 600, true, 'height')
                  ->save(FCPATH . 'uploads/full_size/' . $randomName); // Save in 'public/uploads/full_size_'
    
            // Optionally generate a thumbnail image (e.g., 200x200)
            $image->fit(200, 200, 'center')
                  ->save(FCPATH . 'uploads/thumbnails/' . $randomName); // Save in 'public/uploads/thumbnail_'
    
            // Get the drug ID from POST data
            $drugId = $this->request->getPost('drug_id');
    
            // Create an array with the paths for the full-size image and thumbnail
            $imagePaths = [
                'full_size' => 'uploads/full_size/' . $randomName, // Save path without any subdirectories
                'thumbnail' => 'uploads/thumbnails/' . $randomName // Save path without any subdirectories
            ];
    
            // Save the image paths in the database
            $this->drugModel->saveImages($drugId, $imagePaths);
    
            // Return success message
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Image uploaded successfully'
            ]);
        }
    
        // If the image has already been moved, return an error
        return $this->response->setJSON([
            'success' => false,
            'error' => 'The file has already been moved.'
        ]);
    }
    
}
