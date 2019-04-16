<?php

namespace App\Controller;

use App\Entity\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SessionController
 * @package App\Controller
 */
class SessionController extends AbstractController
{
    /**
     * @Route("/film/{idFilm}/session/{id}", name="session_show")
     * @param $id
     * @return Response
     */
    public function show($id)
    {
        return $this->render('session/show.html.twig', [
            'session' => $this->getDoctrine()->getRepository(Session::class)->find($id),
        ]);
    }
}

