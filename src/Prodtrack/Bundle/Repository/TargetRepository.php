<?php

namespace Prodtrack\Bundle\Repository;


use Doctrine\ORM\EntityRepository;

class TargetRepository extends EntityRepository
{
    public function getTargetsBetweenDates(\DateTime $startDate, \DateTime $endDate)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select(array(
                't.activityId',
                't.startDate',
                't.endDate',
                't.targetMinutes',
                'sum(al.minutes)'
            )
        )
            ->from('\Prodtrack\Bundle\Entity\Target', 't')
            ->innerJoin('\Prodtrack\Bundle\Entity\ActivityLog', 'al', 'WITH', 't.activityId = al.activityId')
            ->where('t.startDate >= :start')
            ->andWhere('t.endDate <= :end')
            ->groupBy('t.activityId, t.startDate, t.endDate, t.targetMinutes')
            ->setParameters(array('start' => $startDate, 'end' => $endDate));
        return $qb->getQuery()->getArrayResult();
    }
} 