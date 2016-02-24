<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonPrint extends Model {

    use BelongsToPerson;

    protected $table = 'person_prints';
}
