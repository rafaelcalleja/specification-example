<?php

/*
 * This file is part of the example specification package.
 *
 * (c) Rafael Calleja <rafaelcalleja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Example\Infrastructure\Persistence\Doctrine\Specification;

use Doctrine\DBAL\Query\QueryBuilder;
use Example\Infrastructure\Persistence\Doctrine\SpecificableInterface;

class AndSpecification extends \Example\Domain\Specification\AndSpecification implements SpecificableInterface
{
    /**
     * @param QueryBuilder $queryBuilder
     *
     * @return QueryBuilder
     */
    public function modifyQuery($queryBuilder)
    {
        $queryBuilder = $this->one->modifyQuery($queryBuilder);
        $queryBuilder = $this->other->modifyQuery($queryBuilder);

        return $queryBuilder;
    }
}
