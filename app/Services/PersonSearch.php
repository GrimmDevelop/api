<?php

namespace App\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

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

    public function paginate($limit)
    {
        $page = Paginator::resolveCurrentPage('page');

        list($books, $count) = $this->getPage($limit, $page);

        return new LengthAwarePaginator($books, $count, $limit, $page, ['path' => Paginator::resolveCurrentPath()]);
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
        $result = $this->elasticsearch->search([
            'sort' => [
                ['id' => ['order' => 'asc']],
            ],
        ], 'person', 'grimm', $limit, $page);

        return [$result['hits']['hits'], $result['hits']['total']];
    }
}
