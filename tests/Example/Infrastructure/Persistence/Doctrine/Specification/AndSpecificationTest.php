<?php

/*
 * This file is part of the example specification package.
 *
 * (c) Rafael Calleja <rafaelcalleja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace tests\Example\Infrastructure\Persistence\Doctrine\Specification;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use Example\Domain\Model\Employee\Employee;
use Example\Infrastructure\Persistence\Doctrine\Employee\DoctrineEmployeeRepository;
use Example\Infrastructure\Persistence\Doctrine\EntityManagerFactory;
use Example\Infrastructure\Persistence\Doctrine\Specification\AndSpecification;
use Example\Infrastructure\Persistence\Doctrine\Specification\NotSpecification;
use Example\Tests\TestCase;

class AndSpecificationTest extends TestCase
{
    /**
     * @var NotSpecification
     */
    private $specification;

    /** @var DoctrineEmployeeRepository */
    private $repository;

    /** @var EntityManager */
    private $entityManager;

    public function setUp()
    {
        $factory = new EntityManagerFactory();

        $this->entityManager = $factory->build(
            array(
                'driver' => 'pdo_sqlite',
                'path'   => __DIR__.'/../../../../../../db.sqlite',
            )
        );

        $this->repository = $this->entityManager->getRepository(Employee::class);
    }

    /**
     * @test
     */
    public function it_should_create_and_query_sql_from_simple_query_builder()
    {
        $mock =
            $this->getMockBuilder('Example\Domain\Specification\Specification')
                ->disableOriginalConstructor()
                ->setMethods(array('modifyQuery', 'isSatisfiedBy', 'andSpecification', 'orSpecification', 'not'))
                ->getMock();

        $this->specification = new AndSpecification($mock, $mock);

        $mock->expects($this->atLeast(2))
            ->method('modifyQuery');

        /** @var $qb QueryBuilder */
        $qb = $this->specification->modifyQuery($this->repository->createQueryBuilder('e'));
        $this->assertInstanceOf('\Doctrine\ORM\QueryBuilder', $qb);

        $expected = 'SELECT e0_.id AS id_0, e0_.name AS name_1, e0_.created_at AS created_at_2 FROM employees e0_';
        $this->assertSame($expected, $qb->getQuery()->getSQL());

        $test1 = clone $qb;
        $expresion = $test1->expr()->andX(
            $test1->expr()->lt('e.id', 4)
        );
        $test1->add('where', $expresion);

        $expected = 'SELECT e0_.id AS id_0, e0_.name AS name_1, e0_.created_at AS created_at_2 FROM employees e0_ WHERE e0_.id < 4 AND e0_.id < 4';
        $actual = $this->specification->modifyQuery($test1);
        $this->assertSame($expected, $actual->getQuery()->getSQL());

        $test2 = clone $qb;

        $expresion = $test2->expr()->andX(
            $test2->expr()->gte('e.id', 4),
            $test2->expr()->notLike('e.name', ':name')
        );

        $test2->add('where', $expresion);
        $test2->setParameter('name', 'foobar');

        $expected = 'SELECT e0_.id AS id_0, e0_.name AS name_1, e0_.created_at AS created_at_2 FROM employees e0_ WHERE (e0_.id >= 4 AND e0_.name NOT LIKE ?) AND (e0_.id >= 4 AND e0_.name NOT LIKE ?)';
        $actual = $this->specification->modifyQuery($test2);
        $this->assertSame($expected, $actual->getQuery()->getSQL());

        $test3 = clone $qb;

        $expresion = $test3->expr()->andX(
            $test3->expr()->andX(
                $test3->expr()->gte('e.id', 4),
                $test3->expr()->notLike('e.name', ':name')
            ),
            $test3->expr()->isNull('e.created_at')
        );

        $test3->add('where', $expresion);
        $test3->setParameter('name', 'foobar');

        $expected = 'SELECT e0_.id AS id_0, e0_.name AS name_1, e0_.created_at AS created_at_2 FROM employees e0_ WHERE ((e0_.id >= 4 AND e0_.name NOT LIKE ?) AND e0_.created_at IS NULL) AND ((e0_.id >= 4 AND e0_.name NOT LIKE ?) AND e0_.created_at IS NULL)';
        $actual = $this->specification->modifyQuery($test3);
        $this->assertSame($expected, $actual->getQuery()->getSQL());

        $test4 = clone $qb;

        $expresion = $test4->expr()->orX(
            $test4->expr()->orX(
                $test4->expr()->gte('e.id', 4),
                $test4->expr()->notLike('e.name', ':name')
            ),
            $test4->expr()->isNotNull('e.created_at')
        );

        $test4->add('where', $expresion);
        $test4->setParameter('name', 'foobar');

        $expected = 'SELECT e0_.id AS id_0, e0_.name AS name_1, e0_.created_at AS created_at_2 FROM employees e0_ WHERE ((e0_.id >= 4 OR e0_.name NOT LIKE ?) OR e0_.created_at IS NOT NULL) AND ((e0_.id >= 4 OR e0_.name NOT LIKE ?) OR e0_.created_at IS NOT NULL)';
        $actual = $this->specification->modifyQuery($test4);
        $this->assertSame($expected, $actual->getQuery()->getSQL());
    }

    /**
     * @test
     */
    public function it_should_create_not_query_sql_from_simple_query_builder_using_dbal()
    {
        $mock =
            $this->getMockBuilder('Example\Domain\Specification\Specification')
                ->disableOriginalConstructor()
                ->setMethods(array('modifyQuery', 'isSatisfiedBy', 'andSpecification', 'orSpecification', 'not'))
                ->getMock();

        $this->specification = new AndSpecification($mock, $mock);

        $mock->expects($this->atLeast(1))
            ->method('modifyQuery');

        /** @var $qb \Doctrine\DBAL\Query\QueryBuilder */
        $conn = $this->entityManager->getConnection();
        $qb = $conn->createQueryBuilder();
        $qb
            ->select(array('e.id', 'e.name', 'e.created_at'))
            ->from('employees e')
        ;
        $qb = $this->specification->modifyQuery($qb);
        $this->assertInstanceOf('\Doctrine\DBAL\Query\QueryBuilder', $qb);

        $expected = 'SELECT e.id, e.name, e.created_at FROM employees e';
        $this->assertSame($expected, $qb->getSQL());

        $test1 = clone $qb;
        $expresion = $test1->expr()->andX(
            $test1->expr()->lt('e.id', 4)
        );
        $test1->add('where', $expresion);

        $expected = 'SELECT e.id, e.name, e.created_at FROM employees e WHERE (e.id < 4) AND (e.id < 4)';
        $actual = $this->specification->modifyQuery($test1);
        $this->assertSame($expected, $actual->getSQL());

        $test2 = clone $qb;

        $expresion = $test2->expr()->andX(
            $test2->expr()->gte('e.id', 4),
            $test2->expr()->notLike('e.name', ':name')
        );

        $test2->add('where', $expresion);
        $test2->setParameter('name', 'foobar');

        $expected = 'SELECT e.id, e.name, e.created_at FROM employees e WHERE ((e.id >= 4) AND (e.name NOT LIKE :name)) AND ((e.id >= 4) AND (e.name NOT LIKE :name))';
        $actual = $this->specification->modifyQuery($test2);
        $this->assertSame($expected, $actual->getSQL());

        $test3 = clone $qb;

        $expresion = $test3->expr()->andX(
            $test3->expr()->andX(
                $test3->expr()->gte('e.id', 4),
                $test3->expr()->notLike('e.name', ':name')
            ),
            $test3->expr()->isNull('e.created_at')
        );

        $test3->add('where', $expresion);
        $test3->setParameter('name', 'foobar');

        $expected = 'SELECT e.id, e.name, e.created_at FROM employees e WHERE (((e.id >= 4) AND (e.name NOT LIKE :name)) AND (e.created_at IS NULL)) AND (((e.id >= 4) AND (e.name NOT LIKE :name)) AND (e.created_at IS NULL))';
        $actual = $this->specification->modifyQuery($test3);
        $this->assertSame($expected, $actual->getSQL());

        $test4 = clone $qb;

        $expresion = $test4->expr()->orX(
            $test4->expr()->orX(
               $test4->expr()->gte('e.id', 4),
               $test4->expr()->notLike('e.name', ':name')
            ),
            $test4->expr()->isNotNull('e.created_at')
        );

        $test4->add('where', $expresion);
        $test4->setParameter('name', 'foobar');

        $expected = 'SELECT e.id, e.name, e.created_at FROM employees e WHERE (((e.id >= 4) OR (e.name NOT LIKE :name)) OR (e.created_at IS NOT NULL)) AND (((e.id >= 4) OR (e.name NOT LIKE :name)) OR (e.created_at IS NOT NULL))';
        $actual = $this->specification->modifyQuery($test4);
        $this->assertSame($expected, $actual->getSQL());
    }

    public function tearDown()
    {
        $this->repository = null;
    }
}
