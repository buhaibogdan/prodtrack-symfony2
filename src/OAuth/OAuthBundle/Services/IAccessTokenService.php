<?php


namespace OAuth\OAuthBundle\Services;

use OAuth\OAuthBundle\Repository\AccessTokenRepository;

interface IAccessTokenService
{
    public function __construct(AccessTokenRepository $accessTokenRepo);

    /**
     * Returns a new token of 40 characters.
     * @return string
     */
    public function getNewToken();
}