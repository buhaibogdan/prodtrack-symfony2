<?php

namespace Prodtrack\ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ClientBundle:Default:index.html.twig', array('name' => $name));
    }
}
