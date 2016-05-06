<?php

namespace App\Services;

use Cviebrock\LaravelElasticsearch\Manager;

class Elasticsearch
{

    /**
     * @var Manager
     */
    protected $elasticsearch;

    public function __construct(Manager $elasticsearch)
    {

        $this->elasticsearch = $elasticsearch;
    }

    public function find($id, $type, $index = 'grimm')
    {
        $params = [
            'index' => $index,
            'type' => $type,
            'id' => $id,
        ];

        return $book = $this->elasticsearch->get($params);
    }

    public function count($type, $index = 'grimm')
    {
        $params = [
            'index' => $index,
            'type' => $type,
        ];

        return $this->elasticsearch->count($params)['count'];
    }

    public function search($type, $criteria, $limit=10, $page=1, $index='grimm')
    {
        $from = ($page - 1) * $limit;

        $params = [
            'index' => $index,
            'type' => $type,
            'size' => $limit,
            'from' => $from
        ];

        if (!is_null($criteria) || !empty($criteria)) {
            $params['body'] = $criteria;
        }

        return $this->elasticsearch->search($params);
    }
}
