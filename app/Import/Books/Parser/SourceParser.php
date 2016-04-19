<?php

namespace App\Import\Books\Parser;

use App\Import\Parser\FieldParser;

class SourceParser implements FieldParser
{

    public function parse($column, $field, $entity)
    {
        $entity->source = $field;
        $entity->save();
    }

    public function handledColumns()
    {
        return ['herkunft'];
    }
}
