<?php

namespace App\Import\Books\Parser;

use App\Import\Parser\FieldParser;

class TitleParser implements FieldParser
{
    protected $titleCache = [];

    public function parse($column, $field, $entity)
    {
        switch ($column) {
            case 'sigle':
                $this->setSigle($field, $entity);
                break;
            default:
                $this->setTitle($column, $field, $entity);
                break;
        }

        $entity->save();
    }

    public function handledColumns()
    {
        return ['sigle', 'volltitel', 'volltitel2', 'volltitel3', 'volltitel4'];
    }

    protected function setSigle($field, $entity)
    {
        $entity->short_title = $field;
    }

    protected function setTitle($column, $field, $entity)
    {
        if ($column === 'volltitel') {
            $entity->title = $field;
        } else {
            if ($column === 'volltitel2') {
                $entity->notes = $entity->title;
                $entity->title = substr($entity->title, 0, 250) . '[...]';
            }

            $entity->notes .= ' ' . $field;
        }
    }
}
