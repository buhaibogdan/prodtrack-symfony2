<?php


namespace OAuth\OAuthBundle\Services;


class TokenGenerator
{

    public function getToken()
    {
        return sha1(microtime(true) . mt_rand(10000, 90000));
    }
}