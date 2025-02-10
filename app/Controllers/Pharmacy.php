<?php

namespace App\Controllers;

use App\Models\PharmacyModel;
use App\Models\PharmacyDrugModel;
use App\Models\ReviewModel;
use App\Models\DrugModel;
use App\Models\ServiceModel;
use App\Models\CertificationModel;
use App\Models\PharmacistModel;
use App\Models\PharmacyViewModel;

class Pharmacy extends BaseController
{
    protected $pharmacyModel;
    protected $pharmacyDrugModel;
    protected $reviewModel;
    protected $drugModel;
    protected $serviceModel;
    protected $certificationModel;
    protected $pharmacistModel;
    protected $pharmacyViewModel;

    public function __construct()
    {
        $this->pharmacyModel = new PharmacyModel();
        $this->pharmacyDrugModel = new PharmacyDrugModel();
        $this->reviewModel = new ReviewModel();
        $this->drugModel = new DrugModel();
        $this->serviceModel = new ServiceModel();
        $this->certificationModel = new CertificationModel();
        $this->pharmacistModel = new PharmacistModel();
        $this->pharmacyViewModel = new PharmacyViewModel();
    }

    public function profile($id)
    {
        $pharmacy = $this->pharmacyModel->find($id);
        if (!$pharmacy) {
            return redirect()->to('/')->with('error', 'Pharmacy not found');
        }

        // Increment view count
        $this->pharmacyViewModel->insert([
            'pharmacy_id' => $id,
            'pharmacy_name' => $pharmacy['name'],
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'user_agent' => $this->request->getUserAgent()->getAgentString(),
            'ip_address' => $this->request->getIPAddress(),
            'view_date' => date('Y-m-d')
        ]);

        // Get daily and total views
        $dailyViews = $this->pharmacyViewModel->getDailyViews($id);
        $totalViews = $this->pharmacyViewModel->getTotalViews($id);

        // Get reviews and rating
        $reviews = $this->reviewModel->getPharmacyReviews($id, 10);
        $averageRating = $this->reviewModel->getAverageRating($id);
        
        // Get pharmacy drugs with categories
        $pharmacyDrugs = $this->pharmacyDrugModel->where('pharmacy_id', $id)->findAll();
        $drugs = [];
        $categories = [];
        
        foreach ($pharmacyDrugs as $pharmacyDrug) {
            $drug = $this->drugModel->find($pharmacyDrug['drug_id']);
            if ($drug) {
                $drugs[] = [
                    'drug' => $drug,
                    'price' => $pharmacyDrug['price'],
                    'stock' => $pharmacyDrug['stock'],
                    'discount' => $pharmacyDrug['discount'] ?? 0,
                    'category' => $drug['category']
                ];
                
                if (!in_array($drug['category'], $categories)) {
                    $categories[] = $drug['category'];
                }
            }
        }

        // Get services
        $services = $this->serviceModel->where('pharmacy_id', $id)->findAll();
        
        // Get certifications
        $certifications = $this->certificationModel->where('pharmacy_id', $id)->findAll();
        
        // Get pharmacists
        $pharmacists = $this->pharmacistModel->where('pharmacy_id', $id)->findAll();
        
        // Get nearby pharmacies
        $nearbyPharmacies = $this->pharmacyModel->getNearbyPharmacies(
            $pharmacy['latitude'],
            $pharmacy['longitude'],
            5, // 5km radius
            $id, // exclude current pharmacy
            10 // limit to 10 results
        );

        $data = [
            'pharmacy' => $pharmacy,
            'drugs' => $drugs,
            'categories' => $categories,
            'reviews' => $reviews,
            'averageRating' => $averageRating,
            'services' => $services,
            'certifications' => $certifications,
            'pharmacists' => $pharmacists,
            'nearbyPharmacies' => $nearbyPharmacies,
            'workingHours' => $this->getWorkingHours($pharmacy['operating_hours']),
            'emergencyContact' => $pharmacy['emergency_contact'] ?? null,
            'acceptedInsurance' => explode(',', $pharmacy['accepted_insurance'] ?? ''),
            'languages' => explode(',', $pharmacy['supported_languages'] ?? 'English'),
            'facilities' => [
                'wheelchair_accessible' => $pharmacy['wheelchair_accessible'] ?? false,
                'parking_available' => $pharmacy['parking_available'] ?? false,
                'consultation_room' => $pharmacy['consultation_room'] ?? false,
                'vaccination_facility' => $pharmacy['vaccination_facility'] ?? false
            ],
            'dailyViews' => $dailyViews,
            'totalViews' => $totalViews
        ];

        return view('pharmacy_profile', $data);
    }

    private function getWorkingHours($workingHours)
    {
        // Parse JSON working hours into structured array
        $hours = json_decode($workingHours, true) ?? [];
        $structured = [];
        
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        foreach ($days as $day) {
            $structured[$day] = $hours[$day] ?? ['open' => '09:00', 'close' => '18:00'];
        }
        
        return $structured;
    }

    public function addToCart()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }

        $drugId = $this->request->getPost('id');
        $quantity = $this->request->getPost('quantity') ?? 1;

        $pharmacyDrug = $this->pharmacyDrugModel->where('drug_id', $drugId)->first();
        if (!$pharmacyDrug) {
            return $this->response->setJSON(['success' => false, 'message' => 'Product not found']);
        }

        // Check stock
        if ($pharmacyDrug['stock'] < $quantity) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Insufficient stock available'
            ]);
        }

        // Add to cart
        $cart = session()->get('cart') ?? [];
        $cart[$drugId] = [
            'id' => $drugId,
            'name' => $this->request->getPost('name'),
            'price' => $this->request->getPost('price'),
            'quantity' => $quantity,
            'pharmacy_id' => $pharmacyDrug['pharmacy_id']
        ];

        session()->set('cart', $cart);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Added to cart successfully',
            'cartCount' => count($cart)
        ]);
    }

    public function filter()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false]);
        }

        $category = $this->request->getGet('category');
        $minPrice = $this->request->getGet('min_price');
        $maxPrice = $this->request->getGet('max_price');
        $inStock = $this->request->getGet('in_stock');
        $pharmacyId = $this->request->getGet('pharmacy_id');

        $builder = $this->pharmacyDrugModel
            ->select('pharmacy_drugs.*, drugs.*')
            ->join('drugs', 'drugs.id = pharmacy_drugs.drug_id')
            ->where('pharmacy_drugs.pharmacy_id', $pharmacyId);

        if ($category) {
            $builder->where('drugs.category', $category);
        }

        if ($minPrice !== null) {
            $builder->where('pharmacy_drugs.price >=', $minPrice);
        }

        if ($maxPrice !== null) {
            $builder->where('pharmacy_drugs.price <=', $maxPrice);
        }

        if ($inStock) {
            $builder->where('pharmacy_drugs.stock >', 0);
        }

        $results = $builder->findAll();

        return $this->response->setJSON([
            'success' => true,
            'data' => $results
        ]);
    }
}

