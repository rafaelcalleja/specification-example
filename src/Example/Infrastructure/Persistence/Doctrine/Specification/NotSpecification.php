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
use Doctrine\ORM\Query\Expr\Andx;
use Doctrine\ORM\Query\Expr\Comparison;
use Doctrine\ORM\Query\Expr\Composite;
use Example\Infrastructure\Persistence\Doctrine\SpecificableInterface;

class NotSpecification extends \Example\Domain\Specification\NotSpecification implements SpecificableInterface
{
    use AbstractSpecification;

    private $notOperators = array(
        '<'           => '>=',
        '>='          => '<',
        '<='          => '>',
        '>'           => '<=',
        '='           => '!=',
        '!='          => '!',
        'LIKE'        => 'NOT LIKE',
        'NOT LIKE'    => 'LIKE',
        'REGEX'       => 'NOT REGEX',
        'NOT REGEX'   => 'REGEX',
        'IS NULL'     => 'IS NOT NULL',
        'IS NOT NULL' => 'IS NULL',
        ') AND ('     => ') OR (',
        ') OR ('      => ') AND (',
    );

    public function modifyQuery($queryBuilder)
    {
        $qb1 = clone $queryBuilder;
        $this->specification->modifyQuery($qb1);

        $where = $qb1 instanceof QueryBuilder ? $qb1->getQueryPart('where') : $qb1->getDQLPart('where');

        /** @var $where Andx */
        if ($where && $queryBuilder instanceof \Doctrine\ORM\QueryBuilder) {
            $composite = $where instanceof Andx ? $queryBuilder->expr()->orX() : $queryBuilder->expr()->andX();

            foreach ($where->getParts() as $expression) {
                /** @var $expression AndX || Composite || Comparison */
                if ($expression instanceof Composite) {
                    foreach ($expression->getParts() as $parts) {
                        /** @var $parts Comparison */
                        $operator = $this->notOperators[$parts->getOperator()];
                        $composite->add(new Comparison($parts->getLeftExpr(), $operator, $parts->getRightExpr()));
                    }
                } elseif ($expression instanceof Comparison) {
                    $operator = $this->notOperators[$expression->getOperator()];
                    $composite->add(new Comparison($expression->getLeftExpr(), $operator, $expression->getRightExpr()));
                } elseif (is_string($expression)) {
                    $expression = strtr($expression, $this->notOperators);
                    $composite->add($expression);
                } else {
                    throw new \InvalidArgumentException('expression not found');
                }
            }

            $queryBuilder->where($composite);

            foreach ($qb1->getParameters() as $key => $value) {
                $type = $value->getType() === 'datetime' ? 'custom_datetime' : $value->getType();

                $queryBuilder->setParameter($value->getName(), $value->getValue(), $type);
            }
        } elseif ($where && $queryBuilder instanceof QueryBuilder) {

            /** @var $where \Doctrine\DBAL\Query\Expression\CompositeExpression * */
            /** @var $queryBuilder QueryBuilder * */
            $composite = $where->getType() === 'AND' ? $queryBuilder->expr()->orX() : $queryBuilder->expr()->andX();
            $expressions = (string) $where;

            $expression = strtr($expressions, $this->notOperators);
            $composite->add($expression);

            $queryBuilder->add('where', $composite);
        }

        return $queryBuilder;
    }
}
