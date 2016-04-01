<?php

namespace App\Import\Persons\Persistence;


interface PersonRepository {
    public function persistPersonCollection(array $persons);
}