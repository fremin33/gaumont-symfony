<?php

namespace App\Controller;

use App\Service\BookingService;
use App\Service\UserService;
use App\Entity\Session;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session as SfSession;
use Symfony\Component\Routing\Annotation\Route;

class BookingController extends AbstractController
{

    /**
     * @Route("/film/{idFilm}/session/{idSession}/booking", name="booking_summary")
     * @param $idSession
     * @param Request $request
     * @return Response
     */
    public function summaryBooking($idSession, Request $request)
    {
        return $this->render('booking/summary.html.twig', [
            'nbPlaceReserved' => $request->get('nb_place_reserved'),
            'session' => $this->getDoctrine()->getRepository(Session::class)->find($idSession),
        ]);
    }

    /**
     * @Route("/film/{idFilm}/session/{idSession}/booking/validate", name="booking_validate")
     * @param $idSession
     * @param $idFilm
     * @param SfSession $session
     * @param BookingService $bookingService
     * @param Request $request
     * @return RedirectResponse
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function validateBooking($idSession, $idFilm, SfSession $session, BookingService $bookingService, Request $request)
    {
        $session->getFlashBag()->clear();
        if ($request->isMethod('POST')) {
            if ($bookingService->validateBooking($idSession)) {
                $session->getFlashBag()->add('sucess', 'Votre réservation a été validé avec succès');
            } else {
                $session->getFlashBag()->add('error', 'Le nombre de place disponible est dépassé');
                return new RedirectResponse($this->generateUrl('session_show', [
                    'id' => $idSession,
                    'idFilm' => $idFilm
                ]));
            }
        } else {
            $session->getFlashBag()->add('sucess', 'Réservation annulée avec succès');
            return $this->redirectToRoute('session_show', ['id' => $idSession, 'idFilm' => $idFilm]);
        }

        return new RedirectResponse($this->generateUrl('user_espace'));
    }


    /**
     * @Route(path="/mon-espace/booking/{id}/remove", name="booking_remove")
     * @param $id
     * @param SfSession $session
     * @param UserService $userService
     * @return Response
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function removeBooking($id, SfSession $session, UserService $userService)
    {
        $session->getFlashBag()->clear();
        if ($userService->removeUserBooking($id)) {
            $session->getFlashBag()->add('sucess', 'Votre réservation a été supprimée avec succès');
        } else {
            $session->getFlashBag()->add('error', 'Une erreur est survenue');
        }
        return new RedirectResponse($this->generateUrl('user_espace'));
    }
}