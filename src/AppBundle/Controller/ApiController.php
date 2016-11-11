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
        $ndoc = $request->get('ndoc');
        $deno = $request->get('deno');
        $sexo = $request->get('sexo');
        $consultas = $this->get('consultas');
        $resultado = $consultas->consultaBasica($ndoc, $deno, $sexo);
        return new JsonResponse($resultado);
    }
    

}
