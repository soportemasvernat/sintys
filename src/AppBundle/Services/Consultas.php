<?php

namespace AppBundle\Services;

use AppBundle\Entity\PersonaFisica;
use AppBundle\Entity\ObraSocial;

class Consultas {
 private $organismo = 'HDCMER';
 private $usuarioOrganismo = 'DALLASINA';
 private $password = 'DMG9x3S8dZnGq0c';
 private $modo = 'xml'; 
 private $conexion = 'https://sews.sintys.gov.ar/controlador/POST.server.php';


    public function __construct(){
        
    }

    public function consulta($operacion, $tdoc, $ndoc, $deno, $sexo, $fnac, $tematicas){
        if($deno===null){
            $deno='';
        }
        if($ndoc===null){
            $ndoc='';
        }
        $params = array(
            'ndoc' => $ndoc,
            'tdoc' => $tdoc,
            'deno' => $deno,
            'sexo' => $sexo,
            'fnac' => $fnac,
            'tematicas' => $tematicas
        );
        $query = array(
            'organismo' => $this->organismo,
            'usuarioOrganismo' => $this->usuarioOrganismo,
            'password' => $this->password,
            'operacion' => $operacion,
            'modo' => $this->modo,
            'parametros'=> $params
        );          

        $data = http_build_query($query);

    //Inicio un handler de cURL
    $ch = curl_init();

    //Seteo la URL del servidor
    $urlServer = $this->conexion;
    // curl_setopt($ch, CURLOPT_PORT , 443);
     curl_setopt($ch, CURLOPT_PORT , 20010);

    //Indico los certificados necesarios para establecer la conexión

    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT_MS, 10000);
    curl_setopt($ch, CURLOPT_CERTINFO, true);
    /* estos certificados están en el mismo directorio que este archivo */
    curl_setopt($ch, CURLOPT_SSLCERT, '/etc/ssl/certs/cert.pem');
    curl_setopt($ch, CURLOPT_SSLKEY, '/etc/ssl/certs/key-u.pem');
    curl_setopt($ch, CURLOPT_CAINFO, '/etc/ssl/certs/cacert.pem');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);

    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,2);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $urlServer);
    curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
    curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type'=>'text/xml',"Content-Length: " . strlen($data)));
    
   
    $respuesta = curl_exec($ch);
    $curl_errno = curl_errno($ch);
    $curl_error = curl_error($ch);
    curl_close($ch);
    if ($curl_errno > 0)
    { echo "Error **".$curl_error; }
     else {

        

      
    $arrResp = new \SimpleXMLElement($respuesta);
    /*print_r($arrResp);
    die;*/
    $array = json_decode(json_encode((array)$arrResp), true);


    $arrayPersonas = array();

    foreach($array['resultado'] as $elemento) {
        $persona = new PersonaFisica();
        $persona->setIdPersona($this->checkIfArrayToString($elemento['idPersona']));
        $persona->setDeno($this->checkIfArrayToString($elemento['deno']));
        $persona->setTdoc($this->checkIfArrayToString($elemento['tdoc']));
        $persona->setNdoc($this->checkIfArrayToString($elemento['ndoc']));
        $persona->setCuit($this->checkIfArrayToString($elemento['cuit']));
        $persona->setTdoc($this->checkIfArrayToString($elemento['tdoc']));
        $persona->setProvincia($this->checkIfArrayToString($elemento['provincia']));
        $fnac = $elemento['fnac'];
        if($fnac == ""){
            $persona->setFnac(null);
        } else {
            $fnac = \DateTime::createFromFormat('d/m/Y', $elemento['fnac']);
            $persona->setFnac($fnac);
        }
        
        $persona->setSexo($this->checkIfArrayToString($elemento['sexo']));
        $persona->setGradoConfiabilidad($this->checkIfArrayToString($elemento['gradoConfiabilidad']));
        $persona->setFallecido($this->checkIfArrayToString($elemento['fallecido']));

        if($persona->getFallecido())
            {$this->haFallecido($persona->getIdPersona());}



        // acá asigno los atributos simples
       if($tematicas=='SI')
       {
            foreach ($elemento['obrasSociales'] as $obra) {
                $obraSocial = new ObraSocial();
                $obraSocial->setCodigo($this->checkIfArrayToString($obra['codigo']));
                $obraSocial->setObraSocial($this->checkIfArrayToString($obra['obraSocial']));
                $obraSocial->setParentesco($this->checkIfArrayToString($obra['parentesco']));
                $obraSocial->setPeriodo($this->checkIfArrayToString($obra['periodo']));
                $obraSocial->setFechaAlta($this->checkIfArrayToString($obra['fechaAlta']));
                $obraSocial->setBaseOrigen($this->checkIfArrayToString($obra['baseOrigen']));
              
                $persona->addCobertura($obraSocial);
            }
        }

        $arrayPersonas[] = $persona;
    }

    //print_r($arrayPersonas);die();
    return $arrayPersonas; // devuelve array de objetos personas
 

    }
}

private function checkIfArrayToString($dato){
    if(is_array($dato) && count($dato) == 0){
        return "";
    }
    return $dato;
}

private function haFallecido($idPersona){
        return null;
}

    

}