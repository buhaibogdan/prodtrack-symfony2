<?php


namespace Prodtrack\ApiBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Prodtrack\ApiBundle\Entity\User;

class UserRepository extends EntityRepository
{
    /**
     * @param $username
     * @param $password
     * @return \Prodtrack\ApiBundle\Entity\User
     */
    public function getUserWithCredentials($username, $password)
    {
        return $this->findOneBy(array('username' => $username, 'password' => $password));
    }

    /**
     * @param $email
     * @param $username
     * @param $password
     */
    public function createUser($email, $username, $password)
    {
        $user = new User();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPassword($password);

        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }
} 