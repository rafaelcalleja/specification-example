<?php

/*
 * This file is part of the example specification package.
 *
 * (c) Rafael Calleja <rafaelcalleja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Example\Domain\Model\Employee;

use Example\Infrastructure\Persistence\Doctrine\Employee\DoctrineFromEmployeeSpecification;
use Example\Infrastructure\Persistence\Doctrine\Specification\AndSpecification;

interface EmployeeSpecificationFactory
{
    /**
     * @return DoctrineFromEmployeeSpecification
     */
    public function createEarliestEmployees(\DateTimeImmutable $from);

    /**
     * @return AndSpecification
     */
    public function createCompositeFromAndNameEmployees(\DateTimeImmutable $from, $name);
}
