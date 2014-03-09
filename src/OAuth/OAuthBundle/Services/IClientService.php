<?php


namespace OAuth\OAuthBundle\Services;


use Doctrine\Common\Persistence\ObjectManager;

interface IClientService
{
    public function __construct(ObjectManager $em);

    /**
     * @param string $clientId
     * @param string $clientSecret
     * @param string $grantType
     * @return \OAuth\OAuthBundle\Entity\Client
     */
    public function getClient($clientId, $clientSecret, $grantType);
}