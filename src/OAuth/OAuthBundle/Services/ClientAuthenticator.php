<?php


namespace OAuth\OAuthBundle\Services;


use OAuth\OAuthBundle\Exception\ClientNotFoundException;

class ClientAuthenticator implements IClientAuthenticator
{
    protected $clientService;
    protected $tokenService;

    public function __construct(IClientService $clientService, IAccessTokenService $tokenService)
    {
        $this->clientService = $clientService;
        $this->tokenService = $tokenService;
    }

    public function getTokenForClient($clientId, $clientSecret, $grantType)
    {
        $client = $this->clientService->getClient($clientId, $clientSecret, $grantType);
        if (is_null($client)) {
            throw new ClientNotFoundException();
        }

        $token = $this->tokenService->getAccessToken($client->getId());
        return array(
            'access_token' => $token->getAccessToken(),
            'refresh_token' => $token->getRefreshToken(),
            'expires_in' => $token->getExpiresIn()
        );
    }
}