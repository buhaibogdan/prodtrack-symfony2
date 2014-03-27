<?php

namespace Prodtrack\Bundle\Controller;

use OAuth\OAuthBundle\Controller\ITokenAuthenticatedController;
use Prodtrack\Bundle\Repository\TargetRepository;
use Prodtrack\Bundle\Services\TargetCollectionService;
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

        $col = new TargetCollectionService($repo);
        $rz = $col->getTargetCollection(1, '2013-03-03', '2014-04-04');

        return new Response(print_r($rz, 1), 200);

    }
}