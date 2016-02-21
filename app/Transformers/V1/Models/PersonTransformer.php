<?php

namespace App\Transformers\V1\Models;

use App\Transformers\AbstractTransformer;

class PersonTransformer extends AbstractTransformer {

    /**
     * Transforms a single item into a new one
     *
     * @param \App\Person $item
     * @return mixed
     */
    public function transform($item)
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
}