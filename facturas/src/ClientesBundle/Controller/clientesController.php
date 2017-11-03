<?php

namespace ClientesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use ClientesBundle\Entity\clientes;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class clientesController extends Controller
{
	/**
     * @Route("/clientes/list")
     */
    public function getAllClients()
    {
    	$em = $this->getDoctrine()->getManager();
    	$repository = $em->getRepository('ClientesBundle:clientes');
    	$clientes = $repository->findAll();
    	
    	//return new Response('datos tabla clientes');
        return $this->render('ClientesBundle:Default:index.html.twig', 
        		array(
        			'clientes'=>$clientes	
    			)
        	);
    }
	/**
     * @Route("/clientes/new")
     * 
     */
    public function insertClient(Request $request)
    {	
    	$client = new clientes; //instance class
    	$form = $this->createFormBuilder($client) //create form
    		->add('nombres', TextType::class)
    		->add('identificacion', TextType::class)
    		->add('save', SubmitType::class, array('label' => 'Crear cliente'))
    		->getForm();
    	$form->handleRequest($request);
    	if ($form->isSubmitted() && $form->isValid()) {

			$client = $form->getData();
			
			$em = $this->getDoctrine()->getManager();

			$em->persist($client);
    		$em->flush();
    		return $this->redirect('/clientes/list');

    	}	
    	
    	return $this->render('ClientesBundle:Default:new.html.twig',
    		array(
    			 'form' => $form->createView(),	
			));
    }

    /**
     * @Route("/clientes/{idCliente}/edit", name="edit_cliente", requirements={"idCliente":"\d+"})
     * 
     **/
    public function editClient(Request $request,$idCliente)
    {	
    	$id = (Int)$idCliente;
    	
    	//get data client to edit	
    	$em = $this->getDoctrine()->getManager();
    	$repository = $em->getRepository('ClientesBundle:clientes');
    	$cliente = $repository->findOneById($id);
    	
    	if(!$cliente){
    		throw $this->createNotFoundException("No Existe ese cliente");
    		
    	}
    	$client = new clientes; //instance class
    	$form = $this->createFormBuilder($client) //create form
    		->add('nombres', TextType::class)
    		->add('identificacion', TextType::class)
    		->add('save', SubmitType::class, array('label' => 'Editar cliente'))
    		->getForm();
    	
    	$form->handleRequest($request);
    	if ($form->isSubmitted() && $form->isValid()) {

			$client = $form->getData();
			
			$em = $this->getDoctrine()->getManager();
			$cliente->setNombres($form["nombres"]->getData());
			$cliente->setIdentificacion($form["identificacion"]->getData());
			
    		$em->flush();
    		return $this->redirect('/clientes/list');

    	}
    	
    	//response edited client
        return $this->render('ClientesBundle:Default:edit.html.twig',
        	array(
        		 'form' => $form->createView(),
        		 'clientes'	=> $cliente,
        	));
    }

     /**
     * @Route("/clientes/{idCliente}/delete", name="delete_cliente", requirements={"idCliente":"\d+"})
     * 
     **/
    public function deleteClient($idCliente)
    {	
    	$id = (Int)$idCliente;
    	$em = $this->getDoctrine()->getManager();
    	$client = $em->getRepository('ClientesBundle:clientes')->find($id);
    	//get data client to delete
    	$em->remove($client);
    	$em->flush();	
    	
    	
        return $this->redirect('/clientes/list');

    }

}
