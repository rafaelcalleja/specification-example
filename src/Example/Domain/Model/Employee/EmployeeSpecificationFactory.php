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

use Example\Domain\Specification\AndSpecification;
use Example\Domain\Specification\Specification;

interface EmployeeSpecificationFactory
{
    /**
     * @return Specification
     */
    public function createEarliestEmployees(\DateTimeImmutable $from);

    /**
     * @return AndSpecification
     */
    public function createCompositeFromAndNameEmployees(\DateTimeImmutable $from, $name);
}
