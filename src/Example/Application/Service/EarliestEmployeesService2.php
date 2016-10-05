<?php

/*
 * This file is part of the example specification package.
 *
 * (c) Rafael Calleja <rafaelcalleja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Example\Application\Service;

use Example\Domain\Model\Employee\EmployeeRepository;
use Example\Domain\Model\Employee\EmployeeSpecificationFactory;

class EarliestEmployeesService2
{
    /**
     * @var EmployeeRepository
     */
    private $repository;

    /**
     * @var EmployeeSpecificationFactory
     */
    private $employeeSpecificationFactory;

    public function __construct(EmployeeRepository $repository, EmployeeSpecificationFactory $employeeSpecificationFactory)
    {
        $this->repository = $repository;
        $this->employeeSpecificationFactory = $employeeSpecificationFactory;
    }

    public function execute($request)
    {
        // ...

        $employees = $this->repository->query(
            $this->employeeSpecificationFactory->createEarliestEmployees(
                new \DateTimeImmutable('-1 year')
            )
        );

        /*
         *  Comentario:
         *
         * Desde el controlador sin usar el abstract factory pattern
         *
         * $repository = new SqlEmployeesService();
         *
         * $service = new EarliestEmployeesService($repository, new SqlFromEmployeeSpecification($date) ) // es un problemna que la especificaion tenga que recibir la fecha
         *
         *
        **/

        // ...
    }
}
