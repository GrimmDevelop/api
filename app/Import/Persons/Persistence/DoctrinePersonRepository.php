<?php

namespace App\Import\Persons\Persistence;


use Doctrine\ORM\EntityManager;

class DoctrinePersonRepository implements PersonRepository {


    /**
     * @var EntityManager
     */
    private $entityManager;

    function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function persistPersonCollection(array $persons)
    {
        foreach ($persons as $person) {
            $this->entityManager->persist($person);
        }

        $this->entityManager->flush();
    }
}