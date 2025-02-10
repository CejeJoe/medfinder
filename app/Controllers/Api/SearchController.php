<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\DrugModel;

class SearchController extends ResourceController
{
    protected $drugModel;

    public function __construct()
    {
        $this->drugModel = new DrugModel();
    }

    public function search()
    {
        $query = $this->request->getGet('q');
        $results = $this->drugModel->searchWithSuggestions($query);

        return $this->respond($results);
    }
}

