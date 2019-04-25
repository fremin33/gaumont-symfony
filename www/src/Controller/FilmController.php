<?php

namespace App\Controller;

use App\Entity\Film;
use App\Service\FilmService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class FilmController
 * @package App\Controller
 */
class FilmController extends AbstractController
{
    /**
     * @Route("/", name="film_index")
     * @param FilmService $filmService
     * @param Request $request
     * @return Response
     */
    public function index(FilmService $filmService, Request $request)
    {
        return $this->render('film/index.html.twig', [
            'films' => $filmService->getFilm($request->get('film_name')),
        ]);
    }

    /**
     * @Route("/film/{id}", name="film_show")
     * @param $film
     * @param FilmService $filmService
     * @return Response
     */
    public function show(Film $film, FilmService $filmService)
    {
        return $this->render('film/show.html.twig', [
            'film' => $film,
            'sessionsFormat' => $filmService->formatSessionsForDisplay($film->getSessions()),
        ]);
    }
}
