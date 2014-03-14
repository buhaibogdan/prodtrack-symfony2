<?php


namespace OAuth\OAuthBundle\Repository;


use Doctrine\ORM\EntityRepository;

class AccessTokenRepository extends EntityRepository
{
    /**
     *
     * @param $clientId
     * @param $type
     * @return null|object
     */
    public function getRecordForClient($clientId, $type)
    {
        return $this->findOneBy(
            array(
                'fk_client_id' => $clientId,
                'token_type' => $type
            )
        );
    }

    /**
     * @param $refreshToken
     * @return null|object
     */
    public function getRecordWithRefreshToken($refreshToken)
    {
        return $this->findOneBy(
            array(
                'refresh_token' => $refreshToken
            )
        );
    }

    /**
     * @param $access_token
     * @param $token_type
     * @return null|object
     */
    public function getAccessTokenByType($access_token, $token_type)
    {
        return $this->findOneBy(
            array(
                'access_token' => $access_token,
                'token_type' => $token_type
            )
        );
    }
}