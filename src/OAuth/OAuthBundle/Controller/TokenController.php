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
            return new Response('', Response::HTTP_METHOD_NOT_ALLOWED);
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
            return new Response('', Response::HTTP_UNAUTHORIZED);
        }
        /** @var \OAuth\OAuthBundle\Services\ClientService $clientService */
        $clientService = $this->get('o_auth.client_service');
        $client = $clientService->getClient($clientId, $clientSecret, $grantType);

        if (is_null($client)) {
            return new Response('', Response::HTTP_UNAUTHORIZED);
        }

        return $this->render('OAuthOAuthBundle:Default:index.html.twig');
    }
}
