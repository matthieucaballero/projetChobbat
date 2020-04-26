<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('projetchobbat@gmail.com');
        $user->setRoles(['ROLE_ADMIN']);
        //$user->setPassword($this->encoder->encodePassword($user, 'demo'));
        $user->setPassword('$2y$12$8wCzxTgfuws6mGVmVTUtzeGda4loMzF6rK1Hf95HIpEE59WD4kahG');
        $manager->persist($user);
        $manager->flush();
    }
}
