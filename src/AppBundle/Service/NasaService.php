<?php

namespace AppBundle\Service;
use AppBundle\Entity\NasaObject;
use Doctrine\ORM\EntityManager;

/**
 * @author Vladislav Iavorskii
 */
class NasaService
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    public function getHazardous() : array
    {
        $nasaRepo = $this->entityManager->getRepository(NasaObject::class);

        return $nasaRepo->findBy(["isHazardous" => true]);
    }

    public function getFastest($hazardous = false)
    {
        $nasaRepo = $this->entityManager->getRepository(NasaObject::class);
        $qb = $nasaRepo->createQueryBuilder('nasa');
        $qb->orderBy("speed", "DESC")
            ->andWhere("isHazardous = :isHazardous")
            ->setParameter('isHazardous', $hazardous)
            ->setMaxResults(1)
        ;

        $result = $qb->getQuery()->getResult();

        return $result;
    }

    public function getBestYear($hazardous = false)
    {
        $nasaRepo = $this->entityManager->getRepository(NasaObject::class);
        $qb = $nasaRepo->createQueryBuilder('nasa');
        $qb->select("count(nasa.id) as numberOfObjects, YEAR(nasa.date) as year")
            ->andWhere("nasa.isHazardous = :isHazardous")
            ->setParameter('isHazardous', $hazardous)
            ->setMaxResults(1)
            ->groupBy("year")
            ->orderBy("numberOfObjects", 'DESC')
        ;

        $result = $qb->getQuery()->getResult();

        return $result;
    }

    public function getBestMonth($hazardous = 0)
    {
        $nasaRepo = $this->entityManager->getRepository(NasaObject::class);
        $qb = $nasaRepo->createQueryBuilder('nasa');
        $qb->select("count(nasa.id) as numberOfObjects, MONTH(nasa.date) as month, YEAR(nasa.date) as year")
            ->andWhere("nasa.isHazardous = :isHazardous")
            ->setParameter('isHazardous', $hazardous)
            ->groupBy("month")
            ->orderBy('numberOfObjects', 'DESC')
            ->setMaxResults(1)
        ;

        $result = $qb->getQuery()->getResult();

        return $result;
    }
}