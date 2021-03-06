<?php

namespace AppBundle\Entity;
use AppBundle\Entity\BaseRepository;

/**
 * Technology2PartRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class Technology2PartRepository extends BaseRepository
{
     protected static $alias = 'technology2part';
    protected static $entity = 'AppBundle:Technology2Part';

    public function customWhere($name, $value)
    {
        $a1 = self::getAlias();
        if ($name == 'id')
        {
            $this->qb->andWhere("{$a1}.id = :id");
            $this->qb->setParameter('id', $value);
            return true;
        }

        if ($name == 'q')
        {

            $this->qb->andWhere("{$a1}.name LIKE :q ");
            $this->qb->setParameter('q', "%{$value}%");
            return true;
        }
    }
}
