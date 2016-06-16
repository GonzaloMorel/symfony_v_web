<?php

namespace VerantBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('VerantBundle:Default:index.html.twig');
    }
}
