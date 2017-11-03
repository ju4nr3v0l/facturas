<?php

namespace FacturasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction(Request $request)
    {
        return $this->render('FacturasBundle:Default:index.html.twig');
    }

   /**
     * @Route("/facturas/{numeroFactura}/edit", requirements={"numeroFactura":"\d+"})
     * 
     **/
    public function editAction($numeroFactura = 0)
    {
        return $this->render('FacturasBundle:Default:edit.html.twig',
        	array(
        		'numeroFactura' => $numeroFactura
        	));
    }
     /**
     * @Route("/facturas/new")
     * 
     */
    public function newAction()
    {
        return $this->render('FacturasBundle:Default:new.html.twig');
    }
}
