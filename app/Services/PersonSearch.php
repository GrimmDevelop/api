<?php

namespace App\Services;

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
        $this->elasticsearch->setType('person');
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
        return $this->elasticsearch->orderBy('id', 'asc')->paginate($limit);
    }

    /**
     * @return int
     */
    public function count()
    {
        return $this->elasticsearch->count('person');
    }

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

        return $result;
    }
}
