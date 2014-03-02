<?php


namespace OAuth\OAuthBundle\Services;

use OAuth\OAuthBundle\Repository\ClientRepository;

class ClientAuthenticator implements IClientAuthenticator
{
    protected $clientRepo = null;

    public function __construct(ClientRepository $clientRepo)
    {
        $this->clientRepo = $clientRepo;
    }

    public function checkClientCredentials($clientId, $clientSecret, $grantType, $scope)
    {
        // TODO: Implement checkClientCredentials() method.
    }
}