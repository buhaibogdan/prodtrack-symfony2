<?php


namespace OAuth\OAuthBundle\Repository;


use Doctrine\ORM\EntityRepository;

class AccessTokenRepository extends EntityRepository
{
    public function getAccessToken()
    {
        //$access_token = $tokenGen->getToken();
    }

    public function getClient($clientId, $clientSecret, $grantType)
    {
        return $this->findOneBy(array(
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'grant_types' => $grantType
            ));
    }
}