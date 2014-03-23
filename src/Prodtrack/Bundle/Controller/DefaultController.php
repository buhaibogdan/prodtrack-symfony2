<?php

namespace Prodtrack\Bundle\Controller;

use OAuth\OAuthBundle\Controller\ITokenAuthenticatedController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
    implements ITokenAuthenticatedController, ICollectionJsonController
{
    public function indexAction(Request $request)
    {

    }
}
