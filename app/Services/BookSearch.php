<?php

namespace App\Services;

class BookSearch
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
        $this->elasticsearch->setType('book');
    }

    /**
     * @param int $id
     *
     * @return mixed
     */
    public function find(int $id)
    {
        return $this->elasticsearch->find($id);
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
        return $this->elasticsearch->count();
    }
}
