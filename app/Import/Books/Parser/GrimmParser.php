<?php

namespace App\Import\Books\Parser;

use App\Import\Parser\FieldParser;

class GrimmParser implements FieldParser
{

    public function parse($column, $field, $entity)
    {
        $entity->grimm = ($field === 'j');
        $entity->save();
    }

    public function handledColumns()
    {
        return ['grimmwerk'];
    }
}
