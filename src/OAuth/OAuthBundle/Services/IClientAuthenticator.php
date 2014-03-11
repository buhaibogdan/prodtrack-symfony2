<?php


namespace OAuth\OAuthBundle\Services;


interface IClientAuthenticator
{
    public function __construct(IClientService $clientService, IAccessTokenService $tokenService);

    /**
     * @param $clientId
     * @param $clientSecret
     * @param $grantType
     * @return mixed
     */
    public function getTokenForClient($clientId, $clientSecret, $grantType);
}