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

use Example\Domain\Model\Employee\Employee;
use Example\Domain\Model\Employee\EmployeeRepository;

class InMemoryEmployeeRepository implements EmployeeRepository
{
    /**
     * @var []
     */
    private $employees = array();

    /**
     * @param Employee $an_employee
     */
    public function add(Employee $an_employee)
    {
        $this->employees[$an_employee->getId()] = $an_employee;
    }

    /**
     * @return []
     */
    public function query($specification)
    {
        return $this->filterPosts(
            function (Employee $an_employee) use ($specification) {
                return $specification->specifies($an_employee);
            }
        );
    }

    /**
     * @return []
     */
    private function filterPosts(callable $fn)
    {
        return array_values(array_filter($this->employees, $fn));
    }


}
