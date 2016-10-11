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
use Example\Infrastructure\Persistence\InMemory\Employee\InMemoryNameEmployeeSpecification;
use Example\Tests\TestCase;

class InMemoryNameEmployeeSpecificationTest extends TestCase
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
    public function it_should_satisfie_a_regex_case_insensitive_name()
    {
        $specification = new InMemoryNameEmployeeSpecification('employee_');

        $this->assertTrue($specification->specifies($this->employee_1));
        $this->assertTrue($specification->specifies($this->employee_2));
        $this->assertTrue($specification->specifies($this->employee_3));

        $specification = new InMemoryNameEmployeeSpecification('EMPLOYEE_');

        $this->assertTrue($specification->specifies($this->employee_1));
        $this->assertTrue($specification->specifies($this->employee_2));
        $this->assertTrue($specification->specifies($this->employee_3));

        $specification = new InMemoryNameEmployeeSpecification('employea_');

        $this->assertFalse($specification->specifies($this->employee_1));
        $this->assertFalse($specification->specifies($this->employee_2));
        $this->assertFalse($specification->specifies($this->employee_3));
    }
}
