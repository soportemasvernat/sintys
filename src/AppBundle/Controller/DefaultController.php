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
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class DefaultController extends Controller
{
      
    /**
     * @Route("/consultar", name="consultar")
     */
    public function consultarAction(Request $request)
    {
        $consultas = $this->get('consultas');
        $consultas->consulta('identificarPersona','', '20248527', '', '', '', 'SI');
        return $this->render('inicio.html.twig');
    }

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
                $form->get('tematicas')->getData()
            );

            $coleccionFormularios = array();
            $organismo = $form->get('organismo')->getData();
            $session = new Session();
          
            // set and get session attributes
            $session->set('idOrganismo',$organismo->getId());

            foreach($resultado as $persona){
                foreach ($persona->getCoberturas() as $cobertura) {
                    $formPersona = $this->createForm(new PersonaFisicaType(), $persona, array('attr' => array('action' => $this->generateUrl('generar_pdf_anexo_2'))));
                    $formPersona->get('obraSocialNombre')->setData($cobertura->getObraSocial());
                    $formPersona->get('obraSocialCodigo')->setData($cobertura->getCodigo());
                    $formPersona->get('obraSocialPeriodo')->setData($cobertura->getPeriodo());
                    $formPersona->get('obraSocialBaseOrigen')->setData($cobertura->getBaseOrigen());

                 
                    /* armar una estructura de nombre de indices....*/
                    $coleccionFormularios[$persona->getIdPersona()."-".$cobertura->getCodigo()] = $formPersona->createView();
                }
            }
         
            
          
            return $this->render('resultado.html.twig', array(
                'resultado'   => $resultado,
                'coleccionFormularios' => $coleccionFormularios,
                              
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
        $persona = new PersonaFisica();

        $form = $this->createForm(new PersonaFisicaType(), $persona);

        $form->handleRequest($request);

        $cobertura = new ObraSocial();
        $cobertura->setObraSocial($form->get('obraSocialNombre')->getData());
        $cobertura->setCodigo($form->get('obraSocialCodigo')->getData());
        $cobertura->setPeriodo($form->get('obraSocialPeriodo')->getData());
        $cobertura->setBaseOrigen($form->get('obraSocialBaseOrigen')->getData());

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
