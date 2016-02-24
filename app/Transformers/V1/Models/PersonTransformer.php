<?php

namespace App\Transformers\V1\Models;

use Grimm\Person;
use League\Fractal\TransformerAbstract;

class PersonTransformer extends TransformerAbstract {

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'information', 'prints', 'inheritances', 'bookAssociations',
    ];

    /**
     * Transforms a single item into a new one
     *
     * @param \Grimm\Person $item
     * @return mixed
     */
    public function transform(Person $item)
    {
        return [
            'links' => [
                'self' => route('v1.persons.show', ['id' => $item->id]),
            ],
            'id' => (int) $item->id,
            'last_name' => $item->last_name,
            'first_name' => $item->first_name,
            'birth_date' => $item->birth_date->format('Y-m-d'),
            'death_date' => $item->death_date->format('Y-m-d'),
            'bio_data' => $item->bio_data,
            'bio_data_source' => $item->bio_data_source,
            'add_bio_data' => $item->add_bio_data,
            'is_organization' => (bool) $item->is_organization,
            'auto_generated' => (bool) $item->auto_generated,
            'source' => $item->source,
        ];
    }

    /**
     * Include person association
     *
     * @param \Grimm\Person $person
     * @return \League\Fractal\Resource\Collection
     */
    public function includeInformation(Person $person)
    {
        return $this->collection($person->information, new PersonInformationTransformer);
    }

    /**
     * Include person association
     *
     * @param \Grimm\Person $person
     * @return \League\Fractal\Resource\Collection
     */
    public function includePrints(Person $person)
    {
        return $this->collection($person->prints, new PersonPrintTransformer);
    }

    /**
     * Include person association
     *
     * @param \Grimm\Person $person
     * @return \League\Fractal\Resource\Collection
     */
    public function includeInheritances(Person $person)
    {
        return $this->collection($person->inheritances, new PersonInheritanceTransformer);
    }

    /**
     * Include person association
     *
     * @param \Grimm\Person $person
     * @return \League\Fractal\Resource\Collection
     */
    public function includeBookAssociations(Person $person)
    {
        return $this->collection($person->bookAssociations, new BookPersonAssociationTransformer);
    }
}