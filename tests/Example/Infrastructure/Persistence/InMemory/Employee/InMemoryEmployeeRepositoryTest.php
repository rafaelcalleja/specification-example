<?php

/*
 * This file is part of the example specification package.
 *
 * (c) Rafael Calleja <rafaelcalleja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace tests\Example\Infrastructure\Persistence\InMemory\Employee;

use Example\Domain\Model\Employee\Employee;
use Example\Infrastructure\Persistence\InMemory\Employee\InMemoryEmployeeRepository;
use Example\Tests\TestCase;

class InMemoryEmployeeRepositoryTest extends TestCase
{
    /** @var InMemoryEmployeeRepository */
    private $repository;

    private $employee_1, $employee_2, $employee_3;

    public function setUp()
    {
        $this->employee_1  = new Employee(1, 'employee_1', new \DateTime());
        $this->employee_2  = new Employee(2, 'employee_2', new \DateTime('-1 day'));
        $this->employee_3  = new Employee(3, 'employee_3', new \DateTime('-2 year'));

        $this->repository = new InMemoryEmployeeRepository();
        $this->repository->add($this->employee_1);
        $this->repository->add($this->employee_2);
        $this->repository->add($this->employee_3);
    }

    /**
     * @test
     */
    public function it_should_retrieve_last_year_employees_using_from_date()
    {
        $expected = $this->employee_3;

        $date = new \DateTimeImmutable('-1 year');
        $actual = $this->repository->fromDate($date);

        $this->assertContainsOnlyInstancesOf('Example\Domain\Model\Employee\Employee', $actual);
        $this->assertContains($expected, $actual);
        $this->assertCount(1, $actual);
    }
}
