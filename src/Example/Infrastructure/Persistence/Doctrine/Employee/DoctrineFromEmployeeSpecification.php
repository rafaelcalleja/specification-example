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
use Example\Domain\Model\Employee\Specification\FromEmployeeSpecification;
use Example\Infrastructure\Persistence\Doctrine\Specification\AbstractSpecification;

class DoctrineFromEmployeeSpecification extends FromEmployeeSpecification implements DoctrineEmployeeSpecification
{
    use AbstractSpecification;

    /**
     * @param QueryBuilder $queryBuilder
     *
     * @return QueryBuilder
     */
    public function modifyQuery($queryBuilder)
    {
        $expression = $queryBuilder->expr()->lt('e.created_at', ':date');
        $queryBuilder->where($expression);
        $queryBuilder->setParameter('date', $this->since);

        return $queryBuilder;
    }
}
