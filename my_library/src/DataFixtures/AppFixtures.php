<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->passwordEncoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        // create first user
        $user1 = new User();
        $user1->setEmail('test1@test.ru');
        $user1->setPassword($this->passwordEncoder->encodePassword($user1, 'Test1!'));
        $user1->setRoles(array('ROLE_USER'));
        // create second user
        $user2 = new User();
        $user2->setEmail('test2@test.ru');
        $user2->setPassword($this->passwordEncoder->encodePassword($user2, 'Test2!'));
        $user2->setRoles(array('ROLE_USER'));
        // insert users to database
        $manager->persist($user1);
        $manager->persist($user2);
        // flush manager
        $manager->flush();
    }
}
