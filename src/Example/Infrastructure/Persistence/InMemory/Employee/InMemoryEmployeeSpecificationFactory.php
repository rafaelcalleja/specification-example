<?php

/*
 * This file is part of the example specification package.
 *
 * (c) Rafael Calleja <rafaelcalleja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Example\Infrastructure\Persistence\InMemory\Employee;

use Example\Domain\Model\Employee\EmployeeSpecificationFactory;
use Example\Domain\Specification\AndSpecification;
use Example\Domain\Specification\Specification;

class InMemoryEmployeeSpecificationFactory implements EmployeeSpecificationFactory
{
    /**
     * @return Specification
     */
    public function createEarliestEmployees(\DateTimeImmutable $from)
    {
        return new InMemoryFromEmployeeSpecification($from);
    }

    /**
     * @return AndSpecification
     */
    public function createCompositeFromAndNameEmployees(\DateTimeImmutable $from, $name)
    {
        return new AndSpecification(
            new InMemoryFromEmployeeSpecification($from),
            new InMemoryNameEmployeeSpecification($name)
        );
    }
}
