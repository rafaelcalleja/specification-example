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

use Example\Domain\Model\Employee\Specification\FromEmployeeSpecification;
use Example\Domain\Specification\AbstractSpecification;

class InMemoryFromEmployeeSpecification extends FromEmployeeSpecification implements InMemoryEmployeeSpecification
{
    use AbstractSpecification;
}
