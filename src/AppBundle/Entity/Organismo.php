<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Organismo
 *
 * @ORM\Table(name="organismo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OrganismoRepository")
 */
class Organismo
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
     * @ORM\Column(name="nombre", type="string", length=255, unique=true)
     */
    private $nombre;

    /**
     * @var int
     *
     * @ORM\Column(name="refes", type="bigint", unique=true)
     */
    private $refes;

     /**
     * @var int
     *
     * @ORM\Column(name="numanexo", type="integer", unique=false,  nullable=true)
     */
    private $numanexo;


    public function __construct(){   
    }

    public function __toString(){
        return " ".$this->getNombre();
    }

    function incrementarNumeroAnexo(){
    $this->numanexo = $this->numanexo + 1;
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
     * Set nombre
     *
     * @param string $nombre
     * @return Organismo
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set refes
     *
     * @param integer $refes
     * @return Organismo
     */
    public function setRefes($refes)
    {
        $this->refes = $refes;

        return $this;
    }

    /**
     * Get refes
     *
     * @return integer 
     */
    public function getRefes()
    {
        return $this->refes;
    }

    /**
     * Set numanexo
     *
     * @param integer $numanexo
     * @return Organismo
     */
    public function setNumanexo($numanexo)
    {
        $this->numanexo = $numanexo;

        return $this;
    }

    /**
     * Get numanexo
     *
     * @return integer 
     */
    public function getNumanexo()
    {
        return $this->numanexo;
    }
}
