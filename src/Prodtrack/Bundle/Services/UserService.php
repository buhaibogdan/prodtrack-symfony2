<?php


namespace Prodtrack\Bundle\Services;

use Doctrine\Common\Persistence\ObjectManager;

class UserService implements IUserService
{
    protected $em;

    public function __construct(ObjectManager $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @param string $username
     * @param string $password
     * @return \Prodtrack\Bundle\Entity\User
     */
    public function getUserWithCredentials($username, $password)
    {
        /** @var \Prodtrack\Bundle\Repository\UserRepository $userRepo */
        $userRepo = $this->em->getRepository('Prodtrack\Bundle\Entity\User');
        return $userRepo->getUserWithCredentials($username, $password);
    }
}