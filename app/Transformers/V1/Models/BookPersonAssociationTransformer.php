<?php

namespace App\Transformers\V1\Models;

use Grimm\BookPersonAssociation;
use League\Fractal\TransformerAbstract;

class BookPersonAssociationTransformer extends TransformerAbstract
{

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'book',
        'person',
    ];

    /**
     * Transforms a single item into a new one
     *
     * @param BookPersonAssociation $item
     * @return mixed
     */
    public function transform(BookPersonAssociation $item)
    {
        return [
            'book_id' => (int)$item->book_id,
            'person_id' => (int)$item->person_id,
            'page' => (int)$item->page,
            'page_to' => (int)$item->page_to,
            'page_description' => $item->page_description,
            'line' => (int)$item->line,
        ];
    }

    /**
     * Include book
     *
     * @param BookPersonAssociation $association
     * @return \League\Fractal\Resource\Item
     */
    public function includeBook(BookPersonAssociation $association)
    {
        return $this->item($association->book, new BookTransformer);
    }

    /**
     * Include person
     *
     * @param BookPersonAssociation $association
     * @return \League\Fractal\Resource\Item
     */
    public function includePerson(BookPersonAssociation $association)
    {
        return $this->item($association->person, new PersonTransformer);
    }
}