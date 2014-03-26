<?php

namespace Prodtrack\Bundle\Controller;

use OAuth\OAuthBundle\Controller\ITokenAuthenticatedController;
use Prodtrack\Bundle\Repository\TargetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class StatusController extends Controller
    implements ITokenAuthenticatedController, ICollectionJsonController
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        /** @var \Prodtrack\Bundle\Repository\TargetRepository $repo */
        $repo = $em->getRepository('\Prodtrack\Bundle\Entity\Target');

        $r = $repo->getTargetsBetweenDates(
            new \DateTime('-1year'),
            new \DateTime('+2weeks')
        );

        return new Response(print_r($r, 1), 200);

    }
}