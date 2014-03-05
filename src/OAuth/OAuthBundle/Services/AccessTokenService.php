<?php


namespace OAuth\OAuthBundle\Services;

use Doctrine\Common\Persistence\ObjectManager;


class AccessTokenService implements IAccessTokenService
{
    protected $em;

    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }

    public function getNewToken()
    {
        return sha1(microtime(true) . mt_rand(10000, 90000));
    }

    public function handleResourceOwnerFlow($clientId, $clientSecret, $grantType)
    {
        /** @var \OAuth\OAuthBundle\Repository\AccessTokenRepository $repo */
        $repo = $this->em->getRepository('\OAuth\OAuthBundle\Entity\AccessToken');
        return $repo->getClient($clientId, $clientSecret, $grantType);
    }
}