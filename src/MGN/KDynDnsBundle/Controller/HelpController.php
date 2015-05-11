<?php

namespace MGN\KDynDnsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class HelpController extends Controller
{
    public function indexAction()
    {
        $engine = $this->container->get('templating');
        $content = $engine->render('MGNKDynDnsBundle:Help:index.html.twig');

        return $response = new Response($content);
    }

    public function helpAction()
    {
        $engine = $this->container->get('templating');
        $content = $engine->render('MGNKDynDnsBundle:Help:help.html.twig');

        return $response = new Response($content);
    }
}
