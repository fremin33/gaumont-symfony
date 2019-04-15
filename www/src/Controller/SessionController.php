<?php

namespace App\Controller;

use App\Service\SessionService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SessionController
 * @package App\Controller
 */
class SessionController extends AbstractController
{
    /**
     * @Route("/session/booking/{id}", name="show_session")
     * @param $id
     * @param SessionService $sessionService
     * @return Response
     */
    public function show($id, SessionService $sessionService)
    {
        return $this->render('session/show.html.twig', [
            'session' => $sessionService->getSession($id),
        ]);
    }

    /**
     * @Route("/session/booking/{id}/summary", name="summary_booking")
     * @param $id
     * @param SessionService $sessionService
     * @param Request $request
     * @return Response
     */
    public function summaryBooking($id, SessionService $sessionService, Request $request)
    {
        return $this->render('session/summary_booking.html.twig', [
            'nbPlaceReserved' => $request->get('nb_place_reserved'),
            'session' => $sessionService->getSession($id),
        ]);
    }


    /**
     * @Route("/session/booking/{id}/validate", name="validate_booking")
     * @param $id
     * @param Session $session
     * @param SessionService $sessionService
     * @param Request $request
     * @return RedirectResponse
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function validateBooking($id, Session $session, SessionService $sessionService, Request $request)
    {
        $session->getFlashBag()->clear();
        if ($request->isMethod('POST')) {
            if ($sessionService->validateBooking($id)) {
                $session->getFlashBag()->add('sucess', 'Votre réservation a été validé avec succès');
            } else {
                $session->getFlashBag()->add('error', 'Le nombre de place disponible est dépassé');
                return new RedirectResponse($this->generateUrl('show_session', [
                    'id' => $id,
                ]));
            }
        } else {
            $session->getFlashBag()->add('sucess', 'Réservation annulée avec succès');
            return $this->redirectToRoute('show_session', ['id' => $id]);
        }

        return new RedirectResponse($this->generateUrl('user_espace'));
    }

}

