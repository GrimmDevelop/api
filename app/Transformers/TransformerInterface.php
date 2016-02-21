<?php

namespace App\Transformers;

interface TransformerInterface {

    /**
     * Transforms a single item into a new one
     *
     * @param $item
     * @return mixed
     */
    public function transform($item);

    /**
     * Transforms an collection of items into a collection of new ones
     *
     * @param array $items
     * @return mixed
     */
    public function transformCollection(array $items);

}
