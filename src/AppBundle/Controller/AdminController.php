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

class AdminController extends Controller
{
      
    /**
     * @Route("/admin", name="admin")
     */
    public function adminAction(Request $request)
    {
               return $this->render('inicio.html.twig');
    }

 

    

}
