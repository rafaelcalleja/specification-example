<?php

namespace Example\Infrastructure\Persistence\Sql\Employee;

interface SqlEmployeeSpecification
{
    public function toSqlClauses();
}
