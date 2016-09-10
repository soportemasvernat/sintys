<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FallecidoImagen
 *
 * @ORM\Table(name="fallecido_imagen")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FallecidoImagenRepository")
 */
class FallecidoImagen
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
     * @ORM\Column(name="idPersona", type="bigint", nullable=true)
     */
    private $idPersona;

    /**
     * @var string
     *
     * @ORM\Column(name="fallecido", type="string", length=2, nullable=true)
     */
    private $fallecido;

    /**
     * @var string
     *
     * @ORM\Column(name="ffall", type="string", length=10, nullable=true)
     */
    private $ffall;

    /**
     * @var string
     *
     * @ORM\Column(name="imagen", type="blob", nullable=true)
     */
    private $imagen;

    /**
     * @var string
     *
     * @ORM\Column(name="baseOrigen", type="text", nullable=true)
     */
    private $baseOrigen;

    /**
     * @var string
     *
     * @ORM\Column(name="error", type="text", nullable=true)
     */
    private $error;


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
     * @param integer $idPersona
     * @return FallecidoImagen
     */
    public function setIdPersona($idPersona)
    {
        $this->idPersona = $idPersona;

        return $this;
    }

    /**
     * Get idPersona
     *
     * @return integer 
     */
    public function getIdPersona()
    {
        return $this->idPersona;
    }

    /**
     * Set fallecido
     *
     * @param string $fallecido
     * @return FallecidoImagen
     */
    public function setFallecido($fallecido)
    {
        $this->fallecido = $fallecido;

        return $this;
    }

    /**
     * Get fallecido
     *
     * @return string 
     */
    public function getFallecido()
    {
        return $this->fallecido;
    }

    /**
     * Set ffall
     *
     * @param string $ffall
     * @return FallecidoImagen
     */
    public function setFfall($ffall)
    {
        $this->ffall = $ffall;

        return $this;
    }

    /**
     * Get ffall
     *
     * @return string 
     */
    public function getFfall()
    {
        return $this->ffall;
    }

    /**
     * Set imagen
     *
     * @param string $imagen
     * @return FallecidoImagen
     */
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;

        return $this;
    }

    /**
     * Get imagen
     *
     * @return string 
     */
    public function getImagen()
    {
        return $this->imagen;
    }

    /**
     * Set baseOrigen
     *
     * @param string $baseOrigen
     * @return FallecidoImagen
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
     * Set error
     *
     * @param string $error
     * @return FallecidoImagen
     */
    public function setError($error)
    {
        $this->error = $error;

        return $this;
    }

    /**
     * Get error
     *
     * @return string 
     */
    public function getError()
    {
        return $this->error;
    }
}
