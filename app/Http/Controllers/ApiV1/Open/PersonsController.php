<?php

namespace App\Http\Controllers\ApiV1\Open;

use App\Http\Controllers\ApiV1\ApiController;
use App\Http\Requests;
use Grimm\Person;
use App\Transformers\V1\Models\PersonTransformer;
use Illuminate\Http\Request;

class PersonsController extends ApiController
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

        $people = Person::query()->paginate($limit);

        return $this->respondWithPagination($people, new PersonTransformer);
    }

    public function findByName(Request $request)
    {
        $limit = $this->limit($request->get('limit'), 100, 10);

        $people = Person::searchByName($request->get('name'))->paginate($limit);

        return $this->respondWithPagination($people, new PersonTransformer);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /** @var Person $person */
        $person = Person::query()->with([
            'information' => function($query) {
                $query->whereHas('code', function($q) {
                    $q->where('internal', false);
                });
            },
            'information.code' => function ($query) {
                $query->where('person_codes.internal', false);
            },
            'prints',
            'inheritances',
            'bookAssociations'
        ])->find($id);

        if (!$person) {
            return $this->responseNotFound();
        }

        return $this->responseWithTransformer(
            $person,
            new PersonTransformer,
            ['information', 'prints', 'inheritances', 'bookAssociations']
        );
    }
}
