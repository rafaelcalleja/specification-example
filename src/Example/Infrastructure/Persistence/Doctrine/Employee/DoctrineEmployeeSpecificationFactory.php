<?php

/*
 * This file is part of the example specification package.
 *
 * (c) Rafael Calleja <rafaelcalleja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Example\Infrastructure\Persistence\Doctrine\Employee;

use Example\Domain\Model\Employee\EmployeeSpecificationFactory;
use Example\Infrastructure\Persistence\Doctrine\SpecificableInterface;
use Example\Infrastructure\Persistence\Doctrine\Specification\AndSpecification;

class DoctrineEmployeeSpecificationFactory implements EmployeeSpecificationFactory
{
    /**
     * @return SpecificableInterface
     */
    public function createEarliestEmployees(\DateTimeImmutable $from)
    {
        return new DoctrineFromEmployeeSpecification($from);
    }

    /**
     * @return AndSpecification
     */
    public function createCompositeFromAndNameEmployees(\DateTimeImmutable $from, $name)
    {
        return new AndSpecification(
            new DoctrineFromEmployeeSpecification($from),
            new DoctrineNameEmployeeSpecification($name)
        );
    }
}
