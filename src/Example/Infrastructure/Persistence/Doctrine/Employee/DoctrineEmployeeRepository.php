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
use Example\Domain\Model\Employee\Employee;
use Example\Domain\Model\Employee\EmployeeRepository;

class DoctrineEmployeeRepository extends EntityRepository implements EmployeeRepository
{

    /**
     * @return []
     */
    public function query($specification)
    {
        return $this->filterPosts(
            function (Employee $an_employee) use ($specification) {
                return $specification->specifies($an_employee);
            }
        );
    }

    /**
     * @return []
     */
    private function filterPosts(callable $fn)
    {
        return array_values(array_filter($this->findAll(), $fn));
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
