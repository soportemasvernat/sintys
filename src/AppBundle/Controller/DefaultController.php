<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\PersonaFisica;
use AppBundle\Entity\ObraSocial;
use AppBundle\Entity\organismo;
use AppBundle\Form\ConsultaType;
use AppBundle\Form\PersonaFisicaType;
use AppBundle\Form\PersonaFisicaSinCoberturaType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class DefaultController extends Controller
{
      
    /**
     * @Route("/", name="new")
     */
    public function newAction()
    {
        $form = $this->createForm(new ConsultaType());
        $form->handleRequest($this->getRequest());

        if($form->isValid())
        {
            $consultas = $this->get('consultas');
            $resultado = $consultas->consultaBasica(
                $form->get('ndoc')->getData(),
                $form->get('deno')->getData(),
                $form->get('sexo')->getData()
            );

            $coleccionFormularios = array();
            $coleccionFormulariosSinCobertura = array();

            $organismo = $form->get('organismo')->getData();
            $session = new Session();
          
            // set and get session attributes
            $session->set('idOrganismo',$organismo->getId());

            foreach($resultado as $persona){

                  // para pacientes SIN coberturas
                    $formPersonaSinCobertura = $this->createForm(new PersonaFisicaSinCoberturaType(), $persona, array('attr' => array('action' => $this->generateUrl('generar_pdf_anexo_2', array('cob' => 'N')))));


                    foreach ($persona->getCoberturas() as $cobertura) {
                    // si los pacientes tienen coberturas
                    $formPersona = $this->createForm(new PersonaFisicaType(), $persona, array('attr' => array('action' => $this->generateUrl('generar_pdf_anexo_2', array('cob' => 'S')))));

                  
                    $formPersona->get('obraSocialNombre')->setData($cobertura->getObraSocial());
                    $formPersona->get('obraSocialCodigo')->setData($cobertura->getCodigo());
                    $formPersona->get('obraSocialPeriodo')->setData($cobertura->getPeriodo());
                    $formPersona->get('obraSocialBaseOrigen')->setData($cobertura->getBaseOrigen());

                 
                    /* armar una estructura de nombre de indices....*/
                    $coleccionFormularios[$persona->getIdPersona()."-".$cobertura->getCodigo()] = $formPersona->createView();
                    
                }

                $coleccionFormulariosSinCobertura[$persona->getIdPersona()] =  $formPersonaSinCobertura->createView();
            }
         
            
          
            return $this->render('resultado.html.twig', array(
                'resultado'   => $resultado,
                'coleccionFormularios' => $coleccionFormularios,
                'coleccionFormulariosSinCobertura' => $coleccionFormulariosSinCobertura,
                              
            ));
        }


        return $this->render('consultar.html.twig', array(
            'form'   => $form->createView(),
        ));
    }

    /**
     * @Route("/generar-pdf-anexo-2", name="generar_pdf_anexo_2")
     */
    public function generarPdfAnexo2(Request $request){
        $cob = $request->get('cob');
        
        $persona = new PersonaFisica();

        if ($cob == 'S')
            { $form = $this->createForm(new PersonaFisicaType(), $persona);}else{ $form = $this->createForm(new PersonaFisicaSinCoberturaType(), $persona);}

       

        $form->handleRequest($request);

        $cobertura = new ObraSocial();
        
       if ($cob == 'S')
       { 
        $cobertura->setObraSocial($form->get('obraSocialNombre')->getData());
        $cobertura->setCodigo($form->get('obraSocialCodigo')->getData());
        $cobertura->setPeriodo($form->get('obraSocialPeriodo')->getData());
        $cobertura->setBaseOrigen($form->get('obraSocialBaseOrigen')->getData());
       }else{

        $cobertura->setObraSocial('');
        $cobertura->setCodigo('');
        $cobertura->setPeriodo('');
        $cobertura->setBaseOrigen('');
       }

        $em = $this->getDoctrine()->getManager();
        $session=new Session();
        $idOrganismo=$session->get('idOrganismo');
        $organismo = $em->getRepository("AppBundle:Organismo")->find($idOrganismo);


        $html = $this->renderView('pdf.html.twig', array(
            'cobertura'  => $cobertura,
            'persona'  => $persona,
            'organismo' => $organismo,
            
        ));

        $organismo->incrementarNumeroAnexo();
        $em->persist($organismo);
        $em->flush();

       return new Response($this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'attachment; filename="anexoII.pdf"'
            )
        );

        return new Response($html);
    }


    

}
