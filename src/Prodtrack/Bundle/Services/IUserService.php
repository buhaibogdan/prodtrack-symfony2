<?php


namespace Prodtrack\Bundle\Services;

use Doctrine\Common\Persistence\ObjectManager;

interface IUserService
{
    public function __construct(ObjectManager $entityManager);

    public function getUserWithCredentials($username, $password);
}