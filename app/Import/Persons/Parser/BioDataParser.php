<?php

namespace App\Import\Persons\Parser;


use App\Import\Parser\FieldParser;

class BioDataParser implements FieldParser {

    /**
     * @param $column
     * @param $field
     * @param $entity \Grimm\Person
     */
    public function parse($column, $field, $entity)
    {
        switch ($column) {
            case 'standard':
                $entity->bio_data = $field;
                //$entity->setBioData($field);
                break;
            case 'nichtstand':
                $entity->add_bio_data = $field;
                //$entity->setAdditionalBioData($field);
                break;
            case 'q_standard':
                $entity->bio_data_source = $field;
                //$entity->setBioDataSource($field);
                break;
            case 'herkunft':
                $entity->source = $field;
                //$entity->setSource($field);
                break;
        }

        $entity->save();
    }

    public function handledColumns()
    {
        return ['standard', 'nichtstand', 'q_standard', 'herkunft'];
    }
}