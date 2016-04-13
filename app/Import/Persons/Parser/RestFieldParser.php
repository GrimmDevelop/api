<?php

namespace App\Import\Persons\Parser;


use Grimm\PersonCode;
use Grimm\PersonInformation;
use App\Import\Parser\FieldParser;

class RestFieldParser implements FieldParser {

    protected $codes = [];

    public function before()
    {
        if (count($this->codes) === 0) {
            $this->populateCodes();
        }
    }

    /**
     * @param $column
     * @param $field
     * @param $entity \Grimm\Person
     */
    public function parse($column, $field, $entity)
    {
        $letterInfo = new PersonInformation();
        $letterInfo->data = $field;
        $letterInfo->code()->associate($this->codes[$column]);
        $entity->information()->save($letterInfo);
    }

    public function handledColumns()
    {
        return ['name_alt', 'wann_gepr', 'freigabe', 'nichtverz', 'asu_j_n', 'asu_grund'];
    }

    private function populateCodes()
    {
        foreach ($this->handledColumns() as $code) {
            $letterCode = new PersonCode();
            $letterCode->name = $code;
            $letterCode->error_generated = true;
            $letterCode->internal = true;
            $letterCode->save();
            $this->codes[$code] = $letterCode;
        }
    }
}
