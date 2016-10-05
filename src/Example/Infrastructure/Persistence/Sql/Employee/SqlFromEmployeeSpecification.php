<?php

/*
 * This file is part of the example specification package.
 *
 * (c) Rafael Calleja <rafaelcalleja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Example\Infrastructure\Persistence\Sql\Employee;

class SqlFromEmployeeSpecification implements SqlEmployeeSpecification
{
    private $since;

    public function __construct(\DateTimeImmutable $since)
    {
        $this->since = $since;
    }

    public function toSqlClauses()
    {
        return "created_at > '".$this->since->format('Y-m-d H:i:s')."'";
    }
}
