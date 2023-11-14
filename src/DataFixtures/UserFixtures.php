<?php

namespace App\DataFixtures;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use App\Entity\Member;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
    }

    private function loadUsers(ObjectManager $manager)
    {
        foreach ($this->getUserData() as [$email,$username, $plainPassword,$role, $memberReference]) {
            $user = new User();
            $password = $this->hasher->hashPassword($user, $plainPassword);
            $user->setEmail($email);
            $user->setUsername($username);
            $user->setPassword($password);

            $roles = array();
            $roles[] = $role;
            $user->setRoles($roles);

            $member = $this->getReference($memberReference);
            $user->setMember($member);

            $manager->persist($user);
        }
        $manager->flush();
    }
        private function getUserData()
        {
                yield [
                        'chris@localhost',
                        'chris',
                        'chris',
                        'ROLE_ADMIN',
                        'chris'
                        
                ];
                yield [
                        'sarah@localhost',
                        'sarah',
                        'sarah',
                        'ROLE_USER',
                        'sarah'
                ];
                yield [
                        'reda@localhost',
                        'reda',
                        'reda',
                        'ROLE_USER',
                        'reda'
                ];
        }
}
