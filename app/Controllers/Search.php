<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Pager\Pager;
use App\Libraries\ElasticSearchClient;

class Search extends BaseController
{
    use ResponseTrait;

    protected $drugModel;
    protected $regionModel;
    protected $pharmacyDrugModel;
    protected $db;
    protected $pager;
    protected $elasticsearchClient;

    public function __construct()
    {
        $this->drugModel = new \App\Models\DrugModel();
        $this->regionModel = new \App\Models\RegionModel();
        $this->pharmacyDrugModel = new \App\Models\PharmacyDrugModel();
        $this->db = \Config\Database::connect();
        $this->pager = service('pager');
        $this->elasticsearchClient = new ElasticSearchClient();
    }

    public function index()
    {
        $categories = $this->drugModel->distinct()->select('category')->findAll();
        $pharmacies = $this->db->table('pharmacies')->select('name')->distinct()->get()->getResultArray();

        $data = [
            'title' => 'Search Medications',
            'categories' => array_column($categories, 'category'),
            'regions' => $this->regionModel->getRegionsWithPharmacies(),
            'query' => $this->request->getGet('query') ?? '',
            'selectedCategory' => $this->request->getGet('category') ?? '',
            'minPrice' => $this->request->getGet('min_price') ?? '',
            'maxPrice' => $this->request->getGet('max_price') ?? '',
            'selectedRating' => $this->request->getGet('rating') ?? '',
            'inStock' => $this->request->getGet('in_stock') ?? '',
            'delivery' => $this->request->getGet('delivery') ?? '',
            'selectedLocation' => $this->request->getGet('location') ?? '',
            'drugType' => $this->request->getGet('drug_type') ?? '',
            'sort' => $this->request->getGet('sort') ?? 'price_asc',
            'locations' => $this->regionModel->findAll(),
            'pharmacies' => array_column($pharmacies, 'name'),
            'selectedPharmacy' => $this->request->getGet('pharmacy') ?? '',
        ];

        $searchResult = $this->performSearch();
        $data['results'] = $searchResult['results'];
        $data['pager'] = $searchResult['pager'];
        $data['totalResults'] = $searchResult['totalCount'];
        $data['favorites'] = session()->get('favorites') ?? [];
        
        return view('search/index', $data);
    }
    
    private function performSearch()
    {
        $page = (int)($this->request->getGet('page') ?? 1);
        $perPage = 10;
        $sort = $this->request->getGet('sort') ?? 'price_asc';
        
        $query = $this->request->getGet('query') ?? '';
        
        if ($query) {
            try {
                $elasticResults = $this->elasticsearchClient->searchDrugs($query);
                $drugIds = array_column($elasticResults['hits']['hits'], '_id');
            } catch (\Exception $e) {
                log_message('error', 'Elasticsearch error: ' . $e->getMessage());
                $drugIds = [];
            }
        }

        $builder = $this->db->table('pharmacy_drugs')
            ->select('pharmacy_drugs.*, drugs.name as drug_name, drugs.category, drugs.image_url, pharmacies.name as pharmacy_name, pharmacies.address, pharmacies.latitude, pharmacies.longitude, pharmacies.delivery_available, pharmacies.rating')
            ->join('drugs', 'drugs.id = pharmacy_drugs.drug_id')
            ->join('pharmacies', 'pharmacies.id = pharmacy_drugs.pharmacy_id');

        if (!empty($drugIds)) {
            $builder->whereIn('drugs.id', $drugIds);
        } elseif ($query) {
            $builder->groupStart()
                ->like('drugs.name', $query)
                ->orLike('pharmacies.name', $query)
                ->groupEnd();
        }

        // Apply filters
        $category = $this->request->getGet('category');
        if ($category) {
            $builder->where('drugs.category', $category);
        }

        $minPrice = $this->request->getGet('min_price');
        $maxPrice = $this->request->getGet('max_price');
        if ($minPrice !== null) {
            $builder->where('pharmacy_drugs.price >=', $minPrice);
        }
        if ($maxPrice !== null) {
            $builder->where('pharmacy_drugs.price <=', $maxPrice);
        }

        $inStock = $this->request->getGet('in_stock');
        if ($inStock) {
            $builder->where('pharmacy_drugs.stock >', 0);
        }

        $location = $this->request->getGet('location');
        if ($location) {
            $builder->where('pharmacies.region_id', $location);
        }

        $pharmacy = $this->request->getGet('pharmacy');
        if ($pharmacy) {
            $builder->where('pharmacies.name', $pharmacy);
        }

        // Get total count before pagination
        $totalCount = $builder->countAllResults(false);

        // Apply sorting
        switch ($sort) {
            case 'price_desc':
                $builder->orderBy('pharmacy_drugs.price', 'DESC');
                break;
            case 'rating':
                $builder->orderBy('pharmacies.rating', 'DESC');
                break;
            case 'price_asc':
            default:
                $builder->orderBy('pharmacy_drugs.price', 'ASC');
        }

        // Get paginated results
        $results = $builder->get($perPage, ($page - 1) * $perPage)->getResultArray();

        // Create pager
        $pager = $this->pager;
        $pager->setPath('search');
        $pager->makeLinks($page, $perPage, $totalCount);

        return [
            'results' => $results,
            'pager' => $pager,
            'totalCount' => $totalCount
        ];
    }

    // public function autocomplete()
    // {
    //     $query = $this->request->getGet('query');
    //     $drugSuggestions = $this->drugModel->like('name', $query)->findAll(5);
    //     $pharmacySuggestions = $this->pharmacyModel->like('name', $query)->findAll(5);

    //     $suggestions = [
    //         'drugs' => $drugSuggestions,
    //         'pharmacies' => $pharmacySuggestions
    //     ];

    //     return $this->respond($suggestions);
    // }

    public function filter()
    {
        $searchResult = $this->performSearch();
        return $this->respond([
            'results' => $searchResult['results'],
            'pager' => $searchResult['pager']->links(),
            'totalCount' => $searchResult['totalCount']
        ]);
    }


    // New Advanced Search
    public function results()
    {
        $query = $this->request->getGet('query') ?? '';
        $category = $this->request->getGet('category') ?? '';
        $minPrice = $this->request->getGet('min_price') ?? '';
        $maxPrice = $this->request->getGet('max_price') ?? '';
        $region = $this->request->getGet('region') ?? '';
        $rating = $this->request->getGet('rating') ?? '';
        $availability = $this->request->getGet('availability') ?? '';
        $sort = $this->request->getGet('sort') ?? '';

        $results = $this->pharmacyDrugModel->advancedSearch(
            $query, $category, $minPrice, $maxPrice, $region, $rating, $availability, $sort
        );

        $data['results'] = $results;
        return view('search/results', $data);
    }

    public function autocomplete()
    {
        $query = $this->request->getGet('query') ?? '';
        $results = $this->drugModel->like('name', $query)->orLike('generic_name', $query)->findAll(10);

        return $this->response->setJSON($results);
    }
    
}

