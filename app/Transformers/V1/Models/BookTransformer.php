<?php

namespace App\Transformers\V1\Models;

use App\Book;
use League\Fractal\TransformerAbstract;

class BookTransformer extends TransformerAbstract {

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'personAssociation',
    ];

    /**
     * Transforms a single item into a new one
     *
     * @param \App\Book $item
     * @return mixed
     */
    public function transform($item)
    {
        return [
            'links' => [
                'self' => route('v1.books.show', ['id' => $item->id]),
            ],
            'id' => (int) $item->id,
            'title' => $item->title,
            'short_title' => $item->short_title,
            'volume' => (int) $item->volume,
            'volume_irregular' => (int) $item->volume_irregular,
            'edition' => $item->edition,
            'year' => (int) $item->year,
        ];
    }

    /**
     * Include person association
     *
     * @param Book $book
     * @return \League\Fractal\ItemResource
     */
    public function includePersonAssociation(Book $book)
    {
        $associations = $book->personAssociations;

        return $this->item($associations, new BookPersonAssociationTransformer);
    }
}