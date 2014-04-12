<?php


namespace Prodtrack\ApiBundle\Services;

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
     * @return \Prodtrack\ApiBundle\Entity\User
     */
    public function getUserWithCredentials($username, $password)
    {
        /** @var \Prodtrack\ApiBundle\Repository\UserRepository $userRepo */
        $userRepo = $this->em->getRepository('Prodtrack\ApiBundle\Entity\User');
        return $userRepo->getUserWithCredentials($username, $password);
    }
}