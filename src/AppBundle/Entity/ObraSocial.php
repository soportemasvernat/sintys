<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ObraSocial
 *
 * @ORM\Table(name="obras_sociales")
 * @ORM\Entity()
 */
class ObraSocial implements \JsonSerializable
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
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PersonaFisica") 
    */
    private $persona;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", length=10)
     */
    private $codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="obraSocial", type="string", length=255, nullable=true)
     */
    private $obraSocial;

    /**
     * @var string
     *
     * @ORM\Column(name="periodo", type="string", length=5, nullable=true)
     */
    private $periodo;

    /**
     * @var string
     *
     * @ORM\Column(name="fechaAlta", type="date", nullable=true)
     */
    private $fechaAlta;

    /**
     * @var string
     *
     * @ORM\Column(name="baseOrigen", type="text", nullable=true)
     */
    private $baseOrigen;

    /**
     * @var string
     *
     * @ORM\Column(name="parentesco", type="text", nullable=true)
     */
    private $parentesco;

    public function jsonSerialize() {
        return [
            'codigo' => $this->codigo,
            'obraSocial' => $this->obraSocial,
            'periodo' => $this->periodo,
            'fechaAlta' => $this->fechaAlta,
            'baseOrigen' => $this->baseOrigen,
            'parentesco' => $this->parentesco,
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
     * Set codigo
     *
     * @param string $codigo
     * @return ObraSocial
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return string 
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set obraSocial
     *
     * @param string $obraSocial
     * @return ObraSocial
     */
    public function setObraSocial($obraSocial)
    {
        $this->obraSocial = $obraSocial;

        return $this;
    }

    /**
     * Get obraSocial
     *
     * @return string 
     */
    public function getObraSocial()
    {
        return $this->obraSocial;
    }

    /**
     * Set periodo
     *
     * @param string $periodo
     * @return ObraSocial
     */
    public function setPeriodo($periodo)
    {
        $this->periodo = $periodo;

        return $this;
    }

    /**
     * Get periodo
     *
     * @return string 
     */
    public function getPeriodo()
    {
        return $this->periodo;
    }

    /**
     * Set fechaAlta
     *
     * @param \DateTime $fechaAlta
     * @return ObraSocial
     */
    public function setFechaAlta($fechaAlta)
    {
        $this->fechaAlta = $fechaAlta;

        return $this;
    }

    /**
     * Get fechaAlta
     *
     * @return \DateTime 
     */
    public function getFechaAlta()
    {
        return $this->fechaAlta;
    }

    /**
     * Set baseOrigen
     *
     * @param string $baseOrigen
     * @return ObraSocial
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

    /**
     * Set persona
     *
     * @param \AppBundle\Entity\PersonaFisica $persona
     * @return ObraSocial
     */
    public function setPersona(\AppBundle\Entity\PersonaFisica $persona = null)
    {
        $this->persona = $persona;

        return $this;
    }

    /**
     * Get persona
     *
     * @return \AppBundle\Entity\PersonaFisica 
     */
    public function getPersona()
    {
        return $this->persona;
    }

    /**
     * Set parentesco
     *
     * @param string $parentesco
     * @return ObraSocial
     */
    public function setParentesco($parentesco)
    {
        $this->parentesco = $parentesco;

        return $this;
    }

    /**
     * Get parentesco
     *
     * @return string 
     */
    public function getParentesco()
    {
        return $this->parentesco;
    }
}
