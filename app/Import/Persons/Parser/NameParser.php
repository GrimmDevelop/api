<?php

namespace App\Import\Persons\Parser;


use App\Import\Parser\FieldParser;

class NameParser implements FieldParser {

    /**
     * @param $column
     * @param $field
     * @param $entity \Grimm\Person
     */
    public function parse($column, $field, $entity)
    {
        $nameParts = preg_split("/,\s*/", $field);

        if (count($nameParts) == 2) {
            $entity->first_name = $nameParts[1];
            $entity->last_name = $nameParts[0];
            $entity->is_organization = false;
        } else {
            $entity->last_name = $field;
            $entity->is_organization = true;
        }
        $entity->save();
    }

    public function handledColumns()
    {
        return ['name_2013', 'name'];
    }
}