<?php

namespace FacturasBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FacturasBundle\Entity\facturas;
use ClientesBundle\Entity\clientes;
use ProductosBundle\Entity\productos;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class facturasController extends Controller
{
	/**
     * @Route("/")
     */
    public function getAllFacturas(Request $request)
    {
        $facturasFinales = [];
    	$em = $this->getDoctrine()->getManager();
    	$repository = $em->getRepository('FacturasBundle:facturas');
        $query = $repository->createQueryBuilder('cc')
            ->select('DISTINCT cc.numeroFactura')
            ->getQuery();
        $init = $query->getResult();
        foreach ($init as $key => $value) {
            $facturasOrganizadas = $this->getFactInfo($value['numeroFactura']);

            array_push($facturasFinales,$facturasOrganizadas);
            
        }

        foreach ($facturasFinales as $key => $value) {
            $sum = 0;
            foreach ($value['productos'] as $llave => $valor) {
                
                $sum += $valor['precio'];    
            }
            $facturasFinales[$key]['total'] = $sum;
        }
        
        
       
        //$facturasOrganizadas = $this->getFactInfo($facturas);
    	//return new Response('datos tabla facturas');
        return $this->render('FacturasBundle:Default:index.html.twig', 
        		array(
        			'facturas'=>$facturasFinales	
    			)
        	);
        
    }

    public function getFactInfo($numeroFactura){
        $resultado = ['cliente'=>'','numeroFactura'=>'','productos'=>[]];
        $em = $this->getDoctrine()->getManager();
        $repositoryFacturas = $em->getRepository('FacturasBundle:facturas');
        $repositoryClientes = $em->getRepository('ClientesBundle:clientes');
        $repositoryProductos = $em->getRepository('ProductosBundle:productos');
        $facturas = $repositoryFacturas->findBy(
            array('numeroFactura' => $numeroFactura)
            
        );
        $clienteFactura = new facturas;
        $datosClienteFactura = new clientes;
        $clienteFactura = $facturas[0];
        $idCliente = $clienteFactura->getIdCliente();
        $datosClienteFactura = $repositoryClientes->findOneById($idCliente);
        $idFactura =  $clienteFactura->getId();
        $resultado['cliente']=$datosClienteFactura->getNombres();
        $resultado['numeroFactura'] = $numeroFactura;
        $resultado['id'] = $idFactura;
        
         if(count($facturas) > 1){
            foreach ($facturas as $key => $value) {
                $facturasVarias = new facturas;
                $facturasVarias = $value;
                $idpro=$facturasVarias->getIdProducto();
                $datosProducto=$repositoryProductos->findOneById($idpro);
                $arrayPass = array(
                     'id'=>$datosProducto->getId(),
                    'nombre'=>$datosProducto->getNombre(),
                    'precio'=>$datosProducto->getPrecio(),
                    );
                array_push($resultado['productos'],$arrayPass);
            }
         } else {
            $idpro=$clienteFactura->getIdProducto();
            $datosProducto=$repositoryProductos->findOneById($idpro); 

            $resultado['productos'][0]= array(
                    'id'=>$datosProducto->getId(),
                    'nombre'=>$datosProducto->getNombre(),
                    'precio'=>$datosProducto->getPrecio(),
                );
         }
                 
        
        return $resultado;
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
