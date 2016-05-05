<?php

namespace App\Http\Controllers\ApiV1\Open;

use Cviebrock\LaravelElasticsearch\Manager;
use Elasticsearch\Common\Exceptions\Missing404Exception;
use Grimm\Book;
use App\Http\Controllers\ApiV1\ApiController;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Transformers\V1\Models\BookTransformer;
use Illuminate\Pagination\LengthAwarePaginator;

class BooksController extends ApiController
{

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param Manager $elasticsearch
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Manager $elasticsearch)
    {
        $limit = $this->limit($request->get('limit'), 100, 10);

        $page = $request->get('page', '1');

        $from = ($page-1) * $limit;

        $params = [
            'index' => 'grimm',
            'type' => 'book',
            'size' => $limit,
            'from' => $from,
            'body' => [
                'sort' => [
                    ['id' => ['order' => 'asc']]
                ]
            ]
        ];

        $books = $elasticsearch->search($params)['hits']['hits'];

        $params = [
            'index' => 'grimm',
            'type' => 'book'
        ];

        $count = $elasticsearch->count($params)['count'];

        $paginator = new LengthAwarePaginator($books, $count, $limit, $page, ['path' => route('v1.books.index')]);

        return $this->respondWithPagination($paginator, new BookTransformer);
    }

    /**
     * Display the specified resource.
     *
     * @param  int    $id
     * @param Manager $elasticsearch
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id, Manager $elasticsearch)
    {
        $params = [
            'index' => 'grimm',
            'type' => 'book',
            'id' => $id
        ];
        try {
            $book = $elasticsearch->get($params);
        } catch (Missing404Exception $exception) {
            return $this->responseNotFound();
        }

        return $this->responseWithTransformer(
            $book,
            new BookTransformer,
            []
        );
    }
}
