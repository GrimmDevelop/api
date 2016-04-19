<?php

namespace App\Import\Books\Parser;

use App\Import\Parser\FieldParser;

class YearParser implements FieldParser
{

    public function parse($column, $field, $entity)
    {
        $entity->year = $field;
        $entity->save();
    }

    public function handledColumns()
    {
        return ['jahr'];
    }
}
