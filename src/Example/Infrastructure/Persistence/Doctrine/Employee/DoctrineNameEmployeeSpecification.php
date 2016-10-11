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

use Example\Domain\Model\Employee\Specification\NameEmployeeSpecification;
use Example\Infrastructure\Persistence\Doctrine\Specification\AbstractSpecification;

class DoctrineNameEmployeeSpecification extends NameEmployeeSpecification implements DoctrineEmployeeSpecification
{
    use AbstractSpecification;

    public function modifyQuery($queryBuilder)
    {
        $expression = $queryBuilder->expr()->like('e.name', ':name');
        $queryBuilder->where($expression);
        $queryBuilder->setParameter('name', sprintf('%%%s%%', $this->name));

        return $queryBuilder;
    }
}
