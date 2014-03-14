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

    /**
     * @param $refreshToken
     * @return \OAuth\OAuthBundle\Entity\AccessToken
     */
    public function getAccessTokenForRefresh($refreshToken);

    /**
     * @param $access_token
     * @param $type
     * @return boolean
     */
    public function isTokenValid($access_token, $type);
}