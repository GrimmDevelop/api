<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class PersonSearch
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
        return $this->elasticsearch->find($id, 'person');
    }

    public function paginate($limit, Request $request)
    {
        $page = $request->get('page', '1');

        $books = $this->getPage($limit, $page);

        $count = $this->count();

        return new LengthAwarePaginator($books, $count, $limit, $page, ['path' => route('v1.persons.index')]);
    }

    /**
     * @return int
     */
    public function count()
    {
        return $this->elasticsearch->count('person');
    }

    public function byName($name/*, $limit, $page, $path*/)
    {
        // TODO: currently broken and only searching last name!
        return $this->elasticsearch->search([
            'query' => [
                'bool' => [

                    'should' => [
                        'match' => ['last_name' => $name],
                        //'match' => ['first_name' => $name],
                        //'first_name' => $name
                    ],
                ],
            ],
        ], 'person');
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
        ], 'person', 'grimm', $limit, $page)['hits']['hits'];
    }
}
