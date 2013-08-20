<?php

namespace Housecare\OldBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('HousecareOldBundle:Default:index.html.twig', array('name' => $name));
    }
}
