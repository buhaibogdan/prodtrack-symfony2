<?php


namespace OAuth\OAuthBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

//TODO: index on client_id maybe
/**
 * Class Client
 * @ORM\Entity(repositoryClass="OAuth\OAuthBundle\Repository\ClientRepository")
 * @ORM\Table(name="oauth_client")
 */
class Client
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
     * @ORM\Column(type="string", length=80)
     */
    protected $client_secret;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    protected $redirect_uri;

    /**
     * @ORM\Column(type="string", length=128)
     */
    protected $scope;

    /**
     * @ORM\Column(type="string", length=80)
     */
    protected $grant_types;

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
     * Set scope
     *
     * @param string $scope
     * @return Client
     */
    public function setScope($scope)
    {
        $this->scope = $scope;

        return $this;
    }

    /**
     * Get scope
     *
     * @return string
     */
    public function getScope()
    {
        return $this->scope;
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
