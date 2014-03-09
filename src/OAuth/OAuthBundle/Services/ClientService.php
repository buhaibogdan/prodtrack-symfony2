<?php


namespace OAuth\OAuthBundle\Services;


use Doctrine\Common\Persistence\ObjectManager;
use OAuth\OAuthBundle\Services\IClientService;

class ClientService implements IClientService
{
    protected $em;

    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }

    public function getClient($clientId, $clientSecret, $grantType)
    {
        /** @var \OAuth\OAuthBundle\Repository\ClientRepository $repo */
        $repo = $this->em->getRepository('\OAuth\OAuthBundle\Entity\Client');
        return $repo->getClient($clientId, $clientSecret, $grantType);
    }
}