<?php

namespace App\Transformers\V1\Models;

use Grimm\Book;
use League\Fractal\TransformerAbstract;

class BookTransformer extends TransformerAbstract
{

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'personAssociations',
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
                'self' => route('v1.books.show', ['id' => $item['id']]),
            ],
            'id' => (int)$item['id'],
            'title' => $item['title'],
            'short_title' => $item['short_title'],
            'volume' => $item['volume'],
            'volume_irregular' => $item['volume_irregular'],
            'edition' => $item['edition'],
            // 'year' => (int)$item->year,
            'grimmwerk' => $item['grimmwerk'],
            'notes' => $item['notes'],
        ];
    }

    /**
     * Include person association
     *
     * @param $book
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includePersonAssociations($book)
    {
        return $this->collection($book['personAssociations'], new BookPersonAssociationTransformer);
    }
}
