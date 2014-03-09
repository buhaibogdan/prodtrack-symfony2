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

    }
}