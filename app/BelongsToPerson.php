<?php

namespace App;

/**
 * Class BelongsToPerson
 * @package App
 *
 * @property Person person
 */
trait BelongsToPerson {

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function person() {
        return $this->belongsTo(Person::class);
    }

}