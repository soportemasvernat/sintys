<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class OrganismoRepository extends EntityRepository
{
	public function findByName($nombre)
	{
	   $em = $this->getEntityManager();
	   $query = $em->createQuery('select org from AppBundle:Organismo org where org.nombre LIKE :nombre order by org.nombre')
		->setParameter('nombre', '%'.$nombre.'%');
	   return $query->getResult(); 
	}
}
