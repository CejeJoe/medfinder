<?php

namespace App\Controllers;

use App\Models\PharmacyModel;
use App\Models\RegionModel;

class Pharmacies extends BaseController
{
    protected $pharmacyModel;
    protected $regionModel;

    public function __construct()
    {
        $this->pharmacyModel = new PharmacyModel();
        $this->regionModel = new RegionModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Pharmacies',
            'regions' => $this->regionModel->findAll(),
        ];

        if ($this->request->isAJAX()) {
            return $this->getFilteredPharmacies();
        }

        return view('pharmacies/index', $data);
    }

    private function getFilteredPharmacies()
    {
        $search = $this->request->getGet('search');
        $region = $this->request->getGet('region');
        $rating = $this->request->getGet('rating');
        $delivery = $this->request->getGet('delivery');

        $pharmacies = $this->pharmacyModel->select('pharmacies.*, regions.name as region_name')
            ->join('regions', 'regions.id = pharmacies.region_id', 'left')
            ->where('pharmacies.is_active', true);

        if ($search) {
            $pharmacies->groupStart()
                ->like('pharmacies.name', $search)
                ->orLike('pharmacies.address', $search)
                ->groupEnd();
        }

        if ($region) {
            $pharmacies->where('pharmacies.region_id', $region);
        }

        if ($rating) {
            $pharmacies->where('pharmacies.rating >=', $rating);
        }

        if ($delivery) {
            $pharmacies->where('pharmacies.delivery_available', 1);
        }

        $result = $pharmacies->paginate(12);

        return $this->response->setJSON([
            'pharmacies' => $result,
            'pager' => $pharmacies->pager->links()
        ]);
    }
}

