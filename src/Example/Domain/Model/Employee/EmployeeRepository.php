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

interface EmployeeRepository
{
    /**
     * @return []
     */
    public function fromDate(\DateTimeImmutable $date);
}
