<?php

namespace Prodtrack\Bundle\Controller;

use OAuth\OAuthBundle\Controller\ITokenAuthenticatedController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class StatusController extends Controller
    implements ITokenAuthenticatedController, ICollectionJsonController
{
    public function indexAction(Request $request)
    {
        return new Response('Success', 200);
    }
}