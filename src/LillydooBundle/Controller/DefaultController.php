<?php

namespace LillydooBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Lillydoo/Default/index.html.twig');
    }
}
