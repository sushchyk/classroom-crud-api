<?php

namespace App\Repository;

use App\Entity\Classroom;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class ClassroomRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Classroom::class);
    }

    /**
     * @param Classroom $classroom
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function saveClassroom(Classroom $classroom)
    {
        $this->getEntityManager()->persist($classroom);
        $this->getEntityManager()->flush($classroom);
    }

    /**
     * @param Classroom $classroom
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function deleteClassroom(Classroom $classroom)
    {
        $this->getEntityManager()->remove($classroom);
        $this->getEntityManager()->flush();
    }
}