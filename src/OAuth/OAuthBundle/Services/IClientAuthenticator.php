<?php


namespace OAuth\OAuthBundle\Services;

use OAuth\OAuthBundle\Repository\ClientRepository;

interface IClientAuthenticator
{
    public function __construct(ClientRepository $clientRepo);

    public function checkClientCredentials($clientId, $clientSecret, $grantType, $scope);
}