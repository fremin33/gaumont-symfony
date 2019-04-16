<?php

namespace App\Controller;

use App\Entity\Film;
use App\Service\FilmService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @return Response
     */
    public function index(FilmService $filmService)
    {
        return $this->render('film/index.html.twig', [
            'films' => $filmService->getFilm(),
        ]);
    }

    /**
     * @Route("/film/{id}", name="film_show")
     * @param $id
     * @param FilmService $filmService
     * @return Response
     */
    public function show($id, FilmService $filmService)
    {
        return $this->render('film/show.html.twig', [
            'film' => $this->getDoctrine()->getRepository(Film::class)->find($id),
            'sessionsFormat' => $filmService->getFilmSessionFormat($id),
        ]);
    }
}
