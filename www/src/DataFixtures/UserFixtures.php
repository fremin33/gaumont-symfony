<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('user@user.fr');
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'user'
        ));
        $manager->persist($user);

        $userAdmin = new User();
        $userAdmin->setEmail('admin@admin.fr');
        $userAdmin->setPassword($this->passwordEncoder->encodePassword(
            $userAdmin,
            'admin'
        ));
        $userAdmin->setRoles(['ROLE_ADMIN']);
        $manager->persist($userAdmin);
        $manager->flush();
    }
}
