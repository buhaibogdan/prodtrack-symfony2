<?php

namespace OAuth\OAuthBundle\Controller;

use OAuth\OAuthBundle\Exception\ClientNotFoundException;
use OAuth\OAuthBundle\Exception\InvalidRefreshTokenException;
use OAuth\OAuthBundle\Exception\UserNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\MissingMandatoryParametersException;


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

        $grantType = $request->request->get('grant_type');

        if ($grantType === static::GRANT_TYPE_PASSWORD) {
            try {
                $token = $this->getToken($request, $grantType);
            } catch (UserNotFoundException $e) {
                return new Response($e->getMessage(), Response::HTTP_UNAUTHORIZED);
            } catch (ClientNotFoundException $e) {
                return new Response($e->getMessage(), Response::HTTP_UNAUTHORIZED);
            } catch (MissingMandatoryParametersException $e) {
                return new Response($e->getMessage(), Response::HTTP_BAD_REQUEST);
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

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param $grantType
     * @throws \Symfony\Component\Routing\Exception\MissingMandatoryParametersException
     * @throws \OAuth\OAuthBundle\Exception\UserNotFoundException
     * @return array
     */
    protected function getToken(Request $request, $grantType)
    {
        $username = $request->request->get('username');
        $password = $request->request->get('password');
        $clientId = $request->request->get('client_id');
        $clientSecret = $request->request->get('client_secret');
        if (empty($clientId) ||
            empty($clientSecret) ||
            empty($username) ||
            empty($password)
        ) {
            throw new MissingMandatoryParametersException('Fields missing from request. Check documentation.');
        }
        /** @var \Prodtrack\Bundle\Services\UserService $userService */
        $userService = $this->get('prodtrack.user_service');
        $user = $userService->getUserWithCredentials($username, $password);
        if (is_null($user)) {
            throw new UserNotFoundException('Invalid username or password.');
        }

        /** @var \OAuth\OAuthBundle\Services\ClientAuthenticator $auth */
        $auth = $this->get('o_auth.authenticator');
        return $auth->getTokenForClient($clientId, $clientSecret, $grantType);
    }
}
