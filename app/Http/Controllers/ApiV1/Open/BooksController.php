<?php

namespace App\Http\Controllers\ApiV1\Open;

use Grimm\Book;
use App\Http\Controllers\ApiV1\ApiController;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Transformers\V1\Models\BookTransformer;

class BooksController extends ApiController
{

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $this->limit($request->get('limit'), 100, 10);

        $books = Book::query()->paginate($limit);

        return $this->respondWithPagination($books, new BookTransformer);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /** @var Book $book */
        $book = Book::query()->with('personAssociations.person')->find($id);

        if (!$book) {
            return $this->responseNotFound();
        }

        return $this->responseWithTransformer(
            $book,
            new BookTransformer,
            ['personAssociations.person']
        );
    }
}
