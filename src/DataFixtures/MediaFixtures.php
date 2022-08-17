<?php

namespace App\DataFixtures;

use App\Entity\Media;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MediaFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {

        for ($k=0; $k < 2; $k++) {
            $media = new Media();
            $media->setName(substr(str_shuffle(str_repeat("#abcdefghilkmnopqrstuvwxyz", 5)), 0, 7));
            $media->setTricks(random_int(1, 10));
            $media->setType('image');
            $manager->persist($media);
        }

        $manager->flush();
    }
}