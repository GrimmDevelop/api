<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property PersonCode code
 * @property string data
 */
class PersonInformation extends Model {

    use BelongsToPerson;

    protected $table = 'person_information';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function code()
    {
        return $this->belongsTo(PersonCode::class, 'person_code_id');
    }
}
