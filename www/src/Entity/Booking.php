<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BookingRepository")
 */
class Booking
{

    /**
     * Booking constructor.
     * @param $user
     * @param $session
     * @param $nbPlaceReserved
     */
    public function __construct($user, $session, $nbPlaceReserved)
    {
        $this->user = $user;
        $this->session = $session;
        $this->nbplaceReserved = $nbPlaceReserved;
    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="bookings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Session")
     * @ORM\JoinColumn(nullable=false)
     */
    private $session;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbplaceReserved;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     * @return Booking
     */
    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Session|null
     */
    public function getSession(): ?Session
    {
        return $this->session;
    }

    /**
     * @param Session|null $session
     * @return Booking
     */
    public function setSession(?Session $session): self
    {
        $this->session = $session;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getNbplaceReserved(): ?int
    {
        return $this->nbplaceReserved;
    }

    /**
     * @param int $nbplaceReserved
     * @return Booking
     */
    public function setNbplaceReserved(int $nbplaceReserved): self
    {
        $this->nbplaceReserved = $nbplaceReserved;

        return $this;
    }
}
