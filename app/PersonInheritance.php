<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonInheritance extends Model {

    use BelongsToPerson;

    protected $table = 'person_inheritances';
}
