<?php

/*
 * This file is part of the example specification package.
 *
 * (c) Rafael Calleja <rafaelcalleja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Example\Domain\Model\Employee\Specification;

use Example\Domain\Model\Employee\Employee;
use Example\Domain\Specification\AbstractSpecification;
use Example\Domain\Specification\Specification;

class IdEmployeeSpecification implements Specification
{
    use AbstractSpecification;

    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @return bool
     */
    public function specifies(Employee $an_employee)
    {
        return $an_employee->getId() === $this->id;
    }

    /**
     * @param mixed $object
     *
     * @return bool
     */
    public function isSatisfiedBy($object)
    {
        return $this->specifies($object);
    }
}
