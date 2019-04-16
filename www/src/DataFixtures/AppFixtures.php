<?php

namespace App\DataFixtures;

use App\Entity\Film;
use App\Entity\Room;
use App\Entity\Session;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use GuzzleHttp\Client;

class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i <= 10; $i++) {
            $room = new Room();
            $room->setName('Salle ' . ($i + 1));
            $manager->persist($room);
            $rooms[] = $room;
        }

        $client = new Client();
        $res = $client->get('https://www.randomlists.com/data/movies.json');
        $data = json_decode($res->getBody(), true);

        for ($i = 0; $i < 20; $i++) {
            $date = new \DateTime();
            $film = new Film();
            $film->setName($data['RandL']['items'][$i]['name']);
            $film->setDuration(rand(65, 125));
            $film->setDescription('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias at dolore, facere perferendis quas temporibus totam? Dolorem ea impedit maiores molestias provident quia quibusdam quidem sunt, veritatis. Natus, quos soluta.');
            $film->setReleaseDate($date);
            $film->setPoster("https://image.tmdb.org/t/p/w300_and_h450_bestv2" . $data['RandL']['items'][$i]['img']);
            $film->setPrice(rand(5, 10));
            $manager->persist($film);

            $days = [1, 2, 3, 4];
            $hours = ['19:00:00', '19:45:00', '20:30:00', '21:00:00', '21:30:00'];
            foreach ($days as $day) {
                foreach ($hours as $hour) {
                    $dateSession = new \DateTime("2019-04-0$day " . $hour);
                    $session = new Session();
                    $session->setFilm($film);
                    $session->setDate($dateSession);
                    $session->setCapacity(rand(20, 50));
                    $session->setRoom($rooms[rand(0, 10)]);
                    $manager->persist($session);
                }


            }
            $manager->flush();
        }
    }


}
