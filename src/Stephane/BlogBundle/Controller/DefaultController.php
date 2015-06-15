<?php

namespace Stephane\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('StephaneBlogBundle:Default:index.html.twig', array('name' => $name));
    }
}
