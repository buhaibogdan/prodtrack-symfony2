<?php

namespace Prodtrack\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $accept = $request->headers->get('accept');
        if ($accept !== 'application/hal+json') {
            return new Response('', 406);
        }
        return new Response('{}', 200, array('Content-type'=>'application/hal+json'));
    }
}