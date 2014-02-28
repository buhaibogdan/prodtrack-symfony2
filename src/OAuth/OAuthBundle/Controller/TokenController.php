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

        $username = $request->query->get('username');
        $password = $request->query->get('password');
        $clientId = $request->query->get('client_id');
        $clientSecret = $request->query->get('client_secret');
        $grantType = $request->query->get('grant_type');

        if (empty($username) ||
            empty($password) ||
            empty($clientId) ||
            empty($clientSecret) ||
            empty($grantType)
        ) {
            return new Response('Fields missing from request. Check documentation.', Response::HTTP_BAD_REQUEST);
        }

        return $this->render('OAuthOAuthBundle:Default:index.html.twig');
    }
}
