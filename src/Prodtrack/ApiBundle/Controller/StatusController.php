<?php

namespace Prodtrack\ApiBundle\Controller;

use OAuth\OAuthBundle\Controller\ITokenAuthenticatedController;
use Prodtrack\ApiBundle\Repository\TargetRepository;
use Prodtrack\ApiBundle\Services\TargetCollectionService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class StatusController extends Controller
    implements ITokenAuthenticatedController, ICollectionJsonController
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        /** @var \Prodtrack\ApiBundle\Repository\TargetRepository $repo */
        $repo = $em->getRepository('\Prodtrack\ApiBundle\Entity\Target');

        $col = new TargetCollectionService($repo);
        $rz = $col->getTargetCollection(1, '2013-03-03', '2014-04-04');

        return new Response(print_r($rz, 1), 200);

    }
}