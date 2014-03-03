<?php


namespace Prodtrack\Bundle\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    /**
     * @param $username
     * @param $password
     * @return \Prodtrack\Bundle\Entity\User
     */
    public function getUserWithCredentials($username, $password)
    {
        return $this->findOneBy(array('username' => $username, 'password' => $password));
    }
} 