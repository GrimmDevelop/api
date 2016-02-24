<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer id
 * @property string last_name
 * @property string first_name
 * @property \Carbon\Carbon birth_date
 * @property \Carbon\Carbon death_date
 * @property string bio_data
 * @property string bio_data_source
 * @property string add_bio_data
 * @property boolean is_organization
 * @property boolean auto_generated
 * @property string source
 * @property BookPersonAssociation[] bookAssociations
 */
class Person extends Model {

    use SoftDeletes;

    protected $table = 'persons';

    protected $fillable = ['id', 'last_name', 'first_name',
        'birth_date', 'death_date',
        'bio_data', 'bio_data_source', 'add_bio_data',
        'is_organization', 'auto_generated',
        'source',
    ];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at', 'birth_date', 'death_date'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function information()
    {
        return $this->hasMany(PersonInformation::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function prints()
    {
        return $this->hasMany(PersonPrint::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function inheritances()
    {
        return $this->hasMany(PersonInheritance::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bookAssociations()
    {
        return $this->hasMany(BookPersonAssociation::class);
    }
}
