<?php

namespace App\DataFixtures;

use App\Entity\Tags;
use App\Entity\Users;
use App\Entity\Stories;
use App\DataFixtures\TagsFixtures;
use App\DataFixtures\UsersFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class StoriesFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager): void
    {
        // Import des repository de Users et Tags.
        $userRepository = $manager->getRepository(Users::class);
        $tagsRepository = $manager->getRepository(Tags::class);

        // Chaîne de caractère contenant toutes les lettres de l'alphabet en minuscule et majuscule ainsi que les chiffres.
        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $longueurMax = strlen($caracteres);
        // create a random number of stories depending on the fonction 'rand' return's
        for ($i = 0; $i < rand(20, 40); $i++) {

            $chaineAleatoire = '';
            // méthode trouvée sur stackoverflow.
            for ($ii = 0; $ii < rand(8, 12); $ii++)
            {
                // Concatene x fois une valeur aléatoire récupérée dans la chaîne de caractère '$caracteres' afin d'obtenir un titre différent pour chacun de mes articles.
                $chaineAleatoire .= $caracteres[rand(0, $longueurMax - 1)];
            }
            
            // Chaîne de caractère contenant du lorem ipsum, que je vais concatener x fois selon le retour de la valeur 'rand',
            // afin de me créer une description différente plus ou moins différente pour mes stories.
            $lorem = "
                    Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                    Enim quos at culpa nemo, voluptatibus maiores ad ea maxime amet provident sed
                    sunt velit labore recusandae commodi distinctio in nulla voluptas.
                "
            ;
            for ($l = 0; $l < rand(1, 4); $l++) {
                $lorem .= $lorem;
            }

            // Instanciation d'un nouvel objet Stories, puis set des différentes valeurs.
            $story = new Stories();
            $story->setUser($userRepository->findOneByPseudo("user-".\rand(0, 19)));
            $story->addTag($tagsRepository->findOneByName(array_rand(array_flip(["SF", "Classique", "Romance", "Dark-fantasy", "Fantasy", "Cuisine"]), 1)));
            $story->setTitle($chaineAleatoire);
            $story->setDescription($lorem);
            $story->setLiked(rand(0, 100000));
            $story->setDisliked(rand(0, 1000));
            $story->setCreatedAt(new \DateTimeImmutable("NOW"));
            $manager->persist($story);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UsersFixtures::class,
            TagsFixtures::class,
        ];
    }
}