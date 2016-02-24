<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonInformation extends Model {

    use BelongsToPerson;

    protected $table = 'person_information';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function code()
    {
        return $this->belongsTo(PersonCode::class);
    }
}
