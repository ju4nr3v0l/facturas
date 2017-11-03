<?php

namespace ProductosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{	
	/**
     * @Route("/productos/list")
     * 
     */
    public function indexAction(Request $request)
    {
        return $this->render('ProductosBundle:Default:index.html.twig');
            
        //return $this->render('ProductosBundle:Default:index.html.twig');
    }

    /**
     * @Route("/productos/{idProduct}/edit", requirements={"idProduct":"\d+"})
     * 
     */
    public function editAction($idProduct = 0)
    {
        return new Response(
            'Editar producto Id: ' .$idProduct

        );
       // return $this->render('ProductosBundle:Default:edit.html.twig',
        //	array(
        //		'product' => $idProduct
        //	));
    }
     /**
     * @Route("/productos/new", requirements={"idProduct":"\d+"})
     * 
     */
    public function newAction(Request $request)
    {
        return new Response(
                json_encode($request->request->all())
            );
        //return $this->render('ProductosBundle:Default:new.html.twig');
    }

     /**
     * @Route("/productos/$idProduct", requirements={"idProduct":"\d+"})
     * 
     */
    public function deleteAction(Request $request)
    {
        return new Response(
                json_encode($request->request->all())
            );
        //return $this->render('ProductosBundle:Default:new.html.twig');
    }	
}
