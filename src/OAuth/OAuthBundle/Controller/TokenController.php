<?php

namespace OAuth\OAuthBundle\Controller;

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
        //var_dump($username);
        //var_dump($password);
        $user = $userService->getUserWithCredentials($username, $password);
        if (is_null($user)) {
            return new Response('Invalid username or password.', Response::HTTP_UNAUTHORIZED);
        }
        /** @var \OAuth\OAuthBundle\Services\ClientService $clientService */
        $clientService = $this->get('o_auth.client_service');
        $client = $clientService->getClient($clientId, $clientSecret, $grantType);

        if (is_null($client)) {
            return new Response('Invalid client credentials.', Response::HTTP_UNAUTHORIZED);
        }
        /** @var \OAuth\OAuthBundle\Services\AccessTokenService $tokenService */
        $tokenService = $this->get('o_auth.token_service');
        $token = $tokenService->getAccessToken($client->getId());
        $response = array(
            'access_token' => $token->getAccessToken(),
            'refresh_token' => $token->getRefreshToken(),
            'expires_in' => $token->getExpiresIn()
        );

        return new Response(json_encode($response), 200, array('Content-type' => 'application/json'));
    }
}
