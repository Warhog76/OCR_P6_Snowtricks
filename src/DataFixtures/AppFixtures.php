<?php

namespace App\DataFixtures;

use App\Entity\User;
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
        $user = new User();
        $user->setUsername('warhog76');
        $user->setEmail('warhog76@free.fr');
        $user->setRoles(array('ROLE_USER'));
        $password = $this->hasher->hashPassword($user, 'Admin1234');
        $user->setPassword($password);
        $manager->persist($user);
        $manager->flush();


        $category = new Category();
        $category->setName('Grab');
        $manager->persist($category);

        $category2 = new Category();
        $category2->setName('Rotation');
        $manager->persist($category2);

        $category3 = new Category();
        $category3->setName('Flip');
        $manager->persist($category3);

        $category4 = new Category();
        $category4->setName('Slide');
        $manager->persist($category4);

        $manager->flush();

        /*
        for ($i=1; $i <= 10 ; $i++)
        {

            $trick = new Tricks();
            $trick->setName("trick " . $i);
            $trick->setDescription("Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression.");
            $trick->setCreatedAt(new DateTimeImmutable());
            $trick->setCategory($category);
            $trick->setUser($user);

            $trick->setImage($image);

            for ($k=0; $k < 5; $k++) {
                $comment = new comment();
                $comment->setMessage(substr(str_shuffle(str_repeat("#abcdefghilkmnopqrstuvwxyz", 5)), 0, 7));
                $comment->setCreatedAt(new DateTimeImmutable());
                $comment->setTricks($trick);
                $comment->setUser($user);
                $manager->persist($comment);
            }

            $manager->persist($trick);
        }
        $manager->flush();*/
    }
}
