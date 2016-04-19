<?php

namespace App\Import\Books\Converter;

use App\Import\Converter\DBFRecordConverter;
use Grimm\Book;

class BookConverter
{
    use DBFRecordConverter;

    protected function setupEntity()
    {
        $b = new Book();
        $b->save();

        return $b;
    }
}
