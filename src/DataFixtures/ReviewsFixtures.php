<?php

namespace App\DataFixtures;

use App\Entity\Users;
use App\Entity\Reviews;
use App\Entity\Stories;
use App\DataFixtures\StoriesFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ReviewsFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager): void
    {
        // Import des repository de Users et Stories.
        $userRepository = $manager->getRepository(Users::class);
        $storiesRepository = $manager->getRepository(Stories::class);

        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $longueurMax = strlen($caracteres);
        // create a random number of reviews depending on the fonction 'rand' return's
        for ($i = 0; $i < rand(10, 40); $i++) {
            $chaineAleatoire = '';
            // Même chose que dans 'StoriesFixtures'.
            for ($ii = 0; $ii < rand(40, 50); $ii++)
            {
                $chaineAleatoire .= $caracteres[rand(0, $longueurMax - 1)];
            }

            // Récupère une stories aléatoire avec la fonction SQL RAND
            $story = $storiesRepository->findOneRand();

            // Instanciation d'un nouvel objet reviews, puis set des différentes valeurs.
            $review = new Reviews();
            $review->setUsers($userRepository->findOneByPseudo("user-".\rand(0, 19)));
            $review->setStory($story[0]);
            $review->setDescription($chaineAleatoire);
            $review->setLiked(rand(0, 100000));
            $review->setDisliked(rand(0, 1000));
            $review->setCreatedAt(new \DateTimeImmutable("NOW"));
            $manager->persist($review);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            StoriesFixtures::class,
        ];
    }
}