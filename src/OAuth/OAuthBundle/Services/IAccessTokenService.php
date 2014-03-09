<?php


namespace OAuth\OAuthBundle\Services;

use Doctrine\Common\Persistence\ObjectManager;

interface IAccessTokenService
{
    public function __construct(ObjectManager $em);

    public function getAccessToken($clientId, $type, $lifeTime);
}