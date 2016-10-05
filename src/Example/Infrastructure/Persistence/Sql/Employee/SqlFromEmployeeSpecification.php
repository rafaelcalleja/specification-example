<?php

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
        return "created_at > '" . $this->since->format('Y-m-d H:i:s') . "'";
    }
}
