<?php

namespace AppBundle\Services;

use AppBundle\Entity\PersonaFisica;
use AppBundle\Entity\ObraSocial;
use AppBundle\Entity\Domicilio;

class Consultas {
 private $organismo = 'HDCMER';
 private $usuarioOrganismo = 'DALLASINA';
 private $password = 'DMG9x3S8dZnGq0c';
 private $modo = 'xml'; 
 private $conexion = 'https://sews.sintys.gov.ar/controlador/POST.server.php';


    public function __construct() {
        
    }

    public function query($operacion, $idPersona = '', $ndoc = '', $deno = '', $sexo = '', $tematicas = 'SI', $tdoc = '',  $fnac = '') {


        if($deno===null){
            $deno='';
        }
        if($ndoc===null){
            $ndoc='';
        }
        if($sexo===null){
            $sexo='';
        }
        $params = array(
            'ndoc' => $ndoc,
            'tdoc' => $tdoc,
            'deno' => $deno,
            'sexo' => $sexo,
            'fnac' => $fnac,
            'tematicas' => $tematicas,
            'idPersona' => $idPersona /* esto para reutilizar la funcion query y busque las otras tematicas */
        );
        $query = array(
            'organismo' => $this->organismo,
            'usuarioOrganismo' => $this->usuarioOrganismo,
            'password' => $this->password,
            'operacion' => $operacion,
            'modo' => $this->modo,
            'parametros'=> $params,
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
        if ($curl_errno > 0) {
            echo "Error **".$curl_error;
            return array();
        } else {
            $arrResp = new \SimpleXMLElement($respuesta);
            $array = json_decode(json_encode((array)$arrResp), true);
            return $array;
        }
    }

    

    public function consultaBasica($ndoc, $deno, $sexo){

        $resultado = $this->query('identificarPersona', '', $ndoc, $deno, $sexo);

        $arrayPersonas = array();

        foreach($resultado['resultado'] as $elemento) {
            $persona = new PersonaFisica();
            $persona->setIdPersona($this->checkIfArrayToString($elemento['idPersona']));
            $persona->setDeno($this->checkIfArrayToString($elemento['deno']));
            $persona->setTdoc($this->checkIfArrayToString($elemento['tdoc']));
            $persona->setNdoc($this->checkIfArrayToString($elemento['ndoc']));
            $persona->setCuit($this->checkIfArrayToString($elemento['cuit']));
            $persona->setTdoc($this->checkIfArrayToString($elemento['tdoc']));
            $persona->setProvincia($this->checkIfArrayToString($elemento['provincia']));
            $persona->setFnac($this->convertirFecha($elemento['fnac']));

            $persona->setSexo($this->checkIfArrayToString($elemento['sexo']));
            $persona->setGradoConfiabilidad($this->checkIfArrayToString($elemento['gradoConfiabilidad']));
            $persona->setFallecido($this->checkIfArrayToString($elemento['fallecido']));

            if($persona->getFallecido()) {
                $this->haFallecido($persona->getIdPersona());
            }

            // acá asigno los atributos simples
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

            foreach ($elemento['domicilio'] as $domicilio) {
                $objDomicilio = new Domicilio();
                $objDomicilio->setProvincia($this->checkIfArrayToString($domicilio['provincia']));
                $objDomicilio->setLocalidad($this->checkIfArrayToString($domicilio['localidad']));
                $objDomicilio->setCodigoPostal($this->checkIfArrayToString($domicilio['codigoPostal']));
                $objDomicilio->setCalle($this->checkIfArrayToString($domicilio['calle']));
                $objDomicilio->setNro($this->checkIfArrayToString($domicilio['nro']));
                $objDomicilio->setPiso($this->checkIfArrayToString($domicilio['piso']));
                $objDomicilio->setDepto($this->checkIfArrayToString($domicilio['depto']));
                $objDomicilio->setBaseOrigen($this->checkIfArrayToString($domicilio['baseOrigen']));
              
                $persona->addDomicilio($objDomicilio);
            }

            $arrayPersonas[] = $persona;
        }
        

    //print_r($arrayPersonas);die();
        return $arrayPersonas; // devuelve array de objetos personas
 
    }

    private function checkIfArrayToString($dato){
        if(is_array($dato) && count($dato) == 0){
            return "";
        }
        return $dato;
    }

    private function haFallecido($idPersona){
        $resultado = $this->query('haFallecido', $idPersona);
        return $resultado;
    }

    /** Puede recibir la fecha como array vacío o como string de 10 caracteres **/
    private function convertirFecha($fecha){
        $fechaString = $this->checkIfArrayToString($fecha);
        if(strlen($fechaString) == 10){
            $nueva = \DateTime::createFromFormat('d/m/Y', $fechaString);
            $nueva->setTime(0,0,0);
            return $nueva;
        }
        return NULL;
    }


}