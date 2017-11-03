<?php

namespace ClientesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/clientes/list")
     */
    public function indexAction()
    {
        return $this->render('ClientesBundle:Default:index.html.twig');
    }
     /**
     * @Route("/clientes/{idCliente}/edit", requirements={"idCliente":"\d+"})
     * 
     **/
    public function editAction($idCliente = 0)
    {
        return $this->render('ClientesBundle:Default:edit.html.twig',
        	array(
        		'idCliente' => $idCliente
        	));
    }
     /**
     * @Route("/clientes/new")
     * 
     */
    public function newAction()
    {
        return $this->render('ClientesBundle:Default:new.html.twig');
    }
}
