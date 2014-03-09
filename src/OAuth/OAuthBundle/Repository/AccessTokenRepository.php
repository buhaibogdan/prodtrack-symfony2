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
}