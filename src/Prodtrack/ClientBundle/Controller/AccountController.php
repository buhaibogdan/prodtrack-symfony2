<?php


namespace Prodtrack\ClientBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AccountController extends Controller
{
    public function loginAction()
    {
        return new Response('login', 200);
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