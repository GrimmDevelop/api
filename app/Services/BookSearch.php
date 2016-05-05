<?php

namespace App\Services;

use Cviebrock\LaravelElasticsearch\Manager;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class BookSearch
{

    /**
     * BookSearch constructor.
     *
     * @param Manager $elasticsearch
     */
    public function __construct(Manager $elasticsearch)
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
        $params = [
            'index' => 'grimm',
            'type' => 'book',
            'id' => $id,
        ];

        return $book = $this->elasticsearch->get($params);
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
        $params = [
            'index' => 'grimm',
            'type' => 'book',
        ];

        return $this->elasticsearch->count($params)['count'];
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
        $from = ($page - 1) * $limit;

        $params = [
            'index' => 'grimm',
            'type' => 'book',
            'size' => $limit,
            'from' => $from,
            'body' => [
                'sort' => [
                    ['id' => ['order' => 'asc']],
                ],
            ],
        ];

        $books = $this->elasticsearch->search($params)['hits']['hits'];

        return $books;
    }
}
