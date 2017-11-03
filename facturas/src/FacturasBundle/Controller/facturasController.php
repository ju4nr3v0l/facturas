<?php

namespace FacturasBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FacturasBundle\Entity\facturas;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class facturasController extends Controller
{
	/**
     * @Route("/")
     */
    public function getAllFacturas(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
    	$repository = $em->getRepository('FacturasBundle:facturas');
    	$facturas = $repository->findAll();
    	
    	//return new Response('datos tabla facturas');
        return $this->render('FacturasBundle:Default:index.html.twig', 
        		array(
        			'facturas'=>$facturas	
    			)
        	);
        
    }

    /**
     * @Route("/facturas/new")
     * 
     */
    public function newfactura(Request $request)
    {
    	$factura = new facturas; //instance class
    	$form = $this->createFormBuilder($factura) //create form
    		->add('numeroFactura', TextType::class)
    		->add('idProducto', TextType::class)
    		->add('idCliente', TextType::class)
    		->add('save', SubmitType::class, array('label' => 'Crear Factura'))
    		->getForm();
    	$form->handleRequest($request);
    	if ($form->isSubmitted() && $form->isValid()) {

			$factura = $form->getData();
			
			$em = $this->getDoctrine()->getManager();

			$em->persist($factura);
    		$em->flush();
    		return $this->redirect('/');

    	}	
    	
    	return $this->render('FacturasBundle:Default:new.html.twig',
    		array(
    			 'form' => $form->createView(),	
			));
       
    }

     /**
     * @Route("/facturas/{numeroFactura}/edit", requirements={"numeroFactura":"\d+"})
     * 
     **/
    public function editAction(Request $request,$numeroFactura)
    {
    	$id = (Int)$numeroFactura;
    	
    	//get data client to edit	
    	$em = $this->getDoctrine()->getManager();
    	$repository = $em->getRepository('FacturasBundle:facturas');
    	$factura = $repository->findOneById($id);
    	
    	if(!$factura){
    		throw $this->createNotFoundException("No Existe esa factura");
    		
    	}
    	$fact = new facturas; //instance class
    	$form = $this->createFormBuilder($fact) //create form
    		->add('numeroFactura', TextType::class)
    		->add('idProducto', TextType::class)
    		->add('idCliente', TextType::class)
    		->add('save', SubmitType::class, array('label' => 'Editar Factura'))
    		->getForm();
    	
    	$form->handleRequest($request);
    	if ($form->isSubmitted() && $form->isValid()) {

			$fact = $form->getData();
			
			$em = $this->getDoctrine()->getManager();
			$factura->setNumeroFactura($form["numeroFactura"]->getData());
			$factura->setIdProducto($form["idProducto"]->getData());
			$factura->setIdCliente($form["idCliente"]->getData());
			
    		$em->flush();
    		return $this->redirect('/');

    	}
    	
    	//response edited client
        return $this->render('FacturasBundle:Default:edit.html.twig',
        	array(
        		 'form' => $form->createView(),
        		 'facturas'	=> $factura,
        	));

        
    }
     /**
     * @Route("/facturas/{idFactura}/delete", name="delete_factura", requirements={"idFactura":"\d+"})
     * 
     **/
    public function deleteFactura($idFactura)
    {	
    	$id = (Int)$idFactura;
    	$em = $this->getDoctrine()->getManager();
    	$factura = $em->getRepository('FacturasBundle:facturas')->find($id);
    	//get data client to delete
    	$em->remove($factura);
    	$em->flush();	
    	
    	
        return $this->redirect('/');

    }
}
