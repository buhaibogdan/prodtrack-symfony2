<?php


namespace OAuth\OAuthBundle\Services;

use Doctrine\Common\Persistence\ObjectManager;
use OAuth\OAuthBundle\Entity\AccessToken;
use Symfony\Component\Validator\Constraints\DateTime;


class AccessTokenService implements IAccessTokenService
{
    protected $em;

    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }

    protected function getNewToken()
    {
        return sha1(microtime(true) . mt_rand(10000, 90000));
    }

    public function getAccessToken($clientId, $type = 'bearer', $lifeTime = 3600)
    {
        /** @var \OAuth\OAuthBundle\Repository\AccessTokenRepository $repo */
        $repo = $this->em->getRepository('\OAuth\OAuthBundle\Entity\AccessToken');
        $accessToken = $repo->getRecordForClient($clientId, $type);
        $add = false;

        if (!$accessToken instanceof AccessToken) {
            $accessToken = new AccessToken();
            $accessToken->setFkClientId($clientId);
            $accessToken->setTokenType($type);
            $add = true;
        }

        $accessToken->setExpiresIn($lifeTime);
        $accessToken->setRefreshToken($this->getNewToken());
        $accessToken->setAccessToken($this->getNewToken());

        if ($add) {
            $this->em->persist($accessToken);
        }

        $this->em->flush();

        return $accessToken;
    }

    /**
     * @param $access_token
     * @param $type
     * @return boolean
     */
    public function isTokenValid($access_token, $type)
    {
        /** @var \OAuth\OAuthBundle\Repository\AccessTokenRepository $repo */
        $repo = $this->em->getRepository('\OAuth\OAuthBundle\Entity\AccessToken');
        $token = $repo->getAccessTokenByType($access_token, $type);

        if (!$token instanceof AccessToken) {
            return false;
        }

        $expiresIn = $token->getExpiresIn();
        $expireTime = $token->getCreatedOn()
            ->add(new \DateInterval('PT' . $expiresIn . 'S'))
            ->getTimestamp();
        $currentTimeStamp = time(true);
        return ($expireTime - $currentTimeStamp) > 0;
    }
}