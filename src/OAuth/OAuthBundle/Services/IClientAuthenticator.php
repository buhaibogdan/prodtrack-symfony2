<?php


namespace OAuth\OAuthBundle\Services;


interface IClientAuthenticator
{
    public function __construct(IClientService $clientService, IAccessTokenService $tokenService);

    /**
     * @param int $clientId
     * @param string $clientSecret
     * @param string $grantType
     * @return mixed
     */
    public function getTokenForClient($clientId, $clientSecret, $grantType);

    /**
     * @param string $authorizationHeader
     * @return boolean
     */
    public function hasValidAuthorization($authorizationHeader);
}