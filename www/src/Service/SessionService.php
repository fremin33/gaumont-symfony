<?php

namespace App\Service;

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
 * Class SessionService
 * @package App\Service
 */
class SessionService
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
     * @param $id
     * @return Session|null
     */
    public function getSession($id)
    {
        return $this->sessionRepository->find($id);
    }

    /**
     * @param $id
     * @return bool
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function validateBooking($id)
    {
        $capacity = $this->sessionRepository->find($id)->getCapacity();
        $nbPlaceReserved = $this->request->getCurrentRequest()->get('nb_place_reserved');

        if (($capacity - $nbPlaceReserved) >= 0) {
            $session = $this->sessionRepository->find($id);
            $session->setCapacity($session->getCapacity() - $nbPlaceReserved);
            $this->user->addSession($session);
            $this->manager->persist($this->user);
            $this->manager->flush();
            $this->sessionRepository->updateNbPlaceReserved($nbPlaceReserved, $this->user->getId(), $session->getId());
            return true;
        }
        return false;
    }
}