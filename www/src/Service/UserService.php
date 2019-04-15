<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\SessionRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class UserService
 * @package App\Service
 */
class UserService
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
     * @return bool
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function removeUserSession($id)
    {
        $this->user->removeSession($this->sessionRepository->find($id));
        $this->manager->flush();
        return true;
    }
}