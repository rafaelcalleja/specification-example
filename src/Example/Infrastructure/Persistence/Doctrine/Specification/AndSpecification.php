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
    use AbstractSpecification;

    /**
     * @param QueryBuilder $queryBuilder
     *
     * @return QueryBuilder
     */
    public function modifyQuery($queryBuilder)
    {
        $qb1 = clone $queryBuilder;
        $this->one->modifyQuery($qb1);

        $qb2 = clone $queryBuilder;
        $this->other->modifyQuery($qb2);

        $method = $queryBuilder instanceof QueryBuilder ? 'getQueryPart' : 'getDQLPart';

        $expresion = $queryBuilder->expr()->andX(
            call_user_func(array($qb1, $method), 'where'),
            call_user_func(array($qb2, $method), 'where')
        );

        if ($expresion->count() > 0) {
            $queryBuilder->add('where', $expresion); //$queryBuilder->add('where', $expresion, true);

            if (!$queryBuilder instanceof QueryBuilder) {
                foreach (array($qb1->getParameters(), $qb2->getParameters()) as $parameters) {
                    foreach ($parameters as $key => $value) {
                        $queryBuilder->setParameter($value->getName(), $value->getValue());
                    }
                }
            }
        }

        return $queryBuilder;
    }
}
