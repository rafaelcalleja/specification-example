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

use Example\Domain\Model\Employee\EmployeeRepository;
use PDO;

class SqlEmployeeRepository implements EmployeeRepository
{
    /** @var PDO */
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @return []
     */
    public function query($specification)
    {
        return $this->retrieveAll(
            'SELECT * FROM posts WHERE '.$specification->toSqlClauses()
        );
    }

    /**
     * @return []
     */
    private function retrieveAll($sql, array $parameters = array())
    {
        $st = $this->pdo->prepare($sql);

        $st->execute($parameters);

        return array_map(function ($row) {
            return $this->buildEmployee($row);
        }, $st->fetchAll(\PDO::FETCH_ASSOC));
    }
}
