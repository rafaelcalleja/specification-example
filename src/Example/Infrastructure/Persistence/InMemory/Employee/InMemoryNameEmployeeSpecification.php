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

use Example\Domain\Model\Employee\Specification\NameEmployeeSpecification;
use Example\Domain\Specification\AbstractSpecification;

class InMemoryNameEmployeeSpecification extends NameEmployeeSpecification implements InMemoryEmployeeSpecification
{
    use AbstractSpecification;
}
