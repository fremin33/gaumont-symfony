<?php

namespace App\Controller;

use App\Service\UserService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
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

    /**
     * @Route(path="/mon-espace/session/{id}/remove", name="user_remove_session")
     * @param $id
     * @param Session $session
     * @param UserService $userService
     * @return Response
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function removeSession($id, Session $session, UserService $userService)
    {
        $session->getFlashBag()->clear();
        if ($userService->removeUserSession($id)) {
            $session->getFlashBag()->add('sucess', 'Votre réservation a été supprimée avec succès');
        } else {
            $session->getFlashBag()->add('error', 'Une erreur est survenue');
        }
        return new RedirectResponse($this->generateUrl('user_espace'));
    }
}
