<?php

namespace App\Service;

use App\Repository\FilmRepository;
use Symfony\Component\HttpFoundation\RequestStack;

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
     * @var RequestStack
     */
    private $request;

    /**
     * FilmService constructor.
     * @param FilmRepository $filmRepository
     * @param RequestStack $request
     */
    public function __construct(FilmRepository $filmRepository, RequestStack $request)
    {
        $this->filmRepository = $filmRepository;
        $this->request = $request;
    }

    /**
     * @return \App\Entity\Film[]|mixed
     */
    public function getFilm()
    {
        if ($this->request->getCurrentRequest()->get('film_name')) {
            return $this->filmRepository->searchFilmByWord($this->request->getCurrentRequest()->get('film_name'));
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