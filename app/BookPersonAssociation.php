<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer page
 * @property integer page_to
 * @property string description
 * @property integer line
 */
class BookPersonAssociation extends Model {

    protected $table = 'book_person';

    protected $fillable = ['page', 'page_to', 'description', 'line'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function person()
    {
        return $this->belongsTo(Person::class);
    }
}
