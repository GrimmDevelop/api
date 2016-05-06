<?php

namespace App\Services;

use Cviebrock\LaravelElasticsearch\Manager;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

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

    public function paginate($limit, Request $request)
    {
        $page = $request->get('page', '1');

        $books = $this->getPage($limit, $page);

        $count = $this->count();

        return new LengthAwarePaginator($books, $count, $limit, $page, ['path' => route('v1.books.index')]);
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
        return $this->elasticsearch->search([
            'sort' => [
                ['id' => ['order' => 'asc']],
            ],
        ], 'book', 'grimm', $limit, $page)['hits']['hits'];
    }
}
