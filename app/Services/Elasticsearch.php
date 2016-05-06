<?php

namespace App\Services;

use Cviebrock\LaravelElasticsearch\Manager;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class Elasticsearch
{

    /**
     * @var Manager
     */
    protected $elasticsearch;

    protected $body = [];

    protected $index = 'grimm';

    protected $type = null;

    public function __construct(Manager $elasticsearch)
    {
        $this->elasticsearch = $elasticsearch;
    }

    /**
     * Get a document of the set type by its id
     *
     * @param $id
     *
     * @return mixed
     */
    public function find($id)
    {
        $params = [
            'index' => $this->index,
            'type' => $this->type,
            'id' => $id,
        ];

        return $this->elasticsearch->get($params);
    }

    /**
     * Get the number of results for the query
     *
     * @return mixed
     */
    public function count()
    {
        $params = [
            'index' => $this->index,
            'type' => $this->type,
            'body' => $this->body,
        ];

        $count = $this->elasticsearch->count($params)['count'];

        $this->body = [];

        return $count;
    }

    /**
     * Set the order of the results to a field and specify the direction.
     * By default a sort by relevance score is applied, which is in most cases the requested behaviour
     * for a search request.
     *
     * @param string $field
     * @param string $order
     *
     * @return $this
     */
    public function orderBy($field, $order = 'asc')
    {
        if (!array_key_exists('sort', $this->body)) {
            $this->body['sort'] = [];
        }

        $this->body['sort'][] = [$field => ['order' => $order]];

        return $this;
    }

    /**
     * Using this method it is possible to add search constraints.
     *
     * @param $query
     *
     * @return $this
     */
    public function query($query)
    {
        $this->body['query'] = $query;

        return $this;
    }

    /**
     * Get the bare result set for a search.
     *
     * @param $limit
     * @param $offset
     *
     * @return array
     */
    public function search($limit = 10, $offset = 0)
    {
        $params = [
            'index' => $this->index,
            'type' => $this->type,
            'size' => $limit,
            'from' => $offset,
            'body' => $this->body,
        ];

        $result = $this->elasticsearch->search($params);

        $this->body = [];

        return $result;
    }

    /**
     * Paginate the results of the search!
     *
     * @param int $limit
     *
     * @return LengthAwarePaginator
     */
    public function paginate($limit = 10)
    {
        $page = Paginator::resolveCurrentPage('page');

        $offset = $this->calcOffset($limit, $page);

        $result = $this->search($limit, $offset);

        $items = $result['hits']['hits'];
        $total = $result['hits']['total'];

        return new LengthAwarePaginator($items, $total, $limit, $page, ['path' => Paginator::resolveCurrentPath()]);
    }

    /**
     * Return the Elasticsearch manager object for further query inspection
     *
     * @return Manager
     */
    public function getElasticsearch()
    {
        return $this->elasticsearch;
    }

    /**
     * Set the index, that is used for search
     *
     * @param string $index
     *
     * @return $this
     */
    public function setIndex($index)
    {
        $this->index = $index;

        return $this;
    }

    /**
     * Set the type of document to search for.
     *
     * @param string $type
     *
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Calculates the result offset from a given page and page size
     *
     * @param $limit
     * @param $page
     *
     * @return mixed
     */
    private function calcOffset($limit, $page)
    {
        return ($page - 1) * $limit;
    }
}
