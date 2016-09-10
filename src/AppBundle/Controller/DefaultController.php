<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\PersonaFisica;
use AppBundle\Entity\ObraSocial;
use AppBundle\Form\ConsultaType;
use AppBundle\Form\PersonaFisicaType;
use Symfony\Component\HttpFoundation\Response;

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

        if($form->isValid()){
            $consultas = $this->get('consultas');
            $resultado = $consultas->consulta('identificarPersona',
                '',
                $form->get('ndoc')->getData(),
                $form->get('deno')->getData(),
                '',
                '',
                $form->get('tematicas')->getData()
            );

            $coleccionFormularios = array();

            foreach($resultado as $persona){
                foreach ($persona->getCoberturas() as $cobertura) {
                    $formPersona = $this->createForm(new PersonaFisicaType(), $persona, array('attr' => array('action' => $this->generateUrl('generar_pdf_anexo_2'))));
                    $formPersona->get('obraSocialNombre')->setData($cobertura->getObraSocial());
                    $formPersona->get('obraSocialCodigo')->setData($cobertura->getCodigo());
                    $formPersona->get('obraSocialPeriodo')->setData($cobertura->getPeriodo());
                    $formPersona->get('obraSocialBaseOrigen')->setData($cobertura->getBaseOrigen());
                    $coleccionFormularios[$persona->getIdPersona()."-".$cobertura->getCodigo()] = $formPersona->createView();
                }
            }
         
            
                    // cargar objetos personas en una array collection
                    //$this->cargar($resultado);
               
         

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

        $html = $this->renderView('pdf.html.twig', array(
            'cobertura'  => $cobertura,
            'persona'  => $persona,
        ));

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
