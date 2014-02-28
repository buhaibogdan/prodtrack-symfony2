<?php


namespace OAuth\OAuthBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class AccessToken
 * @ORM\Entity(repositoryClass="OAuth\OAuthBundle\Repository\AccessTokenRepository")
 * @ORM\Table(name="oauth_access_token")
 */
class AccessToken
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=80)
     */
    protected $client_id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    protected $access_token;

    /**
     * @ORM\Column(type="string", length=50)
     */
    protected $refresh_token;

    /**
     * @ORM\Column(type="string", length=20)
     */
    protected $token_type;
    /**
     * @ORM\Column(type="integer")
     */
    protected $expires_in;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set client_id
     *
     * @param string $clientId
     * @return AccessToken
     */
    public function setClientId($clientId)
    {
        $this->client_id = $clientId;

        return $this;
    }

    /**
     * Get client_id
     *
     * @return string
     */
    public function getClientId()
    {
        return $this->client_id;
    }

    /**
     * Set access_token
     *
     * @param string $accessToken
     * @return AccessToken
     */
    public function setAccessToken($accessToken)
    {
        $this->access_token = $accessToken;

        return $this;
    }

    /**
     * Get access_token
     *
     * @return string
     */
    public function getAccessToken()
    {
        return $this->access_token;
    }

    /**
     * Set refresh_token
     *
     * @param string $refreshToken
     * @return AccessToken
     */
    public function setRefreshToken($refreshToken)
    {
        $this->refresh_token = $refreshToken;

        return $this;
    }

    /**
     * Get refresh_token
     *
     * @return string
     */
    public function getRefreshToken()
    {
        return $this->refresh_token;
    }

    /**
     * Set token_type
     *
     * @param string $tokenType
     * @return AccessToken
     */
    public function setTokenType($tokenType)
    {
        $this->token_type = $tokenType;

        return $this;
    }

    /**
     * Get token_type
     *
     * @return string
     */
    public function getTokenType()
    {
        return $this->token_type;
    }

    /**
     * Set expires_in
     *
     * @param integer $expiresIn
     * @return AccessToken
     */
    public function setExpiresIn($expiresIn)
    {
        $this->expires_in = $expiresIn;

        return $this;
    }

    /**
     * Get expires_in
     *
     * @return integer
     */
    public function getExpiresIn()
    {
        return $this->expires_in;
    }
}
