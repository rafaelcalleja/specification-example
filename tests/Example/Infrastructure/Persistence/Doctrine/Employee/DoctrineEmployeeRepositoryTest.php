<?php

/*
 * This file is part of the example specification package.
 *
 * (c) Rafael Calleja <rafaelcalleja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace tests\Example\Infrastructure\Persistence\Doctrine\Employee;

use Example\Domain\Model\Employee\Employee;
use Example\Infrastructure\Persistence\Doctrine\Employee\DoctrineEmployeeRepository;
use Example\Infrastructure\Persistence\Doctrine\Employee\DoctrineEmployeeSpecificationFactory;
use Example\Infrastructure\Persistence\Doctrine\Employee\DoctrineFromEmployeeSpecification;
use Example\Infrastructure\Persistence\Doctrine\EntityManagerFactory;
use Example\Tests\TestCase;

class DoctrineEmployeeRepositoryTest extends TestCase
{
    /** @var DoctrineEmployeeRepository */
    private $repository;

    public function setUp()
    {
        $factory = new EntityManagerFactory();
        $entityManager = $factory->build(
            array(
                'driver' => 'pdo_sqlite',
                'path'   => __DIR__.'/../../../../../../db.sqlite',
            )
        );

        $this->repository = $entityManager->getRepository(Employee::class);

        $conn = $entityManager->getConnection();
        $qb = $conn->createQueryBuilder();
        $qb->delete('employees');
        $qb->execute();

        $this->employee_1  = new Employee(1, 'employee_1', new \DateTime());
        $this->employee_2  = new Employee(2, 'employee_2', new \DateTime('-1 day'));
        $this->employee_3  = new Employee(3, 'employee_3', new \DateTime('-2 year'));

        $this->repository->add($this->employee_1);
        $this->repository->add($this->employee_2);
        $this->repository->add($this->employee_3);
    }

    /**
     * @test
     */
    public function it_should_retrieve_last_year_employees()
    {
        $expected = $this->repository->find(3);

        $actual = $this->repository->query(
            new DoctrineFromEmployeeSpecification(
                new \DateTimeImmutable('-1 year')
            )
        );

        $this->assertContainsOnlyInstancesOf('Example\Domain\Model\Employee\Employee', $actual);
        $this->assertContains($expected, $actual);
        $this->assertCount(1, $actual);
    }

    /**
     * @test
     */
    public function it_should_create_composite_and_sql_builder_using_factory()
    {
        $factory = new DoctrineEmployeeSpecificationFactory();
        $expected = $this->repository->find(3);

        $actual = $this->repository->query(
            $factory->createCompositeFromAndNameEmployees(
                new \DateTimeImmutable('-1 year'),
                'employee_'
            )
        );

        $this->assertContainsOnlyInstancesOf('Example\Domain\Model\Employee\Employee', $actual);
        $this->assertContains($expected, $actual);
        $this->assertCount(1, $actual);
    }

    /**
     * @test
     */
    public function it_should_create_composite_or_sql_builder_using_factory()
    {
        $factory = new DoctrineEmployeeSpecificationFactory();
        $expected = $this->repository->find(3);
        $expected_2 = $this->repository->find(1);

        $actual = $this->repository->query(
            $factory->createCompositeFromOrNameEmployees(
                new \DateTimeImmutable('-1 year'),
                'employee_1'
            )
        );

        $this->assertContainsOnlyInstancesOf('Example\Domain\Model\Employee\Employee', $actual);
        $this->assertContains($expected, $actual);
        $this->assertContains($expected_2, $actual);
        $this->assertCount(2, $actual);
    }

    /**
     * @test
     */
    public function it_should_create_composite_not_sql_builder_using_factory()
    {
        $factory = new DoctrineEmployeeSpecificationFactory();
        $expected = $this->repository->find(2);
        $expected_2 = $this->repository->find(1);

        $actual = $this->repository->query(
            $factory->createCompositeFromAndNameNotEmployees(
                new \DateTimeImmutable('-1 year'),
                'employee_'
            )
        );

        $this->assertCount(2, $actual);
        $this->assertContains($expected, $actual);
        $this->assertContains($expected_2, $actual);
        $this->assertContainsOnlyInstancesOf('Example\Domain\Model\Employee\Employee', $actual);
    }

    public function tearDown()
    {
        $this->repository = null;
    }
}
