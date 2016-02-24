<?php

namespace App\Http\Controllers\ApiV1\Open;

use App\Http\Controllers\ApiV1\ApiController;
use App\Http\Requests;
use App\Person;
use App\Transformers\V1\Models\PersonTransformer;
use Illuminate\Http\Request;

class PersonsController extends ApiController {

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

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /** @var Person $person */
        $person = Person::query()->with('information', 'prints', 'inheritances', 'bookAssociations')->find($id);

        if (!$person) {
            return $this->responseNotFound();
        }

        return $this->responseWithTransformer($person, new PersonTransformer, ['information', 'prints', 'inheritances', 'bookAssociations']);
    }
}
