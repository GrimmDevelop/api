<?php

namespace App\Transformers\V1\Models;

use Grimm\PersonInheritance;
use League\Fractal\TransformerAbstract;

class PersonInheritanceTransformer extends TransformerAbstract
{

    public function transform(PersonInheritance $item)
    {
        return [
            'entry' => $item->entry,
        ];
    }
}