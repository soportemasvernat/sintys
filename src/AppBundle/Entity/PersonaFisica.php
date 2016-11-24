<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * PersonaFisica
 *
 * @ORM\Table(name="persona_fisica")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PersonaFisicaRepository")
 */
class PersonaFisica implements \JsonSerializable
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
     * @ORM\Column(name="idPersona", type="string", length=255, nullable=true)
     */
    private $idPersona;

    /**
     * @var string
     *
     * @ORM\Column(name="deno", type="string", length=255, nullable=true)
     */
    private $deno;

    /**
     * @var string
     *
     * @ORM\Column(name="tdoc", type="string", length=20, nullable=true)
     */
    private $tdoc;

    /**
     * @var int
     *
     * @ORM\Column(name="ndoc", type="integer", nullable=true)
     */
    private $ndoc;

    /**
     * @var string
     *
     * @ORM\Column(name="cuit", type="string", length=13, nullable=true)
     */
    private $cuit;

    /**
     * @var string
     *
     * @ORM\Column(name="provincia", type="string", length=255, nullable=true)
     */
    private $provincia;

    /**
     * @var string
     *
     * @ORM\Column(name="fnac", type="date", nullable=true)
     */
    private $fnac;

    /**
     * @var string
     *
     * @ORM\Column(name="sexo", type="string", length=15, nullable=true)
     */
    private $sexo;

    /**
     * @var int
     *
     * @ORM\Column(name="gradoConfiabilidad", type="smallint", nullable=true)
     */
    private $gradoConfiabilidad;

    /**
     * @var string
     *
     * @ORM\Column(name="fallecido", type="boolean", nullable=true)
     */
    private $fallecido;

    /** 
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ObraSocial", mappedBy="persona") 
     * @ORM\OrderBy({"id"="ASC"})
    */
    private $coberturas;

     /** 
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Domicilio", mappedBy="persona") 
     * @ORM\OrderBy({"id"="ASC"})
    */
    private $domicilios;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->coberturas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->domicilios = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getEdad(){
        if($this->fnac){
            $hoy = new \DateTime();
            $diferencia = $hoy->diff($this->fnac);
            return $diferencia->format('%y');
        }
        return null;
    }

    /*
    funcion que permite pasar un objeto del tipo PersonaFisica a json
    */
    public function jsonSerialize() {
        /* pasamos cobertura del tipo ArrayCollection a Array */
        $coberturas = array();
        $domicilios = array();
        foreach ($this->coberturas as $cobertura) {
            $coberturas[] = $cobertura;
        }
        foreach ($this->domicilios as $domicilio) {
            $domicilios[] = $domicilio;
        }
        return [
            'idPersona' => $this->idPersona,
            'deno' => $this->deno,
            'tdoc' => $this->tdoc,
            'ndoc' => $this->ndoc,
            'cuit' => $this->cuit,
            'provincia' =>$this->provincia,
            'fnac' =>$this->fnac,
            'sexo' => $this->sexo,
            'gradoConfiabilidad' => $this->gradoConfiabilidad,
            'fallecido' => $this->fallecido,
            'coberturas' => $coberturas,
            'domicilios' => $domicilios
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
     * Set idPersona
     *
     * @param string $idPersona
     * @return PersonaFisica
     */
    public function setIdPersona($idPersona)
    {
        $this->idPersona = $idPersona;

        return $this;
    }

    /**
     * Get idPersona
     *
     * @return string 
     */
    public function getIdPersona()
    {
        return $this->idPersona;
    }

    /**
     * Set deno
     *
     * @param string $deno
     * @return PersonaFisica
     */
    public function setDeno($deno)
    {
        $this->deno = $deno;

        return $this;
    }

    /**
     * Get deno
     *
     * @return string 
     */
    public function getDeno()
    {
        return $this->deno;
    }

    /**
     * Set tdoc
     *
     * @param string $tdoc
     * @return PersonaFisica
     */
    public function setTdoc($tdoc)
    {
        $this->tdoc = $tdoc;

        return $this;
    }

    /**
     * Get tdoc
     *
     * @return string 
     */
    public function getTdoc()
    {
        return $this->tdoc;
    }

    /**
     * Set ndoc
     *
     * @param integer $ndoc
     * @return PersonaFisica
     */
    public function setNdoc($ndoc)
    {
        $this->ndoc = $ndoc;

        return $this;
    }

    /**
     * Get ndoc
     *
     * @return integer 
     */
    public function getNdoc()
    {
        return $this->ndoc;
    }

    /**
     * Set cuit
     *
     * @param string $cuit
     * @return PersonaFisica
     */
    public function setCuit($cuit)
    {
        $this->cuit = $cuit;

        return $this;
    }

    /**
     * Get cuit
     *
     * @return string 
     */
    public function getCuit()
    {
        return $this->cuit;
    }

    /**
     * Set provincia
     *
     * @param string $provincia
     * @return PersonaFisica
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
     * Set fnac
     *
     * @param \DateTime $fnac
     * @return PersonaFisica
     */
    public function setFnac($fnac)
    {
        $this->fnac = $fnac;

        return $this;
    }

    /**
     * Get fnac
     *
     * @return \DateTime 
     */
    public function getFnac()
    {
        return $this->fnac;
    }

    /**
     * Set sexo
     *
     * @param string $sexo
     * @return PersonaFisica
     */
    public function setSexo($sexo)
    {
        $this->sexo = $sexo;

        return $this;
    }

    /**
     * Get sexo
     *
     * @return string 
     */
    public function getSexo()
    {
        return $this->sexo;
    }

    /**
     * Set gradoConfiabilidad
     *
     * @param integer $gradoConfiabilidad
     * @return PersonaFisica
     */
    public function setGradoConfiabilidad($gradoConfiabilidad)
    {
        $this->gradoConfiabilidad = $gradoConfiabilidad;

        return $this;
    }

    /**
     * Get gradoConfiabilidad
     *
     * @return integer 
     */
    public function getGradoConfiabilidad()
    {
        return $this->gradoConfiabilidad;
    }

    /**
     * Set fallecido
     *
     * @param boolean $fallecido
     * @return PersonaFisica
     */
    public function setFallecido($fallecido)
    {
        $this->fallecido = $fallecido;

        return $this;
    }

    /**
     * Get fallecido
     *
     * @return boolean 
     */
    public function getFallecido()
    {
        return $this->fallecido;
    }

    /**
     * Add coberturas
     *
     * @param \AppBundle\Entity\ObraSocial $coberturas
     * @return PersonaFisica
     */
    public function addCobertura(\AppBundle\Entity\ObraSocial $coberturas)
    {
        $this->coberturas[] = $coberturas;

        return $this;
    }

    /**
     * Remove coberturas
     *
     * @param \AppBundle\Entity\ObraSocial $coberturas
     */
    public function removeCobertura(\AppBundle\Entity\ObraSocial $coberturas)
    {
        $this->coberturas->removeElement($coberturas);
    }

    /**
     * Get coberturas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCoberturas()
    {
        return $this->coberturas;
    }

    /**
     * Add domicilios
     *
     * @param \AppBundle\Entity\Domicilio $domicilios
     * @return PersonaFisica
     */
    public function addDomicilio(\AppBundle\Entity\Domicilio $domicilios)
    {
        $this->domicilios[] = $domicilios;

        return $this;
    }

    /**
     * Remove domicilios
     *
     * @param \AppBundle\Entity\Domicilio $domicilios
     */
    public function removeDomicilio(\AppBundle\Entity\Domicilio $domicilios)
    {
        $this->domicilios->removeElement($domicilios);
    }

    /**
     * Get domicilios
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDomicilios()
    {
        return $this->domicilios;
    }
}
