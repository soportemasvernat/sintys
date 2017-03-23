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
         $res = str_replace( '<![CDATA[' , '' , $xml);  
         $res = str_replace( ']]>' , '' , $res); 
         return new Response($res);
        }

        $json = $serializer->serialize($resultado, 'json'); 
        
        return new Response($json);
    }


    /**
    * @Route("/query", name="query")
    */
    public function queryAction(Request $request)
    {
        
        $ndoc = $request->get('ndoc');
        $deno = $request->get('deno');
        $sexo = $request->get('sexo');
        $formato = $request->get('formato');
        $consultas = $this->get('consultas');
        $resultado = $consultas->query2('identificarPersona','',$ndoc, $deno, $sexo);   
        if($formato == 'json')
        {
            $xml = simplexml_load_string($resultado); 
            $json=json_encode($xml);     
            return new Response($json);
        }
        return new Response($resultado);
    }

}
