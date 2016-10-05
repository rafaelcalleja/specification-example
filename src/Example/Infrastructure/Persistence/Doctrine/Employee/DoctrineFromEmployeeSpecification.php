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

class DoctrineFromEmployeeSpecification implements DoctrineEmployeeSpecification
{
    private $since;

    public function __construct(\DateTimeImmutable $since)
    {
        $this->since = $since;
    }

    /**
     * @return bool
     */
    public function specifies(Employee $an_employee)
    {
        return $an_employee->getCreatedAt() < $this->since;
    }
}
