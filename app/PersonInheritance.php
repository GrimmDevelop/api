<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string entry
 */
class PersonInheritance extends Model {

    use BelongsToPerson;

    protected $table = 'person_inheritances';
}
