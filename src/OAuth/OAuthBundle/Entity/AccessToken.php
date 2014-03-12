<?php


namespace OAuth\OAuthBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class AccessToken
 * @ORM\Entity(repositoryClass="OAuth\OAuthBundle\Repository\AccessTokenRepository")
 * @ORM\Table(name="oauth_access_token", uniqueConstraints={@ORM\UniqueConstraint(
 *  name="client_token", columns={"fk_client_id", "access_token"}
 * )})
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
     * @ORM\Column(type="integer", length=40)
     */
    protected $fk_client_id;

    /**
     * @ORM\Column(type="string", length=40)
     */
    protected $access_token;

    /**
     * @ORM\Column(type="string", length=40)
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
     * @ORM\Column(type="datetime", options={"default"="CURRENT_TIMESTAMP"})
     */
    protected $created_on;

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
     * Set fk_client_id
     *
     * @param integer $fkClientId
     * @return AccessToken
     */
    public function setFkClientId($fkClientId)
    {
        $this->fk_client_id = $fkClientId;

        return $this;
    }

    /**
     * Get fk_client_id
     *
     * @return integer
     */
    public function getFkClientId()
    {
        return $this->fk_client_id;
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

    /**
     * Set created_on
     *
     * @param \DateTime $createdOn
     * @return AccessToken
     */
    public function setCreatedOn($createdOn)
    {
        $this->created_on = $createdOn;

        return $this;
    }

    /**
     * Get created_on
     *
     * @return \DateTime
     */
    public function getCreatedOn()
    {
        return $this->created_on;
    }
}
