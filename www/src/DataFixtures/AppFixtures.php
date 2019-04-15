<?php

namespace App\DataFixtures;

use App\Entity\Film;
use App\Entity\Room;
use App\Entity\Session;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {
            $room = new Room();
            $room->setName('Salle' . ($i + 1));
            $manager->persist($room);
            $rooms[] = $room;
        }

        for ($i = 0; $i < 10; $i++) {
            $film = new Film();
            $film->setName('Film n° ' . ($i + 1));
            $film->setDuration((string) rand(1, 2) . 'h' . rand(0, 60));
            $film->setDescription('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias at dolore, facere perferendis quas temporibus totam? Dolorem ea impedit maiores molestias provident quia quibusdam quidem sunt, veritatis. Natus, quos soluta.');
            $film->setReleaseDate(new \DateTime());
            $film->setPoster("https://www.cinemaspathegaumont.com/media/movie/910406$i/poster/360x480.jpg");
            $film->setPrice(rand(1, 5));
            $manager->persist($film);

            for ($t = 0; $t < 5; $t++) {
                $session = new Session();
                $session->setFilm($film);
                $session->setDate(new \DateTime());
                $session->setCapacity(rand(20,50));
                $session->setRoom($rooms[rand(0, 5)]);
                $manager->persist($session);

            }
            $manager->flush();
        }
    }


}
