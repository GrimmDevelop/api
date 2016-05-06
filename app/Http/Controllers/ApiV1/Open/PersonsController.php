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
use League\Fractal\Manager;

class PersonsController extends ApiController
{

    /**
     * @var PersonSearch
     */
    protected $search;

    /**
     * PersonsController constructor.
     *
     * @param Manager      $manager
     * @param PersonSearch $search
     */
    public function __construct(Manager $manager, PersonSearch $search)
    {
        parent::__construct($manager);

        $this->search = $search;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request      $request
     * @param PersonSearch $search
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $this->limit($request->get('limit'), 100, 10);

        $paginator = $this->search->paginate($limit, $request);

        return $this->respondWithPagination($paginator, new PersonTransformer);
    }

    public function findByName(Request $request)
    {
        $limit = $this->limit($request->get('limit'), 100, 10);

        $people = $this->search->byName($request->get('name'), $limit);

        return $this->respondWithPagination($people, new PersonTransformer);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     *
     */
    public function show($id)
    {
        try {
            $person = $this->search->find($id);
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
