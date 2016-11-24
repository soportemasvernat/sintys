<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Domicilio
 *
 * @ORM\Table(name="domicilio")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DomicilioRepository")
 */
class Domicilio implements \JsonSerializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="provincia", type="string", length=255)
     */
    private $provincia;

    /**
     * @var string
     *
     * @ORM\Column(name="localidad", type="string", length=255)
     */
    private $localidad;

    /**
     * @var string
     *
     * @ORM\Column(name="codigopostal", type="string", length=255)
     */
    private $codigoPostal;

    /**
     * @var string
     *
     * @ORM\Column(name="calle", type="string", length=255)
     */
    private $calle;

    /**
     * @var string
     *
     * @ORM\Column(name="nro", type="string", length=255)
     */
    private $nro;

    /**
     * @var string
     *
     * @ORM\Column(name="piso", type="string", length=255)
     */
    private $piso;

    /**
     * @var string
     *
     * @ORM\Column(name="depto", type="string", length=255)
     */
    private $depto;

    /**
     * @var string
     *
     * @ORM\Column(name="baseOrigen", type="string", length=255)
     */
    private $baseOrigen;


    public function jsonSerialize() {
        return [
            'provincia' => $this->provincia,
            'localidad' => $this->localidad,
            'codigoPostal' => $this->codigoPostal,
            'calle' => $this->calle,
            'nro' => $this->nro,
            'piso' => $this->piso,
            'depto' => $this->depto,
            'baseOrigen' => $this->baseOrigen
        ];
    }



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set provincia
     *
     * @param string $provincia
     * @return Domicilio
     */
    public function setProvincia($provincia)
    {
        $this->provincia = $provincia;

        return $this;
    }

    /**
     * Get provincia
     *
     * @return string 
     */
    public function getProvincia()
    {
        return $this->provincia;
    }

    /**
     * Set localidad
     *
     * @param string $localidad
     * @return Domicilio
     */
    public function setLocalidad($localidad)
    {
        $this->localidad = $localidad;

        return $this;
    }

    /**
     * Get localidad
     *
     * @return string 
     */
    public function getLocalidad()
    {
        return $this->localidad;
    }

    /**
     * Set codigoPostal
     *
     * @param string $codigoPostal
     * @return Domicilio
     */
    public function setCodigoPostal($codigoPostal)
    {
        $this->codigoPostal = $codigoPostal;

        return $this;
    }

    /**
     * Get codigoPostal
     *
     * @return string 
     */
    public function getCodigoPostal()
    {
        return $this->codigoPostal;
    }

    /**
     * Set calle
     *
     * @param string $calle
     * @return Domicilio
     */
    public function setCalle($calle)
    {
        $this->calle = $calle;

        return $this;
    }

    /**
     * Get calle
     *
     * @return string 
     */
    public function getCalle()
    {
        return $this->calle;
    }

    /**
     * Set nro
     *
     * @param string $nro
     * @return Domicilio
     */
    public function setNro($nro)
    {
        $this->nro = $nro;

        return $this;
    }

    /**
     * Get nro
     *
     * @return string 
     */
    public function getNro()
    {
        return $this->nro;
    }

    /**
     * Set piso
     *
     * @param string $piso
     * @return Domicilio
     */
    public function setPiso($piso)
    {
        $this->piso = $piso;

        return $this;
    }

    /**
     * Get piso
     *
     * @return string 
     */
    public function getPiso()
    {
        return $this->piso;
    }

    /**
     * Set depto
     *
     * @param string $depto
     * @return Domicilio
     */
    public function setDepto($depto)
    {
        $this->depto = $depto;

        return $this;
    }

    /**
     * Get depto
     *
     * @return string 
     */
    public function getDepto()
    {
        return $this->depto;
    }

    /**
     * Set baseOrigen
     *
     * @param string $baseOrigen
     * @return Domicilio
     */
    public function setBaseOrigen($baseOrigen)
    {
        $this->baseOrigen = $baseOrigen;

        return $this;
    }

    /**
     * Get baseOrigen
     *
     * @return string 
     */
    public function getBaseOrigen()
    {
        return $this->baseOrigen;
    }
}
