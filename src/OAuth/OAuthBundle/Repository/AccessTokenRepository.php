<?php


namespace OAuth\OAuthBundle\Repository;


use Doctrine\ORM\EntityRepository;

class AccessTokenRepository extends EntityRepository
{
    public function getAccessToken()
    {
        //$access_token = $tokenGen->getToken();
    }
}