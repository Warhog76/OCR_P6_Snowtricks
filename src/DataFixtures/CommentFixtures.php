<?php

namespace App\DataFixtures;

use App\Entity\Comment;

use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CommentFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {

        for ($k=0; $k < 5; $k++) {
            $comment = new Comment();
            $comment->setMessage(substr(str_shuffle(str_repeat("#abcdefghilkmnopqrstuvwxyz", 5)), 0, 7));
            $comment->setCreatedAt(new DateTimeImmutable());
            $comment->setTricks(random_int(1, 10));
            $comment->setUser(random_int(1, 4));
            $manager->persist($comment);
        }

        $manager->flush();
    }
}