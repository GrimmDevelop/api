<?php

namespace App\Http\Controllers\ApiV1\Open;

use App\Services\BookSearch;
use Elasticsearch\Common\Exceptions\Missing404Exception;
use App\Http\Controllers\ApiV1\ApiController;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Transformers\V1\Models\BookTransformer;

class BooksController extends ApiController
{

    /**
     * Display a listing of the resource.
     *
     * @param Request    $request
     * @param BookSearch $search
     *
     * @return \Illuminate\Http\Response
     *
     */
    public function index(Request $request, BookSearch $search)
    {
        $limit = $this->limit($request->get('limit'), 100, 10);

        $paginator = $search->paginate($limit, $request);

        return $this->respondWithPagination($paginator, new BookTransformer);
    }

    /**
     * Display the specified resource.
     *
     * @param  int       $id
     * @param BookSearch $search
     *
     * @return \Illuminate\Http\Response
     *
     */
    public function show($id, BookSearch $search)
    {

        try {
            $book = $search->find($id);
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
