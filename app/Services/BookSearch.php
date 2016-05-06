<?php

namespace App\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class BookSearch
{

    /**
     * @var Elasticsearch
     */
    protected $elasticsearch;

    /**
     * BookSearch constructor.
     *
     * @param Elasticsearch $elasticsearch
     */
    public function __construct(Elasticsearch $elasticsearch)
    {
        $this->elasticsearch = $elasticsearch;
    }

    /**
     * @param int $id
     *
     * @return mixed
     */
    public function find(int $id)
    {
        return $this->elasticsearch->find($id, 'book');
    }

    public function paginate($limit)
    {
        $page = Paginator::resolveCurrentPage('page');

        list($books, $count) = $this->getPage($limit, $page);

        return new LengthAwarePaginator($books, $count, $limit, $page, ['path' => Paginator::resolveCurrentPath()]);
    }

    /**
     * @return int
     */
    public function count()
    {
        return $this->elasticsearch->count('book');
    }

    /**
     * @param $limit
     * @param $page
     *
     * @return mixed
     *
     */
    protected function getPage($limit, $page)
    {
        $result = $this->elasticsearch->search('book', [
            'sort' => [
                ['id' => ['order' => 'asc']],
            ],
        ], $limit, $page);

        return [$result['hits']['hits'], $result['hits']['total']];
    }
}
