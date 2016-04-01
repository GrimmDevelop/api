<?php

namespace App\Import\Persons\Parser;


use Grimm\PersonPrint;
use App\Import\Parser\FieldParser;

class PersonPrintParser implements FieldParser {

    /**
     * @param $column
     * @param $field
     * @param $entity \Grimm\Person
     */
    public function parse($column, $field, $entity)
    {
        $print = new PersonPrint();

        $print->entry = $field;
        $entity->prints()->save($print);

    }

    public function handledColumns()
    {
        return ['druck_1','druck_2','druck_3','druck_4','druck_5','druck_6','druck_7',
            'druck_8','druck_9','druck_10','druck_11','druck_12','druck_13','druck_14'];
    }
}