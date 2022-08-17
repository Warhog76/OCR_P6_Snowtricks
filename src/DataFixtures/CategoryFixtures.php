<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {

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

    }
}
