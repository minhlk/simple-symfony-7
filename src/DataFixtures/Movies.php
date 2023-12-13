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
        $movie->setTitle('Avengers')
            ->setReleaseYear('20231212')
            ->setDescription('The Avengers are a team of fictional superheroes and the protagonists of the Marvel Cinematic Universe (MCU) media franchise, based on ')
            ->setImagePath('https://dummyimage.com/600x400/000/fff&text=Avenger');
        
        $manager->persist($movie);

        $movie2 = new Movie();
        $movie2->setTitle('Judgement Day')
            ->setReleaseYear('20231213')
            ->setDescription('Judgement Day are a team of fictional superheroes and the protagonists of the Marvel Cinematic Universe (MCU) media franchise, based on ')
            ->setImagePath('https://dummyimage.com/600x400/000/fff&text=Judgement Day');

        $manager->persist($movie2);

        $manager->flush();
    }
}
