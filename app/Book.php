<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer id
 * @property string title
 * @property string short_title
 * @property integer volume
 * @property integer volume_irregular
 * @property string edition
 * @property integer year
 * @property BookPersonAssociation[] personAssociations
 */
class Book extends Model {

    use SoftDeletes;

    protected $table = 'books';

    protected $fillable = [
        'title', 'short_title',
        'volume', 'volume_irregular',
        'edition', 'year',
    ];

    public function addPersonOccurrence(Person $person, $page = null, $pageTo = null, $description = null, $line = null)
    {
        $bookPersonAssociation = new BookPersonAssociation();

        $bookPersonAssociation->page = $page;
        $bookPersonAssociation->page_to = $pageTo;
        $bookPersonAssociation->description = $description;
        $bookPersonAssociation->line = $line;

        $bookPersonAssociation->book()->associate($this);
        $bookPersonAssociation->person()->associate($person);

        $bookPersonAssociation->save();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function personAssociations()
    {
        return $this->hasMany(BookPersonAssociation::class);
    }
}
