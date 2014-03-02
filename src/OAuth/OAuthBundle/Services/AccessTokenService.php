<?php


namespace OAuth\OAuthBundle\Services;

use OAuth\OAuthBundle\Repository\AccessTokenRepository;

class AccessTokenService implements IAccessTokenService
{
    protected $accTokenRepo = null;

    public function __construct(AccessTokenRepository $accessTokenRepo)
    {
        $this->accTokenRepo = $accessTokenRepo;
    }

    public function getNewToken()
    {
        return sha1(microtime(true) . mt_rand(10000, 90000));
    }
}