<?php

namespace App\DataFixtures;

use App\Entity\Tricks;

use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TrickFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager): void
    {

        $trick = new Tricks();
        $trick->setName("OLLIE");
        $trick->setDescription("An Ollie is probably the first snowboard trick you’ll learn. It’s your introduction to snowboard jumps. To perform an Ollie, you should shift your body weight to your back leg.
         Jump, making sure to lead with your front leg. Lift your back leg in line with your front. The more you practice the Ollie, the higher you can jump and the more parallel you can bring your feet.");
        $trick->setCreatedAt(new DateTimeImmutable());
        $trick->setCategory($this->getReference('Category'));
        $trick->setUser($this->getReference('user1'));
        $manager->persist($trick);

        $trick2 = new Tricks();
        $trick2->setName("MELON");
        $trick2->setDescription("When you catch some snowboarding air, reach down and grab the heel side of the board between your feet. Congratulations, you’ve done your first Melon!");
        $trick2->setCreatedAt(new DateTimeImmutable());
        $trick2->setCategory($this->getReference('Category2'));
        $trick2->setUser($this->getReference('user2'));
        $manager->persist($trick2);

        $trick3 = new Tricks();
        $trick3->setName("FRONTSIDE 180");
        $trick3->setDescription("Ready to rotate your snowboard? With a frontside 180, you rotate your body so that your heels lead. For example, if you jump while riding downhill with your left foot forward, you would rotate in a counter counterclockwise motion for a frontside 180. Stop when your rear leg becomes your leading leg.");
        $trick3->setCreatedAt(new DateTimeImmutable());
        $trick3->setCategory($this->getReference('Category3'));
        $trick3->setUser($this->getReference('user3'));
        $manager->persist($trick3);

        $trick4 = new Tricks();
        $trick4->setName("BUTTER");
        $trick4->setDescription("The butter takes a little more core strength than the frontside 180 and backside 180. Instead of bringing your back leg forward during a jump, you do it while maintaining contact with the snow. The snow creates a little more friction, so prepare to put some muscle into it.");
        $trick4->setCreatedAt(new DateTimeImmutable());
        $trick4->setCategory($this->getReference('Category'));
        $trick4->setUser($this->getReference('user4'));
        $manager->persist($trick4);

        $trick5 = new Tricks();
        $trick5->setName("BACK FLIP");
        $trick5->setDescription("Take care when trying a backflip. You’ll need plenty of time and space to complete the flip before you land.");
        $trick5->setCreatedAt(new DateTimeImmutable());
        $trick5->setCategory($this->getReference('Category'));
        $trick5->setUser($this->getReference('user1'));
        $manager->persist($trick5);

        $trick6 = new Tricks();
        $trick6->setName("FRONT FLIP");
        $trick6->setDescription("The front flip is harder than the backflip because you have to resist the upward motion you get from your jump. Instead, lean forward and tuck your body to rotate forward.");
        $trick6->setCreatedAt(new DateTimeImmutable());
        $trick6->setCategory($this->getReference('Category2'));
        $trick6->setUser($this->getReference('user2'));
        $manager->persist($trick6);

        $trick7 = new Tricks();
        $trick7->setName("FRONT ROLL");
        $trick7->setDescription("The front roll moves your body in a forward motion, but it tilts a little to the side. Master it before moving on to a full front flip");
        $trick7->setCreatedAt(new DateTimeImmutable());
        $trick7->setCategory($this->getReference('Category3'));
        $trick7->setUser($this->getReference('user3'));
        $manager->persist($trick7);

        $trick8 = new Tricks();
        $trick8->setName("50/50 Nose Press");
        $trick8->setDescription("This trick is done the same as the tail press but with a nose butter on the box instead of a tail butter. One thing to note is that you will need to get yourself back to center as you drop off the box. Otherwise, you will land in a nose press still and be off balance.");
        $trick8->setCreatedAt(new DateTimeImmutable());
        $trick8->setCategory($this->getReference('Category4'));
        $trick8->setUser($this->getReference('user4'));
        $manager->persist($trick8);

        $trick9 = new Tricks();
        $trick9->setName("50/50 Grinds");
        $trick9->setDescription("50/50 grinds are the easiest way to get into the wonderful world of jibbing! You should learn these on wider boxes (often called butter boxes) in the park. They will have a mild slope to ride up to the box and aren’t too long.
        Make sure the box you want to hit is clear, then ride up to it straight. The same principles as to when you hit a jump apply, no last-minute carving or your balance will be off. You will need to readjust your balance to be centered once you are on the box because there is a little ramp to ride onto the box with, and you can’t try to turn on the box or go on edge. If you try to turn or go on edge you will definitely slam.
        Once you get onto the box, keep yourself centered and ride off it straight, don’t forget to bend your knees to absorb the landing! Once you get comfortable with that, you can start popping and ollie-ing off for extra steeze points!");
        $trick9->setCreatedAt(new DateTimeImmutable());
        $trick9->setCategory($this->getReference('Category'));
        $trick9->setUser($this->getReference('user1'));
        $manager->persist($trick9);

        $trick10 = new Tricks();
        $trick10->setName("Indy Grabs");
        $trick10->setDescription("Now that you can confidently get air off of jumps, you can learn this easy grab trick! To perform an indy grab, you jump off like you normally would, then suck your knees up to your chest while extending your rear arm down to grab the board between your legs. Release the grab at the peak height of your jump and bend your knees at the landing and ride away like a pro!
        Your front arm should stay extended straight out so you keep your positioning centered in the air, and look straight ahead to spot your landing.");
        $trick10->setCreatedAt(new DateTimeImmutable());
        $trick10->setCategory($this->getReference('Category2'));
        $trick10->setUser($this->getReference('user2'));
        $manager->persist($trick10);

        $manager->flush();

        //Reference
        $this->addReference('trick', $trick);
    }

    public function getDependencies(): array
    {
        return array(
        CategoryFixtures::class,
        UserFixtures::class,
    );
    }
}
