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

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Example\Domain\Model\Employee\Employee;
use Example\Domain\Model\Employee\EmployeeRepository;
use Example\Infrastructure\Persistence\Doctrine\SpecificableInterface;

class DoctrineEmployeeRepository extends EntityRepository implements EmployeeRepository
{
    /**
     * @return []
     */
    public function query($specification)
    {
        return $this->filterEmployees(
            function (Employee $an_employee) use ($specification) {
                return $specification->specifies($an_employee);
            }, $specification);
    }

    /**
     * @param SpecificableInterface $specification
     *
     * @return []
     */
    private function filterEmployees(callable $fn, $specification)
    {

        /** @var $qb QueryBuilder */
        $qb = $this->createQueryBuilder('e');
        $qb = $specification->modifyQuery($qb);

        $query = $qb->getQuery();

        return array_values(array_filter($query->getResult(), $fn));
    }

    /**
     * @return []
     */
    public function fromDate(\DateTimeImmutable $date)
    {
        $criteria = Criteria::create()
            ->where(Criteria::expr()->lt('created_at', $date))
        ;

        return $this->matching($criteria);
    }
}
