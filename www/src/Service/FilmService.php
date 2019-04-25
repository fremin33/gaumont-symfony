<?php

namespace App\Service;

use App\Entity\Film;
use App\Repository\FilmRepository;

/**
 * Class FilmService
 * @package App\Service
 */
class FilmService
{
    /**
     * @var FilmRepository
     */
    private $filmRepository;

    /**
     * FilmService constructor.
     * @param FilmRepository $filmRepository
     */
    public function __construct(FilmRepository $filmRepository)
    {
        $this->filmRepository = $filmRepository;
    }

    /**
     * @param $filmToSearch
     * @return Film[]|mixed
     */
    public function getFilm($filmToSearch)
    {
        if ($filmToSearch) {
            return $this->filmRepository->searchFilmByWord($filmToSearch);
        } else {
            return $this->filmRepository->findAll();
        }
    }

    /**
     * @param $id
     * @return array
     */
    public function getFilmSessionFormat($id) {
        $sessionFormat = [];
        foreach ($this->filmRepository->find($id)->getSessions() as $index => $session) {
            $dateSession = $session->getDate();
            $sessionFormat[$dateSession->format('d/m/y')][] = $session;
        }
        return $sessionFormat;
    }
}