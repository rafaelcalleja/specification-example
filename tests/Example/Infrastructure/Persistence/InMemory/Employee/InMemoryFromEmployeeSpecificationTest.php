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
use Example\Infrastructure\Persistence\InMemory\Employee\InMemoryEmployeeRepository;
use Example\Infrastructure\Persistence\InMemory\Employee\InMemoryFromEmployeeSpecification;
use Example\Tests\TestCase;

class InMemoryFromEmployeeSpecificationTest extends TestCase
{
    /** @var InMemoryEmployeeRepository */
    private $specification;

    private $employee_1, $employee_2, $employee_3;

    public function setUp()
    {
        $this->employee_1  = new Employee(1, 'employee_1', new \DateTime());
        $this->employee_2  = new Employee(2, 'employee_2', new \DateTime('-1 day'));
        $this->employee_3  = new Employee(3, 'employee_3', new \DateTime('-2 year'));
    }

    /**
     * @test
     */
    public function it_should_retrieve_last_year_employees()
    {
        $this->specification = new InMemoryFromEmployeeSpecification(new \DateTimeImmutable('-1 year'));

        $this->assertFalse($this->specification->specifies($this->employee_1));
        $this->assertFalse($this->specification->specifies($this->employee_2));
        $this->assertTrue($this->specification->specifies($this->employee_3));
    }
}
