<?php

namespace App\Service;

use App\Entity\Booking;
use App\Entity\User;
use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\Security\Core\Security;

/**
 * Class UserService
 * @package App\Service
 */
class UserService
{
    /**
     * @var User
     */
    private $user;
    /**
     * @var BookingRepository
     */
    private $bookingRepository;
    /**
     * @var EntityManager
     */
    private $manager;

    /**
     * SessionService constructor.
     * @param BookingRepository $bookingRepository
     * @param Security $security
     * @param EntityManagerInterface $manager
     */
    public function __construct(BookingRepository $bookingRepository, Security $security, EntityManagerInterface $manager)
    {
        $this->bookingRepository = $bookingRepository;
        $this->manager = $manager;
        $this->user = $security->getUser();
    }

    /**
     * @param Booking $booking
     * @return bool
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function removeUserBooking($booking)
    {
        $this->user->removeBooking($booking);
        $capacity = $booking->getSession()->getCapacity() + $booking->getNbplaceReserved();
        $booking->getSession()->setCapacity($capacity);
        $this->manager->flush();
        return true;
    }
}