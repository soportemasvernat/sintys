<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\Session;

/**
* @Route("/api", name="api")
*/
class ApiController extends Controller
{
      
    /**
    * @Route("/consultar", name="consultar")
    */
    public function consultarAction(Request $request)
    {

        $serializer = $this->get('jms_serializer');

        $ndoc = $request->get('ndoc');
        $deno = $request->get('deno');
        $sexo = $request->get('sexo');
        $formato = $request->get('formato');

        $consultas = $this->get('consultas');
        $resultado = $consultas->consultaBasica($ndoc, $deno, $sexo);

        if($formato == 'xml'){
            $xml = $serializer->serialize($resultado, 'xml');
            return new Response($xml);
        }

        $json = $serializer->serialize($resultado, 'json'); 
        
        return new Response($json);
    }


}
