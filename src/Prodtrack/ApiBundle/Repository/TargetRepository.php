<?php

namespace Prodtrack\ApiBundle\Repository;


use Doctrine\ORM\EntityRepository;

class TargetRepository extends EntityRepository
{
    public function getTargetsBetweenDates($userId, \DateTime $startDate, \DateTime $endDate)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select(
            array(
                'a.name',
                't.activityId',
                't.startDate',
                't.endDate',
                't.targetMinutes',
                'sum(al.minutes)'
            )
        )
            ->from('\Prodtrack\ApiBundle\Entity\Target', 't')
            ->innerJoin('\Prodtrack\ApiBundle\Entity\ActivityLog', 'al', 'WITH', 't.activityId = al.activityId')
            ->innerJoin('\Prodtrack\ApiBundle\Entity\Activity', 'a', 'WITH', 'a.id = t.activityId')
            ->where('t.startDate >= :start')
            ->andWhere('t.endDate <= :end')
            ->andWhere('t.userId = :userId')
            ->groupBy('a.name, t.activityId, t.startDate, t.endDate, t.targetMinutes')
            ->setParameters(array('start' => $startDate, 'end' => $endDate, 'userId' => $userId));
        return $qb->getQuery()->getArrayResult();
    }
} 