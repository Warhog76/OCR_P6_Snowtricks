<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user1 = new User();
        $user1->setUsername('user1');
        $user1->setEmail('user1@test.com');
        $user1->setRoles(array('ROLE_USER'));
        $password = $this->hasher->hashPassword($user1, 'User1');
        $user1->setPassword($password);
        $manager->persist($user1);

        $user2 = new User();
        $user2->setUsername('user2');
        $user2->setEmail('user2@test.com');
        $user2->setRoles(array('ROLE_USER'));
        $password = $this->hasher->hashPassword($user2, 'User2');
        $user2->setPassword($password);
        $manager->persist($user2);

        $user3 = new User();
        $user3->setUsername('user3');
        $user3->setEmail('user3@test.com');
        $user3->setRoles(array('ROLE_USER'));
        $password = $this->hasher->hashPassword($user3, 'User3');
        $user3->setPassword($password);
        $manager->persist($user3);

        $user4 = new User();
        $user4->setUsername('user4');
        $user4->setEmail('user4@test.com');
        $user4->setRoles(array('ROLE_USER'));
        $password = $this->hasher->hashPassword($user1, 'User4');
        $user4->setPassword($password);
        $manager->persist($user4);

        $manager->flush();

        //Reference
        $this->addReference('user1', $user1);
        $this->addReference('user2', $user2);
        $this->addReference('user3', $user3);
        $this->addReference('user4', $user4);
    }
}
