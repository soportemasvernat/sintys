<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\PersonaFisica;
use AppBundle\Entity\ObraSocial;
use AppBundle\Entity\Organismo;
use AppBundle\Form\ConsultaType;
use AppBundle\Form\BuscadorType;
use AppBundle\Form\PersonaFisicaType;
use AppBundle\Form\OrganismoType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Admin controller.
 *
 * @Route("/")
 */
class AdminController extends Controller
{
      
    /**
     * @Route("/admin", name="admin")
     */
    public function adminAction(Request $request)
    {
               return $this->render('backend.html.twig');
    }


   
     /**
     * @Route("/organismo", name="organismo")
     */
    public function indexOrganismoAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
        $form=$this->createForm(new BuscadorType(),null,array('method' => 'GET'));
        $form->handleRequest($request);
        $entities =array();
        if ($form->isValid()) {
            $nombre=$form->get('nombre')->getData();
            $entities = $em->getRepository('AppBundle:Organismo')->findByName($nombre);
        }
    	$paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate($entities, $this->getRequest()->query->get('pagina',1), 10);
        return $this->render('organismoIndex.html.twig', array(
        	'entities'=> $entities,
            	'form'=>$form->createView()	
        ));
    }

     /**
     * @Route("/organismo_new", name="organismo_new")
     */
     public function newOrganismoAction()
    {
        $entity = new Organismo();
        $form = $this->createForm(new OrganismoType(), $entity);
        $form->handleRequest($this->getRequest());
        if ($form->isValid())
        {
           try{
              $em = $this->getDoctrine()->getManager();
              $em->persist($entity);
              $em->flush();
              $this->get('session')->getFlashBag()->add('success','Item Guardado');         
              return $this->redirect($this->generateUrl('organismo_show', array('id' => $entity->getId())));
           }
           catch(\Exception $e){
              $this->get('session')->getFlashBag()->add('error','Error al intentar agregar item'); 
             // return $this->redirect($this->generateUrl('alasector_new'));
           }
        }
        return $this->render('organismo_new.html.twig', array(
           'form' => $form->createView()        
    ));
    }
   
    /**
     * @Route("/organismo_edit/{id}", name="organismo_edit")
    */
    public function editOrganismoAction($id)
    {    
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:Organismo')->find($id);
        $form = $this->createForm(new OrganismoType(), $entity);
        $form->handleRequest($this->getRequest());
        if ($form->isValid())
        {
            try{  
                $em->persist($entity);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success','Item actualizado');
                return $this->redirect($this->generateUrl('organismo_edit', array('id' => $entity->getId())));
            }
            catch(\Exception $e){
                $this->get('session')->getFlashBag()->add('error','Error al intentar actualizar item');  
               // return $this->redirect($this->generateUrl('alasector_edit', array('id' => $entity->getId())));
            }    
        }
        return $this->render('organismo_edit.html.twig', array('form'=>$form->createView()));
    }

     /**
     * @Route("/organismo_delete", name="organismo_delete")
     */
    public function eliminarOrganismoAction($id)
    {                
        try{
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Organismo')->find($id);
            $em->remove($entity); 
            $em->flush();
            $this->get('session')->getFlashBag()->add('success','Item Eliminado');
            return $this->redirect($this->generateUrl('organismo'));
        }
    catch(\Exception $e) {
            $this->get('session')->getFlashBag()->add('error','Error al intentar eliminar item'); 
            return $this->redirect($this->generateUrl('organismo_delete'));
        }    
    }

    /**
     * @Route("/{id}", name="organismo_show")
     * @Method("GET")
     */
    public function organismo_showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Organismo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Organismo entity.');
        }

         return $this->render('organismo_show.html.twig', 
            array('entity' => $entity)
        );
    }


  

}
