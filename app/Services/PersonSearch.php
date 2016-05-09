<?php

namespace App\Services;

class PersonSearch
{

    /**
     * @var Elasticsearch
     */
    protected $elasticsearch;

    /**
     * PersonSearch constructor.
     *
     * @param Elasticsearch $elasticsearch
     */
    public function __construct(Elasticsearch $elasticsearch)
    {
        $this->elasticsearch = $elasticsearch;
        $this->elasticsearch->setType('person');
    }

    /**
     * Fetch an person document by its id.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function find(int $id)
    {
        return $this->elasticsearch->find($id);
    }

    /**
     * Fetch a page from the document index.
     *
     * @param $limit
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate($limit)
    {
        return $this->elasticsearch->orderBy('id', 'asc')->paginate($limit);
    }

    /**
     * Count all persons
     *
     * @return int
     */
    public function count()
    {
        return $this->elasticsearch->count();
    }

    /**
     * Search a person by name.
     *
     * @param $name
     * @param $limit
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function byName($name, $limit)
    {
        return $this->elasticsearch->query([
            'match' => [
                'name' => [
                    'query' => $name,
                    'operator' => 'and',
                ],
            ],
        ])->paginate($limit);
    }
}
