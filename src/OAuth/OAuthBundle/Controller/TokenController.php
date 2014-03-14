<?php

namespace OAuth\OAuthBundle\Controller;

use OAuth\OAuthBundle\Exception\ClientNotFoundException;
use OAuth\OAuthBundle\Exception\InvalidRefreshTokenException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class TokenController extends Controller
{
    const GRANT_TYPE_PASSWORD = 'password';
    const GRANT_TYPE_REFRESH_TOKEN = 'refresh_token';

    public function indexAction(Request $request)
    {
        if ($request->getMethod() !== 'POST') {
            // accept only post request
            return new Response('POST method required.', Response::HTTP_METHOD_NOT_ALLOWED);
        }

        // TODO: refactor all this !!

        $grantType = $request->request->get('grant_type');

        if ($grantType === static::GRANT_TYPE_PASSWORD) {
            $username = $request->request->get('username');
            $password = $request->request->get('password');
            $clientId = $request->request->get('client_id');
            $clientSecret = $request->request->get('client_secret');
            if (empty($clientId) ||
                empty($clientSecret) ||
                empty($username) ||
                empty($password)
            ) {
                return new Response('Fields missing from request. Check documentation.', Response::HTTP_BAD_REQUEST);
            }
            /** @var \Prodtrack\Bundle\Services\UserService $userService */
            $userService = $this->get('prodtrack.user_service');
            $user = $userService->getUserWithCredentials($username, $password);
            if (is_null($user)) {
                return new Response('Invalid username or password.', Response::HTTP_UNAUTHORIZED);
            }

            try {
                /** @var \OAuth\OAuthBundle\Services\ClientAuthenticator $auth */
                $auth = $this->get('o_auth.authenticator');
                $token = $auth->getTokenForClient($clientId, $clientSecret, $grantType);
            } catch (ClientNotFoundException $e) {
                return new Response('Invalid client credentials.', Response::HTTP_UNAUTHORIZED);
            }
        } elseif ($grantType === static::GRANT_TYPE_REFRESH_TOKEN) {
            $refreshToken = $request->request->get('refresh_token');
            /** @var \OAuth\OAuthBundle\Services\ClientAuthenticator $auth */
            $auth = $this->get('o_auth.authenticator');

            try {
                $token = $auth->getTokenForRefresh($refreshToken);
            } catch (InvalidRefreshTokenException $e) {
                return new Response('Invalid refresh token.', Response::HTTP_UNAUTHORIZED);
            }
        } else {
            return new Response('Invalid grant type.', Response::HTTP_BAD_REQUEST);
        }


        return new Response(json_encode($token), 200, array('Content-type' => 'application/json'));
    }
}
