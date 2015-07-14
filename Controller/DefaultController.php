<?php

namespace MongoTransactionBundle\Controller;

use MongoTransactionBundle\Biz\MongoTransactionBiz;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('MongoTransactionBundle:Default:index.html.twig', array('name' => $name));
    }
}
