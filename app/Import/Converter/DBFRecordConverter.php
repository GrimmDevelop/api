<?php

namespace App\Import\Converter;


use App\Import\Parser\FieldParser;
use XBase\Column;
use XBase\Record;

trait DBFRecordConverter
{

    protected $parsers = [];

    public function registerParser(FieldParser $parser)
    {
        foreach ($parser->handledColumns() as $fieldName) {
            $this->parsers[$fieldName] = $parser;
        }
    }

    public function preflight()
    {
        foreach ($this->parsers as $parser) {
            if (method_exists($parser, 'before')) {
                $parser->before();
            }
        }
    }

    public function convert(Record $record, $columns)
    {
        $entity = $this->setupEntity();
        foreach ($columns as $column) {
            $this->handleField($record->getObject($column), $column, $entity);
        }

        return $entity;
    }

    public function registerParsers(array $parsers)
    {
        foreach ($parsers as $parser) {
            $this->registerParser($parser);
        }

    }

    protected function utf8ify($field, Column $column)
    {
        return ($column->getType() == Record::DBFFIELD_TYPE_MEMO ||
            $column->getType() == Record::DBFFIELD_TYPE_CHAR) ?
            iconv("IBM850", "UTF-8//TRANSLIT", $field) :
            $field;
    }

    protected function handleField($field, Column $column, $entity)
    {
        $field = $this->utf8ify($field, $column);

        if (empty($field)) {
            return;
        }
        $columnName = $column->getName();

        if (array_key_exists($columnName, $this->parsers)) {
            $this->parsers[$columnName]->parse($columnName, $field, $entity);
        }
    }

}
