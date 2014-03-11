<?php


namespace OAuth\OAuthBundle\Services;

use Doctrine\Common\Persistence\ObjectManager;

interface IAccessTokenService
{
    public function __construct(ObjectManager $em);

    /**
     * @param $clientId
     * @param string $type
     * @param string $lifeTime
     * @return \OAuth\OAuthBundle\Entity\AccessToken
     */
    public function getAccessToken($clientId, $type = 'bearer', $lifeTime = '3600');
}