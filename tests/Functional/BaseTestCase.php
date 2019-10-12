<?php


namespace App\Tests\Functional;


use App\Entity\Classroom;
use App\Repository\ClassroomRepository;
use App\Tests\Fixture\LoadClassrooms;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseTestCase extends WebTestCase
{
    public function setUp()
    {
        static::bootKernel();

        $this->executeFixtures([new LoadClassrooms()]);
    }

    protected function executeFixtures(array $fixtures)
    {
        $entityManager = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');

        (new ORMExecutor($entityManager, new ORMPurger($entityManager)))->execute($fixtures);
    }

    protected function jsonRequest(string $method, string $uri, array $requestData = []): Response
    {
        $client = static::createClient();
        $client->request($method, $uri, [], [], [], json_encode($requestData));
        return $client->getResponse();
    }

    protected function getClassroomRepository(): ClassroomRepository
    {
        return self::$kernel->getContainer()
            ->get('doctrine.orm.entity_manager')
            ->getRepository(Classroom::class);
    }
}