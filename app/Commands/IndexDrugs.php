<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use App\Models\DrugModel;
use App\Libraries\ElasticsearchClient;

class IndexDrugs extends BaseCommand
{
    protected $group = 'MedFinder';
    protected $name = 'elastic:index-drugs';
    protected $description = 'Index all drugs in Elasticsearch';

    public function run(array $params)
    {
        $drugModel = new DrugModel();
        $elastic = new ElasticsearchClient();
        
        $drugs = $drugModel->findAll();
        
        foreach ($drugs as $drug) {
            $params = [
                'index' => 'drugs',
                'id' => $drug['id'],
                'body' => $drug
            ];
            
            $elastic->client->index($params);
        }
    }
} 