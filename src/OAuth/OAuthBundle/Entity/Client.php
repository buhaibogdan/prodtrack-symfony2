<?php


namespace OAuth\OAuthBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Client
 * @ORM\Entity(repositoryClass="OAuth\OAuthBundle\Repository\ClientRepository")
 * @ORM\Table(name="oauth_client", uniqueConstraints={@ORM\UniqueConstraint(
 *      name="client_id_secret", columns={"client_id", "client_secret"}
 * )})
 */
class Client
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=40, unique=true)
     */
    protected $client_id;

    /**
     * @ORM\Column(type="string", length=40, unique=true)
     */
    protected $client_secret;

    /**
     * @ORM\Column(type="string", length=80, nullable=true, name="client_name")
     */
    protected $name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $user_id;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    protected $redirect_uri;

    /**
     * @ORM\Column(type="string", length=128)
     */
    protected $default_scope;

    /**
     * @ORM\Column(type="string", length=80)
     */
    protected $grant_types;


    /**
     * Set client_id
     *
     * @param string $clientId
     * @return Client
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
     * Set client_secret
     *
     * @param string $clientSecret
     * @return Client
     */
    public function setClientSecret($clientSecret)
    {
        $this->client_secret = $clientSecret;

        return $this;
    }

    /**
     * Get client_secret
     *
     * @return string
     */
    public function getClientSecret()
    {
        return $this->client_secret;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Client
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set user_id
     *
     * @param integer $userId
     * @return Client
     */
    public function setUserId($userId)
    {
        $this->user_id = $userId;

        return $this;
    }

    /**
     * Get user_id
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Set redirect_uri
     *
     * @param string $redirectUri
     * @return Client
     */
    public function setRedirectUri($redirectUri)
    {
        $this->redirect_uri = $redirectUri;

        return $this;
    }

    /**
     * Get redirect_uri
     *
     * @return string
     */
    public function getRedirectUri()
    {
        return $this->redirect_uri;
    }

    /**
     * Set default_scope
     *
     * @param string $defaultScope
     * @return Client
     */
    public function setDefaultScope($defaultScope)
    {
        $this->default_scope = $defaultScope;

        return $this;
    }

    /**
     * Get default_scope
     *
     * @return string
     */
    public function getDefaultScope()
    {
        return $this->default_scope;
    }

    /**
     * Set grant_types
     *
     * @param string $grantTypes
     * @return Client
     */
    public function setGrantTypes($grantTypes)
    {
        $this->grant_types = $grantTypes;

        return $this;
    }

    /**
     * Get grant_types
     *
     * @return string
     */
    public function getGrantTypes()
    {
        return $this->grant_types;
    }
}
