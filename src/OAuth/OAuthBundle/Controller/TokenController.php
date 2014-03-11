<?php

namespace OAuth\OAuthBundle\Controller;

use OAuth\OAuthBundle\Exception\ClientNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class TokenController extends Controller
{
    public function indexAction(Request $request)
    {
        if ($request->getMethod() !== 'POST') {
            // accept only post request
            return new Response('POST method required.', Response::HTTP_METHOD_NOT_ALLOWED);
        }

        $username = $request->request->get('username');
        $password = $request->request->get('password');
        $clientId = $request->request->get('client_id');
        $clientSecret = $request->request->get('client_secret');
        $grantType = $request->request->get('grant_type');
        if (empty($username) ||
            empty($password) ||
            empty($clientId) ||
            empty($clientSecret) ||
            empty($grantType)
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
            /** @var \OAuth\OAuthBundle\Services\IClientAuthenticator $auth */
            $auth = $this->get('o_auth.authenticator');
            $token = $auth->getTokenForClient($clientId, $clientSecret, $grantType);
        } catch (ClientNotFoundException $e) {
            return new Response('Invalid client credentials.', Response::HTTP_UNAUTHORIZED);
        }

        return new Response(json_encode($token), 200, array('Content-type' => 'application/json'));
    }
}
