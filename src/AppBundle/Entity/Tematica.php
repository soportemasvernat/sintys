<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tematica
 *
 * @ORM\Table(name="tematica")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TematicaRepository")
 */
class Tematica
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
     * @var string
     *
     * @ORM\Column(name="descriamplia", type="string", length=255, nullable=true)
     */
    private $descriamplia;


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
     * @return Tematica
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
     * Set descriamplia
     *
     * @param string $descriamplia
     * @return Tematica
     */
    public function setDescriamplia($descriamplia)
    {
        $this->descriamplia = $descriamplia;

        return $this;
    }

    /**
     * Get descriamplia
     *
     * @return string 
     */
    public function getDescriamplia()
    {
        return $this->descriamplia;
    }
}
