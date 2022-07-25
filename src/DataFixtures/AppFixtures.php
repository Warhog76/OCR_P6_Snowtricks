<?php

namespace App\DataFixtures;

use App\Entity\Account;
use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Tricks;

use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new Account();
        $user->setUsername('warhog76');

        $user->setEmail('warhog76@free.fr');

        $password = $this->hasher->hashPassword($user, 'Admin1234');
        $user->setPassword($password);

        $manager->persist($user);

        $manager->flush();

        $dateTime = new DateTimeImmutable();

        for ($i=0; $i < 10 ; $i++)
        {
            for ($ii=0; $ii < 4 ; $ii++)
            {
                $category = new Category();
                $category->setName('category'.($ii+1));

                $manager->persist($category);
            }

            $trick = new Tricks();
            $trick->setName("trick " . ($i+1));
            $trick->setDescription("Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression.");
            $trick->setCreatedAt($dateTime);
            $trick->setCategory($category);
            $trick->setAccount($user);

            /*$trick->setImage($image);*/

            for ($iii=0; $iii < 5; $iii++) {
                $comment = new comment();
                $comment->setMessage(substr(str_shuffle(str_repeat("abcdefghijklmnopqrstuvwxyz", 5)), 0, 7));
                $comment->setCreatedAt($dateTime);
                $comment->setTricks($trick);
                $comment->setAccount($user);
                $manager->persist($comment);
            }

            $manager->persist($trick);
        }
        $manager->flush();
    }
}
