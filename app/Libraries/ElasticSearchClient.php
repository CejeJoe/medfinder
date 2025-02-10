<?php

namespace App\Libraries;

use Elastic\Elasticsearch\ClientBuilder;
use CodeIgniter\Config\Services;

class ElasticsearchClient
{
    private $client;
    private $logger;

    public function __construct()
    {
        $this->logger = Services::logger();
        try {
            $this->client = ClientBuilder::create()
                ->setHosts(['localhost:9200'])
                ->build();
        } catch (\Exception $e) {
            $this->logger->error('Failed to create Elasticsearch client: ' . $e->getMessage());
            throw new \RuntimeException('Failed to connect to Elasticsearch');
        }
    }

    public function indexDrug($drug)
    {
        try {
            $params = [
                'index' => 'drugs',
                'id'    => $drug['id'],
                'body'  => $drug
            ];
            return $this->client->index($params);
        } catch (\Exception $e) {
            $this->logger->error('Failed to index drug: ' . $e->getMessage());
            throw new \RuntimeException('Failed to index drug');
        }
    }

    public function searchDrugs($query)
    {
        try {
            $params = [
                'index' => 'drugs',
                'body'  => [
                    'query' => [
                        'multi_match' => [
                            'query'  => $query,
                            'fields' => ['name', 'description', 'category']
                        ]
                    ]
                ]
            ];
            return $this->client->search($params);
        } catch (\Exception $e) {
            $this->logger->error('Failed to search drugs: ' . $e->getMessage());
            throw new \RuntimeException('Failed to search drugs');
        }
    }

    public function createDrugsIndex()
    {
        $params = [
            'index' => 'drugs',
            'body' => [
                'mappings' => [
                    'properties' => [
                        'name' => ['type' => 'text'],
                        'category' => ['type' => 'keyword'],
                        'description' => ['type' => 'text'],
                        'price' => ['type' => 'float'],
                        'pharmacy_id' => ['type' => 'integer']
                    ]
                ]
            ]
        ];

        return $this->client->indices()->create($params);
    }
}

