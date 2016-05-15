<?php

namespace App\Transformers\V1\Models;

use League\Fractal\TransformerAbstract;

class PersonInformationTransformer extends TransformerAbstract
{

    public function transform($item)
    {
        return [
            'data' => $item['data'],
            'code' => $item['code']['name'],
            'error_generated' => $item['code']['error_generated'],
        ];
    }
}
