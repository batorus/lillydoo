<?php

namespace LillydooBundle\Repository;

/**
 * AddressbookRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AddressbookRepository extends \Doctrine\ORM\EntityRepository
{
    public function getEnabledRecords()
    {      
                return $this->createQueryBuilder('a')
                    ->andWhere('a.enabled = :enabled')
                    ->leftJoin("a.documents", "docs")
                    ->addSelect("docs")
                    ->setParameter('enabled', '1')
                    ->orderBy('a.firstname', 'ASC')
                    ->getQuery()
                    ->execute();
    }
}
