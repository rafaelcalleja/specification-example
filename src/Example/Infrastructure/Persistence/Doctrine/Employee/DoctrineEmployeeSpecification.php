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

use Example\Domain\Model\Employee\Employee;
use Example\Infrastructure\Persistence\Doctrine\SpecificableInterface;

interface DoctrineEmployeeSpecification extends SpecificableInterface
{
    /**
     * @return bool
     */
    public function specifies(Employee $an_employee);
}
