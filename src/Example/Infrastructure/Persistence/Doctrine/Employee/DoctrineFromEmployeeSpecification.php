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
use Example\Domain\Specification\AbstractSpecification;

class DoctrineFromEmployeeSpecification extends AbstractSpecification implements DoctrineEmployeeSpecification
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

    /**
     * @param QueryBuilder $queryBuilder
     *
     * @return QueryBuilder
     */
    public function modifyQuery($queryBuilder)
    {
        $queryBuilder->andWhere('e.created_at NOT IN (:dates)');
        $queryBuilder->setParameter('dates', array(
            '1',
            '2',
        ));

        return $queryBuilder;
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
