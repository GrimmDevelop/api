<?php

namespace App\Import\Parser;

interface FieldParser
{

    public function parse($column, $field, $entity);

    public function handledColumns();
}