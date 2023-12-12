<?php

namespace App\DataFixtures;

use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Movies extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $movie = new Movie();
        $movie->setTitle('Title 1')
            ->setReleaseYear('20231212')
            ->setDescription('This is the first description')
            ->setImagePath('https://dummyimage.com/120x120');
        
        $manager->persist($movie);

        $movie2 = new Movie();
        $movie2->setTitle('Title 2')
            ->setReleaseYear('20231213')
            ->setDescription('This is the second description')
            ->setImagePath('https://dummyimage.com/125x125');

        $manager->persist($movie2);

        $manager->flush();
    }
}
