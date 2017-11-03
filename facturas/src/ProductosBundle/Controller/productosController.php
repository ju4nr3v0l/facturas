<?php

namespace ProductosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use ProductosBundle\Entity\productos;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class productosController extends Controller
{
	/**
     * @Route("/productos/list")
     * 
     */
    public function getAllProducts(Request $request)
    {	
    	$em = $this->getDoctrine()->getManager();
    	$repository = $em->getRepository('ProductosBundle:productos');
    	$productos = $repository->findAll();
    	
    	//return new Response('datos tabla clientes');
        return $this->render('ProductosBundle:Default:index.html.twig', 
        		array(
        			'productos'=>$productos	
    			)
        	);
    }

    /**
     * @Route("/productos/new")
     * 
     */
    public function insertProduct(Request $request)
    {	
    	$producto = new productos; //instance class
    	$form = $this->createFormBuilder($producto) //create form
    		->add('nombre', TextType::class)
    		->add('precio', TextType::class)
    		->add('save', SubmitType::class, array('label' => 'Crear producto'))
    		->getForm();
    	$form->handleRequest($request);
    	if ($form->isSubmitted() && $form->isValid()) {

			$product = $form->getData();
			
			$em = $this->getDoctrine()->getManager();

			$em->persist($product);
    		$em->flush();
    		return $this->redirect('/productos/list');

    	}	
    	
    	return $this->render('ProductosBundle:Default:new.html.twig',
    		array(
    			 'form' => $form->createView(),	
			));
    }


    /**
     * @Route("/productos/{idProduct}/edit", requirements={"idProduct":"\d+"})
     * 
     */
    public function editProducto(Request $request,$idProduct)
    {
        $id = (Int)$idProduct;
    	
    	//get data client to edit	
    	$em = $this->getDoctrine()->getManager();
    	$repository = $em->getRepository('ProductosBundle:productos');
    	$producto = $repository->findOneById($id);
    	
    	if(!$producto){
    		throw $this->createNotFoundException("No Existe ese producto");
    		
    	}
    	$product = new productos; //instance class
    	$form = $this->createFormBuilder($product) //create form
    		->add('nombre', TextType::class)
    		->add('precio', TextType::class)
    		->add('save', SubmitType::class, array('label' => 'Editar producto'))
    		->getForm();
    	
    	$form->handleRequest($request);
    	if ($form->isSubmitted() && $form->isValid()) {

			$product = $form->getData();
			
			$em = $this->getDoctrine()->getManager();
			$producto->setNombre($form["nombre"]->getData());
			$producto->setPrecio($form["precio"]->getData());
			
    		$em->flush();
    		return $this->redirect('/productos/list');

    	}
    	
    	//response edited client
        return $this->render('ProductosBundle:Default:edit.html.twig',
        	array(
        		 'form' => $form->createView(),
        		 'productos'	=> $producto,
        	));
      
    }

     /**
     * @Route("/productos/{idProducto}/delete", name="delete_producto", requirements={"idProducto":"\d+"})
     * 
     **/
    public function deleteClient($idProducto)
    {	
    	$id = (Int)$idProducto;
    	$em = $this->getDoctrine()->getManager();
    	$product = $em->getRepository('ProductosBundle:productos')->find($id);
    	//get data client to delete
    	$em->remove($product);
    	$em->flush();	
    	
    	
        return $this->redirect('/productos/list');

    }
}
