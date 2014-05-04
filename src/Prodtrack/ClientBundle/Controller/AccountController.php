<?php


namespace Prodtrack\ClientBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AccountController extends Controller
{
    public function loginAction(Request $request)
    {
        $username = $request->request->get('username');
        $password = $request->request->get('password');
        $clientSecret = '871c85109d7563735565d0b9c044432d3755c5c5';
        $clientId = 'a9df6c5b72622dbea463ad1a1ba774425efc7eea';
        $grantType = 'password';

        /* @var \Prodtrack\ClientBundle\Services\AuthService $auth */
        $auth = $this->get('client.auth');
        $token = $auth->getToken($username, $password, $clientId, $clientSecret, $grantType);
        var_dump($token);
        return new Response($token, 200);
    }

    public function logoutAction()
    {
        // invalidate tokens and stuff
        return new Response('Logged out', 200);
    }

    public function createAction()
    {
        return new Response('{created:1, error: 0}', 201, array('Content-type' => 'application/json'));
    }
}