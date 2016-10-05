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
use Example\Domain\Model\Employee\EmployeeRepository;

class DoctrineEmployeeRepository extends EntityRepository implements EmployeeRepository
{
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
