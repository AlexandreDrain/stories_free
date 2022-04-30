<?php

namespace App\DataFixtures;

use App\Entity\Tags;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class TagsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // create 1 tag per value in the array
        foreach (["SF", "Classique", "Romance", "Dark-fantasy", "Fantasy", "Cuisine"] as $genre) {
            $tag = new Tags();
            $tag->setName($genre);
            $manager->persist($tag);
        }

        $manager->flush();
    }
}
