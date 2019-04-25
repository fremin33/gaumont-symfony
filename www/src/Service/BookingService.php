<?php

namespace App\Service;

use App\Entity\Booking;
use App\Entity\Session;
use App\Entity\User;
use App\Repository\SessionRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class BookingService
 * @package App\Service
 */
class BookingService
{
    /**
     * @var RequestStack
     */
    private $request;
    /**
     * @var User
     */
    private $user;
    /**
     * @var SessionRepository
     */
    private $sessionRepository;
    /**
     * @var EntityManager
     */
    private $manager;

    /**
     * SessionService constructor.
     * @param SessionRepository $sessionRepository
     * @param Security $security
     * @param EntityManagerInterface $manager
     * @param RequestStack $request
     */
    public function __construct(SessionRepository $sessionRepository, Security $security, EntityManagerInterface $manager, RequestStack $request)
    {
        $this->sessionRepository = $sessionRepository;
        $this->manager = $manager;
        $this->user = $security->getUser();
        $this->request = $request;
    }

    /**
     * @param Session $session
     * @param $nbPlaceReserved
     * @return bool
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function validateBooking($session, $nbPlaceReserved)
    {
        if ($this->capacityIsNotExceed($session->getCapacity(), $nbPlaceReserved)) {
            $booking = new Booking($this->user, $session, $nbPlaceReserved);
            $session->setCapacity($session->getCapacity() - $nbPlaceReserved);
            $this->manager->persist($booking);
            $this->manager->flush();
            return true;
        }
        return false;
    }

    /**
     * @param $capacity
     * @param $nbPlaceReserved
     * @return bool
     */
    private function capacityIsNotExceed($capacity, $nbPlaceReserved)
    {
        return ($capacity - $nbPlaceReserved) >= 0 ? true : false;
    }
}