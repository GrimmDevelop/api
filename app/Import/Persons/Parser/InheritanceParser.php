<?php

namespace App\Import\Persons\Parser;


use Grimm\PersonInheritance;
use App\Import\Parser\FieldParser;

class InheritanceParser implements FieldParser {

    /**
     * @param $column
     * @param $field
     * @param $entity \Grimm\Person
     */
    public function parse($column, $field, $entity)
    {
        $print = new PersonInheritance();

        $print->entry = $field;

        $entity->inheritances()->save($print);
    }

    public function handledColumns()
    {
        return ['nl_1','nl_2','nl_3','nl_4','nl_5',
                'nl_6','nl_7','nl_8','nl_9','nl_10'];
    }
}