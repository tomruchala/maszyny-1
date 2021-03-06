<?php

namespace AppBundle\Entity;

/**
 * OrderRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FabricOrderRepository extends BaseRepository
{

    protected static $alias = 'fabricorder';
    protected static $entity = 'AppBundle:FabricOrder';
     
        protected function setSelectMany(array $crit = array())
    {
        $a1 = self::getAlias();
        $a2 = Fabric2PartRepository::getAlias();
        $a3 = PartRepository::getAlias();
        $a4 = ProjectRepository::getAlias();
        $a5 = StatusyRepository::getAlias();
        
        $this->qb->select($a1, $a2, $a3, $a4, $a5)
        ->innerJoin("{$a1}.fabric2part", $a2)
        ->innerJoin("{$a2}.part", $a3)
        ->innerJoin("{$a3}.project", $a4)
        ->innerJoin("{$a1}.status", $a5);
    }    

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
