<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string entry
 * @property float year
 */
class PersonPrint extends Model {

    use BelongsToPerson;

    protected $table = 'person_prints';
}
