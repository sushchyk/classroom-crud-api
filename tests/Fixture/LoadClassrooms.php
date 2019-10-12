<?php

namespace App\Tests\Fixture;

use App\Entity\Classroom;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadClassrooms implements FixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        for($i = 1; $i <= 2; $i++) {
            $classroom = new Classroom();
            $classroom->setTitle('Classroom ' . $i);
            $classroom->setCreatedAt(new \DateTime());
            $classroom->setIsActive(true);
            $manager->persist($classroom);
        }

        $manager->flush();
    }
}