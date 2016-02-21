<?php

namespace App\Transformers;

abstract class AbstractTransformer implements TransformerInterface {

    /**
     * @inheritdoc
     */
    public function transformCollection(array $items)
    {
        return array_map([$this, 'transform'], $items);
    }
}