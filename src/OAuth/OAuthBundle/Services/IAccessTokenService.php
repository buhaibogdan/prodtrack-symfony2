<?php


namespace OAuth\OAuthBundle\Services;

use Doctrine\Common\Persistence\ObjectManager;

interface IAccessTokenService
{
    public function __construct(ObjectManager $em);

    /**
     * Returns a new token of 40 characters.
     * @return string
     */
    public function getNewToken();
}