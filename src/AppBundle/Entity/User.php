<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

      /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=60)
     * @Assert\NotBlank()
    */
    private $nombre;

     /**
     * @ORM\ManyToMany(targetEntity="Organismo")
     */
    private $organismos;

    public function __construct()
    {
        parent::__construct();
        $this->enabled = true;
        $this->organismos = new \Doctrine\Common\Collections\ArrayCollection();
    }



    /**
     * Set nombre
     *
     * @param string $nombre
     * @return User
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
     * Add organismos
     *
     * @param \AppBundle\Entity\Organismo $organismos
     * @return User
     */
    public function addOrganismo(\AppBundle\Entity\Organismo $organismos)
    {
        $this->organismos[] = $organismos;

        return $this;
    }

    /**
     * Remove organismos
     *
     * @param \AppBundle\Entity\Organismo $organismos
     */
    public function removeOrganismo(\AppBundle\Entity\Organismo $organismos)
    {
        $this->organismos->removeElement($organismos);
    }

    /**
     * Get organismos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOrganismos()
    {
        return $this->organismos;
    }
}
