<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

echo '<title>Cliente Usando cURL<title>'; 
$organismo = 'HDCMER'; 
$usuarioOrganismo = 'DALLASINA'; 
$password = 'DMG9x3S8dZnGq0c'; 
$operacion = 'identificarPersona'; 
$modo = "xml"; /*Formato de la respuesta */ 

//Parametros de búsqueda: 
$params = array(    'ndoc' => "20248527
    ", 
                    'tdoc' => "",  
                    'deno' => "", 
                    'sexo' => "", 
                    'fnac' => "", 
                    'tematicas' => "SI"
                     /* Si el valor es NO, la consulta devuelve solo la identificación, si el valor es SI la consulta devuelve la identificación mas las temáticas.*/ 
                );

//Armo la query de petición
$query = array( 'organismo'=>$organismo, 
                'usuarioOrganismo'=>$usuarioOrganismo, 
                'password'=>$password, 
                'operacion'=>$operacion, 
                'modo'=>$modo, 'parametros'=> $params ); 

//Formateo el array como HTTP 
$data = http_build_query($query); 

//Inicio un handler de cURL 
$ch = curl_init(); 

//Seteo la URL del servidor 
$urlServer = 'https://sews.sintys.gov.ar/controlador/POST.server.php'; 
curl_setopt($ch, CURLOPT_PORT , 443); 

//Indico los certificados necesarios para establecer la conexión 
curl_setopt($ch, CURLOPT_SSLCERT, '/etc/ssl/cert/cert.pem');
curl_setopt($ch, CURLOPT_SSLKEY, '/etc/ssl/cert/key.pem'); 
curl_setopt($ch, CURLOPT_CAINFO, '/etc/ssl/cert/cacert.pem'); 
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
