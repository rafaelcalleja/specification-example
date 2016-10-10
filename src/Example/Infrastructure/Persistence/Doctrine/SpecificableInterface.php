<?php

/*
 * This file is part of the example specification package.
 *
 * (c) Rafael Calleja <rafaelcalleja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Example\Infrastructure\Persistence\Doctrine;

use Doctrine\DBAL\Query\QueryBuilder;
use Example\Domain\Specification\Specification;

interface SpecificableInterface extends Specification
{
    /**
     * @param QueryBuilder $queryBuilder
     *
     * @return QueryBuilder
     */
    public function modifyQuery($queryBuilder);
}
