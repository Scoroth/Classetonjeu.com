<?php

namespace Ctj\RegisterBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * JeuxRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class JeuxRepository extends EntityRepository
{
        public function getTotal()
    {
       /* $qb = $this->createQueryBuilder('j')
                   ->select('COUNT(j)');     // On sélectionne simplement COUNT(a)

        return (int) $qb->getQuery()
                         ->getSingleScalarResult(); // Utilisation de getSingleScalarResult pour avoir directement le résultat du COUNT */
    }
}
