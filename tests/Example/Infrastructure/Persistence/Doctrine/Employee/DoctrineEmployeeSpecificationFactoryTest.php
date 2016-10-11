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
use Example\Domain\Model\Employee\EmployeeSpecificationFactory;
use Example\Domain\Specification\AndSpecification;
use Example\Infrastructure\Persistence\Doctrine\Employee\DoctrineEmployeeSpecificationFactory;
use Example\Tests\TestCase;

class DoctrineEmployeeSpecificationFactoryTest extends TestCase
{
    /** @var EmployeeSpecificationFactory */
    private $factory;

    private $employee_1, $employee_2, $employee_3;

    public function setUp()
    {
        $this->factory = new  DoctrineEmployeeSpecificationFactory();

        $this->employee_1  = new Employee(1, 'employee_1', new \DateTime());
        $this->employee_2  = new Employee(2, 'employee_2', new \DateTime('-1 day'));
        $this->employee_3  = new Employee(3, 'employee_3', new \DateTime('-2 year'));
    }

    /**
     * @test
     */
    public function it_should_satisfie_a_and_composite_name()
    {
        /** @var $specification AndSpecification */
        $specification = $this->factory->createCompositeFromAndNameEmployees(new \DateTimeImmutable('-1 year'), 'employee_');

        $this->assertFalse($specification->isSatisfiedBy($this->employee_1));
        $this->assertFalse($specification->isSatisfiedBy($this->employee_2));
        $this->assertTrue($specification->isSatisfiedBy($this->employee_3));

        $specification = $this->factory->createCompositeFromAndNameEmployees(new \DateTimeImmutable('-1 year'), 'employee_1');

        $this->assertFalse($specification->isSatisfiedBy($this->employee_1));
        $this->assertFalse($specification->isSatisfiedBy($this->employee_2));
        $this->assertFalse($specification->isSatisfiedBy($this->employee_3));

        $specification = $this->factory->createCompositeFromAndNameEmployees(new \DateTimeImmutable('-2 year'), 'employee_3');

        $this->assertFalse($specification->isSatisfiedBy($this->employee_1));
        $this->assertFalse($specification->isSatisfiedBy($this->employee_2));
        $this->assertFalse($specification->isSatisfiedBy($this->employee_3));

        $specification = $this->factory->createCompositeFromAndNameEmployees(new \DateTimeImmutable(), 'employee_');

        $this->assertFalse($specification->isSatisfiedBy($this->employee_1));
        $this->assertTrue($specification->isSatisfiedBy($this->employee_2));
        $this->assertTrue($specification->isSatisfiedBy($this->employee_3));

        $specification = $this->factory->createCompositeFromAndNameEmployees(new \DateTimeImmutable('+1 seconds'), 'employee_');

        $this->assertTrue($specification->isSatisfiedBy($this->employee_1));
        $this->assertTrue($specification->isSatisfiedBy($this->employee_2));
        $this->assertTrue($specification->isSatisfiedBy($this->employee_3));
    }
}
