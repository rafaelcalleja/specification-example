<?php

/*
 * This file is part of the example specification package.
 *
 * (c) Rafael Calleja <rafaelcalleja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace tests\Example\Infrastructure\Persistence\Sql\Employee;

use Example\Infrastructure\Persistence\Sql\Employee\SqlFromEmployeeSpecification;
use Example\Tests\TestCase;

class SqlFromEmployeeSpecificationTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_retrieve_last_year_employees()
    {
        $date1 = new \DateTimeImmutable('Wed, 05 Oct 2016 13:47:03 +0000');
        $date2 = new \DateTimeImmutable('Thu, 06 Oct 2016 13:47:03 +0000');
        $date3 = new \DateTimeImmutable('Sun, 05 Oct 2014 13:47:31 +0000');

        $specification1 = new SqlFromEmployeeSpecification($date1);
        $specification2 = new SqlFromEmployeeSpecification($date2);
        $specification3 = new SqlFromEmployeeSpecification($date3);

        $this->assertSame(
            "created_at > '2016-10-05 13:47:03'",
            $specification1->toSqlClauses()
        );

        $this->assertSame(
            "created_at > '2016-10-06 13:47:03'",
            $specification2->toSqlClauses()
        );

        $this->assertSame(
            "created_at > '2014-10-05 13:47:31'",
            $specification3->toSqlClauses()
        );
    }
}
