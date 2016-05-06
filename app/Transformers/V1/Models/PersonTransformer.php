<?php

namespace App\Transformers\V1\Models;
 
use League\Fractal\TransformerAbstract;

class PersonTransformer extends TransformerAbstract
{

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'information',
        'prints',
        'inheritances',
        'bookAssociations',
    ];

    /**
     * Transforms a single item into a new one
     *
     * @param $item
     *
     * @return mixed
     */
    public function transform($item)
    {
        if (array_key_exists('_source', $item)) {
            $item = $item['_source'];
        }

        return [
            'links' => [
                'self' => route('v1.persons.show', ['id' => $item['id']]),
            ],
            'id' => (int)$item['id'],
            'last_name' => $item['last_name'],
            'first_name' => $item['first_name'],
            'birth_date' => $item['birth_date'],
            'death_date' => $item['death_date'],
            'bio_data' => $item['bio_data'],
            'bio_data_source' => $item['bio_data_source'],
            'add_bio_data' => $item['add_bio_data'],
            'is_organization' => (bool)$item['is_organization'],
            'auto_generated' => (bool)$item['auto_generated'],
            'source' => $item['source'],
        ];
    }

    /**
     * Include person association
     *
     * @param $person
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeInformation($item)
    {
        if (array_key_exists('_source', $item)) {
            $item = $item['_source'];
        }
        /*if (!array_key_exists('information')) {
            return;
        }*/
        return $this->collection($item['information'], new PersonInformationTransformer);
    }

    /**
     * Include person association
     *
     * @param $item
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includePrints($item)
    {
        if (array_key_exists('_source', $item)) {
            $item = $item['_source'];
        }
        return $this->collection($item['prints'], new PersonPrintTransformer);
    }

    /**
     * Include person association
     *
     * @param $item
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeInheritances($item)
    {
        if (array_key_exists('_source', $item)) {
            $item = $item['_source'];
        }
        return $this->collection($item['inheritances'], new PersonInheritanceTransformer);
    }

    /**
     * Include person association
     *
     * @param $item
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeBookAssociations($item)
    {
        if (array_key_exists('_source', $item)) {
            $item = $item['_source'];
        }
        return $this->collection($item['bookAssociations'], new BookPersonAssociationTransformer);
    }
}
