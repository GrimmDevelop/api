<?php

namespace App\Transformers\V1\Models;

use League\Fractal\TransformerAbstract;

class PersonInheritanceTransformer extends TransformerAbstract
{

    public function transform($item)
    {
        return [
            'entry' => $item['entry'],
        ];
    }
}
