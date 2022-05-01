<?php

namespace App\DataPersister;

use App\Entity\Stories;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;

class StoriesPersister implements DataPersisterInterface {
    
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {

        $this->entityManager = $entityManager;

    }

    /**
     * Is the data supported by the persister?
     *
     * @param mixed $data
     */
    public function supports($data): bool
    {
        return $data instanceof Stories;
    }

    /**
     * Persists the data.
     *
     * @param mixed $data
     *
     * @return object|void Void will not be supported in API Platform 3, an object should always be returned
     */
    public function persist($data)
    {
        // 1. Date de création de l'histoire

        $story->setLiked(0);
        $story->setDisliked(0);
        $story->setCreatedAt(new \DateTimeImmutable("NOW"));
        $story->setUser($user);

        // 2. Demander à Doctrine de persister
        $this->entityManager->persist($data);
        $this->entityManager->flush();

    }

    /**
     * Removes the data.
     *
     * @param mixed $data
     */
    public function remove($data)
    {
        // 1. Demande à doctrine de supprimer l'article
    }
    
}