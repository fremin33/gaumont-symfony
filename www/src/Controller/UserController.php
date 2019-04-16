<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController
 * @package App\Controller
 */
class UserController extends AbstractController
{

    /**
     * @Route(path="/mon-espace", name="user_espace")
     * @return Response
     */
    public function index()
    {
        return $this->render('user/index.html.twig', [
            'user' => $this->getUser(),
        ]);
    }
}
