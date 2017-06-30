<?php

namespace AppBundle\Command;

use AppBundle\Service\NasaClient;
use AppBundle\Service\NasaObjectMapper;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Vladislav Iavorskii
 */
class GetNasaData extends ContainerAwareCommand
{
    /**
     * @var EntityManager
     */
    private $entityManager;
    /**
     * @var NasaClient
     */
    private $nasaClient;
    /**
     * @var NasaObjectMapper
     */
    private $nasaObjectMapper;

    public function configure()
    {
        $this->setName("nasa:data:get");
    }

    public function __construct(EntityManager $entityManager, NasaClient $nasaClient, NasaObjectMapper $nasaObjectMapper)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->nasaClient = $nasaClient;
        $this->nasaObjectMapper = $nasaObjectMapper;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $startDate = (new \DateTime())->modify("-3 days");
        $endDate = new \DateTime();
        $objectsByDate = $this->nasaClient->getNearObjectsByDate($startDate, $endDate);
        foreach ($objectsByDate as $objects) {
            foreach ($objects as $object) {
                $entity = $this->nasaObjectMapper->map($object);
                $this->entityManager->persist($entity);
            }
        }
        $this->entityManager->flush();
    }
}