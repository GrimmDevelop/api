<?php

namespace App\Http\Controllers\ApiV1\Open;

use App\Services\BookSearch;
use Elasticsearch\Common\Exceptions\Missing404Exception;
use App\Http\Controllers\ApiV1\ApiController;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Transformers\V1\Models\BookTransformer;
use League\Fractal\Manager;

class BooksController extends ApiController
{

    /**
     * @var BookSearch
     */
    protected $search;

    public function __construct(Manager $manager, BookSearch $bookSearch)
    {
        parent::__construct($manager);
        $this->search = $bookSearch;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request    $request
     *
     * @return \Illuminate\Http\Response
     *
     */
    public function index(Request $request)
    {
        $limit = $this->limit($request->get('limit'), 100, 10);

        $paginator = $this->search->paginate($limit, $request);

        return $this->respondWithPagination($paginator, new BookTransformer);
    }

    /**
     * Display the specified resource.
     *
     * @param  int       $id
     *
     * @return \Illuminate\Http\Response
     *
     */
    public function show($id)
    {

        try {
            $book = $this->search->find($id);
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
