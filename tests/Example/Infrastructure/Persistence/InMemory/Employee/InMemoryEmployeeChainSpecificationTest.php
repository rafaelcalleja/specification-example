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
use Example\Domain\Specification\AndSpecification;
use Example\Domain\Specification\NotSpecification;
use Example\Domain\Specification\OrSpecification;
use Example\Infrastructure\Persistence\InMemory\Employee\InMemoryEmployeeRepository;
use Example\Infrastructure\Persistence\InMemory\Employee\InMemoryFromEmployeeSpecification;
use Example\Infrastructure\Persistence\InMemory\Employee\InMemoryNameEmployeeSpecification;
use Example\Tests\TestCase;

class InMemoryEmployeeChainSpecificationTest extends TestCase
{
    /** @var InMemoryEmployeeRepository */
    private $specification;

    private $employee_1, $employee_2, $employee_3;

    public function setUp()
    {
        $this->employee_1 = new Employee(1, 'employee_1', new \DateTime());
        $this->employee_2 = new Employee(2, 'employee_2', new \DateTime('-1 day'));
        $this->employee_3 = new Employee(3, 'employee_3', new \DateTime('-2 year'));
    }

    /**
     * @test
     */
    public function it_should_satisfied_a_composite_or_specification()
    {
        $specification1 = new InMemoryFromEmployeeSpecification(new \DateTimeImmutable('-1 year'));
        $specification2 = new InMemoryFromEmployeeSpecification(new \DateTimeImmutable('-1 day +1 second'));

        $composite = new OrSpecification($specification1, $specification2);

        $this->assertFalse($composite->isSatisfiedBy($this->employee_1));
        $this->assertTrue($composite->isSatisfiedBy($this->employee_2));
        $this->assertTrue($composite->isSatisfiedBy($this->employee_3));

        $specification3 = new InMemoryFromEmployeeSpecification(new \DateTimeImmutable('+1 second'));
        $another = new OrSpecification($specification3, $composite);

        $this->assertTrue($another->isSatisfiedBy($this->employee_1));
        $this->assertTrue($another->isSatisfiedBy($this->employee_2));
        $this->assertTrue($another->isSatisfiedBy($this->employee_3));
    }

    /**
     * @test
     */
    public function it_should_satisfied_a_not_specification()
    {
        $specification1 = new InMemoryFromEmployeeSpecification(new \DateTimeImmutable('-1 year'));
        $specification2 = new InMemoryFromEmployeeSpecification(new \DateTimeImmutable('-1 day +1 second'));

        $composite = new NotSpecification($specification1);
        $this->assertFalse($composite->isSatisfiedBy($this->employee_3));

        $another = new NotSpecification($specification2);
        $this->assertFalse($another->isSatisfiedBy($this->employee_2));
    }

    /**
     * @test
     */
    public function it_should_satisfied_composite_and_specification()
    {
        $specification1 = new InMemoryNameEmployeeSpecification('_2');
        $specification2 = new InMemoryFromEmployeeSpecification(new \DateTimeImmutable('-1 day +1 second'));

        $composite = new AndSpecification($specification1, $specification2);

        $this->assertFalse($composite->isSatisfiedBy($this->employee_1));
        $this->assertTrue($composite->isSatisfiedBy($this->employee_2));
        $this->assertFalse($composite->isSatisfiedBy($this->employee_3));

        $specification1 = new InMemoryNameEmployeeSpecification('_3');
        $specification2 = new InMemoryFromEmployeeSpecification(new \DateTimeImmutable('-1 year'));

        $composite = new AndSpecification($specification1, $specification2);

        $this->assertFalse($composite->isSatisfiedBy($this->employee_1));
        $this->assertFalse($composite->isSatisfiedBy($this->employee_2));
        $this->assertTrue($composite->isSatisfiedBy($this->employee_3));

        $specification1 = new InMemoryNameEmployeeSpecification('_2');
        $specification2 = new InMemoryFromEmployeeSpecification(new \DateTimeImmutable('-1 year'));

        $composite = new AndSpecification($specification1, $specification2);

        $this->assertFalse($composite->isSatisfiedBy($this->employee_1));
        $this->assertFalse($composite->isSatisfiedBy($this->employee_2));
        $this->assertFalse($composite->isSatisfiedBy($this->employee_3));
    }
}
