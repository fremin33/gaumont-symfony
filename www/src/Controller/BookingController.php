<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Service\BookingService;
use App\Service\UserService;
use App\Entity\Session;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
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
     * @Entity("session", expr="repository.find(idSession)")
     * @param $session
     * @param Request $request
     * @return Response
     */
    public function summaryBooking(Session $session, Request $request)
    {
        return $this->render('booking/summary.html.twig', [
            'nbPlaceReserved' => $request->get('nb_place_reserved'),
            'session' => $session,
        ]);
    }

    /**
     * @Route("/film/{idFilm}/session/{idSession}/booking/validate", name="booking_validate")
     * @Entity("session", expr="repository.find(idSession)")
     * @param $session
     * @param $idFilm
     * @param SfSession $SfSession
     * @param BookingService $bookingService
     * @param Request $request
     * @return RedirectResponse
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function validateBooking(Session $session, $idFilm, SfSession $SfSession, BookingService $bookingService, Request $request)
    {
        $SfSession->getFlashBag()->clear();
        if ($request->isMethod('POST')) {
            if ($bookingService->validateBooking($session, $request->get('nb_place_reserved'))) {
                $SfSession->getFlashBag()->add('sucess', 'Votre réservation a été validé avec succès');
            } else {
                $SfSession->getFlashBag()->add('error', 'Le nombre de place disponible est dépassé');
                return new RedirectResponse($this->generateUrl('session_show', [
                    'id' => $session,
                    'idFilm' => $idFilm
                ]));
            }
        } else {
            $SfSession->getFlashBag()->add('sucess', 'Réservation annulée avec succès');
            return $this->redirectToRoute('session_show', ['id' => $session->getId(), 'idFilm' => $idFilm]);
        }

        return new RedirectResponse($this->generateUrl('user_espace'));
    }


    /**
     * @Route(path="/mon-espace/booking/{id}/remove", name="booking_remove")
     * @param Booking $booking
     * @param SfSession $session
     * @param UserService $userService
     * @return Response
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function removeBooking(Booking $booking, SfSession $session, UserService $userService)
    {
        $session->getFlashBag()->clear();
        if ($userService->removeUserBooking($booking)) {
            $session->getFlashBag()->add('sucess', 'Votre réservation a été supprimée avec succès');
        } else {
            $session->getFlashBag()->add('error', 'Une erreur est survenue');
        }
        return new RedirectResponse($this->generateUrl('user_espace'));
    }
}