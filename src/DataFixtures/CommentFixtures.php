<?php

namespace App\DataFixtures;

use App\Entity\Comment;

use App\Entity\Tricks;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager): void
    {

        for ($k=1; $k < 10; $k++) {
            $comment = new Comment();
            $comment->setMessage(substr(str_shuffle(str_repeat("#abcdefghilkmnopqrstuvwxyz", 5)), 0, 7));
            $comment->setCreatedAt(new DateTimeImmutable());
            $comment->setTricks($this->getReference('trick'));
            $comment->setUser($this->getReference('user2'));
            $manager->persist($comment);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return array(
            TrickFixtures::class,
            UserFixtures::class,
        );
    }
}
