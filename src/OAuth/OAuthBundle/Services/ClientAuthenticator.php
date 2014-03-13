<?php


namespace OAuth\OAuthBundle\Services;


use OAuth\OAuthBundle\Exception\ClientNotFoundException;

class ClientAuthenticator implements IClientAuthenticator
{
    protected $clientService;
    protected $tokenService;

    public function __construct(IClientService $clientService, IAccessTokenService $tokenService)
    {
        $this->clientService = $clientService;
        $this->tokenService = $tokenService;
    }

    public function getTokenForClient($clientId, $clientSecret, $grantType)
    {
        $client = $this->clientService->getClient($clientId, $clientSecret, $grantType);
        if (is_null($client)) {
            throw new ClientNotFoundException();
        }

        $token = $this->tokenService->getAccessToken($client->getId());
        return array(
            'access_token' => $token->getAccessToken(),
            'refresh_token' => $token->getRefreshToken(),
            'expires_in' => $token->getExpiresIn()
        );
    }

    /**
     * @param string $authHeader like "Bearer dlsjbgkb3kjbkjsh3ush9934541243edf444"
     * @return bool
     */
    public function hasValidAuthorization($authHeader)
    {
        // parse header
        $authHeaderParts = explode(' ', $authHeader);
        $authHeaderParsed = array();
        foreach ($authHeaderParts as $part) {
            $part = trim(strtolower($part));
            if ($part === 'bearer') {
                $authHeaderParsed['type'] = $part;
            } elseif (strlen($part) >= 40) {
                $authHeaderParsed['access_token'] = $part;
            }
        }

        if (array_key_exists('type', $authHeaderParsed) &&
            array_key_exists('access_token', $authHeaderParsed)
        ) {

            return $this->tokenService->isTokenValid(
                $authHeaderParsed['access_token'],
                $authHeaderParsed['type']
            );
        }

        return false;
    }
}