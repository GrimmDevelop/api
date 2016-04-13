<?php

namespace App\Import\Persons\Parser;

use App\Import\Parser\FieldParser;
use App\Import\Persons\BioDataExtractor;

class BioDataParser implements FieldParser
{

    /**
     * @var BioDataExtractor
     */
    private $bioDataExtractor;

    public function __construct(BioDataExtractor $bioDataExtractor)
    {
        $this->bioDataExtractor = $bioDataExtractor;
    }

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
                $this->bioDataExtractor->extract($entity->bio_data);
                $entity->birth_date = $this->bioDataExtractor->getBirthDate();
                $entity->death_date = $this->bioDataExtractor->getDeathDate();
                break;
            case 'nichtstand':
                $entity->add_bio_data = $field;
                break;
            case 'q_standard':
                $entity->bio_data_source = $field;
                break;
            case 'herkunft':
                $entity->source = $field;
                break;
        }

        $entity->save();
    }

    public function handledColumns()
    {
        return ['standard', 'nichtstand', 'q_standard', 'herkunft'];
    }
}
