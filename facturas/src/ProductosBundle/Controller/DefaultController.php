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
