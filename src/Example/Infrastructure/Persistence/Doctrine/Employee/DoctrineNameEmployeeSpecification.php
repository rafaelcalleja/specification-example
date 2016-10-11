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

use Doctrine\DBAL\Query\QueryBuilder;
use Example\Domain\Model\Employee\Employee;
use Example\Infrastructure\Persistence\Doctrine\Specification\AbstractSpecification;

class DoctrineNameEmployeeSpecification extends AbstractSpecification implements DoctrineEmployeeSpecification
{
    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return bool
     */
    public function specifies(Employee $an_employee)
    {
        return (bool) preg_match("/{$this->name}/i", $an_employee->getName());
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

    public function modifyQuery($queryBuilder)
    {
        $queryBuilder->andWhere('e.name like :name');
        $queryBuilder->setParameter('name', sprintf("%%%s%%", $this->name));

        return $queryBuilder;
    }
}
