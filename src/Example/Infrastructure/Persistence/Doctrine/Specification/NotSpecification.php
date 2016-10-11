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

class NotSpecification extends \Example\Domain\Specification\NotSpecification implements SpecificableInterface
{

    public function modifyQuery($queryBuilder)
    {
        // TODO: Implement modifyQuery() method.
    }
}