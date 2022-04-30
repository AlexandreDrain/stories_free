<?php

namespace App\DataFixtures;

use App\Entity\Users;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class UsersFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // create 20 Users! Bam!
        for ($i = 0; $i < 20; $i++) {
            $user = new Users();
            $user->setPseudo('user-'.$i);
            $user->setEmail($user->getPseudo()."@gmail.com");
            $manager->persist($user);
        }

        $manager->flush();
    }
}
