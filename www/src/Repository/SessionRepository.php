<?php

namespace App\Repository;

use App\Entity\Session;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Session|null find($id, $lockMode = null, $lockVersion = null)
 * @method Session|null findOneBy(array $criteria, array $orderBy = null)
 * @method Session[]    findAll()
 * @method Session[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SessionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Session::class);
    }

    public function updateNbPlaceReserved($nbPlaceReserved, $userId, $sessionId)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "
                UPDATE `user_session` 
                SET `nb_place_reserved`= :nb_place_reserved 
                WHERE `user_id` = :user_id 
                AND `session_id` = :session_id
                ";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':session_id', $sessionId);
        $stmt->bindParam(':nb_place_reserved', $nbPlaceReserved);
        $stmt->execute();
    }
}
