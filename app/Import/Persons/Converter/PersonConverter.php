<?php

namespace App\Import\Persons\Converter;


use App\Import\Converter\DBFRecordConverter;
use Grimm\Person;

class PersonConverter {
    use DBFRecordConverter;

    protected function setupEntity()
    {
        $p = new Person();
        $p->save();

        return $p;
    }
}