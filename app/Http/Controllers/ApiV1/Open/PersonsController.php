<?php

namespace App\Http\Controllers\ApiV1\Open;

use App\Http\Controllers\ApiV1\ApiController;
use App\Http\Requests;
use App\Services\Elasticsearch;
use App\Services\PersonSearch;
use Elasticsearch\Common\Exceptions\Missing404Exception;
use Grimm\Person;
use App\Transformers\V1\Models\PersonTransformer;
use Illuminate\Http\Request;

class PersonsController extends ApiController
{

    /**
     * Display a listing of the resource.
     *
     * @param Request      $request
     * @param PersonSearch $search
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, PersonSearch $search)
    {
        $limit = $this->limit($request->get('limit'), 100, 10);
        
        $paginator = $search->paginate($limit, $request);

        return $this->respondWithPagination($paginator, new PersonTransformer);
    }

    public function findByName(Request $request, PersonSearch $search)
    {
        $limit = $this->limit($request->get('limit'), 100, 10);

        dd($search->byName($request->get('name')));

        $people = Person::searchByName($request->get('name'))->paginate($limit);

        return $this->respondWithPagination($people, new PersonTransformer);
    }

    /**
     * Display the specified resource.
     *
     * @param  int         $id
     * @param PersonSearch $search
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id, PersonSearch $search)
    {
        try {
            $person = $search->find($id, 'person');
        } catch (Missing404Exception $e) {
            return $this->responseNotFound();
        }

        return $this->responseWithTransformer(
            $person,
            new PersonTransformer,
            ['information', 'prints', 'inheritances', 'bookAssociations']
        );
    }
}
