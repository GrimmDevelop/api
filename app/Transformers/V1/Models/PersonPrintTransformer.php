<?php

namespace App\Transformers\V1\Models;

use League\Fractal\TransformerAbstract;

class PersonPrintTransformer extends TransformerAbstract {

    public function transform($item)
    {
        $data = [
            'entry' => $item['entry'],
        ];

        if ($item['year'] !== null) {
            $data['year'] = floor($item['year']);
        }

        return $data;
    }
}
